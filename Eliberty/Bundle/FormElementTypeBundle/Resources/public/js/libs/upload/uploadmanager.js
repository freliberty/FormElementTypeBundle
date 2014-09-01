/**
 * Created by mbaechtel on 16/06/2014.
 */

/**
 * UploadManager manage the upload Jcrop Picture for a document
 *
 * @param origin
 * @constructor
 */
var UploadManager = function(origin) {
    this.ratio = 0.83;
    this.jcrop_api = null;
    this.origin = origin;
};

UploadManager.prototype = {
    /**
     * Return the selected array
     * @param picheight
     * @param picwidth
     * @returns {*[]}
     */
    getSelectArray : function(picheight, picwidth) {
        var width = 200;
        var height = width * 1 / this.ratio;

        var x = (picwidth - width) / 2;
        var y = (picheight - height) / 2;
        var x1 = x + width;
        var y1 = y + height;

        return [x,y,x1,y1];
    },
    /**
     * Show preview picture
     * @param coords
     * @param origin
     */
    showPreview : function(coords, origin) {
        var cropbox = $('#cropbox_' + origin);
        if (parseInt(coords.w) > 0) {
            var i_height = cropbox.height();
            var i_width  = cropbox.width();

            var rx = 125 / coords.w;
            var ry = 150 / coords.h;

            $('#preview_' + origin).css({
                width: Math.round(rx * i_width) + 'px',
                height: Math.round(ry * i_height) + 'px',
                marginLeft: '-' + Math.round(rx * coords.x) + 'px',
                marginTop: '-' + Math.round(ry * coords.y) + 'px'
            });
        }
    },
    /**
     * Update the coords of crop picture
     * @param coords
     * @param origin
     */
    updateCoords : function(coords, origin) {
        $('#x-' + origin).val(coords.x);
        $('#y-' + origin).val(coords.y);
        $('#w-' + origin).val(coords.w);
        $('#h-' + origin).val(coords.h);
    },
    /**
     * Init Jcrop
     */
    initJcrop : function() {
        var myself = this;

        var crop_options = {
            onChange: function(coords) {
                myself.showPreview(coords, myself.origin);
            },
            onSelect: function(coords) {
                myself.updateCoords(coords, myself.origin);
            },
            aspectRatio: this.ratio,
            bgOpacity: 0.3,
            boxWidth: 500,
            boxHeight: 400
        };

        $('#cropbox_' + this.origin).Jcrop(crop_options, function(){
            myself.jcrop_api = this;
        });
    },
    /**
     * Init Gritter
     */
    initGritter: function() {
        $.extend($.gritter.options, {
            fade_in_speed: 'medium', // how fast notifications fade in (string or int)
            fade_out_speed: 2000, // how fast the notices fade out
            time: 10000 // hang on the screen for...
        });
    },
    /**
     * Init actions of the cropper
     */
    initActions : function() {
        var imguploader = $('#imguploader_' + this.origin);
        var rotator     = $('#rotator_' + this.origin);
        var picsaver    = $('#picsaver_' + this.origin);
        var myself = this;

        if (imguploader.length) {
            imguploader.fineUploader({
                multiple: false,
                validation: {
                    allowedExtensions: imguploader.attr('role').split('|'),
                    sizeLimit: 3 * 1024 * 1024 //4mb
                },
                request: {
                    endpoint: "/doupload",
                    params: {'origin' : imguploader.attr('rel'), 'scale' : imguploader.hasClass('withCropper') }
                },
                text: {
                    uploadButton: txtBtnChooseFile +'<span class="glyphicon glyphicon-upload"></span>',
                    cancelButton: txtCancel,
                    retryButton: txtBtnRetry,
                    failUpload: txtUploadFailed,
                    formatProgress: "{percent}% "+txtFrom+" {total_size}",
                    waitingForResponse: txtPending
                },
                template: '<div id="qq-uploader-' + this.origin + '" class="qq-uploader" style="padding-left:0px !important;">' +
                    '<pre class="qq-upload-drop-area col-lg-12"><span>{dragZoneText}</span></pre>' +
                    '<div class="qq-upload-button ' + classBtn + 'btn btn-default ' + (imguploader.hasClass('withCropper') ? 'btn-warning' :'') + '">{uploadButtonText}</div><br/>' +
                    '<div id="qq-upload-list-'+ this.origin + '" class="qq-upload-list ' + classUpload + ' " style="margin-top: 2em;"><ul style="text-align: center;"></ul></div>',
                showMessage: function(message) {
                    // Using Bootstrap's classes
                    $.gritter.add({
                        'title' : txtProbleme,
                        'text'  : message,
                        'sticky': false,
                        'image' : '/img/error.png'
                    });
                },
                messages: {
                    typeError: "{file} "+txtMessageTypeError+" {extensions}.",
                    sizeError: "{file} "+txtMessageSizeError+" {sizeLimit}.",
                    minSizeError: "{file} "+txtMessageMinSizeError+" {minSizeLimit}.",
                    emptyError: "{file} "+txtMessageEmptyError,
                    noFilesError: txtMessageNoFilesError,
                }
            }).on('complete', function(event, id, fileName, resp) {
                if (resp.success) {
                    var usrc = null;
                    if (imguploader.hasClass('withCropper')) {
                        usrc = resp.url + "?sid=" + Math.round((new Date()).getTime() / 1000);

                        var cropbox = $('#cropbox_' + resp.origin);
                        cropbox.attr('rel', resp.origin);
                        cropbox.attr('src', usrc).css({'height': resp.height , 'width': resp.width});

                        $('#preview_' + resp.origin).attr('src', usrc).css({'height': resp.height , 'width': resp.width});

                        var select_array = myself.getSelectArray(resp.height, resp.width);

                        $('#modal-pop-' + resp.origin).modal('show');

                        cropbox.load(function() {
                            myself.jcrop_api.setImage(usrc);
                            myself.jcrop_api.animateTo(select_array);
                            myself.updateCoords({x:select_array[0],y:select_array[1],w:select_array[2]-select_array[0],h:select_array[3]-select_array[1]}, myself.origin);
                        }).attr('src', usrc);
                    } else {
                        usrc = resp.url;
                        $('#' + resp.origin).val(usrc.replace(/\\/g,'/').replace(/.*\//, ''));
                        $('#final-pic-' + resp.origin).attr('src', usrc);
                        $('#secndCTBlock_' + resp.origin).removeClass('row');
                        $('#thumbnail_' + resp.origin).removeAttr('style');
                    }
                } else if (typeof resp.error != 'undefined') {
                    $.gritter.add({
                        'title' : txtProbleme,
                        'text'  : resp.error,
                        'sticky': false,
                        'image' : '/img/error.png'
                    });
                }
            });

            rotator.click(function() {
                var cropbox = $('#cropbox_' + myself.origin);
                var parts = cropbox.attr('src').split('?');
                var filename = parts[0];

                var pdatas = {
                    'img' : filename,
                    'origin' : cropbox.attr('rel'),
                    'action': 'rotate'
                };

                $.get('/doupload', pdatas, function(resp) {
                    if (resp.success) {
                        var usrc = resp.filename + "?sid=" + Math.round((new Date()).getTime() / 1000);
                        var select_array = myself.getSelectArray(resp.height, resp.width);

                        $('#' + resp.origin).val(usrc.replace(/\\/g,'/').replace(/.*\//, ''));

                        cropbox.attr('src', usrc).css({'height': resp.height , 'width': resp.width});

                        $('#preview_' + resp.origin).attr('src', usrc).css({'height': resp.height , 'width': resp.width});

                        cropbox.load(function() {
                            myself.jcrop_api.setImage(usrc);
                            myself.jcrop_api.animateTo(select_array);
                            myself.updateCoords({x:select_array[0],y:select_array[1],w:select_array[2]-select_array[0],h:select_array[3]-select_array[1]}, myself.origin);
                        }).attr('src', usrc);
                    } else if (typeof resp.error != 'undefined') {
                        $.gritter.add({
                            'title' : txtProbleme,
                            'text'  : resp.error,
                            'sticky': false,
                            'image' : '/img/error.png'
                        });
                    }
                }, 'json');
            });

            picsaver.click(function(event){
                var cropbox = $('#cropbox_' + myself.origin);
                var parts = cropbox.attr('src').split('?');
                var filename = parts[0];

                var imgdatas = {
                    'img' : filename,
                    'origin' : cropbox.attr('rel'),
                    'x' : $('#x-' + myself.origin).val(),
                    'y' : $('#y-' + myself.origin).val(),
                    'width' : $('#w-' + myself.origin).val(),
                    'height' : $('#h-' + myself.origin).val(),
                    'action':'crop'
                };

                $.post('/doupload', imgdatas, function(resp) {
                    if (resp.success) {
                        var usrc = resp.filename;
                        $('#' + resp.origin).val(usrc.replace(/\\/g,'/').replace(/.*\//, ''));
                        $('#final-pic-' + resp.origin).attr('src', usrc);
                        $('#modal-pop-' + resp.origin ).modal('hide');
                        $('#secndCTBlock_' + resp.origin).removeClass('row');
                        var thumbnail = $('#thumbnail_' + resp.origin);
                        thumbnail.removeAttr('style');
                        thumbnail.parents('.col-xs-12').first().find('.alert-info').first().hide();
                        $('#qq-upload-list-' + resp.origin).empty();
                    } else if (typeof resp.error != 'undefined') {
                        $.gritter.add({
                            'title' : txtProbleme,
                            'text'  : resp.error,
                            'sticky': false,
                            'image' : '/img/error.png'
                        });
                    }
                }, 'json');
                // e = event
                event.stopPropagation();
                // click on this link will cause ONLY child to fire
                event.preventDefault();
            });
        }
    },
    /**
     * Check the final pic on submit error form
     */
    checkFinalPic : function() {
        var finalpic = $('#final-pic-' + this.origin);
        if (finalpic.length) {
            var finalpicval = finalpic.attr('src').trim();
            if (finalpicval != '') {
                if(finalpicval.indexOf('amazonaws') == -1 && finalpicval.indexOf('pictures') == -1){
                    finalpic.attr('src', '/upload/tmp/' + finalpicval);
                }
                $('#' + this.origin).val(finalpicval);
            }
        }
    }
};

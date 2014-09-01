$(document).ready(function(){

    /**
     * Menu collapse on xsmall screen
     * @param  {[type]} ){                     $(this).next().collapse('toggle');    } [description]
     * @return {[type]}     [description]
     */
    $('.collapse').collapse({
      toggle: false
    }).prev().on('click', function(){
        $(this).next().collapse();
    });


    /**
     * Skiers count selector ;
     * add or remove skier item
     * @param  {[type]} ){ $(this).blur() })    $('.skiers .plus').on('click', function( [description]
     * @return {[type]}     [description]
     */
    $('.nb-skiers').on('focus', function(){ $(this).blur() })
    $('.skiers .plus').on('click', function(){
        changeNbSkiers('+');
    })
    $('.skiers .less').on('click', function(){
        changeNbSkiers('-');
    })


    /**
     * toggle checkbox icon on document ready
     * @return {[type]} [description]
     */
    $('input.fa').each(function(){
        $class = 'fa-square-o';
        if( $(this).is(':checked'))
        {
            $class = 'fa-check-square-o';
        } 

        $(this).hide().after('<i class="fa fa-2x '+$class+'"></i>').next().css('cursor','pointer').css('vertical-align','middle').on('click', function(e){
                $(this).toggleClass('fa-check-square-o fa-square-o');
                if ($(this).hasClass('fa-check-square-o')) {
                    $(this).prev().prop('checked',true);
                } else {
                    $(this).prev().prop('checked', false);
                }
                e.stopPropagation();
                return false;
        });

        $(this).on('change', function(){
                if ($(this).is(':checked')) {
                    $(this).next().removeClass('fa-square-o').addClass('fa-check-square-o');
                } else {
                    $(this).next().removeClass('fa-check-square-o').addClass('fa-square-o');
                }
        });
    });

    rpDialog();

    $('.social-btn').on('click', function(){

        var left = (screen.width/2)-(500/2);
        var top = (screen.height/2)-(500/2);
        console.log(left);
        console.log(top);

        open( $(this).data('href'), '', 'scrollbars=1,resizable=1, height=500, width=500, top='+top+', left='+left );
        return false;
    });

});

function changeNbSkiers(operator)
{
    if(operator == "+")
    {
        $nb = 1;
        $action = 'addSkier($baseVal)';
    } else if(operator == "-"){
        $nb = -1;
        $action = 'removeSkier()';
    }
    $baseVal = parseInt($('.nb-skiers').val());
    if( $baseVal > 1 || $nb > 0) {
        if( $baseVal == 6 && $nb > 0)
        {
            $('.age-skiers').next().show();
        } else {
            $('.age-skiers').next().hide();
            $('.nb-skiers').val( $baseVal + $nb );
            eval($action);
        }
    }
}

function removeSkier()
{
    $('.a-skier').last().remove();
}

function addSkier(baseVal)
{
    $('.a-skier').last().after( $('.a-skier').first().clone()  );
    if(baseVal==5)
    {
        $('.age-skiers').next().show();
    }
}

// Paiement accordion
$('#paiement-accordion .panel .panel-collapse').on('show.bs.collapse', function(){
      $('#paiement-accordion  .panel .panel-collapse').not(this).collapse('hide');
});

/**
 * Used to manage and play with BootStrap Modal
 *
 * - Modal is initialized (HTML Created) in Views/Console/Layout [just after block content]
 *
 * - One modal is initialized :
 *     To populate modal with remote url :
 *         <a
 *         class="rp-dialog"
 *         rp-title="Titre de la modal"
 *         rp-target="{{path('rp_console_translation_text',{ 'entityName':'pickup_site', 'entityId':pickupsite.id, 'entityField':'label'}) }}"
 *         >Link</a>
 *
 *      To populate modal with present HTML object :
 *         <a
 *         class="rp-dialog"
 *         rp-object=".rp-contract-addsubcontact"       // <-- Rp object is the jquery selector of the object to put in modal
 *         rp-title="Nouveau Sous-Contact"
 *         >Link</a>
 *
 *      To execute a function when modal is shown :
 *         <a
 *         class="rp-dialog"
 *         rp-title="Titre de la modal"
 *         rp-target="{{path('rp_console_translation_text',{ 'entityName':'pickup_site', 'entityId':pickupsite.id, 'entityField':'label'}) }}"
 *         rp-callback="alertme"                        // <--  function alertme(){ alert('me')}
 *         >Link</a>
 *
 */
var dialogHref='';
var dialogObject='';
var dialogModaltitle='';
var dialogCallback='';
var dialogFooter='';
function rpDialog(){
    $('a.rp-dialog').each(function(){
        $(this).unbind('click');
        $(this).on('click', function(e){

            if( $(this).hasClass('rp-spinner') )
            {
                $spin = $('<i></i>').addClass('fa fa-spin fa-spinner fa-4x');
                $spinCon = $('<div></div>')
                    .addClass('rp-dialog-spinner text-center')
                    .css('height', $('body').height() )
                    .append( $spin );
                $('body').addClass('blur').append($spinCon);

            }

            var dialogHref = $(this).attr('rp-target');
            var dialogObject = $(this).attr('rp-object');
            var dialogModaltitle = $(this).attr('rp-title');
            var dialogCallback = $(this).attr('rp-callback');
            var dialogFooter= $(this).attr('rp-footer');
            if( typeof dialogFooter != "undefined" ) {
                $('#modal .modal-footer').html('');
                $('#modal .modal-footer').append($(dialogFooter).clone().show());
                $('body').removeClass('blur'); $('.rp-dialog-spinner').remove();
            }
            if( typeof dialogObject != "undefined" ) {
                $('#modal .modal-body').html('');
                $('#modal .modal-body').append($(dialogObject).clone().show());
                $('.modal-title').html(dialogModaltitle);
                $('#modal').modal();
                if( typeof dialogCallback != "undefined" ) {
                    eval(dialogCallback+'();');
                }
                $('body').removeClass('blur'); $('.rp-dialog-spinner').remove();
            } else {
                $.ajax({
                    type: "GET",
                    url: dialogHref,
                    data: '',
                    cache: false,
                    success: function(data){
                        $('#modal .modal-body').html(data);
                        $('.modal-title').html(dialogModaltitle);
                        $('#modal').modal();
                    },
                    error: function(){},
                    complete: function(){
                        $('body').removeClass('blur'); $('.rp-dialog-spinner').remove();
                        if( typeof dialogCallback != "undefined" ) {
                            eval(dialogCallback+'();');
                        }
                    }
                });
            }



        });
    });
}

/**
 * Created by mbaechtel on 14/03/2014.
 */
$().ready(function() {
    "use strict";

    function showSkierInfos(elem, isChanged)
    {
        var skier;

        $(elem).closest('.adresse').children('.chooseSkier').show();
        $(elem).closest('.adresse').children('.row').find('input').val('');

        var id = parseInt(elem.val(),10);

        if (id > 0 && skiers_list.length > 0) {
            skier = _.findWhere(skiers_list, {id: id});
        }

        if (skier) {
            var parentDiv = $(elem).closest(".adresse");
            parentDiv.find($("input[id*='lastname']")).val(skier.lastname);
            parentDiv.find($("input[id*='firstname']")).val(skier.firstname);
            if (typeof skier.birthdate !== "undefined") {
                var birthdate = moment(skier.birthdate, "YYYY-MM-DD");
                parentDiv.find($("input[id*='birthdate']")).val(birthdate.format('DD/MM/YYYY'));
            } else {
                parentDiv.find($("input[id*='birthdate']")).focus().closest(".form-group").addClass("has-error");
            }
        }
    }

    var identificationchoice = $('.identification_choice  input[type=radio]:checked').val();
    if( 'login' === identificationchoice) {
        $('.login_identification').removeClass('hidden');
        $('.forgot_password').removeClass('hidden');
    }

    $('.identification_choice  input[type=radio]').on('change', function() {
        if( 'login' === $(this).val()) {
            $('.login_identification').removeClass('hidden');
            $('.forgot_password').removeClass('hidden');
        } else {
            $('.login_identification').addClass('hidden');
            $('.forgot_password').addClass('hidden');
        }
    });

    if(!$('#homedeliveryaddress_same_address').is(':checked')) {
        $('.shipping_lastname').removeClass('hidden');
        $('.shipping_firstname').removeClass('hidden');
        $('.shipping_company').removeClass('hidden');
        $('.shipping_address1').removeClass('hidden');
        $('.shipping_address2').removeClass('hidden');
        $('.shipping_locality').removeClass('hidden');
    }

    $('#homedeliveryaddress_same_address').on('change', function() {
        if($(this).is(':checked')) {
            $('.shipping_lastname').addClass('hidden');
            $('.shipping_firstname').addClass('hidden');
            $('.shipping_company').addClass('hidden');
            $('.shipping_address1').addClass('hidden');
            $('.shipping_address2').addClass('hidden');
            $('.shipping_locality').addClass('hidden');
        } else {
            $('.shipping_lastname').removeClass('hidden');
            $('.shipping_firstname').removeClass('hidden');
            $('.shipping_company').removeClass('hidden');
            $('.shipping_address1').removeClass('hidden');
            $('.shipping_address2').removeClass('hidden');
            $('.shipping_locality').removeClass('hidden');
        }
    });

    $('.adresse .chooseSkier select').each(function(){
        showSkierInfos($(this), false);
        $(this).on('change', function(){
            showSkierInfos($(this), true);
        });
    });
})

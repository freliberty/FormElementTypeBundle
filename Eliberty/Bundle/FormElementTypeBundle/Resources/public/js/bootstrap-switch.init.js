$(function() {
    $('input[type=checkbox][data-switch^=switch]').bootstrapSwitch();
})

$(document).on('click.bs.switch', 'div[data-switch^=switch]', function(e) {
    var $checkbox = $(this).find('input[type=checkbox]');
    $checkbox.bootstrapSwitch('switch');
    e.preventDefault();
})

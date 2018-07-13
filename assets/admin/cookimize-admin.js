jQuery(document).ready(function ($) {

    /* input */
    $("input.premium").attr('disabled', 'disabled');

    let td = $("input.premium").parent();

    $(td).append('<span class="pro">PRO</span>');

    /* textarea */

    $("textarea.premium").attr('disabled', 'disabled');

    let td_txt = $("textarea.premium").parent();

    $(td_txt).append('<span class="pro">PRO</span>');

    let logo = '<div class="cookimize-logo checkout-logo" style="background-image:url(' + cookimize_admin.logo + ');background-size: contain;background-repeat: no-repeat;"></div>\n';
    $('#fs_pricing').prepend(logo);

});
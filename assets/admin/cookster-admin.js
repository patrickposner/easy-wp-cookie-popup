jQuery(document).ready(function( $ ) {


    $("input.premium").attr('disabled','disabled');

    let td = $("input.premium").parent();

    $(td).append('<span class="pro">PRO</span>');

});
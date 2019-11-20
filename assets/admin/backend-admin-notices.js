jQuery(document).ready(function( $ ) {
    $('.cookii-dismiss .notice-dismiss').on('click', function () {
        $.ajax({
            type: 'POST',
            url: ci_ajax_object.ajax_url,
            data: {'action' : 'ci_dismiss_notice' },
          });
    });
});
jQuery(document).ready(function ($) {

    let cookie_types = [];

    let ga = {
        type: 'Google Analytics',
        value: 'ga',
        description: cookii.ga_code_description,
        lifetime: cookii.ga_code_lifetime,
    };

    let fb = {
        type: 'Facebook',
        value: 'fb',
        description: cookii.fb_code_description,
        lifetime: cookii.fb_code_lifetime,
    };

    let additional_cookie_1 = {
        type: cookii.custom_code_1_label,
        value: 'custom_code_1',
        description: cookii.custom_code_1_desc,
        lifetime: cookii.custom_code_1_lifetime,
    };

    let additional_cookie_2 = {
        type: cookii.custom_code_2_label,
        value: 'custom_code_2',
        description: cookii.custom_code_2_desc,
        lifetime: cookii.custom_code_2_lifetime,
    };

    if ( '' !== cookii.ga_used && '' !== cookii.fb_used ) {
        cookie_types = [ga, fb, additional_cookie_1, additional_cookie_2];
    } else if ( '' !== cookii.ga_used ) {
        cookie_types = [ga, additional_cookie_1, additional_cookie_2];
    } else if ( '' !== cookii.fb_used ) {
        cookie_types = [fb, additional_cookie_1, additional_cookie_2];
    } else {
        cookie_types = [additional_cookie_1, additional_cookie_2];
    }

    $('body').ihavecookies({
        onAccept: function(){ window.location.reload(); },
        title: cookii.headline,
        message: '<div id="gdpr-cookie-text">' + cookii.message + '</div>',
        link: cookii.privacy_page,
        delay: cookii.trigger_time,
        expires: cookii.expiration_time,
        cookieTypes: cookie_types,
        moreInfoLabel: cookii.privacy_page_text,
        acceptBtnLabel: cookii.accept,
        advancedBtnLabel: cookii.customize,
        cookieTypesTitle: cookii.cookie_type_title,
        fixedCookieTypeLabel:cookii.necessary,
        fixedCookieTypeDesc: cookii.necessary_desc,
        fixedCookieLifetime: cookii.required_code_lifetime,
    });


    $(document).on('click', '.cookii-toggle a', function() {
        var cookie = $(this).attr('data-cookie');

        $("table[data-cookie='" + cookie +"']").toggle();
        $(this).text($(this).text() == cookii.more_information ? cookii.less_information : cookii.more_information );
    });
});

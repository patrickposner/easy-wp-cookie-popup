jQuery(document).ready(function ($) {

    $('body').ihavecookies({
        onAccept: function(){ window.location.reload(); },
        title: cookii.headline,
        message: '<div id="gdpr-cookie-text">' + cookii.message + '</div>',
        link: cookii.privacy_page,
        delay: cookii.trigger_time,
        expires: cookii.expiration_time,
        cookieTypes: [
            {
                type: 'Google Analytics',
                value: 'ga',
                description: cookii.ga_code_description,
                lifetime: cookii.ga_code_lifetime,
            },
            {
                type: 'Facebook',
                value: 'fb',
                description: cookii.fb_code_description,
                lifetime: cookii.fb_code_lifetime,
            },
            {
                type: cookii.custom_code_1_label,
                value: 'custom_code_1',
                description: cookii.custom_code_1_desc,
                lifetime: cookii.custom_code_1_lifetime,
            },
            {
                type: cookii.custom_code_2_label,
                value: 'custom_code_2',
                description: cookii.custom_code_2_desc,
                lifetime: cookii.custom_code_2_lifetime,
            },
        ],
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

jQuery(document).ready(function ($) {

    $('body').ihavecookies({
        title: cookimize.headline,
        message: cookimize.message,
        link: cookimize.privacy_page,
        delay: cookimize.trigger_time,
        expires: cookimize.expiration_time,
        cookieTypes: [
            {
                type: cookimize.ga_label,
                value: 'ga',
            },
            {
                type: cookimize.fb_label,
                value: 'fb',
            },
            {
                type: cookimize.custom_code_1_label,
                value: 'custom_code_1',
            },
            {
                type: cookimize.custom_code_2_label,
                value: 'custom_code_2',
            },
            {
                type: cookimize.iframe_label,
                value: 'iframe',
            }
        ],
        moreInfoLabel: cookimize.privacy_page_text,
        acceptBtnLabel: cookimize.accept,
        advancedBtnLabel: cookimize.customize,
        cookieTypesTitle: cookimize.cookie_type_title,
    });
});
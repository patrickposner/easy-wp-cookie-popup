jQuery(document).ready(function ($) {

    $('body').ihavecookies({
        title: cookster.headline,
        message: cookster.message,
        link: cookster.privacy_page,
        delay: cookster.trigger_time,
        expires: cookster.expiration_time,
        cookieTypes: [
            {
                type: cookster.ga_label,
                value: 'ga',
            },
            {
                type: cookster.fb_label,
                value: 'fb',
            },
            {
                type: cookster.custom_code_1_label,
                value: 'custom_code_1',
            },
            {
                type: cookster.custom_code_2_label,
                value: 'custom_code_2',
            }
        ],
        moreInfoLabel: cookster.privacy_page_text,
        acceptBtnLabel: cookster.accept,
        advancedBtnLabel: cookster.customize,
        cookieTypesTitle: cookster.cookie_type_title,
    });

    var $iFrameContents = $('iframe').contents(),
        $entryContent   = $iFrameContents.find('div.entry-content');

    $iFrameContents.find('html').replaceWith($entryContent);

});
jQuery(document).ready(function ($) {

    console.log(cookster);

    $('body').ihavecookies({
        title: cookster.headline,
        message: cookster.message,
        link: cookster.privacy_page,
        delay: cookster.trigger_time,
        expires: cookster.expiration_time,
        cookieTypes: [
            {
                type: 'Site Preferences',
                value: 'preferences',
                description: 'These are cookies that are related to your site preferences, e.g. remembering your username, site colours, etc.'
            },
            {
                type: 'Analytics',
                value: 'analytics',
                description: 'Cookies related to site visits, browser types, etc.'
            },
            {
                type: 'Marketing',
                value: 'marketing',
                description: 'Cookies related to marketing, e.g. newsletters, social media, etc'
            }
        ],
        moreInfoLabel: cookster.privacy_page_text,
        acceptBtnLabel: cookster.accept,
        advancedBtnLabel: cookster.customize,
        uncheckBoxes: false, // Unchecks all checkboxes on page load that have class .ihavecookies
        cookieTypesTitle: cookster.cookie_type_title,
    });


});
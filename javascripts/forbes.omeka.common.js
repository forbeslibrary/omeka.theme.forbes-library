/**
 * @fileOverview This file is required by the Omeka theme 'Forbes'.
 * 
 * @author Benjamin Kalish
 * @version 0.1
 * @requires the jQuery Framework
 */

/** @namespace */
/*var Forbes = Forbes || {}

Forbes.resize = function () {
    var windowWidth = jQuery(window).width();
    var windowHeight = jQuery(window).height();
    
    if (!Forbes.resize.insertedCss) {
        jQuery('<style></style>').attr('id', 'dynamicStyle').appendTo('head');
        Forbes.resize.insertedCss = jQuery('#dynamicStyle');
    }
    
    if (jQuery('#primary-nav').width() + jQuery('#site-title a').width() < windowWidth) {
        Forbes.resize.insertedCss.replaceWith(jQuery(
            '<style>' +
            '#header { position: relative; }' +
            '#primary-nav { position: absolute; top:0; right:0; }' +
            '</style>'))
    } else {
        Forbes.resize.insertedCss.replaceWith(jQuery('<style></style>'));
    
    }
    
    if (windowWidth <= 400) {
        jQuery('#primary-nav *').hide();
    }
}

jQuery(document).ready(function () {
    Forbes.resize();
    jQuery(window).resize(Forbes.resize);
});*/
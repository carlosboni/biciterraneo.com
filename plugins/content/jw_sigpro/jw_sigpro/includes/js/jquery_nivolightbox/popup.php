<?php
/**
 * @version    3.8.x
 * @package    Simple Image Gallery Pro
 * @author     JoomlaWorks - https://www.joomlaworks.net
 * @copyright  Copyright (c) 2006 - 2020 JoomlaWorks Ltd. All rights reserved.
 * @license    https://www.joomlaworks.net/license
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

/* Nivo Lightbox v1.3.1 released on 04/10/2016 [Final] */
$relName = 'nivoLightbox';
$customLinkAttributes = 'data-lightbox-gallery="nvlb'.$gal_id.'"';

$stylesheets = array(
    'https://cdn.jsdelivr.net/gh/Codeinwp/Nivo-Lightbox-jQuery/dist/nivo-lightbox.min.css?v=1.3.1',
    'https://cdn.jsdelivr.net/gh/Codeinwp/Nivo-Lightbox-jQuery/themes/default/default.css?v=1.3.1'
);
if (!defined('PE_NIVOLIGHTBOX_CSS_LOADED')) {
    define('PE_NIVOLIGHTBOX_CSS_LOADED', true);
    $stylesheetDeclarations = array('
        /* Custom for SIGPro */
        .nivo-lightbox-title {display:inline-block;}
    ');
} else {
    $stylesheetDeclarations = array();
}
$scripts = array('https://cdn.jsdelivr.net/gh/Codeinwp/Nivo-Lightbox-jQuery/dist/nivo-lightbox.min.js?v=1.3.1');

if (!defined('PE_NIVOLIGHTBOX_JS_LOADED')) {
    define('PE_NIVOLIGHTBOX_JS_LOADED', true);
    $scriptDeclarations = array('
        (function($) {
            $(document).ready(function() {
                $("a[rel^=\'nivoLightbox\']").nivoLightbox({
                    effect: \'fade\',                           // The effect to use when showing the lightbox. Options are: fade, fadeScale, slideLeft, slideRight, slideUp, slideDown, fall
                    theme: \'default\',                         // The lightbox theme to use
                    keyboardNav: true,                          // Enable/Disable keyboard navigation (left/right/escape)
                    clickOverlayToClose: true,                  // If false clicking the "close" button will be the only way to close the lightbox
                    onInit: function(){},                       // Callback when lightbox has loaded
                    beforeShowLightbox: function(){},           // Callback before the lightbox is shown
                    afterShowLightbox: function(lightbox){},    // Callback after the lightbox is shown
                    beforeHideLightbox: function(){},           // Callback before the lightbox is hidden
                    afterHideLightbox: function(){},            // Callback after the lightbox is hidden
                    onPrev: function(element){},                // Callback when the lightbox gallery goes to previous item
                    onNext: function(element){},                // Callback when the lightbox gallery goes to next item
                    errorMessage: \'The requested content cannot be loaded. Please try again later.\' // Error message when content can\'t be loaded
                });
            });
        })(jQuery);
    ');
} else {
    $scriptDeclarations = array();
}

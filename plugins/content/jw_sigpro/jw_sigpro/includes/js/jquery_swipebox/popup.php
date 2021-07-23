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

/* Swipebox v1.4.6 released on 14/03/2016 */
$relName = 'swipebox';
$extraClass = 'swipebox';

$stylesheets = array('https://cdn.jsdelivr.net/npm/swipebox@1.4.6/src/css/swipebox.min.css');

if (!defined('PE_SWIPEBOX_CSS_LOADED')) {
    define('PE_SWIPEBOX_CSS_LOADED', true);
    $stylesheetDeclarations = array('
        /* Custom for SIGPro */
        #swipebox-top-bar {min-height:50px;height:auto !important;padding:8px;opacity:0.8 !important;}
        #swipebox-bottom-bar {opacity:0.6 !important;}
        #swipebox-title {height:auto;line-height:120%;}
        #swipebox-title br {display:block;padding:0;margin:0;line-height:1px;height:1px;content:" ";}
    ');
} else {
    $stylesheetDeclarations = array();
}

$scripts = array(
    'https://cdn.jsdelivr.net/npm/swipebox@1.4.6/lib/ios-orientationchange-fix.js',
    'https://cdn.jsdelivr.net/npm/swipebox@1.4.6/src/js/jquery.swipebox.min.js'
);

if (!defined('PE_SWIPEBOX_JS_LOADED')) {
    define('PE_SWIPEBOX_JS_LOADED', true);
    $scriptDeclarations = array('
        (function($) {
            $(document).ready(function() {
            	$("a.swipebox").swipebox({hideBarsDelay: 0});
			});
		})(jQuery);
    ');
} else {
    $scriptDeclarations = array();
}

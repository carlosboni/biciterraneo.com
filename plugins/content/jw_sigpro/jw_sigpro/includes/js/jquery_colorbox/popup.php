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

/* Colorbox v1.6.4 released on 10/05/2016 */
$relName = 'colorbox';
$extraClass = 'sigProColorbox';

$stylesheets = array('https://cdn.jsdelivr.net/npm/jquery-colorbox@1.6.4/example1/colorbox.css');

if (!defined('PE_COLORBOX_CSS_LOADED')) {
    define('PE_COLORBOX_CSS_LOADED', true);
    $stylesheetDeclarations = array('
		/* Custom for SIGPro */
		#cboxTitle {position:absolute;bottom:28px;left:0;width:100%;padding:8px 0 4px;line-height:150%;text-align:center;background:#fff;opacity:0.9;}
		#cboxSlideshow {color:#999;}
	');
} else {
    $stylesheetDeclarations = array();
}

$scripts = array('https://cdn.jsdelivr.net/npm/jquery-colorbox@1.6.4/jquery.colorbox.min.js');

if (!defined('PE_COLORBOX_JS_LOADED')) {
    define('PE_COLORBOX_JS_LOADED', true);
    $scriptDeclarations = array('
        (function($) {
            $(document).ready(function() {
				jQuery(".sigProColorbox").colorbox({
					current: "'.JText::_('JW_SIGP_PLG_POPUP_IMAGE').' {current} '.JText::_('JW_SIGP_PLG_POPUP_OF').' {total}",
					//previous: "previous", // Text or HTML for the previous button while viewing a group
					//next: "next", // Text or HTML for the next button while viewing a group
					//close: "close", // Text or HTML for the close button - the \'esc\' key will also close Colorbox
					maxWidth: "90%",
					maxHeight: "90%",
					slideshow: true, // If true, adds an automatic slideshow to a content group / gallery
					slideshowSpeed: 2500, // Sets the speed of the slideshow, in milliseconds
					slideshowAuto: false, // If true, the slideshow will automatically start to play
					slideshowStart: "start slideshow", // Text for the slideshow start button
					slideshowStop: "stop slideshow" // Text for the slideshow stop button
				});
			});
		})(jQuery);
	');
} else {
    $scriptDeclarations = array();
}

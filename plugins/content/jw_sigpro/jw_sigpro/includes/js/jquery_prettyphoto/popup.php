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

/* prettyPhoto v3.1.6 released on 07/05/2015 [Final] */
$relName = 'prettyPhoto';

$stylesheets = array('https://cdn.jsdelivr.net/gh/scaron/prettyphoto/css/prettyPhoto.css?v=3.1.6');
$stylesheetDeclarations = array();
$scripts = array('https://cdn.jsdelivr.net/gh/scaron/prettyphoto/js/jquery.prettyPhoto.js?v=3.1.6');

if (!defined('PE_PRETTYPHOTO_JS_LOADED')) {
    define('PE_PRETTYPHOTO_JS_LOADED', true);
    $scriptDeclarations = array('
        (function($) {
            $(document).ready(function() {
				$("a[rel^=\'prettyPhoto\']").prettyPhoto({
					animation_speed:\'fast\',
					slideshow:5000,
					autoplay_slideshow:false,
					opacity:0.80,
					show_title:false,
					allow_resize:true,
					default_width:500,
					default_height:344,
					counter_separator_label:\'/\',
					theme:\'pp_default\',
					horizontal_padding:20,
					hideflash:false,
					wmode:\'opaque\',
					autoplay:true,
					modal:false,
					deeplinking:true,
					overlay_gallery:true,
					keyboard_shortcuts:true,
					ie6_fallback:true,
					custom_markup:\'\',
					social_tools:\'\'
				});
			});
		})(jQuery);
	');
} else {
    $scriptDeclarations = array();
}

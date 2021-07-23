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

/* Magnific Popup v1.1.0 released on 20/02/2016 */
$relName = 'magnificpopup';
$extraClass = 'magnificpopup';

$stylesheets = array('https://cdn.jsdelivr.net/npm/magnific-popup@1.1.0/dist/magnific-popup.css');
$stylesheetDeclarations = array();
$scripts = array('https://cdn.jsdelivr.net/npm/magnific-popup@1.1.0/dist/jquery.magnific-popup.min.js');

if (!defined('PE_MAGNIFICPOPUP_JS_LOADED')) {
    define('PE_MAGNIFICPOPUP_JS_LOADED', true);
    $scriptDeclarations = array('
        (function($) {
            $(document).ready(function() {
	            $(\'.sigProContainer\').each(function() {
	                $(this).find(\'a.magnificpopup\').magnificPopup({
	                    type: \'image\',
	                    tLoading: \'Loading image #%curr%...\',
	                    gallery: {
	                        enabled: true,
	                        navigateByImgClick: true,
	                        preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
	                    },
	                    image: {
	                        tError: \'<a href="%url%">The image #%curr%</a> could not be loaded.\',
	                        titleSrc: function(item) {
	                            return item.el.attr(\'title\');
	                        }
	                    }
	                });
	            });
	        });
	    })(jQuery);
    ');
} else {
    $scriptDeclarations = array();
}

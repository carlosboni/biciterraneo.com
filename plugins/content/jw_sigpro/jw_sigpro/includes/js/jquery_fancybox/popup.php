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

/* Fancybox v3.5.7 released on Mar 11th, 2019 */
$extraClass = 'fancybox-gallery';
$customLinkAttributes = 'data-fancybox="gallery'.$gal_id.'"';

$stylesheets = array('https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css');

if (!defined('PE_FANCYBOX_CSS_LOADED')) {
    define('PE_FANCYBOX_CSS_LOADED', true);
    $stylesheetDeclarations = array('
        /* Custom for SIGPro */
        b.fancyboxCounter {margin-right:10px;}
        .fancybox-caption__body {overflow:visible;}
    ');
} else {
    $stylesheetDeclarations = array();
}

$scripts = array('https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js');

if (!defined('PE_FANCYBOX_JS_LOADED')) {
    define('PE_FANCYBOX_JS_LOADED', true);
    $scriptDeclarations = array('
        (function($) {
            $(document).ready(function() {
                $(\'a.fancybox-gallery\').fancybox({
                    buttons: [
                        \'slideShow\',
                        \'fullScreen\',
                        \'thumbs\',
                        \'share\',
                        //\'download\',
                        //\'zoom\',
                        \'close\'
                    ],
                    slideShow: {
                        autoStart: false,
                        speed: 5000
                    },
                    beforeShow: function(instance, current) {
                        if (current.type === \'image\') {
                            var title = current.opts.$orig.attr(\'title\');
                            current.opts.caption = (title.length ? \'<b class="fancyboxCounter">'.JText::_('JW_SIGP_PLG_POPUP_IMAGE').' \' + (current.index + 1) + \' '.JText::_('JW_SIGP_PLG_POPUP_OF').' \' + instance.group.length + \'</b>\' + \' | \' + title : \'\');
                        }
                    }
                });
            });
        })(jQuery);
    ');
} else {
    $scriptDeclarations = array();
}

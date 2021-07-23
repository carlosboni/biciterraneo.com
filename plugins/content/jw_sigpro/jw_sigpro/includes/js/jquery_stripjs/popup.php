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

/* Strip v1.7.0 released on 26/10/2019 */
$relName = '';
$extraClass = 'strip';
$customLinkAttributes = 'data-strip-group="'.$gal_id.'" data-strip-caption=""';

$stylesheets = array('https://cdn.jsdelivr.net/npm/@staaky/strip@1.7.0/dist/css/strip.css');
$stylesheetDeclarations = array();
$scripts = array('https://cdn.jsdelivr.net/npm/@staaky/strip@1.7.0/dist/js/strip.pkgd.min.js');
if (!defined('PE_STRIP_JS_LOADED')) {
    define('PE_STRIP_JS_LOADED', true);
    $scriptDeclarations = array('
        (function($) {
            $(document).ready(function() {
                $(\'[data-strip-group]\').each(function(i){
                    $(this).attr(\'data-strip-caption\', $(this).attr(\'title\'));
                });
            });
        })(jQuery);
    ');
} else {
    $scriptDeclarations = array();
}

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

/* Fresco v2.3.0 released on 26/11/2019 */
$relName = 'fresco';
$extraClass = 'fresco';
$customLinkAttributes = 'data-fresco-group="'.$gal_id.'" data-fresco-caption=""';

$stylesheets = array('css/fresco.css?v=2.3.0');
$stylesheetDeclarations = array();
$scripts = array('js/fresco.min.js?v=2.3.0');
if (!defined('PE_FRESCO_JS_LOADED')) {
    define('PE_FRESCO_JS_LOADED', true);
    $scriptDeclarations = array('
        (function($) {
            $(document).ready(function() {
                $(\'[data-fresco-group]\').each(function(i){
                    $(this).attr(\'data-fresco-caption\', $(this).attr(\'title\'));
                });
            });
        })(jQuery);
    ');
} else {
    $scriptDeclarations = array();
}

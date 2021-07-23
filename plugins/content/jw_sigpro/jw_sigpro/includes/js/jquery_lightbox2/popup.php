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

/* Lightbox2 v2.11.1 released on 14/07/2019 */
$relName = '';
$extraClass = '';
$customLinkAttributes = 'data-lightbox="'.$gal_id.'" data-title=""';

$stylesheets = array('https://cdn.jsdelivr.net/npm/lightbox2@2.11.1/dist/css/lightbox.min.css');
$stylesheetDeclarations = array();
$scripts = array('https://cdn.jsdelivr.net/npm/lightbox2@2.11.1/dist/js/lightbox.min.js');
if (!defined('PE_LIGHTBOX2_LOADED')) {
    define('PE_LIGHTBOX2_LOADED', true);
    $scriptDeclarations = array('
        (function($) {
            $(document).ready(function() {
                $(\'[data-lightbox]\').each(function(i){
                    $(this).attr(\'data-title\', $(this).attr(\'title\'));
                });
            });
        })(jQuery);
    ');
} else {
    $scriptDeclarations = array();
}

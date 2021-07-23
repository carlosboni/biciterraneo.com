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

/* Highslide v5.0.0 released on 24/05/2016 [Final] */
$relName = 'highslide';
$extraClass = 'highslide';

$stylesheets = array('highslide.css');
$stylesheetDeclarations = array();
$scripts = array('highslide-full.packed.js');

if (!defined('PE_HIGHSLIDE_JS_LOADED')) {
    define('PE_HIGHSLIDE_JS_LOADED', true);
    $scriptDeclarations = array('
		hs.graphicsDir = \''.$popupPath.'/graphics/\';
		hs.align = \'center\';
		hs.transitions = [\'expand\', \'crossfade\'];
		hs.fadeInOut = true;
		hs.dimmingOpacity = 0.8;
		hs.wrapperClassName = \'wide-border\';
		hs.captionEval = \'this.a.title\';
		hs.marginLeft = 100; // make room for the thumbstrip
		hs.marginBottom = 80 // make room for the controls and the floating caption
		hs.numberPosition = \'caption\';
		hs.lang.number = \'%1/%2\';
		hs.showCredits = false;

		// Add the slideshow providing the controlbar and the thumbstrip
		hs.addSlideshow({
			interval: 5000,
			repeat: false,
			useControls: true,
			overlayOptions: {
				className: \'text-controls\',
				position: \'bottom center\',
				relativeTo: \'viewport\',
				offsetX: 50,
				offsetY: -5
			},
			thumbstrip: {
				position: \'middle left\',
				mode: \'horizontal\',
				relativeTo: \'viewport\'
			}
		});

		// Add the simple close button
		hs.registerOverlay({
			html: \'<div class="closebutton" onclick="return hs.close(this)" title="Close"></div>\',
			position: \'top right\',
			fade: 2 // fading the semi-transparent overlay looks bad in IE
		});

		// Load HighSlide
		var highSlideForSIGP = {
			init: function() {
				if(!document.getElementsByTagName) return false;
				if(!document.getElementById) return false;
				var a = document.getElementsByTagName("a");
				for(var i=0; i<a.length; i++){
					if(/highslide/.test(a[i].className) || /highslide/.test(a[i].getAttribute("class"))){
						a[i].onclick = function(){
							return hs.expand(this);
							return false;
						}
					}
				}
			},
			ready: function(cb) {
				/in/.test(document.readyState) ? setTimeout(\'highSlideForSIGP.ready(\'+cb+\')\', 9) : cb();
			}
		}
		highSlideForSIGP.ready(highSlideForSIGP.init);

		/*
		document.addEventListener("DOMContentLoaded", function(event) {
			highSlideForSIGP.init;
		});
		*/
	');
} else {
    $scriptDeclarations = array();
}

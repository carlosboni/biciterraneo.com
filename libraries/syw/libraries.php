<?php
/**
 * @copyright	Copyright (C) 2011 Simplify Your Web, Inc. All rights reserved.
 * @license		GNU General Public License version 3 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

class SYWLibraries {
	
	static $jqlsLoaded = false;
	
	static $jqpLoaded = false;
	
	static $jqcLoaded = false;
	static $jqcMultipackLoaded = false;
	static $jqcthrottleLoaded = false;
	static $jqctouchLoaded = false;
	static $jqcmousewheelLoaded = false;
	static $jqctransitLoaded = false;
	
	static $jqhighres = array();
	
	static $jqcompareLoaded = false;
	
	/**
	 * Load Lazysizes jQuery plugin if needed
	 * https://github.com/aFarkas/lazysizes
	 */
	static function loadLazysizes($defer = false, $async = false, $debug = false)
	{
		if (self::$jqlsLoaded) {
			return;
		}
	
		$doc = JFactory::getDocument();
			
		if ($debug) {
			$doc->addScript(JURI::root(true).'/media/syw/js/lazysizes/jquery.lazysizes.js', "text/javascript", $defer, $async);
		} else {
		    if (version_compare(JVERSION, '3.2.0', 'ge')) {
		        $doc->addScriptVersion(JURI::root(true).'/media/syw/js/lazysizes/jquery.lazysizes.min.js', null, "text/javascript", $defer, $async);
		    } else {
		        $doc->addScript(JURI::root(true).'/media/syw/js/lazysizes/jquery.lazysizes.min.js', "text/javascript", $defer, $async);
		    }
		}
	
		self::$jqlsLoaded = true;
	}
	
	/**
	 * Load Pajinate jQuery plugin if needed
	 */
	static function loadPagination($defer = false, $async = false, $debug = false)
	{
		if (self::$jqpLoaded) {
			return;
		}
		
		$doc = JFactory::getDocument();
			
		if ($debug) {
			$doc->addScript(JURI::root(true).'/media/syw/js/pagination/jquery.pajinate.js', "text/javascript", $defer, $async);
		} else {
		    if (version_compare(JVERSION, '3.2.0', 'ge')) {
		        $doc->addScriptVersion(JURI::root(true).'/media/syw/js/pagination/jquery.pajinate.min.js', null, "text/javascript", $defer, $async);
		    } else {
		        $doc->addScript(JURI::root(true).'/media/syw/js/pagination/jquery.pajinate.min.js', "text/javascript", $defer, $async);
		    }
		}
		
		self::$jqpLoaded = true;
	}
	
	/**
	 * Load the carousel library (and its plugins) if needed
	 * jQuery v1.7+
	 */
	static function loadCarousel($throttle = true, $touch = true, $mousewheel = false, $transit = false, $defer = false, $async = false, $debug = false)
	{
		if (self::$jqcMultipackLoaded && !$mousewheel && !$transit) {
			return;
		}
		
		$will_use_multipack = false;
		if (!self::$jqcLoaded && $throttle && $touch && !$mousewheel && !$transit && !$debug) {
			$will_use_multipack = true;
		}
		
		if ($throttle && !self::$jqcMultipackLoaded && !$will_use_multipack) {
			self::loadCarousel_throttle($defer, $async, $debug);
		}
		
		if ($touch && !self::$jqcMultipackLoaded && !$will_use_multipack) {
			self::loadCarousel_touch($defer, $async, $debug);
		}
		
		if ($mousewheel) {
			self::loadCarousel_mousewheel($defer, $async, $debug);
		}
		
		if ($transit) {
			self::loadCarousel_transit($defer, $async, $debug);
		}
		
		$doc = JFactory::getDocument();
		
		if (!self::$jqcMultipackLoaded && $will_use_multipack) {
			
		    if (version_compare(JVERSION, '3.2.0', 'ge')) {
		        $doc->addScriptVersion(JURI::root(true).'/media/syw/js/carousel/jquery.carouFredSel.min.js', null, "text/javascript", $defer, $async);
		    } else {
		        $doc->addScript(JURI::root(true).'/media/syw/js/carousel/jquery.carouFredSel.min.js', "text/javascript", $defer, $async);
		    }
			
			self::$jqcMultipackLoaded = true;
		} else {
	
			if (self::$jqcLoaded) {
				return;
			}		
			
			if ($debug) {
				$doc->addScript(JURI::root(true).'/media/syw/js/carousel/jquery.carouFredSel-6.2.1.js', "text/javascript", $defer, $async);
			} else {
			    if (version_compare(JVERSION, '3.2.0', 'ge')) {
			        $doc->addScriptVersion(JURI::root(true).'/media/syw/js/carousel/jquery.carouFredSel-6.2.1-packed.js', null, "text/javascript", $defer, $async);
			    } else {
			        $doc->addScript(JURI::root(true).'/media/syw/js/carousel/jquery.carouFredSel-6.2.1-packed.js', "text/javascript", $defer, $async);
			    }
			}
		
			self::$jqcLoaded = true;
		}
	}
	
	static function loadCarousel_throttle($defer = false, $async = false, $debug = false)
	{	
		if (self::$jqcthrottleLoaded) {
			return;
		}
		
		$doc = JFactory::getDocument();
			
		if (version_compare(JVERSION, '3.2.0', 'ge')) {
		    $doc->addScriptVersion(JURI::root(true).'/media/syw/js/carousel/jquery.ba-throttle-debounce.min.js', null, "text/javascript", $defer, $async);
		} else {
		    $doc->addScript(JURI::root(true).'/media/syw/js/carousel/jquery.ba-throttle-debounce.min.js', "text/javascript", $defer, $async);
		}
	
		self::$jqcthrottleLoaded = true;
	}
	
	static function loadCarousel_touch($defer = false, $async = false, $debug = false)
	{	
		if (self::$jqctouchLoaded) {
			return;
		}
		
		$doc = JFactory::getDocument();
			
		if (version_compare(JVERSION, '3.2.0', 'ge')) {
		    $doc->addScriptVersion(JURI::root(true).'/media/syw/js/carousel/jquery.touchSwipe.min.js', null, "text/javascript", $defer, $async);
		} else {
		    $doc->addScript(JURI::root(true).'/media/syw/js/carousel/jquery.touchSwipe.min.js', "text/javascript", $defer, $async);
		}
	
		self::$jqctouchLoaded = true;
	}
	
	static function loadCarousel_mousewheel($defer = false, $async = false, $debug = false)
	{	
		if (self::$jqcmousewheelLoaded) {
			return;
		}
		
		$doc = JFactory::getDocument();
		
		if (version_compare(JVERSION, '3.2.0', 'ge')) {
		    $doc->addScriptVersion(JURI::root(true).'/media/syw/js/carousel/jquery.mousewheel.min.js', null, "text/javascript", $defer, $async);
		} else {
		    $doc->addScript(JURI::root(true).'/media/syw/js/carousel/jquery.mousewheel.min.js', "text/javascript", $defer, $async);
		}
	
		self::$jqcmousewheelLoaded = true;
	}
	
	static function loadCarousel_transit($defer = false, $async = false, $debug = false)
	{	
		if (self::$jqctransitLoaded) {
			return;
		}
		
		$doc = JFactory::getDocument();
		
		if (version_compare(JVERSION, '3.2.0', 'ge')) {
		    $doc->addScriptVersion(JURI::root(true).'/media/syw/js/carousel/jquery.transit.min.js', null, "text/javascript", $defer, $async);
		} else {
		    $doc->addScript(JURI::root(true).'/media/syw/js/carousel/jquery.transit.min.js', "text/javascript", $defer, $async);
		}

		self::$jqctransitLoaded = true;
	}
	
    static function triggerLazysizes($jQuery_path = 'img', $lazyload = false, $lazyload_image = '')
	{		
		if (in_array($jQuery_path, self::$jqhighres)) {
			return;
		}
		
		$javascript = 'jQuery(document).ready(function() { ';
		
			$javascript .= 'if (window.devicePixelRatio > 1) { '; // undefined > 1 results in false (IE < 11 do not support the property)
                $javascript .= 'jQuery("'.$jQuery_path.'[data-src]").each(function() { ';
                    $javascript .= 'jQuery(this).addClass("lazyload"); ';
                    if ($lazyload && $lazyload_image) {
                		$javascript .= 'jQuery(this).attr("src", "'.$lazyload_image.'"); ';
            		}
                $javascript .= '});';
            $javascript .= '}';
				
		if ($lazyload && $lazyload_image) {
			$javascript .= ' else {';
		    
            	$javascript .= 'jQuery("'.$jQuery_path.'[data-src]").each(function() { ';
                	$javascript .= 'jQuery(this).addClass("lazyload"); ';
                	$javascript .= 'jQuery(this).attr("data-src", jQuery(this).attr("src")); ';
                	$javascript .= 'jQuery(this).attr("src", "'.$lazyload_image.'"); ';
            	$javascript .= '});';
            
			$javascript .= '}';
		}
		
		$javascript .= '});';
				
		JFactory::getDocument()->addScriptDeclaration($javascript);
		
		self::$jqhighres[] = $jQuery_path;
	}
	
	/**
	 * Load the comparison version function if needed
	 */
	static function loadCompareVersions()
	{
		if (self::$jqcompareLoaded) {
			return;
		}
	
		$doc = JFactory::getDocument();
				
		// returns false if version e > t (version is 1.3.2 for example)
		$compareScript = 'function SYWCompareVersions(e,t){var r=!1;if(e==t)return!0;"object"!=typeof e&&(e=e.toString().split(".")),"object"!=typeof t&&(t=t.toString().split("."));for(var o=0;o<Math.max(e.length,t.length);o++){if(void 0==e[o]&&(e[o]=0),void 0==t[o]&&(t[o]=0),Number(e[o])<Number(t[o])){r=!0;break}if(e[o]!=t[o])break}return r};';
			
		$doc->addScriptDeclaration($compareScript);
	
		self::$jqcompareLoaded = true;
	}
	
}
?>

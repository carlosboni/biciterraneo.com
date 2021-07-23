<?php
/**
 * @copyright	Copyright (C) 2011 Simplify Your Web, Inc. All rights reserved.
 * @license		GNU General Public License version 3 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

class SYWFonts 
{	
	//protected static $iconfontLoaded = false;
	protected static $googlefontLoaded = array();
		
	/**
	 * Load the icon font if needed
	 */
	static function loadIconFont($syw_font = true, $icomoon_font = false, $debug = false)
	{	
// 		if (self::$iconfontLoaded) {
// 			return;
// 		}
		
		if ($syw_font) {
    		if ($debug) {
    			//JFactory::getDocument()->addStyleSheet(JURI::base(true).'/media/syw/css/fonts.css');
                JHtml::_('stylesheet', 'syw/fonts.css', array(), true);
    		} else {
    			//JFactory::getDocument()->addStyleSheet(JURI::base(true).'/media/syw/css/fonts-min.css');
                JHtml::_('stylesheet', 'syw/fonts-min.css', array(), true);
    		}
		}
		
		if ($icomoon_font) {
			//JFactory::getDocument()->addStyleSheet(JURI::base(true).'/media/jui/css/icomoon.css');
            JHtml::_('stylesheet', 'jui/icomoon.css', array(), true);
		}
						
		//self::$iconfontLoaded = true;
	}
	
	/**
	 * Load the Google font if needed
	 */
	static function loadGoogleFont($safefont)
	{
		if (isset(self::$googlefontLoaded[$safefont]) && self::$googlefontLoaded[$safefont]) {
			return;
		}
		
		JFactory::getDocument()->addStyleSheet('https://fonts.googleapis.com/css?family='.$safefont);
		
		self::$googlefontLoaded[$safefont] = true;
	}
	
}
?>

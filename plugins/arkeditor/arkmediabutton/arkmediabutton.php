<?php
/*------------------------------------------------------------------------
# Copyright (C) 2014-2015 WebxSolution Ltd. All Rights Reserved.
# @license - GPLv2.0
# Author: WebxSolution Ltd
# Websites:  http://www.webxsolution.com
# Terms of Use: An extension that is derived from the JoomlaCK editor will only be allowed under the following conditions: http://joomlackeditor.com/terms-of-use
# ------------------------------------------------------------------------*/ 

defined('_JEXEC') or die;

/**
 *Ark  Editor Plugin
 *
 * @package     Joomla.Plugin
 * @subpackage  ArkEditor.ArkMediabutton
 */
class PlgArkEditorArkMediabutton extends JPlugin
{
	public function onBeforeInstanceLoaded(&$params)
	{
	   	if(!JPluginHelper::isEnabled('arkmedia','audios') && !JPluginHelper::isEnabled('arkmedia','videos'))
			return "
				editor.on( 'configLoaded', function()
				{
					editor.config.arkMediaProEnabled = 0;
				});";
		else
		{	
			$MediaParams = JComponentHelper::getParams('com_arkmedia');
			
			return "
			editor.on( 'configLoaded', function()
				{
					editor.config.arkMediaProEnabled = 1;
					editor.config.arkMediaWindowDimensions = '". $MediaParams->get('window-dimensions')."';
					editor.config.arkMediaWindowX = '". $MediaParams->get('window-x')."';
					editor.config.arkMediaWindowY = '". $MediaParams->get('window-y')."';
					
					if(this.config.removePlugins.indexOf('imagemanager') == -1)
					{
						if(	this.config.removePlugins)
							this.config.removePlugins += ',imagemanager';
						else
							this.config.removePlugins = 'imagemanager';
					}
					
					
				});";
		}		
	}

	public function onInstanceLoaded(&$params) {}
}

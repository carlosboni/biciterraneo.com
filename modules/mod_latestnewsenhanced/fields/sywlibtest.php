<?php
/**
 * @copyright	Copyright (C) 2011 Simplify Your Web, Inc. All rights reserved.
 * @license		GNU General Public License version 3 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Form\FormField;
use Joomla\CMS\Language\Text;

/*
 * Checks if the SYW library is installed and has the version needed for the extension to run properly
 */
class JFormFieldSYWlibtest extends FormField 
{
	public $type = 'SYWlibtest';
	
	protected $minversion;
	protected $downloadlink;
	
	protected function getLabel()
	{
		return '';
	}
	
	protected function getInput()
	{
		$html = '';
		
		if (!\JFolder::exists(JPATH_ROOT.'/libraries/syw')) {
			$html .= '<div class="alert alert-warning">';
			$html .= '<span>'.Text::_('SYW_MISSING_SYWLIBRARY').'</span><br />';
			$html .= '<a href="'.$this->downloadlink.'" target="_blank">'.Text::_('SYW_DOWNLOAD_SYWLIBRARY').'</a>';
			$html .= '</div>';
		} else {
		    \JLoader::register('SYWVersion', JPATH_LIBRARIES.'/syw/version.php');
			if (!SYWVersion::isCompatible($this->minversion)) {
				$html .= '<div class="alert alert-warning">';
				$html .= '<span>'.Text::_('SYW_NONCOMPATIBLE_SYWLIBRARY').'</span><br />';
				$html .= '<span>'.Text::_('SYW_UPDATE_SYWLIBRARY').' '.Text::_('SYW_OR').' </span>';
				$html .= '<a href="'.$this->downloadlink.'" target="_blank">'.strtolower(Text::_('SYW_DOWNLOAD_SYWLIBRARY')).'</a>';
				$html .= '</div>';
			}
		}
		
		return $html;
	}
	
	public function renderField($options = array())
	{
		if (!\JFolder::exists(JPATH_ROOT.'/libraries/syw')) {
			return parent::renderField();
		} else {
		    \JLoader::register('SYWVersion', JPATH_LIBRARIES.'/syw/version.php');
			if (!SYWVersion::isCompatible($this->minversion)) {
				return parent::renderField();
			}
		}
		
		return '';
	}
	
	public function setup(\SimpleXMLElement $element, $value, $group = null)
	{
		$return = parent::setup($element, $value, $group);
		
		if ($return) {
			$this->minversion = $this->element['minversion'];
			$this->downloadlink = $this->element['downloadlink'];
		}
		
		return $return;
	}
	
}
?>
<?php
/**
 * @copyright	Copyright (C) 2011 Simplify Your Web, Inc. All rights reserved.
 * @license		GNU General Public License version 3 or later; see LICENSE.txt
*/

defined( '_JEXEC' ) or die;

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Form\FormHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

FormHelper::loadFieldClass('list');

class JFormFieldRelatedSelect extends \JFormFieldList
{
	protected $type = 'RelatedSelect';

	protected function getOptions() {
			
		$options = array();
		
		// test the fields folder first to avoid message warning that the component is missing
		if (\JFolder::exists(JPATH_ADMINISTRATOR . '/components/com_contact') && ComponentHelper::isEnabled('com_contact')) {
			$options[] = HTMLHelper::_('select.option', 'contact', Text::_('MOD_LATESTNEWSENHANCEDEXTENDED_RELATEDTOCONTACT'), 'value', 'text', $disable=true );
		}	
		
		// test the fields folder first to avoid message warning that the component is missing
		if (\JFolder::exists(JPATH_ADMINISTRATOR . '/components/com_comprofiler') && ComponentHelper::isEnabled('com_comprofiler')) {
			$options[] = HTMLHelper::_('select.option', 'cb_user_profile', Text::_('MOD_LATESTNEWSENHANCEDEXTENDED_RELATEDTOCBUSERPROFILE'), 'value', 'text', $disable=true );
		}		
		
		// Merge any additional options in the XML definition.
		$options = array_merge(parent::getOptions(), $options);
		
		return $options;
	}
}
?>
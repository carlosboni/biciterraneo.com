<?php
/**
 * @copyright	Copyright (C) 2011 Simplify Your Web, Inc. All rights reserved.
 * @license		GNU General Public License version 3 or later; see LICENSE.txt
 */

defined( '_JEXEC' ) or die;

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Form\FormHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

FormHelper::loadFieldClass('list');

/**
 * unused
 */
class JFormFieldAuthorSelect extends \JFormFieldList
{
	protected $type = 'AuthorSelect';

	protected function getOptions()
	{
		$options = array();

		// test the fields folder first to avoid message warning that the component is missing
		if (\JFolder::exists(JPATH_ADMINISTRATOR . '/components/com_comprofiler') && ComponentHelper::isEnabled('com_comprofiler')) {
			$options[] = HTMLHelper::_('select.option', 'cb_user_profile', Text::_('MOD_LATESTNEWSENHANCEDEXTENDED_VALUE_CBUSERPROFILE'), 'value', 'text', $disable=true );
		}

		// content authors thru SQL

		// old
		// select id, name, username from #__users where id IN (select distinct(created_by) from #__content) order by name ASC

		$db = Factory::getDbo();

		$query = $db->getQuery(true)
		->select('u.id AS value, u.name AS text')
		->from('#__users AS u')
		->join('INNER', '#__content AS c ON c.created_by = u.id')
		->group('u.id, u.name')
		->order('u.name');

		$db->setQuery($query);

		try {
			$authors = $db->loadObjectList();
		} catch (\RuntimeException $e) {
			$authors = array();
		}

		$options = array_merge($options, $authors);

		// Merge any additional options in the XML definition.
		$options = array_merge(parent::getOptions(), $options);

		return $options;
	}
}
?>
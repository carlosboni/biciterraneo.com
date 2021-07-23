<?php 
/**
 * ------------------------------------------------------------------------
 * JA Builder Component
 * ------------------------------------------------------------------------
 * Copyright (C) 2004-2018 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
 * @license - GNU/GPL, http://www.gnu.org/licenses/gpl.html
 * Author: J.O.O.M Solutions Co., Ltd
 * Websites: http://www.joomlart.com - http://www.joomlancers.com
 * ------------------------------------------------------------------------
 */
defined('_JEXEC') or die;

class JabuilderModelRevisions extends JModelList
{
	public function getListQuery() {
		
		$input = JFactory::getApplication()->input;
		
		$page_id = $input->get->get('page_id');
				
		if( empty($page_id))
		{
			return false;
		}
		
		$db = JFactory::getDbo();
		
		$query = $db->getQuery(true);
		
		$query	->select('*')
				->from($db->quoteName('#__jabuilder_pages'))
				->where($db->quoteName('parent').'='. (int) $page_id )
				->order('modified_date desc');
		
		return $query;
	}
}
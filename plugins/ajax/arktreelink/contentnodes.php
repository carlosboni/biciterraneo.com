<?php
/*------------------------------------------------------------------------
# Copyright (C) 2005-2015 WebxSolution Ltd. All Rights Reserved.
# @license - GPLv2.0
# Author: WebxSolution Ltd
# Websites:  http://www.webxsolution.com
# Terms of Use: An extension that is derived from the JoomlaCK editor will only be allowed under the following conditions: http://joomlackeditor.com/terms-of-use
# ------------------------------------------------------------------------*/ 
require_once(JPATH_CONFIGURATION.'/components/com_content/helpers/route.php');
require_once('nodes.php');

defined( '_JEXEC' ) or die( 'Restricted access' );

class contentLinkNodes extends linkNodes
{
	public function  __construct()
	{
		parent::__construct();
	}	
	
	public function getItems()
	{
	
		
		$db = JFactory::getDBO();
		$input = JFactory::getApplication()->input;
		$sectionid = (int) $input->get('sectionid',0);
		$catid = (int) $input->get('catid',0);
		$user	= JFactory::getUser();
		$groups	= implode(',', $user->getAuthorisedViewLevels());
	
		
		$query = '';
		
		if($sectionid || $catid)
		{
			
			
			$section_catid = $sectionid + $catid;
			
			
			$query = '
					SELECT c.title AS name,0 AS sectionid,c.id AS catid, 0 AS id,
					1 AS expandible,
					1 as selectable,
					0 as doc_icon,
					"category" AS type 
					FROM #__categories s
					INNER JOIN #__categories c ON c.parent_id  = s.id  
					WHERE s.id = '. $section_catid .'  
					AND c.published = 1 AND c.extension = "com_content" 
					AND  c.access IN ('.$groups.') 
						 
					UNION 
			
					SELECT title AS name,0 AS sectionid,catid,id, 
					0 AS expandible,
					1 as selectable,
					1 as doc_icon,
					"article" AS type 
					FROM #__content  WHERE catid=' . $section_catid .
					' And state = 1
					  AND access IN ('.$groups.')'; //filter access level
					
		}
		else
		{
			$query = 'SELECT s.title AS name,s.id AS catid,0 AS sectionid, 0 AS id,
					1 AS expandible,
					1 as selectable,
					0 as doc_icon,
					"category" AS type 
					FROM #__categories s
					WHERE EXISTS (select 1 FROM  #__categories c WHERE c.parent_id  = s.id)  
					AND s.published = 1 AND s.extension = "com_content" AND s.parent_id = 1
					AND  s.access IN ('.$groups.')
					 
					UNION
					
					SELECT s.title AS name,s.id AS catid,0 AS sectionid, 0 AS id,
					1 AS expandible,
					1 as selectable,
					0 as doc_icon,
					"category" AS type 
					FROM #__categories s
					WHERE EXISTS (select 1 FROM  #__content i WHERE i.catid = s.id) 
					AND s.published = 1 AND s.extension = "com_content" AND s.parent_id = 1
					AND  s.access IN ('.$groups.')
									
					UNION
				
					SELECT DISTINCT s.title AS name,s.id AS catid,0 AS sectionid, 0 AS id,
					0 AS expandible,
					1 as selectable,
					1 as doc_icon,
					"category" AS type 
					FROM #__categories s
					LEFT JOIN #__content i ON i.catid = s.id
					LEFT JOIN #__categories c ON c.parent_id = s.id 
					WHERE s.published = 1 AND i.id IS NULL AND c.id IS NULL
					AND s.extension = "com_content" AND s.parent_id = 1
					AND  s.access IN ('.$groups.')';

		}
		
		$db->setQuery($query); 
		$nodeList =  $db->loadObjectList();

		return $nodeList;
	
	}
	
	public function getLoadLink($node)
	{
		$config = JFactory::getConfig();
		$config->set('live_site','');
		return JURI::root().'index.php?option=com_ajax&amp;plugin=arktreelink&amp;format=json&amp;action=links&amp;sectionid='.$node->sectionid.'&amp;catid='.$node->catid. '&amp;extension=content';
	}
	
	
	public function getUrl($node)
	{
		$url = '';

		switch($node->type)
		{
		 	case 'article' :
				$url =  str_replace('&','&amp;',ContentHelperRoute::getArticleRoute($node->id,$node->catid));
			break;
			case 'category':
			 	$url = str_replace('&','&amp;', ContentHelperRoute::getCategoryRoute($node->catid));
			break;
		}
	
	 	return $url;	
	}
}
?>
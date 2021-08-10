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

class JabuilderViewPages extends JViewLegacy
{
	function display($tpl=null)
	{
		if( $this->getLayout() !== 'modal' ) {
			JabuilderHeper::addSubmenu('pages');
		}
		$this->addToolbar();
		$this->items = $this->get('Items');
		//$this->sidebar = JHtmlSidebar::render();
		$this->pagination = $this->get('Pagination');
		parent::display($tpl);
	}
	
	function addToolbar()
	{
		JToolBarHelper::title( 'JA Builder Pages' );
		JToolBarHelper::addNew('page.add');		
		JToolBarHelper::deleteList('Be careful!', 'pages.delete');
		//JToolbarHelper::preferences('com_jabuilder');
		JToolbarHelper::divider();
		/*
		$canDo = JHelperContent::getActions('com_jabuilder');
		if ($canDo->get('core.admin') || $canDo->get('core.options'))
		{
		}
		*/
	}
}
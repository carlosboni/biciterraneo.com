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

if (!JFactory::getUser()->authorise('core.manage', 'com_jabuilder'))
{
	throw new JAccessExceptionNotallowed(JText::_('JERROR_ALERTNOAUTHOR'), 403);
}

JLoader::register('JabuilderHeper', __DIR__ . '/helpers/jabuilder.php');

$controller = JControllerLegacy::getInstance('jabuilder');

$input = JFactory::getApplication()->input;

$controller->execute($input->getCmd('task'));

$controller->redirect();
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

JLoader::register('JabuilderHeper', JPATH_ADMINISTRATOR. '/components/com_jabuilder/helpers/jabuilder.php');

$controller = JControllerLegacy::getInstance('jabuilder');

$input = JFactory::getApplication()->input;
// by pass other task
$input->del('layout', 'default');
$input->set('view', 'page');

$controller->execute($input->getCmd('task'));

$controller->redirect();

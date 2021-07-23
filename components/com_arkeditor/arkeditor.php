<?php
/*------------------------------------------------------------------------
# Copyright (C) 2005-2012 WebxSolution Ltd. All Rights Reserved.
# @license - GPLv2.0
# Author: WebxSolution Ltd
# Websites:  http://webx.solutions
# Terms of Use: An extension that is derived from the ARK Editor will only be allowed under the following conditions: http://arkextensions.com/terms-of-use
# ------------------------------------------------------------------------*/ 

defined( '_JEXEC' ) or die();

// Require specific controller
// Controller


if (!JFactory::getUser()->authorise('core.delete', 'com_arkeditor'))
{
	throw new JAccessExceptionNotallowed(JText::_('JERROR_ALERTNOAUTHOR'), 403);
}


// Execute the task.
$controller = JControllerLegacy::getInstance('Arkeditor');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
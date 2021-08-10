<?php
/**
 * @version    3.8.x
 * @package    Simple Image Gallery Pro
 * @author     JoomlaWorks - https://www.joomlaworks.net
 * @copyright  Copyright (c) 2006 - 2020 JoomlaWorks Ltd. All rights reserved.
 * @license    https://www.joomlaworks.net/license
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

class SigProViewMedia extends SigProView
{
    function display($tpl = null)
    {
        $app = JFactory::getApplication();
        $user = JFactory::getUser();
        $document = JFactory::getDocument();
        $token = version_compare(JVERSION, '2.5', 'ge') ? JSession::getFormToken() : JUtility::getToken();
        $this->assignRef('token', $token);

        parent::display($tpl);
    }
}

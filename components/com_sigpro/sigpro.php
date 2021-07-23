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

define('SIGPRO_VERSION', 'v3.8.0');

// Get application
$app = JFactory::getApplication();

$type = JRequest::getCmd('type');
if ($type != 'site' && $type != 'k2') {
    JRequest::setVar('type', 'site');
}
$view = JRequest::getCmd('view', 'galleries');
$task = JRequest::getWord('task');

// Check user is logged in
$user = JFactory::getUser();
if ($user->guest) {
    JError::raiseWarning(403, JText::_('JERROR_ALERTNOAUTHOR'));
    $app->redirect('index.php');
}

// Load admin language
$language = JFactory::getLanguage();
$language->load('com_sigpro', JPATH_ADMINISTRATOR);

// Load the helper and initialize
JLoader::register('SigProHelper', JPATH_COMPONENT_ADMINISTRATOR.'/helper.php');
SigProHelper::initialize();

// Check some variables for security reasons
if ($view == 'media' || $view == 'info' || $view == 'settings') {
    JError::raiseWarning(403, JText::_('JERROR_ALERTNOAUTHOR'));
    $app->redirect('index.php');
}

// K2 galleries permissions check
if ($app->isSite() && $type == 'k2') {
    $folderID = ($view == 'galleries' && $task == 'create') ? JRequest::getCmd('newFolder') : JRequest::getCmd('folder');
    if (is_numeric($folderID)) {
        $itemID = (int) $folderID; // Existing K2 item
    } else {
        $itemID = null; // Temp folder ID used, not an existing K2 item
    }

    require_once JPATH_SITE.'/components/com_k2/helpers/permissions.php';
    K2HelperPermissions::setPermissions();

    JTable::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_k2/tables');
    $item = JTable::getInstance('K2Item', 'Table');
    $item->load($itemID);

    $isNew = is_null($item->id);

    $canAccess = false;

    if (($view == 'galleries' && $task == 'create') || $view == 'gallery') {
        if ($isNew && K2HelperPermissions::canAddItem()) {
            $canAccess = true;
        }
        if (!$isNew && K2HelperPermissions::canEditItem($item->created_by, $item->catid)) {
            $canAccess = true;
        }
    }

    if (!$canAccess) {
        JError::raiseWarning(403, JText::_('JERROR_ALERTNOAUTHOR'));
        $app->redirect('index.php');
    }
}

// Add model path
if (version_compare(JVERSION, '3.0', 'ge')) {
    JModelLegacy::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.'/models');
} else {
    JModel::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.'/models');
}

// Bootstrap
if (JFile::exists(JPATH_COMPONENT_ADMINISTRATOR.'/controllers/'.$view.'.php')) {
    JRequest::setVar('view', $view);
    require_once JPATH_COMPONENT_ADMINISTRATOR.'/controllers/'.$view.'.php';
    $class = 'SigProController'.ucfirst($view);
    $controller = new $class();
    $controller->addViewPath(JPATH_COMPONENT_ADMINISTRATOR.'/views');
    $controller->execute(JRequest::getWord('task'));
    $controller->redirect();
}

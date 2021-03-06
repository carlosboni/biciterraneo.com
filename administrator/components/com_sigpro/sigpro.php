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

$user = JFactory::getUser();

// Check user permissions
if (version_compare(JVERSION, '2.5', 'ge')) {
    if (!$user->authorise('core.manage', 'com_sigpro')) {
        JError::raiseWarning(403, JText::_('JERROR_ALERTNOAUTHOR'));
        $app = JFactory::getApplication();
        $app->redirect('index.php');
    }
}

// Load the helper and initialize
JLoader::register('SigProHelper', JPATH_COMPONENT.'/helper.php');
SigProHelper::initialize();

// Bootstrap
$view = JRequest::getCmd('view', 'galleries');
$type = JRequest::getCmd('type', 'site');
$isSuperUser = version_compare(JVERSION, '2.5', 'ge') ? $user->authorise('core.admin', 'com_sigpro') : $user->gid == 25;
if ($type == 'users' && !$isSuperUser) {
    JError::raiseWarning(403, JText::_('JERROR_ALERTNOAUTHOR'));
    $app = JFactory::getApplication();
    $app->redirect('index.php');
}

if (JFile::exists(JPATH_COMPONENT.'/controllers/'.$view.'.php')) {
    JRequest::setVar('view', $view);
    require_once JPATH_COMPONENT.'/controllers/'.$view.'.php';
    $class = 'SigProController'.ucfirst($view);
    $controller = new $class();
    $controller->execute(JRequest::getWord('task'));
    $controller->redirect();
}

// Update service
$loadUpdateService = false;
if (version_compare(JVERSION, '1.6', 'ge')) {
    if ($user->authorise('core.admin', 'com_sigpro')) {
        $loadUpdateService = true;
    }
} else {
    if ($user->gid > 24) {
        $loadUpdateService = true;
    }
}

if ($loadUpdateService): ?>
<!-- Update Service -->
<script type="text/javascript">
	var APP_INSTALLED_VERSION = '<?php echo SIGPRO_VERSION; ?>';
</script>
<script type="text/javascript" src="https://cdn.joomlaworks.org/updates/sigpro.js?t=<?php echo date('Ymd'); ?>"></script>
<?php endif;

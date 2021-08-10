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

jimport('joomla.application.component.controller');
jimport('joomla.filesystem.file');

class SigProControllerMedia extends SigProController
{
    public function display($cachable = false, $urlparams = array())
    {
        JRequest::setVar('view', 'media');
        parent::display();
    }

    public function connector()
    {
        // Check token
        $method = ($_POST) ? 'post' : 'get';
        if (version_compare(JVERSION, '2.5', 'ge')) {
            JSession::checkToken($method) or jexit(JText::_('JINVALID_TOKEN'));
        } else {
            JRequest::checkToken($method) or jexit(JText::_('JINVALID_TOKEN'));
        }

        $app = JFactory::getApplication();

        // Disable debug
        JRequest::setVar('debug', false);

        // Get paths
        $path = SigProHelper::getPath('site');
        $url = SigProHelper::getHTTPPath($path);

        // Disallow force downloading sensitive file types
        $disallowedFileTypes = array('php', 'ini', 'sql', 'htaccess');
        $target = JRequest::getCmd('target');
        $download = JRequest::getCmd('download');
        if ($target && $download) {
            $filePath = base64_decode(substr($target, 2));
            $fileExtension = strtolower(pathinfo(basename($filePath), PATHINFO_EXTENSION));
            if (in_array($fileExtension, $disallowedFileTypes)) {
                return;
            }
        }

        require_once(JPATH_SITE.'/media/jw_sigpro/assets/vendors/studio-42/elfinder/php/autoload.php');

        function access($attr, $path, $data, $volume)
        {
            $app = JFactory::getApplication();

            // Hide PHP files
            $ext = strtolower(JFile::getExt(basename($path)));

            if ($ext == 'php') {
                return true;
            }

            // Hide files and folders starting with .
            if (strpos(basename($path), '.') === 0 && $attr == 'hidden') {
                return true;
            }

            // Read only access for front-end. Full access for administration section.
            switch ($attr) {
                case 'read':
                    return true;
                    break;
                case 'write':
                    return ($app->isSite()) ? false : true;
                    break;
                case 'locked':
                    return ($app->isSite()) ? true : false;
                    break;
                case 'hidden':
                    return false;
                    break;
            }
        }

        if ($app->isAdmin()) {
            $permissions = array('read' => true, 'write' => true);
        } else {
            $permissions = array('read' => true, 'write' => false);
        }

        $options = array(
            'debug' => false,
            'roots' => array(
                array(
                    'driver' => 'LocalFileSystem',
                    'path' => $path,
                    'URL' => $url,
                    'accessControl' => 'access',
                    'defaults' => $permissions,
                    'mimeDetect' => 'internal',
                    'mimefile' => JPATH_SITE.'/media/jw_sigpro/assets/vendors/studio-42/elfinder/php/mime.types',
                    'uploadDeny' => array('all'),
                    'uploadAllow' => array('image', 'video', 'audio', 'text/plain', 'application/json', 'application/zip', 'application/x-7z-compressed', 'application/x-bzip', 'application/x-bzip2'),
                    'uploadOrder' => array('deny', 'allow')
                )
            )
        );
        $connector = new elFinderConnector(new elFinder($options));
        $connector->run();
    }
}

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

if (version_compare(JVERSION, '3.0', 'ge')) {
    class SigProViewBase extends JViewLegacy
    {
    }
} else {
    class SigProViewBase extends JView
    {
    }
}

class SigProView extends SigProViewBase
{
    public function __construct($config = array())
    {

        // Parent construct
        parent::__construct($config);

        // Add common variables to the view
        $app = JFactory::getApplication();

        $option = JRequest::getCmd('option');
        $this->assignRef('option', $option);

        $view = JRequest::getCmd('view');
        $this->assignRef('view', $view);

        $task = JRequest::getCmd('task');
        $this->assignRef('task', $task);

        $type = JRequest::getCmd('type', 'site');
        $this->assignRef('type', $type);

        $limit = $app->getUserStateFromRequest('global.list.limit', 'limit', $app->getCfg('list_limit'), 'int');
        $this->assignRef('limit', $limit);

        $limitstart = $app->getUserStateFromRequest($option.$view.$type.'.limitstart', 'limitstart', 0, 'int');
        $this->assignRef('limitstart', $limitstart);

        $sorting = $app->getUserStateFromRequest($option.$view.$type.'sorting', 'sorting', 'modified DESC', 'string');
        $this->assignRef('sorting', $sorting);

        $folder = SigProHelper::getVar('folder');
        $this->assignRef('folder', $folder);

        $params = JComponentHelper::getParams('com_sigpro');
        $this->assignRef('params', $params);

        $tmpl = JRequest::getCmd('tmpl', 'index');
        $this->assignRef('tmpl', $tmpl);

        $template = JRequest::getCmd('template');
        $this->assignRef('template', $template);

        $editorName = JRequest::getCmd('editorName');
        $this->assignRef('editorName', $editorName);

        $languages = SiGProHelper::getLanguagesList();
        $this->assignRef('languages', $languages);

        $language = JRequest::getCmd('sigLang');
        $this->assign('language', $language);

        if (version_compare(JVERSION, '3.0', 'ge')) {
            $version = '30';
        } elseif (version_compare(JVERSION, '2.5', 'ge')) {
            $version = '25';
        } else {
            $version = '15';
        }
        $this->assignRef('version', $version);

        // Configure modal drop-downs
        $options = array();
        $options[] = JHTML::_('select.option', '', JText::_('COM_SIGPRO_USE_COMPONENT_SETTING'));
        $options[] = JHTML::_('select.option', 0, JText::_('COM_SIGPRO_NORMAL'));
        $options[] = JHTML::_('select.option', 1, JText::_('COM_SIGPRO_SINGLE_THUMBNAIL'));
        $displayMode = JHTML::_('select.genericlist', $options, 'displayMode', '', 'value', 'text');
        $this->assign('displayMode', $displayMode);

        $options = array();
        $options[] = JHTML::_('select.option', '', JText::_('COM_SIGPRO_USE_COMPONENT_SETTING'));
        $options[] = JHTML::_('select.option', 0, JText::_('COM_SIGPRO_NO_CAPTIONS'));
        $options[] = JHTML::_('select.option', 1, JText::_('COM_SIGPRO_SHOW_GENERIC_MESSAGES'));
        $options[] = JHTML::_('select.option', 2, JText::_('COM_SIGPRO_READ_CONTENTS_OF_CAPTION_FILES'));
        $captionsMode = JHTML::_('select.genericlist', $options, 'captionsMode', '', 'value', 'text');
        $this->assign('captionsMode', $captionsMode);

        $this->assign('galleryLayout', $this->getGalleryLayouts());

        // Add layout path
        $this->addTemplatePath(JPATH_ADMINISTRATOR.'/components/'.$this->option.'/layouts');
        $this->addTemplatePath(JPATH_ADMINISTRATOR.'/components/'.$this->option.'/views/'.$this->view.'/tmpl');

        // Add title and toolbar depending on contenxt
        if (class_exists('JToolBarHelper')) {
            switch ($view) {
                case 'galleries':
                    if ($task == 'add') {
                        JToolBarHelper::title(JText::_('COM_SIGPRO_ADD_GALLERY'), 'sigPro');
                    } else {
                        if ($type == 'k2') {
                            $pageTitle = JText::_('COM_SIGPRO_K2_GALLERIES');
                        } elseif ($type == 'users') {
                            $pageTitle = JText::_('COM_SIGPRO_USER_GALLERIES');
                        } else {
                            $pageTitle = JText::_('COM_SIGPRO_SITE_GALLERIES');
                        }
                        JToolBarHelper::title($pageTitle, 'sigPro');
                    }
                    break;

                case 'gallery':
                    JToolBarHelper::title(JText::_('COM_SIGPRO_EDIT_GALLERY'), 'sigPro');
                    break;

                case 'media':
                case 'info':
                    if ($view == 'info') {
                        JToolBarHelper::title(JText::_('COM_SIGPRO_INFORMATION'), 'sigPro');
                    } else {
                        JToolBarHelper::title(JText::_('COM_SIGPRO_MEDIA_MANAGER'), 'sigPro');
                    }
                    break;
                case 'settings':
                    JToolBarHelper::title(JText::_('COM_SIGPRO_SETTINGS'), 'sigPro');
                    break;
            }
        }

        // Add permissions object to the view
        $user = JFactory::getUser();
        $permissions = new stdClass;
        $permissions->create = version_compare(JVERSION, '1.6', 'ge') ? $user->authorise('core.create', 'com_sigpro') : true;
        $permissions->edit = version_compare(JVERSION, '1.6', 'ge') ? $user->authorise('core.edit', 'com_sigpro') : true;
        $permissions->delete = version_compare(JVERSION, '1.6', 'ge') ? $user->authorise('core.delete', 'com_sigpro') : true;
        if ($this->type == 'k2' || $app->isSite()) {
            $permissions->create = true;
            $permissions->edit = true;
            $permissions->delete = true;
        }
        $this->assignRef('permissions', $permissions);

        // Add styles and scripts if we are in an HTML document
        $document = JFactory::getDocument();
        if ($document->getType() == 'html') {
            if (version_compare(JVERSION, '1.6.0', 'ge')) {
                JHtml::_('script', 'system/core.js', false, true);
            }
            $document->setMetaData("viewport", "width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no");
            JHTML::_('behavior.keepalive');

            // CSS
            if ($this->tmpl == 'component' && version_compare(JVERSION, '1.6.0', 'lt')) {
                $app = JFactory::getApplication();
                $document->addStyleSheet(JURI::root(true).'/administrator/templates/system/css/system.css');
                $document->addStyleSheet(JURI::root(true).'/administrator/templates/'.$app->getTemplate().'/css/icon.css');
            }
            $document->addStyleSheet('https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,300,600,700&subset=latin,cyrillic,greek,vietnamese');
            $document->addStyleSheet(JURI::root(true).'/media/jw_sigpro/assets/css/fonts.css?v=3.8.0');
            $document->addStyleSheet(JURI::root(true).'/media/jw_sigpro/assets/css/style.css?v=3.8.0');

            // JS
            if (version_compare(JVERSION, '3.0', 'ge')) {
                JHtml::_('jquery.framework');
            } else {
                $document->addScript('https://cdn.jsdelivr.net/npm/jquery@1.12.4/dist/jquery.min.js');
            }

            $document->addScript(JURI::root(true).'/media/jw_sigpro/assets/js/script.js?v=3.8.0');

            // No conflict mode for Joomla 1.5 - 2.5
            if (version_compare(JVERSION, '3.0', 'lt')) {
                $document->addScriptDeclaration('jQuery.noConflict();');
            }

            // Filesize limit
            $fileSizeLimit = strtolower(preg_replace("#\s+#s", "", $params->get('fileSizeLimit')));
            $uploadMaxFilesize = ($fileSizeLimit) ? $fileSizeLimit : ini_get('upload_max_filesize');
            $this->assignRef('uploadMaxFilesize', $uploadMaxFilesize);

            // Load language & Plupload variables
            $document->addScriptDeclaration('
                /* SIG Pro */
                var SIGProLanguage = {
                    checking: "'.JText::_('COM_SIGPRO_CHECKING', true).'",
                    uploadMaxFilesize: "'.$uploadMaxFilesize.'",
                    imgDeleteWarning: "'.JText::_('COM_SIGPRO_DELETE_WARNING', true).'",
                    imgLabel: "'.JText::_('COM_SIGPRO_IMAGES', true).'",
                    imgUploadFailed: "'.JText::_('COM_SIGPRO_IMAGE_UPLOAD_FAILED', true).'"
                }
            ');

            // Load the uploader where needed
            if ($view == 'gallery') {
                // Fancybox
                $document->addScript('https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js');
                $document->addStyleSheet('https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css');

                // Plupload
                $document->addScript(JURI::root(true).'/media/jw_sigpro/assets/vendors/moxiecode/plupload/plupload.full.min.js?v=3.8.0');
                $document->addScript(JURI::root(true).'/media/jw_sigpro/assets/vendors/moxiecode/plupload/jquery.plupload.queue/jquery.plupload.queue.js?v=3.8.0');
                //$document->addStyleSheet(JURI::root(true).'/media/jw_sigpro/assets/vendors/moxiecode/plupload/jquery.plupload.queue/css/jquery.plupload.queue.css');

                // Try to load the approprieate language file for the uploader
                $language = JFactory::getLanguage();
                $tag = $language->getTag();
                $tag = str_replace('-', '_', $tag);
                $lang = false;
                if (JFile::exists(JPATH_SITE.'/media/jw_sigpro/assets/vendors/moxiecode/plupload/i18n/'.$tag.'.js')) {
                    $lang = $tag;
                } else {
                    $parts = @explode('_', $tag);
                    if (isset($parts[0]) && JFile::exists(JPATH_SITE.'/media/jw_sigpro/assets/vendors/moxiecode/plupload/i18n/'.$parts[0].'.js')) {
                        $lang = $parts[0];
                    }
                }
                if ($lang) {
                    $document->addScript(JURI::root(true).'/media/jw_sigpro/assets/vendors/moxiecode/plupload/i18n/'.$lang.'.js?v=3.8.0');
                }
            }
            if ($view == 'media') {
                // jQueryUI
                $document->addStyleSheet('https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.min.css');
                $document->addScript('https://code.jquery.com/ui/1.12.1/jquery-ui.min.js');

                // elFinder
                $document->addStyleSheet(JURI::root(true).'/media/jw_sigpro/assets/vendors/studio-42/elfinder/css/elfinder.min.css?v=3.8.0');
                $document->addStyleSheet(JURI::root(true).'/media/jw_sigpro/assets/vendors/studio-42/elfinder/css/theme.css?v=3.8.0');
                $document->addScript(JURI::root(true).'/media/jw_sigpro/assets/vendors/studio-42/elfinder/js/elfinder.min.js?v=3.8.0');

                // Try to load the approprieate language file for the media manager
                $language = JFactory::getLanguage();
                $tag = $language->getTag();
                $tag = str_replace('-', '_', $tag);
                $lang = false;
                if (JFile::exists(JPATH_SITE.'/media/jw_sigpro/assets/vendors/studio-42/elfinder/js/i18n/elfinder.'.$tag.'.js')) {
                    $lang = $tag;
                } else {
                    $parts = @explode('_', $tag);
                    if (isset($parts[0]) && JFile::exists(JPATH_SITE.'/media/jw_sigpro/assets/vendors/studio-42/elfinder/js/i18n/elfinder.'.$parts[0].'.js')) {
                        $lang = $parts[0];
                    }
                }
                if ($lang) {
                    $document->addScript(JURI::root(true).'/media/jw_sigpro/assets/vendors/studio-42/elfinder/js/i18n/elfinder.'.$lang.'.js?v=3.8.0');
                    define('SIGPRO_ELFINDER_LANGUAGE', $lang);
                } else {
                    define('SIGPRO_ELFINDER_LANGUAGE', 'en');
                }
            }
        }

        // Add the toolbar and the title to the view.
        if ($app->isAdmin()) {
            $title = $app->JComponentTitle;
        } else {
            $title = ($this->type == 'k2') ? JText::_('COM_SIGPRO_K2_GALLERIES') : JText::_('COM_SIGPRO_SITE_GALLERIES');
        }
        $this->assignRef('title', $title);
        if ($this->tmpl == 'component' && class_exists('JToolBar')) {
            $toolbar = JToolBar::getInstance('toolbar');
            $toolbar = $toolbar->render('toolbar');
            $this->assignRef('toolbar', $toolbar);
        }
    }

    public function display($tpl = null)
    {
        $user = JFactory::getUser();
        if (version_compare(JVERSION, '2.5', 'ge')) {
            $isSuperUser = $user->authorise('core.admin', 'com_sigpro');
        } else {
            $isSuperUser = $user->gid == 25;
        }

        // Add the menu layout
        if ($this->tmpl == 'component') {
            $menu = '';
        } else {
            ob_start();
            include JPATH_COMPONENT_ADMINISTRATOR.'/layouts/menu.php';
            $menu = ob_get_clean();
        }
        $this->assign('menu', $menu);

        // Add the sidebar layout
        ob_start();
        include JPATH_COMPONENT_ADMINISTRATOR.'/layouts/sidebar.php';
        $sidebar = ob_get_clean();
        $this->assign('sidebar', $sidebar);

        if (isset($this->pagination)) {
            $pagination = $this->pagination;
            if (version_compare(JVERSION, '3.0', 'lt')) {
                $pagination->pagesCurrent = $this->pagination->get('pages.current');
                $pagination->pagesTotal = $this->pagination->get('pages.total');
                $pagination->pagesStart = $this->pagination->get('pages.start');
                $pagination->pagesStop = $this->pagination->get('pages.stop');
            }

            // Add the pagination layout
            ob_start();
            include JPATH_COMPONENT_ADMINISTRATOR.'/layouts/pagination.php';
            $pagination = ob_get_clean();
            $this->assign('pagination', $pagination);
        }
        parent::display($tpl);
    }

    private function getGalleryLayouts()
    {
        jimport('joomla.filesystem.folder');

        $plgTemplatesPath = version_compare(JVERSION, '1.6', 'ge') ? JPATH_SITE.'/plugins/content/jw_sigpro/jw_sigpro/tmpl' : JPATH_SITE.'/plugins/content/jw_sigpro/tmpl';
        $plgTemplatesFolders = JFolder::folders($plgTemplatesPath);

        $db = JFactory::getDBO();
        if (version_compare(JVERSION, '1.6', 'ge')) {
            $query = "SELECT template FROM #__template_styles WHERE client_id = 0 AND home = '1'";
        } else {
            $query = "SELECT template FROM #__templates_menu WHERE client_id = 0 AND menuid = 0";
        }
        $db->setQuery($query);
        $template = $db->loadResult();
        $templatePath = JPATH_SITE.'/templates/'.$template.'/html/jw_sigpro';

        if (JFolder::exists($templatePath)) {
            $templateFolders = JFolder::folders($templatePath);
            $folders = @array_merge($templateFolders, $plgTemplatesFolders);
            $folders = @array_unique($folders);
        } else {
            $folders = $plgTemplatesFolders;
        }

        sort($folders);

        $options = array();
        $options[] = JHTML::_('select.option', '', JText::_('COM_SIGPRO_USE_COMPONENT_SETTING'));
        foreach ($folders as $folder) {
            $options[] = JHTML::_('select.option', $folder, $folder);
        }
        return JHTML::_('select.genericlist', $options, 'galleryLayout', '', 'value', 'text');
    }
}

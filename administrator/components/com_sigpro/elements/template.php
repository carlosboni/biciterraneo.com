<?php
/**
 * @version    3.8.x
 * @package    Simple Image Gallery Pro
 * @author     JoomlaWorks - https://www.joomlaworks.net
 * @copyright  Copyright (c) 2006 - 2020 JoomlaWorks Ltd. All rights reserved.
 * @license    https://www.joomlaworks.net/license
 */

defined('_JEXEC') or die;

require_once(dirname(__FILE__).'/base.php');

class JWElementTemplate extends JWElement
{
    public function fetchElement($name, $value, &$node, $control_name)
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
        foreach ($folders as $folder) {
            $options[] = JHTML::_('select.option', $folder, $folder);
        }
        $fieldName = version_compare(JVERSION, '1.6', 'ge') ? $name : $control_name.'['.$name.']';
        return JHTML::_('select.genericlist', $options, $fieldName, '', 'value', 'text', $value);
    }
}

class JFormFieldTemplate extends JWElementTemplate
{
    public $type = 'template';
}

class JElementTemplate extends JWElementTemplate
{
    public $_name = 'template';
}

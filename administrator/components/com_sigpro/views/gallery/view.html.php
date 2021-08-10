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

class SigProViewGallery extends SigProView
{
    public function display($tpl = null)
    {
        $model = $this->getModel();
        $model->setState('type', $this->type);
        $model->setState('folder', $this->folder);
        $model->setState('language', $this->language);
        $gallery = $model->getData();
        $this->assignRef('row', $gallery);
        if ($this->type == 'k2') {
            $heading = 'COM_SIGPRO_EDITING_GALLERY_OF_K2_ITEM';
        } else {
            $heading = 'COM_SIGPRO_EDITING_GALLERY';
        }
        if ($gallery->name) {
            $heading = JText::sprintf($heading, $gallery->name);
        } else {
            $heading = '';
        }
        $this->assignRef('heading', $heading);
        parent::display($tpl);
    }

    public function add($tpl = null)
    {
        $this->addTemplatePath(JPATH_ADMINISTRATOR.'/components/'.$this->option.'/views/gallery/tmpl');
        $this->setLayout('add');
        parent::display($tpl);
    }
}

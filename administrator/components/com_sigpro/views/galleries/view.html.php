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

class SigProViewGalleries extends SigProView
{
    public function display($tpl = null)
    {
        $model = SigProModel::getInstance('Galleries', 'SigProModel');
        $model->setState('limit', $this->limit);
        $model->setState('limitstart', $this->limitstart);
        $model->setState('sorting', $this->sorting);
        $model->setState('type', $this->type);
        $galleries = $model->getData();
        $this->assignRef('rows', $galleries);

        $total = $model->getState('total');
        $this->assignRef('total', $total);

        jimport('joomla.html.pagination');
        $pagination = new JPagination($total, $this->limitstart, $this->limit);
        $this->assignRef('pagination', $pagination);

        if ($this->type == 'k2') {
            $frameSrc = 'index.php?option=com_k2&view=items&tmpl=component&context=modalselector&fname=newFolder';
            $frameHeight = 450;
            $frameClass = 'sigProModalK2ItemsFrame';
        } else {
            $frameSrc = 'index.php?option=com_sigpro&view=galleries&task=add&tmpl=component&editorName='.$this->editorName.'&type='.$this->type.'&parentTmpl='.$this->tmpl;
            $frameHeight = 50;
            $frameClass = 'sigProModalAddGalleryFrame';
        }
        if ($this->template) {
            $frameSrc .= '&template='.$this->template;
        }
        $frameSrc = JRoute::_($frameSrc);
        $this->assignRef('frameSrc', $frameSrc);
        $this->assignRef('frameHeight', $frameHeight);
        $this->assignRef('frameClass', $frameClass);

        $options = array();
        $options[] = JHTML::_('select.option', 'folder ASC', JText::_('COM_SIGPRO_FOLDER_NAME_ASC'));
        $options[] = JHTML::_('select.option', 'folder DESC', JText::_('COM_SIGPRO_FOLDER_NAME_DESC'));
        $options[] = JHTML::_('select.option', 'modified ASC', JText::_('COM_SIGPRO_MODIFIED_DATE_ASC'));
        $options[] = JHTML::_('select.option', 'modified DESC', JText::_('COM_SIGPRO_MODIFIED_DATE_DESC'));
        $lists = array();
        $lists['sorting'] = JHTML::_('select.genericlist', $options, 'sorting', 'onchange="this.form.submit();"', 'value', 'text', $this->sorting);
        $this->assignRef('lists', $lists);

        parent::display($tpl);
    }
}

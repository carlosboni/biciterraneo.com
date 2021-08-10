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

?>

<div class="sigTopWhiteFix"></div>
<div class="sigGrayFix"></div>
<div id="sigPro" class="J<?php echo $this->version; if($this->tmpl == 'component')  echo ' sigProModalSite'; ?> sigPermissions">
    <div class="sigProHeader sigBoldMenu">
        <div class="sigProTopRow"></div>
        <div class="sigProLogo sigFloatLeft">
            <i class="hidden"><?php echo JText::_('COM_SIGPRO'); ?></i>
        </div>
        <span class="sigMenuVersion"><?php echo SIGPRO_VERSION; ?></span>
        <div class="sigProMenu sigFloatRight">
            <ul class="darkMenu">
                <li><a href="#" onclick="Joomla.submitbutton('save')" class="sigProMenuItems"><?php echo JText::_('COM_SIGPRO_SAVE_AND_CLOSE'); ?></a></li>
                <li><a href="#" onclick="Joomla.submitbutton('apply')" class="sigProMenuItems"><?php echo JText::_('COM_SIGPRO_SAVE'); ?></a></li>
                <li><a href="#" onclick="Joomla.submitbutton('cancel')" class="sigProMenuItems"><?php echo JText::_('COM_SIGPRO_CLOSE'); ?></a></li>
            </ul>
        </div>
    </div>

    <div id="adminFormContainer" class="sigInformationForm">
        <form action="<?php echo JRoute::_('index.php'); ?>" method="post" name="adminForm" id="adminForm" class="sigInformationForm">
            <div class="sigProToolbar sigTransition sigBoxSizing sigSlidingItem">
                <div class="sigProUpperToolbar sigInformationToolbar">
                    <h3 class="sigProPageTitle sigPurple"><?php echo strip_tags($this->title); ?></h3>
                </div>
            </div>

            <?php echo $this->sidebar; ?>

            <div class="sigProGrid sigInformationWrap sigTransition sigSlidingItem">

                <?php if(version_compare(JVERSION, '2.5.0', 'ge')): ?>
                <div class="sigInformationNav sigSideNavBar sigTransition sigSlidingItem">
                    <ul class="sigSideNav">
                        <?php foreach($this->form->getFieldsets() as $name => $fieldset): ?>
                        <li><a href="#<?php echo $name; ?>" class="sigAnchor"><?php echo JText::_($fieldset->label); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <?php foreach($this->form->getFieldsets() as $name => $fieldset): ?>
                <div class="sigSettingsFieldSet">
                    <h3 class="sigPermissionHeader" id="<?php echo $name; ?>"><?php echo JText::_($fieldset->label); ?></h3>
                    <?php if (isset($fieldset->description) && !empty($fieldset->description)): ?>
                    <p><?php echo JText::_($fieldset->description); ?></p>
                    <?php endif; ?>

                    <?php foreach ($this->form->getFieldset($name) as $field): ?>
                    <div class="sigFieldsetRow sig<?php echo $name; ?>Fieldset">
                        <?php echo $field->label; ?>
                        <?php echo $field->input; ?>
                    </div>
                    <div class="clr"></div>
                    <?php endforeach; ?>
                </div>
                <?php endforeach; ?>

                <div class="sigSettingsDummyHeight"></div>

                <?php else: ?>

                <div class="sigInformationNav sigSideNavBar sigSlidingItem sigTransition">
                    <ul class="sigSideNav">
                        <?php foreach($this->form->_xml as $fieldset): ?>
                        <li><a href="#<?php echo $fieldset->attributes('group'); ?>" class="sigAnchor"><?php echo JText::_($fieldset->attributes('label')); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <?php foreach($this->form->_xml as $fieldset): ?>
                <div class="sigSettingsFieldSet">
                    <h3 class="sigPermissionHeader" id="<?php echo $fieldset->attributes('group'); ?>"><?php echo JText::_($fieldset->attributes('label')); ?></h3>
                    <?php if ($fieldset->attributes('description')): ?>
                    <p><?php echo JText::_($fieldset->attributes('description')); ?></p>
                    <?php endif; ?>
                    <div class="sigFieldsetRow sig<?php echo $fieldset->attributes('group'); ?>Fieldset">
                        <?php echo $this->form->render('params', $fieldset->attributes('group')); ?>
                    </div>
                    <div class="clr"></div>
                </div>
                <?php endforeach; ?>

                <div class="sigSettingsDummyHeight"></div>
                <?php endif; ?>
            </div>

            <!-- Dummy input to fix broken JS in Joomla 3.x -->
            <input type="hidden" name="jform_title" id="jform_title" value="" />

            <input type="hidden" name="id" value="<?php echo $this->id;?>" />
            <input type="hidden" name="component" value="com_sigpro" />
            <input type="hidden" name="option" value="com_sigpro" />
            <input type="hidden" name="view" value="settings" />
            <input type="hidden" id="task" name="task" value="" />
            <input type="hidden" name="return" value="<?php echo JRequest::getVar('return'); ?>" />
            <?php echo JHTML::_('form.token'); ?>
        </form>
    </div>
</div>
<div class="sigBtmWhiteFix"></div>

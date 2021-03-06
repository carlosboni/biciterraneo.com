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

$document = JFactory::getDocument();
$document->addScriptDeclaration('
    /* SIG Pro - Gallery Edit Form */
    function SigProGalleryDelete() {
        if (document.adminForm.boxchecked.value == 0) {
            alert("'.JText::_('COM_SIGPRO_NO_ROWS_SELECTED', true).'");
        } else {
            if (confirm("'.JText::_('COM_SIGPRO_YOU_ARE_GOING_TO_DELETE_PERMANENTLY_THE_SELECTED_IMAGES_FROM_THE_SERVER_ARE_YOU_SURE', true).'")) {
                Joomla.submitbutton("delete");
                return false;
            }
        }
    }
');

?>

<div class="sigTopWhiteFix"></div>
<div class="sigGrayFix"></div>

<div id="sigProModal">
    <div id="sigProUploaderContainer">
        <div id="sigProUploader"></div>
        <span class="sigProSubNote"><?php echo JText::_('COM_SIGPRO_MAX_UPLOAD_SIZE'); ?>: <b><?php echo ini_get('upload_max_filesize'); ?></b> / <?php echo JText::_('COM_SIGPRO_FILE_SIZE_LIMIT_NOTICE'); ?>: <b><?php echo $this->uploadMaxFilesize; ?></b></span>
        <a class="sigProModalCloseButton floatRight"><?php echo JText::_('COM_SIGPRO_CLOSE'); ?><i class="sig-icon sig-icon-cancel-circled"></i></a>
        <div class="clr"></div>
    </div>
</div>

<div id="sigPro" class="J<?php echo $this->version; if(count($this->row->images) == 0) { echo ' sigProGalleryEmpty';} if($this->tmpl == 'component')  { echo ' sigProModalSite'; } ?>">
    <div class="sigProHeader sigBoldMenu">
        <div class="sigProTopRow"></div>
        <div class="sigProLogo sigFloatLeft">
            <i class="hidden"><?php echo JText::_('COM_SIGPRO'); ?></i>
        </div>
        <span class="sigMenuVersion"><?php echo SIGPRO_VERSION; ?></span>
        <div class="sigProMenu sigFloatRight">
            <ul class="darkMenu">
                <?php if($this->type == 'k2' && $this->tmpl == 'component'): ?>
                <?php if($this->permissions->edit): ?>
                <li><a href="#" onclick="return SigProGalleryAction('apply');" class="sigProMenuItems"><?php echo JText::_('COM_SIGPRO_SAVE'); ?></a></li>
                <?php endif; ?>
                <?php else: ?>
                <?php if($this->permissions->edit): ?>
                <li><a href="#" onclick="return SigProGalleryAction('save')" class="sigProMenuItems"><?php echo JText::_('COM_SIGPRO_SAVE_AND_CLOSE'); ?></a></li>
                <li><a href="#" onclick="return SigProGalleryAction('apply')" class="sigProMenuItems"><?php echo JText::_('COM_SIGPRO_SAVE'); ?></a></li>
                <?php endif; ?>
                <li><a href="#" onclick="return SigProGalleryAction('cancel')" class="sigProMenuItems"><?php echo JText::_('COM_SIGPRO_CLOSE'); ?></a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <div class="sigProClearFix"></div>
    <div id="adminFormContainer">
        <form action="index.php" enctype="multipart/form-data" method="post" name="adminForm" id="adminForm">
            <div class="sigProToolbar sigTransition sigBoxSizing sigSlidingItem">
                <div class="sigProUpperToolbar">
                    <?php $galTitle = explode(':',$this->heading); ?>
                    <h3 class="sigProEditingGalleryTitle">
                        <span class="sigPurple hide-on-tablet"><?php if ($galTitle[0]) echo $galTitle[0].': '; ?></span>
                        <span class="sigStrong"><?php if (isset($galTitle[1])) echo trim($galTitle[1]); ?></span>
                        <span id="sigProImageCounter">(<?php echo count($this->row->images); ?> <span class="hide-on-tablet"><?php echo JText::_('COM_SIGPRO_IMAGES'); ?></span>)</span>
                    </h3>
                    <?php if($this->permissions->edit): ?>
                    <a href="#" onclick="return SigProGalleryAction('add')" class="sigProBtnadd"><?php echo JText::_('COM_SIGPRO_ADD_FILES'); ?></a>
                    <?php endif; ?>
                    <div class="sigProLanguageSwitcher sigProOrdering">
                        <label class="selectHeading"><?php echo JText::_('COM_SIGPRO_LABELS_LANGUAGE'); ?></label>
                        <?php echo $this->languages; ?>
                    </div>
                </div>

                <div class="sigProClearFix"></div>

                <div class="sigProLowerToolbar">
                    <div class="sigFloatLeft sigThin sigPro50">
                        <span id="selectedCount" class="sigPurple"></span> <?php echo JText::_('COM_SIGPRO_SELECTED'); ?>
                        <span id="selectedItem">
                            <span id="sigSel1" class="hidden"><?php echo JText::_('COM_SIGPRO_ITEM'); ?></span>
                            <span id="sigSel2" class="hidden"><?php echo JText::_('COM_SIGPRO_ITEMS'); ?></span>
                        </span>
                    </div>
                    <?php if($this->permissions->edit): ?>
                    <div class="sigFloatLeft sigPro50 sigProItemDeleteLinks">
                        <a href="#" onclick="SigProGalleryDelete()" class="sig-icon-trash">Delete</a>
                    </div>
                    <?php endif; ?>
                </div>

            </div>

            <?php echo $this->sidebar; ?>

            <div class="sigProClearFix"></div>

            <div class="sigProGrid sigTransition sigBoxSizing sigSlidingItem">

                <div class="sigProGalleryEmptyMessage">
                    <?php if($this->permissions->edit): ?>
                    <h2 class="sigTextCenter"><?php echo JText::_('COM_SIGPRO_CLICK_ON_THE_ADD_IMAGES_BUTTON_TO_UPLOAD_SOME_IMAGES'); ?></h2>
                    <?php endif; ?>
                    <div class="sigProGalleryEmptyBody sigTextCenter">
                        <div class="sig-icon hugeNoGalleryIcon sig-icon-picture"></div>
                        <?php echo JText::_('COM_SIGPRO_THIS_GALLERY_IS_EMPTY'); ?>
                    </div>
                </div>

                <?php $counter = 0; foreach ($this->row->images as $image): ?>
                <div class="sigProGalleryImage sigProGridColumn">
                    <?php if($this->permissions->edit): ?>
                    <span class="sigCheckWrapper">
                        <label class="sigCheckbox" for="cb<?php echo $counter; ?>">
                            <span class="sigIcon"></span><span class="sigIconFade sig-icon-check"></span>
                            <?php echo JHTML::_('grid.id', $counter, $image->name, false, 'image'); ?>
                        </label>
                    </span>
                    <?php endif; ?>
                    <div class="sigProGalleryInner">
                        <div class="sigProImageContainer">
                            <?php if(!$this->editorName): ?>
                            <a class="sigProPreviewButton sig-icon" data-fancybox="galleryView" title="<?php echo $image->path; ?>" href="<?php echo $image->path; ?>">
                                <span>??? <i class="hidden"><?php echo JText::_('COM_SIGPRO_PREVIEW'); ?></i></span></a>
                            <?php endif; ?>
                            <div class="sigProGalleryPreviewImage sigCover sigSafeTransition" style="background-image:url('<?php echo $image->url; ?>');"></div>
                        </div>

                        <div class="sigProGalleryTextInner">
                            <label><?php echo JText::_('COM_SIGPRO_TITLE'); ?></label>
                            <input type="text" name="titles[]" placeholder="<?php echo JText::_('COM_SIGPRO_GALLERY_PLACEHOLDER_TITLE'); ?>" value="<?php echo htmlspecialchars($image->title, ENT_QUOTES, 'UTF-8'); ?>"<?php if (!$this->permissions->edit) echo ' readonly="readonly"'; ?> />

                            <label><?php echo JText::_('COM_SIGPRO_DESCRIPTION'); ?></label>
                            <textarea rows="5" cols="30" name="descriptions[]" placeholder="<?php echo JText::_('COM_SIGPRO_GALLERY_PLACEHOLDER_DESCRIPTION'); ?>"<?php if (!$this->permissions->edit) echo ' readonly="readonly"'; ?>><?php echo $image->description; ?></textarea>

                            <input type="hidden" class="sigProFilename" name="filenames[]" value="<?php echo $image->name; ?>" />
                            <div class="sigProImageInfo">
                                <div class="sigProImageName sigProCollapse">
                                    <strong><?php echo JText::_('COM_SIGPRO_FILE_NAME'); ?></strong>: <span class="sigProImageNameValue"><?php echo $image->name; ?></span>
                                </div>
                                <div class="sigProImageSize">
                                    <strong><?php echo JText::_('COM_SIGPRO_FILE_SIZE'); ?></strong>: <span class="sigProImageSizeValue"><?php echo $image->size; ?></span> KB
                                </div>
                                <div class="clr"></div>
                                <div class="sigProImageDimensions sigFloatLeft">
                                    <strong><?php echo JText::_('COM_SIGPRO_IMAGE_DIMENSIONS'); ?></strong>: <span class="sigProImageDimensionsValue"><?php echo $image->dimensions; ?></span> px
                                </div>
                                <?php if($this->permissions->edit): ?>
                                <div class="sigProImageToolbar sigFloatRight">
                                     <a class="sigProDeleteButton sig-icon-trash" title="<?php echo JText::_('COM_SIGPRO_DELETE'); ?>" href="<?php echo $image->name; ?>"><?php echo JText::_('COM_SIGPRO_DELETE'); ?></a>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                     </div>
                </div>
                <?php $counter++; endforeach; ?>
            </div>

            <!-- Block template for new images  -->
            <div class="sigProGalleryImage sigProGridColumn" id="sigProImageTemplate">
                <?php if($this->permissions->delete): ?>
                <span class="sigCheckWrapper">
                    <label class="sigCheckbox">
                        <span class="sigIcon"></span><span class="sigIconFade sig-icon-check"></span>
                        <input type="checkbox" name="image[]" />
                    </label>
                </span>
                <?php endif; ?>
                <div class="sigProGalleryInner">
                    <div class="sigProImageContainer">
                        <?php if(!$this->editorName): ?>
                        <a class="sig-icon" title="" href="">
                            <span>??? <i class="hidden"><?php echo JText::_('COM_SIGPRO_PREVIEW'); ?></i></span>
                        </a>
                        <?php endif; ?>
                        <div class="sigProGalleryPreviewImage sigCover sigSafeTransition"></div>
                    </div>
                    <div class="sigProGalleryTextInner">
                        <label><?php echo JText::_('COM_SIGPRO_TITLE'); ?></label>
                        <input type="text" name="titles[]" placeholder="<?php echo JText::_('COM_SIGPRO_GALLERY_PLACEHOLDER_TITLE'); ?>" value=""<?php if (!$this->permissions->edit) echo ' readonly="readonly"'; ?> />

                        <label><?php echo JText::_('COM_SIGPRO_DESCRIPTION'); ?></label>
                        <textarea rows="5" cols="30" name="descriptions[]" placeholder="<?php echo JText::_('COM_SIGPRO_GALLERY_PLACEHOLDER_DESCRIPTION'); ?>"<?php if (!$this->permissions->edit) echo ' readonly="readonly" '; ?>></textarea>

                        <input type="hidden" class="sigProFilename" name="filenames[]" value="" />
                        <div class="sigProImageInfo">
                            <div class="sigProImageName sigProCollapse">
                                <strong><?php echo JText::_('COM_SIGPRO_FILE_NAME'); ?></strong>: <span class="sigProImageNameValue"></span>
                            </div>
                            <div class="sigProImageSize">
                                <strong><?php echo JText::_('COM_SIGPRO_FILE_SIZE'); ?></strong>: <span class="sigProImageSizeValue"></span> KB
                            </div>
                            <div class="sigProImageDimensions sigFloatLeft">
                                <strong><?php echo JText::_('COM_SIGPRO_IMAGE_DIMENSIONS'); ?></strong>: <span class="sigProImageDimensionsValue"></span> px
                            </div>
                            <div class="sigProImageToolbar sigFloatRight">
                              <a class="sigProDeleteButton sig-icon-trash" title="<?php echo JText::_('COM_SIGPRO_DELETE'); ?>" href=""><?php echo JText::_('COM_SIGPRO_DELETE'); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="folder" value="<?php echo $this->row->folder; ?>" />
            <input type="hidden" name="file" value="" />
            <input type="hidden" name="option" value="com_sigpro" />
            <input type="hidden" name="view" value="gallery" />
            <input type="hidden" name="task" value="" />
            <input type="hidden" name="type" value="<?php echo $this->type; ?>" />
            <input type="hidden" name="tmpl" value="<?php echo $this->tmpl; ?>" />
            <input type="hidden" name="editorName" value="<?php echo $this->editorName; ?>" />
            <input type="hidden" name="boxchecked" value="0" />
            <?php if($this->template): ?>
            <input type="hidden" name="template" value="<?php echo $this->template; ?>" />
            <?php endif; ?>
            <?php echo JHTML::_('form.token'); ?>
        </form>
    </div>
</div>
<div class="sigBtmWhiteFix"></div>

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
    /* SIG Pro */
    jQuery(function($) {
        $(document).ready(function() {
            if ($("#sigProMediaManager").length) {
                function renderElFinder() {
                    var mmOffset = $("#elfinder").offset().top;
                    // Position
                    if ($("body").hasClass("contentpane")) {
                        // In a modal
                        var mediaHeight = 600
                    } else if ($("body").hasClass("isJVersion30")) {
                        // Joomla 3.x
                        var statusBarOffset = $("#status").offset().top;
                        var mediaHeight = (statusBarOffset - mmOffset);
                    } else {
                        // Joomla 1.5 & 2.5
                        var mediaHeight = ($(window).height() - mmOffset) - 200;
                    }
                    $("#elfinder").elfinder({
                        url: "'.JURI::base(true).'/index.php?option=com_sigpro&view=media&task=connector",
                        soundPath: "'.JURI::root(true).'/media/jw_sigpro/assets/vendors/studio-42/elfinder/sounds/",
                        lang: "'.SIGPRO_ELFINDER_LANGUAGE.'",
                        customData: {
                            "'.$this->token.'": 1
                        },
                        uiOptions: {
                            toolbar: [
                                ["home", "back", "forward", "up", "reload"],
                                ["mkdir", "mkfile", "upload"],
                                ["open", "download", "getfile"],
                                ["undo", "redo"],
                                ["copy", "cut", "paste", "rm", "empty", "hide"],
                                ["duplicate", "rename", "edit", "resize", "chmod"],
                                ["selectall", "selectnone", "selectinvert"],
                                ["quicklook", "info"],
                                ["extract", "archive"],
                                ["search"],
                                ["view", "sort"]
                            ]
                        },
                        onlyMimes: ["image", "text"],
                        resizable: true,
                        height: mediaHeight
                    });
                }
                renderElFinder();
                var resizeTimer;
                $(window).on("resize", function(e) {
                    clearTimeout(resizeTimer);
                    resizeTimer = setTimeout(function() {
                        $("#elfinder").elfinder("destroy");
                        renderElFinder();
                    }, 1000);
                });
            }
        });
    });
');

?>

<div class="sigTopWhiteFix"></div>
<div class="sigMiddleWhiteFix"></div>
<div id="sigPro" class="J<?php echo $this->version; ?>">
    <div class="sigProHeader sigLight">
        <div class="sigProTopRow"></div>
        <div class="sigProLogo sigFloatLeft">
            <i class="hidden"><?php echo JText::_('COM_SIGPRO'); ?></i>
        </div>
        <span class="sigMenuVersion"><?php echo SIGPRO_VERSION; ?></span>
        <?php echo $this->menu; ?>
    </div>
    <div class="sigProToolbar sigTransition sigBoxSizing sigSlidingItem">
        <div class="sigProUpperToolbar sigInformationToolbar">
            <h3 class="sigProPageTitle sigPurple"><?php echo strip_tags($this->title); ?></h3>
        </div>
    </div>
    <?php echo $this->sidebar; ?>
    <div id="sigProMediaManager" class="sigTransition sigSlidingItem">
        <div id="elfinder"></div>
    </div>
</div>
<div class="sigBtmWhiteFix"></div>

<?php
/**
 * @version     3.8.x
 * @package     Simple Image Gallery Pro
 * @author      JoomlaWorks - https://www.joomlaworks.net
 * @copyright   Copyright (c) 2006 - 2015 JoomlaWorks Ltd. All rights reserved.
 * @license     https://www.joomlaworks.net/license
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

$document->addStylesheet('https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css');
$document->addScript('https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js');
$document->addScriptDeclaration('
    (function($){
        $(document).ready(function($){
            $(\'#sigProSlickShow1'.$gal_id.' .sigpro-for\').slick({
                arrows: false,
                asNavFor: \'#sigProSlickShow1'.$gal_id.' .sigpro-slider\',
                fade: true,
                slidesToScroll: 1,
                slidesToShow: 1
            });
            $(\'#sigProSlickShow1'.$gal_id.' .sigpro-slider\').slick({
                asNavFor: \'#sigProSlickShow1'.$gal_id.' .sigpro-for\',
                centerMode: true,
                dots: true,
                focusOnSelect: true,
                slidesToScroll: 1,
                slidesToShow: 3
            });
        });
    })(jQuery);
');

?>
<div id="sigProSlickShow1<?php echo $gal_id; ?>" class="sigProContainer sigProSlickShow1Container<?php echo $extraWrapperClass; ?>">
    <div id="sigProId<?php echo $gal_id; ?>" class="sigpro-for sigProSlickShow1<?php echo $extraWrapperClass; ?>">
        <?php foreach($gallery as $count=>$photo): ?>
        <div class="sigMainThumb">
            <span class="sigProLinkOuterWrapper">
                <span class="sigProLinkWrapper">
                    <?php if(($gal_singlethumbmode && $count==0) || !$gal_singlethumbmode): ?>
                    <a class="sigProLink sigProMainImage <?php echo $extraClass; ?>" data-rel="<?php echo $relName; ?>[gallery<?php echo $gal_id; ?>]" rel="<?php echo $relName; ?>[gallery<?php echo $gal_id; ?>]" href="<?php echo $photo->sourceImageFilePath; ?>" target="_blank" style="background-image: url(<?php echo $photo->sourceImageFilePath; ?>); padding-bottom: <?php echo ($photo->height / $photo->width) * 100; ?>%" title="<?php echo JText::_('JW_SIGP_PLG_CLICK_TO_ENLARGE_IMG').' '.$photo->filename; ?>"<?php echo $customLinkAttributes; ?>>
                        <?php if($gal_captions): ?>
                        <span class="sigProCaption" title="<?php echo $photo->captionTitle; ?>"><?php echo $photo->captionTitle; ?></span>
                        <?php endif; ?>
                    </a>
                    <?php endif; ?>
                </span>
            </span>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="sigpro-slider sigProSlickShow1<?php echo $extraWrapperClass; ?>">
        <?php foreach($gallery as $count=>$photo): ?>
        <div class="sigProThumb">
            <span class="sigProSlickShow1Link sigProSlickShow1LinkEmpty">
            <img class="sigProImg" src="<?php echo $transparent; ?>" alt="<?php echo JText::_('JW_SIGP_PLG_CLICK_TO_ENLARGE_IMG').' '.$photo->filename; ?>" title="<?php echo JText::_('JW_SIGP_PLG_CLICK_TO_ENLARGE_IMG').' '.$photo->filename; ?>" style="width:<?php echo $photo->width; ?>px;height:<?php echo $photo->height; ?>px;background-image:url('<?php echo $photo->thumbImageFilePath; ?>');" />
            </span>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php if(isset($flickrSetUrl)): ?>
<a class="sigProFlickrSetLink" title="<?php echo $flickrSetTitle; ?>" target="_blank" href="<?php echo $flickrSetUrl; ?>"><?php echo JText::_('JW_SIGP_PLG_FLICKRSET'); ?></a>
<?php endif; ?>

<?php if($itemPrintURL): ?>
<div class="sigProPrintMessage">
    <?php echo JText::_('JW_SIGP_PLG_PRINT_MESSAGE'); ?>:
    <br />
    <a title="<?php echo $row->title; ?>" href="<?php echo $itemPrintURL; ?>"><?php echo $itemPrintURL; ?></a>
</div>
<?php endif; ?>
<div class="clr"></div>

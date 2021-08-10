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

<div class="sigProPaginationPages">
    <div class="sigFloatRight sigProPageItem hide-on-tablet">
        <?php if($pagination->pagesTotal): ?>
        <?php echo JText::_('COM_SIGPRO_PAGE'); ?> <b><?php echo $pagination->pagesCurrent; ?></b>
        <?php echo JText::_('COM_SIGPRO_OF'); ?> <b><?php echo $pagination->pagesTotal; ?></b>
        <?php endif; ?>
    </div>
    <ul class="sigFloatRight">
        <li class="pagination-start"><a href="#" onclick="SigProPagination(0)" class="sig-icon-to-start"><i class="hidden"><?php echo JText::_('COM_SIGPRO_START'); ?></i></a></li>
        <?php if(($pagination->pagesCurrent - 1) > 0) : ?>
        <li class="pagination-prev"><a href="#" onclick="SigProPagination(<?php echo ((($pagination->pagesCurrent - 1) * $pagination->limit) - $pagination->limit); ?>)" class="sig-icon-left-dir"><i class="hidden"><?php echo JText::_('COM_SIGPRO_PREVIOUS'); ?></i></a></li>
        <?php endif; ?>
        <?php for($i = $pagination->pagesStart; $i <= $pagination->pagesStop; $i++) : ?>
        <li class="pagination-page"><a <?php if($i == $pagination->pagesCurrent): ?> class="sigActive" <?php endif; ?> href="#" onclick="SigProPagination(<?php echo (($i * $pagination->limit) - $pagination->limit); ?>)"><?php echo $i; ?></a></li>
        <?php endfor; ?>
        <?php if(($pagination->pagesCurrent + 1) <= $pagination->pagesTotal) : ?>
        <li class="pagination-next"><a href="#" onclick="SigProPagination(<?php echo ($pagination->pagesCurrent * $pagination->limit); ?>)" class="sig-icon-right-dir"><i class="hidden"><?php echo JText::_('COM_SIGPRO_NEXT'); ?></i></a></li>
        <?php endif; ?>
        <li class="pagination-end"><a href="#" onclick="SigProPagination(<?php echo ($pagination->pagesTotal * $pagination->limit) - $pagination->limit; ?>)" class="sig-icon-to-end"><i class="hidden"><?php echo JText::_('COM_SIGPRO_END'); ?></i></a></li>
    </ul>
    <div class="limit sigFloatLeft">
        <label><?php echo JText::_('COM_SIGPRO_DISPLAY'); ?></label><?php echo $pagination->getLimitBox(); ?>
    </div>
    <input type="hidden" name="limitstart" value="<?php echo $pagination->get('limitstart'); ?>" />
</div>

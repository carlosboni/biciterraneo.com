<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

$params = $displayData['params'];
$item = $displayData['item'];
$direction = JFactory::getLanguage()->isRtl() ? 'left' : 'right';
?>

<section class="readmore">
	<?php if (!$params->get('access-view')) : ?>
		<a class="btn btn-default btn-sp" href="<?php echo $displayData['link']; ?>" itemprop="url" aria-label="<?php echo JText::_('COM_CONTENT_REGISTER_TO_READ_MORE'); ?>
			<span>
				<?php echo htmlspecialchars($item->title, ENT_QUOTES, 'UTF-8'); ?>">
				<?php echo '<span class="icon-chevron-' . $direction . '" aria-hidden="true"></span>'; ?>
				<?php echo JText::_('COM_CONTENT_REGISTER_TO_READ_MORE'); ?>
			</span>
		</a>
	<?php elseif ($readmore = $item->alternative_readmore) : ?>
		<a class="btn btn-default btn-sp" href="<?php echo $displayData['link']; ?>" itemprop="url" aria-label="<?php echo htmlspecialchars($item->title, ENT_QUOTES, 'UTF-8'); ?>">
			<span>
				<?php echo $readmore; ?>
				<?php if ($params->get('show_readmore_title', 0) != 0) : ?>
					<?php echo JHtml::_('string.truncate', $item->title, $params->get('readmore_limit')); ?>
				<?php endif; ?>
				<span class="fa fa-arrow-right"></span>
			</span>
		</a>
	<?php elseif ($params->get('show_readmore_title', 0) == 0) : ?>
		<a class="btn btn-default btn-sp" href="<?php echo $displayData['link']; ?>" itemprop="url" aria-label="<?php echo JText::_('COM_CONTENT_READ_MORE'); ?> <?php echo htmlspecialchars($item->title, ENT_QUOTES, 'UTF-8'); ?>">
			<span>
				<?php echo JText::sprintf('TPL_CONTENT_READ_MORE_TITLE'); ?>
				<span class="fa fa-arrow-right"></span>
			</span>
		</a>
	<?php else : ?>
		<a class="btn btn-default btn-sp" href="<?php echo $displayData['link']; ?>" itemprop="url" aria-label="<?php echo JText::_('COM_CONTENT_READ_MORE'); ?> <?php echo htmlspecialchars($item->title, ENT_QUOTES, 'UTF-8'); ?>">
		<span>
			<?php echo JText::_('COM_CONTENT_READ_MORE'); ?>
			<?php echo JHtml::_('string.truncate', $item->title, $params->get('readmore_limit')); ?>
			<span class="fa fa-arrow-right"></span>
		</span>
		</a>
	<?php endif; ?>
</section>

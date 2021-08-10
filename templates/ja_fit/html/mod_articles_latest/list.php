<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_latest
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
$modCreated = $params->get('mod-created');

?>
<div class="latestnews list<?php echo $moduleclass_sfx; ?>">
	<div class="row">
		<?php foreach ($list as $item) : ?>
			<?php
				$images = json_decode($item->images);
				$title = $item->category_title;
			?>

			<div class="col-sm-4" itemscope itemtype="https://schema.org/Article">
				<div class="item-wrap">
					<div class="image-wrap">
						<img src="<?php echo $images->image_intro ;?>" alt="<?php echo $item->title; ?>" />

						<div class="category-name">
							<?php echo JHtml::_('link', JRoute::_(ContentHelperRoute::getCategoryRoute($item->catslug)), '<span itemprop="genre">'.$title.'</span>'); ?>
						</div>
					</div>

					<h4>
						<a href="<?php echo $item->link; ?>" itemprop="url">
							<span itemprop="name">
								<?php echo $item->title; ?>
							</span>
						</a>
					</h4>

					<div class="create">
						<?php echo JHtml::_('date', $item->created, JText::_('DATE_FORMAT_LC3')); ?>
					</div>

					<?php if($item->introtext) :?>
						<div class="intro">
							<?php echo $item->introtext; ?>
						</div>
					<?php endif ;?>

					<a class="action" href="<?php echo $item->link; ?>" title="<?php echo Jtext::_('TPL_READ_MORE') ;?>"><?php echo Jtext::_('TPL_READ_MORE') ;?><span class="fa fa-arrow-right" aria-hidden="true"></span></a>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>

<?php 
/**
 * ------------------------------------------------------------------------
 * JA Fit Template
 * ------------------------------------------------------------------------
 * Copyright (C) 2004-2018 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
 * @license - Copyrighted Commercial Software
 * Author: J.O.O.M Solutions Co., Ltd
 * Websites:  http://www.joomlart.com -  http://www.joomlancers.com
 * This file may not be redistributed in whole or significant part.
 * ------------------------------------------------------------------------
*/
defined('_JEXEC') or die;
	$count = $helper->getRows('title');
	$column = 12/($helper->get('columns'));

	$moduleTitle = $module->title;
	$moduleSub = $params->get('sub-heading');
?>

<div class="acm-features style-1">
	<?php if($module->showtitle || $moduleSub) : ?>
	<div class="module-title-wrap">
	<!-- Module Title -->
		<?php if ($moduleSub): ?>
			<div class="sub-heading">
				<span><?php echo $moduleSub; ?></span>		
			</div>
		<?php endif; ?>

		<?php if($module->showtitle) : ?>
		<h2 class="module-title"><?php echo $moduleTitle ?></h2>
		<?php endif; ?>
	<!-- // Module Title -->
	</div>
	<?php endif ; ?>

	<div class="row equal-height equal-height-child">
		<?php for ($i=0; $i<$count; $i++) : ?>
			<div class="col col-sm-12 col-md-<?php echo $column ?>">
				<div class="features-item">
					<?php if($helper->get('ft-img', $i)) : ?>
						<div class="image-intro">
							<img src="<?php echo $helper->get('ft-img', $i) ?>" alt="Intro Image" />

							<?php if($helper->get('ft-icon', $i)) : ?>
								<div class="feature-icon">
									<img src="<?php echo $helper->get('ft-icon', $i) ; ?>" alt="Icon intro" />
								</div>
							<?php endif ; ?>
						</div>
					<?php endif ; ?>
					
					<div class="feature-info">
						<?php if($helper->get('title', $i)) : ?>
							<h3><?php echo $helper->get('title', $i) ?></h3>
						<?php endif ; ?>
						
						<?php if($helper->get('description', $i)) : ?>
							<p><?php echo $helper->get('description', $i) ?></p>
						<?php endif ; ?>

						<?php if($helper->get('link', $i)) : ?>
							<a class="btn btn-primary" href="<?php echo $helper->get('link', $i) ?>">
								<?php echo $helper->get('text-link', $i) ?>
							</a>
						<?php endif ; ?>
					</div>
				</div>
			</div>
		<?php endfor ?>
	</div>
</div>
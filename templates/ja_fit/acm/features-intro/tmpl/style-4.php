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

  $align = $helper->get('align');
  
  if ($align==1): 
  	$contentAlign = "content-right";
  	$featuresContentPull = "col-sm-12 col-xs-12 col-md-6 pull-right";
  	$featuresImgPull = " col-md-6 pull-left";
  else: 
  	$contentAlign = "content-left";
  	$featuresContentPull = "col-sm-12 col-xs-12 col-md-6 pull-left";
  	$featuresImgPull = " col-md-6 pull-right";
  endif;

  $moduleTitle = $module->title;
  $moduleSub = $params->get('sub-heading');

?>

<div class="acm-features style-4 <?php echo $helper->get('features-style'); ?>">
	<div class="row <?php echo $contentAlign; ?>">
		<?php if($helper->get('img-features')) : ?>
		<div class="features-image <?php echo $featuresImgPull; ?>">
			<img src="<?php echo $helper->get('img-features'); ?>" alt="<?php echo $moduleTitle; ?>"/>
		</div>
		<?php endif; ?>
		
		<div class="<?php echo $featuresContentPull; ?>">
			<div class="features-content">
				<!--- Features Content -->
				<div class="module-title-wrap">
					<?php if ($moduleSub): ?>
						<div class="sub-heading">
							<span><?php echo $moduleSub; ?></span>		
						</div>
					<?php endif; ?>

					<?php if($module->showtitle) : ?>
						<h2 class="module-title">
							<?php echo $moduleTitle ?>
						</h2>
					<?php endif ; ?>
				</div>

				<?php if ($helper->get('description')): ?>
					<p>
						<?php echo $helper->get('description'); ?>
					</p>
				<?php endif ; ?>

				<?php if ($helper->get('btn-link')): ?>
				<div class="features-action">
					<a href="<?php echo $helper->get('btn-link') ;?>" title="<?php echo $helper->get('link-title') ;?>" class="btn btn-primary">
						<?php echo $helper->get('btn-title') ;?>
					</a>
				</div>
				<?php endif ; ?>
				<!--- //Features Content -->
			</div>
		</div>
	</div>
</div>
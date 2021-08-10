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
  $moduleTitle = $module->title;
  $moduleSub = $params->get('sub-heading');
?>

<div class="container">
	<div class="acm-features style-2">
		<div class="features-content">
			<div class="row">
				<?php if($helper->get('img-features')) : ?>
				<div class="col-xs-12 col-md-6">
					<div class="features-image">
						<img src="<?php echo $helper->get('img-features'); ?>" alt="<?php echo $moduleTitle; ?>"/>
					</div>
				</div>
				<?php endif ; ?>

				<div class="col-xs-12 col-md-6">
					<div class="features-item">
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
						
						<?php if($helper->get('description')) : ?>
							<p><?php echo $helper->get('description') ?></p>
						<?php endif ; ?>
						
						<?php if($helper->get('button')) : ?>
							<a class="btn btn-primary" href="<?php echo $helper->get('title-link'); ?>"><?php echo $helper->get('button') ?>
							</a>
						<?php endif ; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
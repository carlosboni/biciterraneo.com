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
	$count 					= $helper->getRows('data.title');
	$column 				= $helper->get('columns');

	$moduleTitle = $module->title;
	$moduleSub = $params->get('sub-heading');	
?>

<div class="acm-features style-3">
	<?php if($module->showtitle) : ?>
	<div class="module-title">
		<!-- Module Title -->
		<?php if ($moduleSub): ?>
			<div class="sub-heading">
				<span><?php echo $moduleSub; ?></span>		
			</div>
		<?php endif; ?>

		<h2><?php echo $moduleTitle ?></h2>
		<!-- // Module Title -->
	</div>		
	<?php endif ; ?>

	<div id="acm-feature-<?php echo $module->id; ?>" class="owl-slide">
		<div class="owl-carousel owl-theme">
			<?php 
				for ($i=0; $i<$count; $i++) : 
			?>
				<?php if($helper->get('data.link', $i)) : ?>
					<a href="<?php echo $helper->get('data.link', $i) ?>" title="">
				<?php endif ;?>

				<div class="features-item">
					<div class="features-item-inner">
						<?php if($helper->get('data.img', $i)) : ?>
							<div class="features-img" style="background-image: url('<?php echo $helper->get('data.img', $i) ?>');">
							</div>
							<div class="mask"></div>
						<?php endif ; ?>
						
						<?php if($helper->get('data.title', $i) || $helper->get('data.description', $i)) : ?>
						<div class="features-text">
							<?php if($helper->get('data.title', $i)) : ?>
								<h3><?php echo $helper->get('data.title', $i) ?></h3>
							<?php endif ; ?>
							
							<?php if($helper->get('data.description', $i)) : ?>
								<p><?php echo $helper->get('data.description', $i) ?></p>
							<?php endif ; ?>
						</div>
						<?php endif ; ?>

						<?php if($helper->get('data.link', $i)) : ?>
							<div class="action">
								<i class="fa fa-arrow-right" aria-hidden="true"></i>
							</div>
						<?php endif ;?>
					</div>
				</div>

				<?php if($helper->get('data.link', $i)) : ?>
					</a>
				<?php endif ;?>
			<?php endfor ?>
		</div>
	</div>
</div>

<script>
(function($){
  jQuery(document).ready(function($) {
    $("#acm-feature-<?php echo $module->id; ?> .owl-carousel").owlCarousel({
      addClassActive: true,
      items: <?php echo $column; ?>,
      margin: 0,
      responsive : {
      	0 : {
      		items: 1,
      	},

      	768 : {
      		items: 2,
      	},

      	979 : {
      		items: 2,
      	},

      	1199 : {
      		items: <?php echo $column; ?>,
      	}
      },
      loop: true,
      nav : false,
      dots: <?php echo($column >= $count) ? 'false' : 'true' ;?>,
      autoplay: false
    });
  });
})(jQuery);
</script>
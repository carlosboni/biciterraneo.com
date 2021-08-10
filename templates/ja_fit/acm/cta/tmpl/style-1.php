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
	$bgSource = $helper->get('bg-source');

	$bgImage = '';

	if($helper->get('bg-image')) {
		$bgImage = 'data-paroller-factor="-0.1" style="background-image: url('.$helper->get('bg-image').')"';
	}

	$bgMask = $helper->get('bg-mask');
?>

<div class="acm-cta">
	<div class="cta-showcase-item" <?php echo $bgImage ;?>>
		<?php if($helper->get('cta-title')) :?>
			<h2><?php echo $helper->get('cta-title'); ?></h2>
		<?php endif ;?>

		<?php if($helper->get('cta-btn-link')) :?>
		<a class="btn btn-primary" href="<?php echo $helper->get('cta-btn-link'); ?>">
			<?php echo $helper->get('cta-btn'); ?>
		</a>
		<?php endif ;?>
	</div>
</div>

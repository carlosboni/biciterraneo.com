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
?>

<!-- MAIN NAVIGATION -->
<nav id="t3-mainnav" class="wrap navbar navbar-default t3-mainnav">
	<div class="container">

		<?php if ($this->getParam('navigation_collapse_enable')) : ?>
			<div class="t3-navbar-collapse navbar-collapse collapse"></div>
		<?php endif ?>

		<div class="t3-navbar navbar-collapse collapse">
			<jdoc:include type="<?php echo $this->getParam('navigation_type', 'megamenu') ?>" name="<?php echo $this->getParam('mm_type', 'mainmenu') ?>" />
		</div>

		<div class="mainnav-right">			
			<?php if ($this->getParam('navigation_collapse_enable', 1) && $this->getParam('responsive', 1)) : ?>
				<?php $this->addScript(T3_URL.'/js/nav-collapse.js'); ?>
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".t3-navbar-collapse">
					<i class="fa fa-bars"></i>
				</button>
			<?php endif ?>

			<?php if ($this->getParam('addon_offcanvas_enable')) : ?>
				<?php $this->loadBlock ('off-canvas') ?>
			<?php endif ?>

			<?php if ($this->countModules('head-search')) : ?>
			<!-- HEAD SEARCH -->
			<div class="head-search <?php $this->_c('head-search') ?>">
				<jdoc:include type="modules" name="<?php $this->_p('head-search') ?>" style="raw" />
			</div>
			<!-- //HEAD SEARCH -->
			<?php endif ?>
		</div>
	</div>
</nav>
<!-- //MAIN NAVIGATION -->

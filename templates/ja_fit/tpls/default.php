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

// Background for body
$bgBody = '';
if($this->params->get('bg-body')) {
  $bgBody = 'style="background: url('.$this->params->get('bg-body').');"';
};

?>

<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>"
	  class='<jdoc:include type="pageclass" />'>

<head>
	<jdoc:include type="head" />
	<?php $this->loadBlock('head') ?>
</head>

<body <?php echo $bgBody ;?>>

	<div class="t3-wrapper"> 

	  <?php $this->loadBlock('topbar') ?>

	  <?php $this->loadBlock('header') ?>

	  <?php $this->loadBlock('mainnav') ?>

	  <?php $this->loadBlock('slideshow') ?>

	  <?php $this->loadBlock('masthead') ?>

	  <?php $this->loadBlock('sections-top') ?>

	  <?php $this->loadBlock('mainbody') ?>

	  <?php $this->loadBlock('sections-bottom') ?>

	  <?php $this->loadBlock('navhelper') ?>

	  <?php $this->loadBlock('spotlight-1') ?>

	  <?php $this->loadBlock('footer') ?>

	</div>

</body>

</html>
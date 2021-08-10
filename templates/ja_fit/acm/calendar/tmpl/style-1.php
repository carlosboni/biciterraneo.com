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
  $count = $helper->getCols('data');
  $features_count = $helper->getRows('data');

  $moduleTitle = $module->title;
  $moduleSub = $params->get('sub-heading'); 
  $desTop = $helper->get('intro-top'); 
  $desBottom = $helper->get('intro-bottom'); 
?>


<div class="acm-calendar">
  <?php if($module->showtitle) : ?>
  <div class="module-title-wrap">
    <!-- Module Title -->
    <?php if ($moduleSub): ?>
      <div class="sub-heading">
        <span><?php echo $moduleSub; ?></span>    
      </div>
    <?php endif; ?>

    <h2 class="module-title"><?php echo $moduleTitle ?></h2>
    <!-- // Module Title -->

    <?php if ($desTop): ?>
      <div class="description description-top">
        <p><?php echo $desTop; ?></p>    
      </div>
    <?php endif; ?>
  </div>    
  <?php endif ; ?>

	<div class="calendar-table">
		<?php for ($col = 0; $col < $count; $col++) : ?>
			<div
				class="col has-<?php echo $count ;?>">
				<div class="col-header">
					<h3><?php echo $helper->get('data.calendar-col-name', $col) ?></h3>
				</div>
				<div class="col-body">
					<div>
						<?php for ($row = 0; $row < $features_count; $row++) :
							$timeClass = $helper->getCell('data', $row, 0);
							$infoClass = $helper->getCell('data', $row, $col + 1);
						?>

            <?php if ($infoClass == 't'): ?>
							<div class="calendar-info empty row<?php echo($row % 2); ?>"></div>
            <?php else : ?> 
              <div class="calendar-info row<?php echo($row % 2); ?>">
                <div class="info-class"><?php echo substr($infoClass, 1); ?></div>
                <div class="time-class"><?php echo $timeClass; ?></div>
              </div>
            <?php endif ;?>
						<?php endfor; ?>
					</div>
				</div>
			</div>
		<?php endfor; ?>
	</div>

  <?php if ($desBottom): ?>
      <div class="description description-bottom">
        <span><?php echo $desBottom; ?></span>    
      </div>
    <?php endif; ?>
</div>
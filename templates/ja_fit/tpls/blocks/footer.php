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

// get params
$sitename  = $this->params->get('sitename');
$slogan    = $this->params->get('slogan', '');
$logoimage = $this->params->get('logofooterimage', T3Path::getUrl('images/logo.png', '', true));
$logolink  = $this->params->get('logolink');

if (!$sitename) {
  $sitename = JFactory::getConfig()->get('sitename');
}

// get logo url
$logourl = JURI::base(true);
if ($logolink == 'page') {
  $logopageid = $this->params->get('logolink_id');
  $_item = JFactory::getApplication()->getMenu()->getItem ($logopageid);
  if ($_item) {
    $logourl = JRoute::_('index.php?Itemid=' . $logopageid);
  }
}

?>

<!-- FOOTER -->
<footer id="t3-footer" class="wrap t3-footer">
  <div class="container">
  	<div class="row">
      <div class="col-xs-12 col-sm-12 col-md-8 pull-right">
      	<?php if ($this->checkSpotlight('footnav', 'footer-1, footer-2, footer-3, footer-4')) : ?>
      	<!-- FOOT NAVIGATION -->
      		<?php $this->spotlight('footnav', 'footer-1, footer-2, footer-3, footer-4') ?>
      	<!-- //FOOT NAVIGATION -->
      	<?php endif ?>
          <div class="footer-banner">
              <jdoc:include type="modules" name="<?php $this->_p('footer-banner') ?>" />
          </div>
      </div>

      <div class="col-xs-12 col-sm-12 col-md-4 pull-left">
        <!-- LOGO -->
        <div class="logo">
          <div class="logo-image">
            <a href="<?php echo $logourl ?>" title="<?php echo strip_tags($sitename) ?>">
                <img class="logo-img" src="<?php echo JURI::base(true) . '/' . $logoimage ?>" alt="<?php echo strip_tags($sitename) ?>" />
              <span><?php echo $sitename ?></span>
            </a>
            <small class="site-slogan"><?php echo $slogan ?></small>
          </div>
        </div>
        <!-- //LOGO -->

        <!-- COPYRIGHT -->
        <div class="t3-copyright">
          <jdoc:include type="modules" name="<?php $this->_p('footer') ?>" />

          <?php if ($this->getParam('t3-rmvlogo', 1)): ?>
            <div class="poweredby text-hide">
              <a class="t3-logo t3-logo-small t3-logo-light" href="http://t3-framework.org" title="<?php echo JText::_('T3_POWER_BY_TEXT') ?>"
                 target="_blank" <?php echo method_exists('T3', 'isHome') && T3::isHome() ? '' : 'rel="nofollow"' ?>><?php echo JText::_('T3_POWER_BY_HTML') ?></a>
            </div>
          <?php endif; ?>
        </div>
        <!-- //COPYRIGHT -->
      </div>
    </div>
  </div>
</footer>
<!-- //FOOTER -->
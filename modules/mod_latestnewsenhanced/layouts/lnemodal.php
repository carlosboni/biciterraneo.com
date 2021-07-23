<?php
/**
 * @copyright	Copyright (C) 2011 Simplify Your Web, Inc. All rights reserved.
 * @license		GNU General Public License version 3 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

$bootstrapVersion = isset($displayData['bootstrap_version']) ? strval($displayData['bootstrap_version']) : '2';
$loadBootstrap = isset($displayData['load_bootstrap']) ? $displayData['load_bootstrap'] : true;
if ($loadBootstrap) {
    jimport('syw.stylesheets', JPATH_LIBRARIES);
    SYWStylesheets::loadBootstrapModals();
    JHtml::_('bootstrap.framework');
}

$selector = $displayData['selector'];

$width = isset($displayData['width']) ? $displayData['width'] : '600';
$height = isset($displayData['height']) ? $displayData['height'] : '400';

$title = isset($displayData['title']) ? $displayData['title'] : JText::_('MOD_LATESTNEWSENHANCEDEXTENDED_MODAL_TITLE');

$script = "jQuery(document).ready(function($) { ";

$script .= "$('.".$selector."').on('click', function () { var dataTitle = $(this).attr('data-modaltitle'); if (typeof (dataTitle) !== 'undefined' && dataTitle !== null) { $('#".$selector."').find('.modal-title').text(dataTitle); } var dataURL = $(this).attr('href'); $('#".$selector."').find('.iframe').attr('src', dataURL); }); ";

$script .= "$('#".$selector."')";
$script .= ".on('show.bs.modal', function() { $('body').addClass('modal-open').trigger('modalopen'); })";
$script .= ".on('shown.bs.modal', function() { var modal_body = $(this).find('.modal-body'); modal_body.css({'max-height': ".$height."}); var padding = parseInt(modal_body.css('padding-top')) + parseInt(modal_body.css('padding-bottom')); modal_body.find('.iframe').css({'height': (".$height." - padding)}); })";
$script .= ".on('hide.bs.modal', function () { var modal_body = $(this).find('.modal-body'); modal_body.css({'max-height': 'initial'}); modal_body.find('.iframe').attr('src', 'about:blank'); $('body').removeClass('modal-open').trigger('modalclose'); });";

$script .= "}); ";

JFactory::getDocument()->addScriptDeclaration($script);

$style = '';
if ($bootstrapVersion !== '2') {
    $style = '@media (min-width: 768px) { #'.$selector.' .modal-dialog { width: 80%; max-width: '.$width.'px; } } ';
} else {
    $style = '@media (min-width: 768px) { #'.$selector.' { max-width: 80%; left: 50%; margin-left: auto; -webkit-transform: translate(-50%); -ms-transform: translate(-50%); transform: translate(-50%); width: '.$width.'px; } } ';
}
JFactory::getDocument()->addStyleDeclaration($style);
?>
<?php if ($bootstrapVersion === '2') : ?>
	<div id="<?php echo $selector; ?>" data-backdrop="false" data-keyboard="true" data-remote="true" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="<?php echo $selector; ?>Label" aria-hidden="true">
    	<div class="modal-header">
    		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    		<h3 id="<?php echo $selector; ?>Label" class="modal-title"><?php echo $title; ?></h3>
    	</div>
    	<div class="modal-body">
    		<iframe class="iframe" width="100%" height="<?php echo $height; ?>" frameborder="0" scrolling="auto"></iframe>
    	</div>
    	<div class="modal-footer">
    		<button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo JText::_('MOD_LATESTNEWSENHANCEDEXTENDED_CLOSE'); ?></button>
    	</div>
    </div>
<?php endif; ?>
<?php if ($bootstrapVersion !== '2') : ?>
	<div id="<?php echo $selector; ?>" data-backdrop="false" data-keyboard="true" data-remote="true" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="<?php echo $selector; ?>Label" aria-hidden="true">
    	<div class="modal-dialog" role="document">
    		<div class="modal-content">
            	<div class="modal-header">
            		<?php if ($bootstrapVersion === '3') : ?>
            			<button type="button" class="close" data-dismiss="modal" aria-label="<?php echo JText::_('MOD_LATESTNEWSENHANCEDEXTENDED_CLOSE'); ?>"><span aria-hidden="true">&times;</span></button>
            			<h4 id="<?php echo $selector; ?>Label" class="modal-title"><?php echo $title; ?></h4>
            		<?php endif; ?>
            		<?php if ($bootstrapVersion === '4') : ?>
            			<h5 id="<?php echo $selector; ?>Label" class="modal-title"><?php echo $title; ?></h5>
            			<button type="button" class="close" data-dismiss="modal" aria-label="<?php echo JText::_('MOD_LATESTNEWSENHANCEDEXTENDED_CLOSE'); ?>"><span aria-hidden="true">&times;</span></button>
            		<?php endif; ?>
            	</div>
            	<div class="modal-body">
            		<iframe class="iframe" width="100%" height="<?php echo $height; ?>" frameborder="0" scrolling="auto"></iframe>
            	</div>
            	<div class="modal-footer">
            		<button class="btn btn-secondary" data-dismiss="modal" aria-hidden="true"><?php echo JText::_('MOD_LATESTNEWSENHANCEDEXTENDED_CLOSE'); ?></button>
            	</div>
    		</div>
    	</div>
    </div>
<?php endif; ?>
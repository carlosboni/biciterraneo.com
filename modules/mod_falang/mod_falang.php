<?php
/**
 * @package     Falang for Joomla!
 * @author      Stéphane Bouey <stephane.bouey@faboba.com> - http://www.faboba.com
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @copyright   Copyright (C) 2010-2017. Faboba.com All rights reserved.
 */

// No direct access to this file
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once(dirname(__FILE__)) . '/helper.php';

if (!modFaLangHelper::isFalangDriverActive()){
	echo JText::_("MOD_FALANG_PLUGIN_DRIVER_NOT_ENABLED");
	return;
}

$headerText	= JString::trim($params->get('header_text'));
$footerText	= JString::trim($params->get('footer_text'));



$list   = modFaLangHelper::getList($params);

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

require JModuleHelper::getLayoutPath('mod_falang', $params->get('layout', 'default'));

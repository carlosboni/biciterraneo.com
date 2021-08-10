<?php
/**
 * @version    3.8.x
 * @package    Simple Image Gallery Pro
 * @author     JoomlaWorks - https://www.joomlaworks.net
 * @copyright  Copyright (c) 2006 - 2020 JoomlaWorks Ltd. All rights reserved.
 * @license    https://www.joomlaworks.net/license
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.model');

if (version_compare(JVERSION, '3.0', 'ge')) {
    class SigProModel extends JModelLegacy
    {
    }
} else {
    class SigProModel extends JModel
    {
    }
}

<?php
/**
 * @copyright	Copyright (C) 2011 Simplify Your Web, Inc. All rights reserved.
 * @license		GNU General Public License version 3 or later; see LICENSE.txt
*/

defined( '_JEXEC' ) or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Form\FormHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Uri\Uri;

FormHelper::loadFieldClass('dynamicsingleselect');

class JFormFieldDatasourceSelect extends JFormFieldDynamicSingleSelect
{
	public $type = 'DatasourceSelect';

	protected function getOptions() 
	{	
	    $options = parent::getOptions();
		
	    \JLoader::register('SYWK2', JPATH_LIBRARIES.'/syw/k2.php');
		
		$options[] = array('k2', Text::_('MOD_LATESTNEWSENHANCEDEXTENDED_VALUE_K2ITEMS'), '', '', '', !SYWK2::exists());
		
		$imagefolder = '/modules/mod_latestnewsenhanced/images/datasources';
		
		foreach ($options as &$option) {
		    
	        if ($option[0] == 'articles') {
	            $image = 'articles';
	        } else if ($option[0] == 'k2') {
	            $image = 'k2';
	        } else {
	            $image = 'unknown';
	        }
	        
	        $option[3] = URI::root(true).$imagefolder.'/'.$image.'.png';
		}		
		
		return $options;
	}
	
	public function setup(\SimpleXMLElement $element, $value, $group = null)
	{
	    $return = parent::setup($element, $value, $group);
	    
	    if ($return) {
	        $this->width = 100;
	        $this->height = 100;
	    }
	    
	    return $return;
	}
}
?>
<?php
/*------------------------------------------------------------------------
# Copyright (C) 2005-2012 WebxSolution Ltd. All Rights Reserved.
# @license - GPLv2.0
# Author: WebxSolution Ltd
# Websites:  http://webx.solutions
# Terms of Use: An extension that is derived from the Ark Editor will only be allowed under the following conditions: http://arkextensions.com/terms-of-use
# ------------------------------------------------------------------------*/ 

defined( '_JEXEC' ) or die();

arkimport('event.observable.editor');

class ARKController extends JControllerLegacy
{
	/**
	 * Custom Constructor
	 */
	private   $editor_obervable;
	protected  $event_args;
    protected $default_view = 'cpanel';

	public function __construct( $config = array())
	{
		
        $this->input = JFactory::getApplication()->input;

		// Menus frontpage Editor Menu proxying:
		if ($this->input->get('view') === 'typography')
		{
			$config['base_path'] = JPATH_SITE.'/components/com_arkeditor';
            $config['name'] = 'arkeditor';
		}
        
        
        parent::__construct( $config );

		$app = JFactory::getApplication();
		$this->_event_args = null;
		$name = $app->input->get( 'controller', '');
		
		if(!$name) 
			$name = $app->input->get( 'view', $this->getName() );

		$eventListenerFile = JPATH_COMPONENT .'/event/' . $name . '.php';

		jimport('joomla.filesystem.file');

		if(JFile::exists($eventListenerFile))
		{
			require_once($eventListenerFile);			
			$this->editor_obervable = new ARKEditorObservable($name);
        }

		//load style sheet
		$document = JFactory::getDocument();
		$document->addStyleSheet( ARKEDITOR_COMPONENT . '/css/header.css', 'text/css' );
	}

	public function execute( $task )
	{
		parent::execute( $task );
		
		//fire event to update editor
		$this->updateEditor($this->getTask(),$this->event_args);
	}

	private function updateEditor($event,$args = array())
	{
		if(isset($this->editor_obervable))
		{
			$this->editor_obervable->update( 'on' . JString::ucfirst($event),$args);
		}
	}
}
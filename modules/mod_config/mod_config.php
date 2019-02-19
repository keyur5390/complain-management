<?php 
	//restrict direct access to the page
	defined( 'DMCCMS' ) or die( 'Unauthorized access' );
	
	class Config
	{
		/**
		 * constructor of class page. do initialisation
		 *
		 * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
		 */
		function __construct()
		{		
			
		}
		
		/**
		 * Site configuration action
		 *
		 * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
		 */
		function site_config()
		{
			// load model
			Load::loadModel("config");
			
			// create object
			$configObj = new ConfigModel();
			
			// save config data
			$configObj->saveConfigData();
			
			// get configuration data
			$configData = $configObj->getConfigData();
		
			// include js in footer
			$jsData = Layout::bufferContent(URI::getAbsModulePath()."/js/site_config.php",$configData);	
			
			// create javascript variable for ajax url			
			Layout::addFooter($jsData);
			
			// render layout
			Layout::renderLayout();
		}
	}
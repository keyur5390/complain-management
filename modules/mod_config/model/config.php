<?php
    //restrict direct access to the page
	defined( 'DMCCMS' ) or die( 'Unauthorized access' );			
	
	class ConfigModel
	{
		/**
		 * constructor of class ConfigModel. do initialisation
		 *
		 * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
		 */
		function __construct()
		{
		}		
		
		/**
		 * Returns configuration records
		 *
		 * @return array config data
		 * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
		 */
		function getConfigData()
		{
			return DB::query("SELECT config_key,config_value FROM ".CFG::$tblPrefix."configuration ");
		}
		
		/**
		 * Save config data
		 *
		 * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
		 */
		function saveConfigData()
		{
			if(isset($_POST['site_name']))
			{
				foreach($_POST as $field => $value)
				{
					$arrFields = array("config_value" => $value);
					// update record
					DB::update(CFG::$tblPrefix."configuration",Stringd::processString($arrFields)," config_key=%s ",$field);
				}
				
				// pass action result
				$_SESSION["actionResult"] = array("success" => "Configuration settings have been saved");
				
				UTIL::redirect(URI::getURL(APP::$moduleName,"site_config"));
			}
		}
	}
?>
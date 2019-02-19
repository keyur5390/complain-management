<?php 
	//restrict direct access to the page
	defined( 'DMCCMS' ) or die( 'Unauthorized access' );
	
	class BlockHeader
	{
		/**
		 * constructor of class. do initialisation
		 *
		 * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
		 */
		function __construct()
		{		
			 
		}
		
		public function process()
		{
                         $data['seo']  =  DB::query("select module_key,active_action ,active_module from ".CFG::$tblPrefix."module_action where module_key = 'mod_seo'");
                     $data['config']  =  DB::query("select module_key,active_action ,active_module from ".CFG::$tblPrefix."module_action where module_key = 'mod_config'");
                     
                     //print_r($data);exit;
                     
                     return $data;
		}
                
               
	}
<?php 
	//restrict direct access to the page
	defined( 'DMCCMS' ) or die( 'Unauthorized access' );
	
	class BlockFooter
	{
	    /**
		 * object of car db
		 *
		 * @author Kushan Antani <kushan.datatechmedia@gmail.com>
		 */
		public $data = array();			

		 
		/**
		 * constructor of class. do initialisation
		 *
		 *@author Kushan Antani <kushan.datatechmedia@gmail.com>
		 */
		function __construct()
		{		
			// connect new db
 			//BlockFooter::$carDB = new MeekroDB(CFG::$host,CFG::$user,CFG::$password,CFG::$cardb);
		}
		
		public function process()
		{
			// $data = array();
                        
                        
                        if(isset($_POST['email_chimp']))
                        {
                           $data = UTIL::subscribeEmail($_POST['email_chimp']);
                        }
				
			return $data;
//                        
		}
	}
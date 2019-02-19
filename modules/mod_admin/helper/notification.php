<?php
	//restrict direct access to the page
	defined( 'DMCCMS' ) or die( 'Unauthorized access' );

	class NotificationHelper
	{


		/**
		 * constructor of class admin. do initialisation
		 *
		 * @author Kushan Antani <kushan.datatechmedia@gmail.com>
		 */
		function __construct()
		{


		}

		/**
		 * get notification list.
		 *
		 * @author Rutwik Avasthi <php@datatechmedia@gmail.com>
		 */
		public function getNotificationList()
		{
			$orderBy = "id desc";
			if(isset($_GET['o_type']))
				$orderBy = $_GET['o_field']." ".$_GET['o_type'];
			$where="notify_to=".$_SESSION['user_login']['id'];
                        $flag=true;
                        $whereParam=array();


                        //DB::debugMode();
			UTIL::doPaging("totalNotifications","id,notification,po_id,status",CFG::$tblPrefix."notification",$where,$whereParam,$orderBy);		 //exit;

		}
                
                /** Change Status of users
		 *
		 * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
		 */
		function changeStatus()
		{
			$newStatus = $_GET['newstatus'];
			
			foreach($_POST['status'] as $key => $val)
			{
                            
				DB::update(CFG::$tblPrefix."notification",array("status" => $newStatus)," id=%d ",$key);
                             
			}
		}
	}
<?php 
	//restrict direct access to the page
	defined( 'DMCCMS' ) or die( 'Unauthorized access' );
	
	class BlockLeft
	{
		/**
		 * constructor of class. do initialisation
		 *
		 * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
		 */
		function __construct()
		{		
			
		}
		
		/**
		 * Get menu data
		 *
		 * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
		 */
		public function process()
		{
                    //echo "<pre>";
                    //print_r($_SESSION['user_login']); exit;
                    //DB::debugMode();
			//$menuData = DB::query("select ma.name,ma.related_actions,ma.module_key,ma.action,ma.admin_menu_label,m.name as moduleName,m.icon_class from ".CFG::$tblPrefix."module_action as ma,".CFG::$tblPrefix."modules as m where ma.module_key=m.module_key and admin_menu=%s order by m.menu_order, ma.menu_order",1);
                        $sql="select ma.name,ma.related_actions,ma.module_key,ma.action,ma.admin_menu_label,m.name as moduleName,m.icon_class from ".CFG::$tblPrefix."module_action as ma,".CFG::$tblPrefix."modules as m where ma.module_key=m.module_key and admin_menu=%s ";
                        
                         if($_SESSION['user_login']['access_type'] == 'selected')
				{
					$sql.=" and ma.id in (SELECT action_id FROM ".CFG::$tblPrefix."roll_action WHERE roll_id =%d)"; 
				}
                        else if($_SESSION['user_login']['access_type'] == 'exclude')
				{
					$sql.=" and ma.id not in (SELECT action_id FROM ".CFG::$tblPrefix."roll_action WHERE roll_id =%d)";  
				}
	                $menuData=DB::query($sql." order by m.menu_order,ma.menu_order",1,$_SESSION['user_login']['roll_id']); 
			return $menuData;
		}
	}
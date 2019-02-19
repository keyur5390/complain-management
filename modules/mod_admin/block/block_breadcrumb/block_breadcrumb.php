<?php 
	//restrict direct access to the page
	defined( 'DMCCMS' ) or die( 'Unauthorized access' );
	
	class BlockBreadcrumb
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
			 $sql="select ma.name,ma.related_actions,ma.module_key,ma.action,ma.admin_menu_label,m.name as moduleName,m.icon_class from ".CFG::$tblPrefix."module_action as ma,".CFG::$tblPrefix."modules as m where ma.module_key=m.module_key and admin_menu='1' and active_module = '1' and active_action='1'";
                        
                         if($_SESSION['user_login']['access_type'] == 'selected')
				{
					$sql.=" and ma.id in (SELECT action_id FROM ".CFG::$tblPrefix."roll_action WHERE roll_id =%d)"; 
				}
                        else if($_SESSION['user_login']['access_type'] == 'exclude')
				{
					$sql.=" and ma.id not in (SELECT action_id FROM ".CFG::$tblPrefix."roll_action WHERE roll_id =%d)";  
				}
                                
                        //DB::debugMode();        
	                 $menuData=DB::query($sql." order by m.menu_order,ma.menu_order",$_SESSION['user_login']['roll_id']); 
                        
                        $len = count($menuData);
                        //echo $len;exit;
                        //print_r($menuData);exit;
                        //exit;
			return $menuData;
			//return '';
		}
	}
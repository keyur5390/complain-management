<?php 
	//restrict direct access to the page
	defined( 'DMCCMS' ) or die( 'Unauthorized access' );
	
	class Admin
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
		 * About company action
		 *
		 * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
		 */
		function dashboard()
		{	
                    // check user logged in or not
                    if(!UTIL::isUserLogin())
                        UTIL::redirect(URI::getURL("mod_complain","complain_list"));	// redirect user to login page if not logged in

                    // Load helper file
                    Load::loadHelper("admin",APP::$moduleName);

                    // create object of helper
                    $adminHelper = new AdminHelper();

                    $adminHelper->gettTicketData();

                    $adminHelper->getAllTicketDataByStatus();
                    
                    $unreadArr[]=array(
                        'tableName'=>CFG::$tblPrefix."ticket",
                        'fields'=>'t.id,t.subject,t.user_name,(select name from '.CFG::$tblPrefix.'user where id=t.engineer_id)as engeneer_name,r.name as region_name,h.name as helpdesk_name,t.created_date,"Ticket" as datatype',
                        'type'=>CFG::$ticketStatusArray
                        );
                    
//                    pre($unreadArr,0);
                    
                    $data['ddData']=$unreadArr;
                   
//                    pre($unreadArr,0);
                    
                    $adminHelper->getAllUnreadTicketData($unreadArr);
                    
                    $adminHelper->getAllRecentTicketData($unreadArr);
                    
                    $data['ticketStatus']=array($adminHelper->getTicketStatus());

//                    pre($data,1);
                    
                    // include chart js
                    $jsData = Layout::bufferContent(URI::getAbsModulePath()."/js/chart.php",$data);

                    // create javascript variable for ajax url			
                    Layout::addFooter($jsData);

                    // render layout
                    Layout::renderLayout($data);
		}
		
		/**
		 * Upload image file into server
		 *
		 * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
		 */
		function upload_image()
		{ 
                    Load::loadLibrary("UploadHandler.php","jquery_uploader");                          
                    $upload_handler = new UploadHandler(array('script_url' => $_POST['deleteURL'],	
                                                              'upload_dir' => URI::getAbsMediaPath($_POST['uploadDir'])."/",	// Physical upload directory path
                                                              'upload_url' => URI::getLiveMediaPath($_POST['uploadDir'])."/",	// live image url
                                                              'param_name'  => $_POST['fileInput']));                                                  
                    exit;
		}
	}
<?php 
	//restrict direct access to the region
	defined( 'DMCCMS' ) or die( 'Unauthorized access' );

        Class HelpDesk
        {
            /**
            * constructor of class HelpDesk. do initialization
            *
            * @author Mayur Patel <mayur.datatech@gmail.com>
            */

            function __construct()
            {
                // load model
                Load::loadModel("helpDesk");
            }

            /**
            * List of all the help desk recored
            *
            * @author Mayur Patel <mayur.datatech@gmail.com>
            */
            function helpDesk_list()
            {
                //create model object
                $helpDeskObj=new HelpDeskModel();
                
                
                /*
                *  Following Code For Manage Whene Login User Roll As Help Desk Manager 
                *  Only Display Those Help Desk Which Can Assign To Current Login Help Desk Admin User
                *  @Author Mayur Patel<mayur.datatech@gmail.com> 
                */
                /*
                $filteHelpDeskUserUserLoginFilterId="";
                if($_SESSION['user_login']['roll_name'] == "Help Desk Manager"){
                    //pre($_SESSION,1);
                    $filteHelpDeskUserUserLoginFilterId=$_SESSION['user_login']['id'];
                }
                //get all listing
                $helpDeskObj->getHelpDeskList($filteHelpDeskUserUserLoginFilterId);
                */
                
                //get all listing
                $helpDeskObj->getHelpDeskList();
                
                //get all parent-region record for update
                $data['parentRegionData']=$helpDeskObj->getParentregion(APP::$curId);
                
//                pre($data, 1);
                
                $jsData = Layout::bufferContent(URI::getAbsModulePath()."/js/helpDesk_list.php");
                
                
//                pre($data,1);
                
                
                //create javascript variable for ajax url
                Layout::addFooter($jsData);

                //render layout
                Layout::renderLayout($data['parentRegionData']);
                
            }

            /*
            * Edit help desk record
            *
            * @author Mayur Patel <mayur.datatech@gmail.com>
            */
            function helpDesk_edit()
            {
                //create model object
                $helpDeskObj=new HelpDeskModel();
                
                // Check region valid code thorugh ajax
                if(isset($_REQUEST['ajaxCall']) && $_REQUEST['ajaxCall']!="")
                {
                    $isExist = false;
                    if (isset($_REQUEST['code']) && $_REQUEST['code'] != '') {
                        $isExist = ($helpDeskObj->check_helpDesk_code($_REQUEST['code']) == '') ? true : false;
                    }
                    
                    if (!$isExist) {
                        echo 'false';
                    } else {
                        echo 'true';
                    }
                    exit;
                }
                
                //Save category record
                $helpDeskObj->saveHelpDesk();

    
                
                //get record for update
                $data['helpDeskData']=$helpDeskObj->getHelpDeskData(APP::$curId);
                 
                /*
                *  Following Code For Manage Whene Login User Roll As Help Desk Manager 
                *  Only Display Those Help Desk Which Can Assign To Current Login Help Desk Admin User
                *  @Author Mayur Patel<mayur.datatech@gmail.com> 
                */
                
                /*
                $filteHelpDeskUserUserLoginFilterId="";
                if($_SESSION['user_login']['roll_name'] == "Help Desk Manager"){
                    //pre($_SESSION,1);
                    $filteHelpDeskUserUserLoginFilterId=$_SESSION['user_login']['id'];
                }
                //get record for update
                $data['helpDeskData']=$helpDeskObj->getHelpDeskData(APP::$curId,$filteHelpDeskUserUserLoginFilterId);
                 
                 // Following Code Help To Restric Access to The Un-Assign HelpDesk Edit 
                if(empty($data['helpDeskData']) && isset(APP::$curId))
                {
                    $_SESSION['actionResult']=array("warning"=>"You Cant Access This Help Desk");  // different type success, info, warning, error    
                    UTIL::redirect(URI::getURL(APP::$moduleName,"helpDesk_list")); // Redirect to the list page
                }
                */
                

                //load user manager model
                Load::loadModel("region","mod_region");

                // create object
                $regionObj = new RegionModel();

                //get all region record for update
//                $data['allRegionData']=$regionObj->getAllRegion(); // Its Return All Region Without Parent Child Group
                $data['allRegionData']=$regionObj->getParentAllRegion(); // Its Return All Region With Parent Child Group
                //print_r($data['allRegionData']);
                $data['remainRegionData']=$regionObj->getRemainParentRegion();
                
                $data['remainingManagerData']=$helpDeskObj->getRemainManager();
                 //load user manager model
                Load::loadModel("user","mod_user");

                // create object
                $userObj = new UserModel();
                if(count($data['remainingManagerData'])==0)
                {
                    $data['remainingManagerData']=$userObj->getAllHelpDeskManager();
                }
                //$data['registerRegionData']=$regionObj->getAssignParentRegion();
                
               

                //get all help desk manager Users record for update
                $data['helpDeskManagersData']=$userObj->getAllHelpDeskManager();
                
//              pre($data,1);
                
                //include js in footer
                $jsData=Layout::bufferContent(URI::getAbsModulePath()."/js/helpDesk_edit.php",$data);

                // create javascrpt variable for ajax url
                Layout::addFooter($jsData);
                
                //render layout
                Layout::renderLayout();
                
            }
            
            /**
            * Change status of help desk
            *
            * @author Mayur Patel <mayur.datatech@gmail.com>
            */
            function change_status()
            {
                //Create Model Object
                $helpDeskObj=new HelpDeskModel();
                
                //change status
                $helpDeskObj->changeStatus();

                $msg="Help Desk status has been activated successfully";
                if($_GET['newstatus']=='0')
                {
                    $msg="Help Desk status has been deactivated successfully";
                }

                echo json_encode(array("result" => "success","title" => "Help Desk Status","message" => $msg));
                exit();
            }
            
            /**
            * delete recored
            *
            * @author Mayur Patel <mayur.datatech@gmail.com>
            */
            function delete_helpDesk()
            {
                //Create Model Object
                $helpDeskObj=new HelpDeskModel();
               
                //delete recored
                $helpDeskObj->deleteHelpDesk();
                
                echo json_encode(array("result" => "success","title" => "Help Desk","message" => "Help Desk(s) have been deleted successfully"));
                
		exit;
            }
            
            /**
            * save sort order
            *
            * @author Mayur Patel <mayur.datatech@gmail.com>
            */
            function save_sortorder()
            {
                //Create model object
                $helpDeskObj=new HelpDeskModel();
                
                //Save sort order of category
                $helpDeskObj->saveSortOrder();

                echo json_encode(array("result" => "success","title" => "Region","message" => "Sort order has been saved successfully"));
                
                exit;
            }
            
        }
?>
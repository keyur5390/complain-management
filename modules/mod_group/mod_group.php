<?php 
	//restrict direct access to the region
	defined( 'DMCCMS' ) or die( 'Unauthorized access' );

        Class group
        {
            /**
            * constructor of class group. do initialization
            *
            * @author Sagar Jogi <sagarjogi.datatech@gmail.com>
            */

            function __construct()
            {
                // load model
                Load::loadModel("group");
            }

            /**
            * List of all the types of group recored
            *
          * @author Sagar Jogi <sagarjogi.datatech@gmail.com>
            */
            function group_list()
            {
                //create model object
                $groupObj=new groupModel();
                
                
                //get all listing
                $groupObj->getgroupList();
             
                
                $jsData = Layout::bufferContent(URI::getAbsModulePath()."/js/group_list.php");
               
                
                //create javascript variable for ajax url
                Layout::addFooter($jsData);

                //render layout
                Layout::renderLayout();
                
            }
             /**
            * Save type of group 
            *
            * @author Sagar Jogi <sagarjogi.datatech@gmail.com>
            */
             function save_group() {

                 //   Load::loadModel("group");

                   $groupObj=new groupModel();

                    $groupObj->savegroupData($_POST);
             }
           
            /**
            * Change status of group
            *
            * @author Sagar Jogi <sagarjogi.datatech@gmail.com>
            */
            function change_status()
            {
                //Create Model Object
                $groupObj=new groupModel();
                
                //change status
                $groupObj->changeStatus();

                $msg="Group Type status has been activated successfully";
                if($_GET['newstatus']=='0')
                {
                    $msg="Group Type status has been deactivated successfully";
                }

                echo json_encode(array("result" => "success","title" => "Group Status","message" => $msg));
                exit();
            }
            
            /**
            * delete group
            *
            * @author Sagar Jogi <sagarjogi.datatech@gmail.com>
            */
            function delete_group()
            {
                //Create Model Object
                $groupObj=new groupModel();
               
                //delete recored
                $groupObj->deletegroup();
                
                echo json_encode(array("result" => "success","title" => "Group","message" => "Group Type(s) have been deleted successfully"));
                
		exit;
            }
            
        }
?>
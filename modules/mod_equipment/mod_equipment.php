<?php 
	//restrict direct access to the region
	defined( 'DMCCMS' ) or die( 'Unauthorized access' );

        Class equipment
        {
            /**
            * constructor of class equipment. do initialization
            *
            * @author Sagar Jogi <sagarjogi.datatech@gmail.com>
            */

            function __construct()
            {
                // load model
                Load::loadModel("equipment");
            }

            /**
            * List of all the types of equipment recored
            *
          * @author Sagar Jogi <sagarjogi.datatech@gmail.com>
            */
            function equipment_list()
            {
                //create model object
                $equipmentObj=new equipmentModel();
                
                
                //get all listing
                $equipmentObj->getequipmentList();
             
                
                $jsData = Layout::bufferContent(URI::getAbsModulePath()."/js/equipment_list.php");
               
                
                //create javascript variable for ajax url
                Layout::addFooter($jsData);

                //render layout
                Layout::renderLayout();
                
            }
             /**
            * Save type of equipment 
            *
            * @author Sagar Jogi <sagarjogi.datatech@gmail.com>
            */
             function save_equipment() {

                 //   Load::loadModel("equipment");

                   $equipmentObj=new equipmentModel();

                    $equipmentObj->saveequipmentData($_POST);
             }
           
            /**
            * Change status of equipment
            *
            * @author Sagar Jogi <sagarjogi.datatech@gmail.com>
            */
            function change_status()
            {
                //Create Model Object
                $equipmentObj=new equipmentModel();
                
                //change status
                $equipmentObj->changeStatus();

                $msg="Equipment Type status has been activated successfully";
                if($_GET['newstatus']=='0')
                {
                    $msg="Equipment Type status has been deactivated successfully";
                }

                echo json_encode(array("result" => "success","title" => "Equipment Status","message" => $msg));
                exit();
            }
            
            /**
            * delete equipment
            *
            * @author Sagar Jogi <sagarjogi.datatech@gmail.com>
            */
            function delete_equipment()
            {
                //Create Model Object
                $equipmentObj=new equipmentModel();
               
                //delete recored
                $equipmentObj->deleteequipment();
                
                echo json_encode(array("result" => "success","title" => "Equipment","message" => "Equipment Type(s) have been deleted successfully"));
                
		exit;
            }
            
        }
?>
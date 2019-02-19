<?php 
	//restrict direct access to the station
	defined( 'DMCCMS' ) or die( 'Unauthorized access' );

        Class station
        {
            /**
            * constructor of class category. do initialization
            *
            * @author Mayur Patel <mayur.datatech@gmail.com>
            */

            function __construct()
            {
                // load model
                Load::loadModel("station");
            }

            /**
            * List of all the category
            *
            * @author Mayur Patel <mayur.datatech@gmail.com>
            */
            function station_list()
            {
                //create model object
                $stationObj=new stationModel();
                
                //get all listing
                $stationObj->getstationList();
                
                //get all parent-station record for searching
                
//                pre($data,1);
                
                $jsData = Layout::bufferContent(URI::getAbsModulePath()."/js/station_list.php");
                
                //create javascript variable for ajax url
                Layout::addFooter($jsData);

                //render layout
                Layout::renderLayout($data);
                
            }

            /*
            * Edit category record
            *
            * @author Mayur Patel <mayur.datatech@gmail.com>
            */
            function station_edit()
            {
                
                //Create Model Object
                $stationObj=new stationModel();
                
                // Check station valid code thorugh ajax
                if(isset($_REQUEST['ajaxCall']) && $_REQUEST['ajaxCall']!="")
                {
                    $isExist = false;
                    if (isset($_REQUEST['code']) && $_REQUEST['code'] != '') {
                        $isExist = ($stationObj->check_station_code($_REQUEST['code']) == '') ? true : false;
                    }
                    
                    if (!$isExist) {
                        echo 'false';
                    } else {
                        echo 'true';
                    }
                    exit;
                }
                
                
                
                //Save category record
                $stationObj->savestation();

                //get record for update
                $data['stationData']=$stationObj->getstationData(APP::$curId);
                
                
                //load user manager model
                Load::loadModel("user","mod_user");
                
                
                
                //get all help desk manager record for update
//                $data['helpDeskManagerData']=array(
//                                [0]=>array("id"=>"1","name"=>"Manager 1"),
//                                [1]=>array("id"=>"2","name"=>"Manager 2"),
//                                [2]=>array("id"=>"3","name"=>"Manager 3"));
//                
//                //get all Engineer record for update
//                $data['engineerData']=array(
//                                [0]=>array("id"=>"1","name"=>"Engineer 1"),
//                                [1]=>array("id"=>"2","name"=>"Engineer 2"),
//                                [2]=>array("id"=>"3","name"=>"Engineer 3"));
                
                
//                pre($data,1);
                
                //include js in footer
                $jsData=Layout::bufferContent(URI::getAbsModulePath()."/js/station_edit.php",$data);

                // create javascrpt variable for ajax url
                Layout::addFooter($jsData);
                
                //render layout
                Layout::renderLayout();
                
            }
            
            /**
            * Change status of Category
            *
            * @author Mayur Patel <mayur.datatech@gmail.com>
            */
            function change_status()
            {
                //Create Model Object
                $stationObj=new stationModel();
                
                //change status
                $stationObj->changeStatus();

                $msg="station status has been activated successfully";
                if($_GET['newstatus']=='0')
                {
                    $msg="station status has been deactivated successfully";
                }

                echo json_encode(array("result" => "success","title" => "station Status","message" => $msg));
                exit();
            }
            
            /**
            * delete recored
            *
            * @author Mayur Patel <mayur.datatech@gmail.com>
            */
            function delete_station()
            {
                //Create model object
                $stationObj=new stationModel();
               
                //delete recored
                $productCount=$stationObj->deletestation();
                
                echo json_encode(array("result" => "success","title" => "station","message" => "station(s) have been deleted successfully"));
                
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
                $stationObj=new stationModel();
                
                //Save sort order of category
                $stationObj->saveSortOrder();

                echo json_encode(array("result" => "success","title" => "station","message" => "Sort order has been saved successfully"));
                
                exit;
            }
            
        }
?>
<?php 
	//restrict direct access to the complain
	defined( 'DMCCMS' ) or die( 'Unauthorized access' );

        Class complain
        {
            /**
            * constructor of class category. do initialization
            *
            * @author Mayur Patel <mayur.datatech@gmail.com>
            */

            function __construct()
            {
                // load model
                Load::loadModel("complain");
            }

            /**
            * List of all the category
            *
            * @author Mayur Patel <mayur.datatech@gmail.com>
            */
            function complain_list()
            {
                //create model object
                $complainObj=new complainModel();
                
                //get all listing
                $complainObj->getcomplainList();
                
                //get all parent-complain record for searching
                
//                pre($data,1);
                
                $jsData = Layout::bufferContent(URI::getAbsModulePath()."/js/complain_list.php");
                
                //create javascript variable for ajax url
                Layout::addFooter($jsData);

                //render layout
                Layout::renderLayout($data);
                
            }
            /**
            * List of all the category
            *
            * @author Mayur Patel <mayur.datatech@gmail.com>
            */
            function report_list()
            {
                //create model object
                $complainObj=new complainModel();
                
                //get all listing
                $complainObj->getreportList();
                $data['complainName']=$complainObj->getAllcomplainName();
                $data['complainType']=$complainObj->getcomplainType();
                $data['stationName']=$complainObj->getstationData();
                $data['departmentName']=$complainObj->getdepartment();
                
                //get all parent-complain record for searching
                
//                pre($data,1);
                
                $jsData = Layout::bufferContent(URI::getAbsModulePath()."/js/report_list.php",$data);
                
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
            function complain_edit()
            {
                
                //Create Model Object
                $complainObj=new complainModel();
                
                //Save category record
                $complainObj->savecomplain();

                //get record for update
                $data['complainData']=$complainObj->getcomplainData(APP::$curId);
                $viewData['complainData']=$complainObj->getcomplainData(APP::$curId);
                
                //load user manager model
                Load::loadModel("user","mod_user");
                $viewData['complain_type']=$complainObj->getcomplainType();
                $viewData['department']=$complainObj->getdepartment();
                $viewData['employeeAll']=$complainObj->getemployee();
                $viewData['vendorAll']=$complainObj->getvendor();
//                $viewData['persondata']=$complainObj->getpersonData();
//                $viewData['stationdata']=$complainObj->getstationData();
//                $viewData['groupdata']=$complainObj->getgroupData();
                //include js in footer
                $jsData=Layout::bufferContent(URI::getAbsModulePath()."/js/complain_edit.php",$data);

                // create javascrpt variable for ajax url
                Layout::addFooter($jsData);
                
                //render layout
                Layout::renderLayout($viewData);
                
            }
            /*
            * Edit category record
            *
            * @author Mayur Patel <mayur.datatech@gmail.com>
            */
            function complain_view()
            {
                
                //Create Model Object
                $complainObj=new complainModel();
                
                //Save category record
//                $complainObj->savecomplain();

                //get record for update
                $data['complainData']=$complainObj->getcomplainData(APP::$curId);
                
                //load user manager model
                Load::loadModel("user","mod_user");
                $viewData['complain_type']=$complainObj->getcomplainType();
                $viewData['department']=$complainObj->getdepartment();
//                $viewData['persondata']=$complainObj->getpersonData();
//                $viewData['stationdata']=$complainObj->getstationData();
//                $viewData['groupdata']=$complainObj->getgroupData();
                //include js in footer
                $jsData=Layout::bufferContent(URI::getAbsModulePath()."/js/complain_view.php",$data);

                // create javascrpt variable for ajax url
                Layout::addFooter($jsData);
                
                //render layout
                Layout::renderLayout($viewData);
                
            }
            
            /**
            * Change status of Category
            *
            * @author Mayur Patel <mayur.datatech@gmail.com>
            */
            function change_status()
            {
                //Create Model Object
                $complainObj=new complainModel();
                
                //change status
                $complainObj->changeStatus();

                $msg="complain status has been activated successfully";
                if($_GET['newstatus']=='0')
                {
                    $msg="complain status has been deactivated successfully";
                }

                echo json_encode(array("result" => "success","title" => "complain Status","message" => $msg));
                exit();
            }
            
            /**
            * delete recored
            *
            * @author Mayur Patel <mayur.datatech@gmail.com>
            */
            function delete_complain()
            {
                //Create model object
                $complainObj=new complainModel();
               
                //delete recored
                $productCount=$complainObj->deletecomplain();
                
                echo json_encode(array("result" => "success","title" => "complain","message" => "complain(s) have been deleted successfully"));
                
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
                $complainObj=new complainModel();
                
                //Save sort order of category
                $complainObj->saveSortOrder();

                echo json_encode(array("result" => "success","title" => "complain","message" => "Sort order has been saved successfully"));
                
                exit;
            }
            
        }
?>
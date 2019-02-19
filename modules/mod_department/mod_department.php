<?php 
	//restrict direct access to the department
	defined( 'DMCCMS' ) or die( 'Unauthorized access' );

        Class department
        {
            /**
            * constructor of class category. do initialization
            *
            * @author Mayur Patel <mayur.datatech@gmail.com>
            */

            function __construct()
            {
                // load model
                Load::loadModel("department");
            }

            /**
            * List of all the category
            *
            * @author Mayur Patel <mayur.datatech@gmail.com>
            */
            function department_list()
            {
                //create model object
                $departmentObj=new departmentModel();
                
                //get all listing
                $departmentObj->getdepartmentList();
                
                //get all parent-department record for searching
                
//                pre($data,1);
                
                $jsData = Layout::bufferContent(URI::getAbsModulePath()."/js/department_list.php");
                
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
            function department_edit()
            {
                
                //Create Model Object
                $departmentObj=new departmentModel();
                
                // Check department valid code thorugh ajax
                if(isset($_REQUEST['ajaxCall']) && $_REQUEST['ajaxCall']!="")
                {
                    $isExist = false;
                    if (isset($_REQUEST['code']) && $_REQUEST['code'] != '') {
                        $isExist = ($departmentObj->check_department_code($_REQUEST['code']) == '') ? true : false;
                    }
                    
                    if (!$isExist) {
                        echo 'false';
                    } else {
                        echo 'true';
                    }
                    exit;
                }
                
                
                
                //Save category record
                $departmentObj->savedepartment();

                //get record for update
                $data['departmentData']=$departmentObj->getdepartmentData(APP::$curId);
//                $viewData['departmentData']=$departmentObj->getdepartmentData(APP::$curId);
                $viewData['equipmentdata']=$departmentObj->getequipemtnData();
                
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
                $jsData=Layout::bufferContent(URI::getAbsModulePath()."/js/department_edit.php",$data);

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
                $departmentObj=new departmentModel();
                
                //change status
                $departmentObj->changeStatus();

                $msg="Department status has been activated successfully";
                if($_GET['newstatus']=='0')
                {
                    $msg="Department status has been deactivated successfully";
                }

                echo json_encode(array("result" => "success","title" => "Department Status","message" => $msg));
                exit();
            }
            
            /**
            * delete recored
            *
            * @author Mayur Patel <mayur.datatech@gmail.com>
            */
            function delete_department()
            {
                //Create model object
                $departmentObj=new departmentModel();
               
                //delete recored
                $productCount=$departmentObj->deletedepartment();
                
                echo json_encode(array("result" => "success","title" => "Department","message" => "Department(s) have been deleted successfully"));
                
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
                $departmentObj=new departmentModel();
                
                //Save sort order of category
                $departmentObj->saveSortOrder();

                echo json_encode(array("result" => "success","title" => "Department","message" => "Sort order has been saved successfully"));
                
                exit;
            }
            
        }
?>
<?php 
	//restrict direct access to the employee
	defined( 'DMCCMS' ) or die( 'Unauthorized access' );

        Class employee
        {
            /**
            * constructor of class category. do initialization
            *
            * @author Mayur Patel <mayur.datatech@gmail.com>
            */

            function __construct()
            {
                // load model
                Load::loadModel("employee");
            }

            /**
            * List of all the category
            *
            * @author Mayur Patel <mayur.datatech@gmail.com>
            */
            function employee_list()
            {
                //create model object
                $employeeObj=new employeeModel();
                
                //get all listing
                $employeeObj->getemployeeList();
                
                //get all parent-employee record for searching
                
//                pre($data,1);
                
                $jsData = Layout::bufferContent(URI::getAbsModulePath()."/js/employee_list.php");
                
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
            function employee_edit()
            {
                
                //Create Model Object
                $employeeObj=new employeeModel();
                
                
                //Save category record
                $employeeObj->saveemployee();

                //get record for update
                $data['employeeData']=$employeeObj->getemployeeData(APP::$curId);
                $viewData['employeeData']=$employeeObj->getemployeeData(APP::$curId);
                $viewData['equipmentdata']=$employeeObj->getequipemtnData();
                $viewData['asset']=$employeeObj->getassetData();
                 $viewData['station']=$employeeObj->getstationData();
                
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
                $jsData=Layout::bufferContent(URI::getAbsModulePath()."/js/employee_edit.php",$data);

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
                $employeeObj=new employeeModel();
                
                //change status
                $employeeObj->changeStatus();

                $msg="Employee status has been activated successfully";
                if($_GET['newstatus']=='0')
                {
                    $msg="Employee status has been deactivated successfully";
                }

                echo json_encode(array("result" => "success","title" => "Employee Status","message" => $msg));
                exit();
            }
            
            /**
            * delete recored
            *
            * @author Mayur Patel <mayur.datatech@gmail.com>
            */
            function delete_employee()
            {
                //Create model object
                $employeeObj=new employeeModel();
               
                //delete recored
                $productCount=$employeeObj->deleteemployee();
                
                echo json_encode(array("result" => "success","title" => "Employee","message" => "Employee(s) have been deleted successfully"));
                
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
                $employeeObj=new employeeModel();
                
                //Save sort order of category
                $employeeObj->saveSortOrder();

                echo json_encode(array("result" => "success","title" => "Employee","message" => "Sort order has been saved successfully"));
                
                exit;
            }
            
        }
?>
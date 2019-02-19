<?php 
	//restrict direct access to the compalinname
	defined( 'DMCCMS' ) or die( 'Unauthorized access' );

        Class compalinname
        {
            /**
            * constructor of class category. do initialization
            *
            * @author Mayur Patel <mayur.datatech@gmail.com>
            */

            function __construct()
            {
                // load model
                Load::loadModel("compalinname");
            }

            /**
            * List of all the category
            *
            * @author Mayur Patel <mayur.datatech@gmail.com>
            */
            function compalinname_list()
            {
                //create model object
                $compalinnameObj=new compalinnameModel();
                
                //get all listing
                $compalinnameObj->getcompalinnameList();
                
                //get all parent-compalinname record for searching
                
//                pre($data,1);
                
                $jsData = Layout::bufferContent(URI::getAbsModulePath()."/js/compalinname_list.php");
                
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
            function compalinname_edit()
            {
                
                //Create Model Object
                $compalinnameObj=new compalinnameModel();
                
                // Check compalinname valid code thorugh ajax
                if(isset($_REQUEST['ajaxCall']) && $_REQUEST['ajaxCall']!="")
                {
                    $isExist = false;
                    if (isset($_REQUEST['code']) && $_REQUEST['code'] != '') {
                        $isExist = ($compalinnameObj->check_compalinname_code($_REQUEST['code']) == '') ? true : false;
                    }
                    
                    if (!$isExist) {
                        echo 'false';
                    } else {
                        echo 'true';
                    }
                    exit;
                }
                
                
                
                //Save category record
                $compalinnameObj->savecompalinname();

                //get record for update
                $data['compalinnameData']=$compalinnameObj->getcompalinnameData(APP::$curId);
//                $viewData['compalinnameData']=$compalinnameObj->getcompalinnameData(APP::$curId);
                $viewData['equipmentdata']=$compalinnameObj->getequipemtnData();
                
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
                $jsData=Layout::bufferContent(URI::getAbsModulePath()."/js/compalinname_edit.php",$data);

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
                $compalinnameObj=new compalinnameModel();
                
                //change status
                $compalinnameObj->changeStatus();

                $msg="Compalin Name status has been activated successfully";
                if($_GET['newstatus']=='0')
                {
                    $msg="Compalin Name status has been deactivated successfully";
                }

                echo json_encode(array("result" => "success","title" => "Compalin Name Status","message" => $msg));
                exit();
            }
            
            /**
            * delete recored
            *
            * @author Mayur Patel <mayur.datatech@gmail.com>
            */
            function delete_compalinname()
            {
                //Create model object
                $compalinnameObj=new compalinnameModel();
               
                //delete recored
                $productCount=$compalinnameObj->deletecompalinname();
                
                echo json_encode(array("result" => "success","title" => "Compalin Name","message" => "Compalin Name(s) have been deleted successfully"));
                
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
                $compalinnameObj=new compalinnameModel();
                
                //Save sort order of category
                $compalinnameObj->saveSortOrder();

                echo json_encode(array("result" => "success","title" => "Compalin Name","message" => "Sort order has been saved successfully"));
                
                exit;
            }
            
        }
?>
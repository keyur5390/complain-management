<?php 
	//restrict direct access to the asset
	defined( 'DMCCMS' ) or die( 'Unauthorized access' );

        Class asset
        {
            /**
            * constructor of class category. do initialization
            *
            * @author Mayur Patel <mayur.datatech@gmail.com>
            */

            function __construct()
            {
                // load model
                Load::loadModel("asset");
            }

            /**
            * List of all the category
            *
            * @author Mayur Patel <mayur.datatech@gmail.com>
            */
            function asset_list()
            {
                //create model object
                $assetObj=new assetModel();
                
                //get all listing
                $assetObj->getassetList();
                
                //get all parent-asset record for searching
                
//                pre($data,1);
                
                $jsData = Layout::bufferContent(URI::getAbsModulePath()."/js/asset_list.php");
                
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
            function asset_edit()
            {
                
                //Create Model Object
                $assetObj=new assetModel();
                
                // Check asset valid code thorugh ajax
                if(isset($_REQUEST['ajaxCall']) && $_REQUEST['ajaxCall']!="")
                {
                    $isExist = false;
                    if (isset($_REQUEST['code']) && $_REQUEST['code'] != '') {
                        $isExist = ($assetObj->check_asset_code($_REQUEST['code']) == '') ? true : false;
                    }
                    
                    if (!$isExist) {
                        echo 'false';
                    } else {
                        echo 'true';
                    }
                    exit;
                }
                
                
                
                //Save category record
                $assetObj->saveasset();

                //get record for update
                $data['assetData']=$assetObj->getassetData(APP::$curId);
                $viewData['station']=$assetObj->getstationData();
                $viewData['employee']=$assetObj->getemployeeData();
                $viewData['vendor']=$assetObj->getvendorData();
                
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
                $jsData=Layout::bufferContent(URI::getAbsModulePath()."/js/asset_edit.php",$data);

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
                $assetObj=new assetModel();
                
                //change status
                $assetObj->changeStatus();

                $msg="asset status has been activated successfully";
                if($_GET['newstatus']=='0')
                {
                    $msg="asset status has been deactivated successfully";
                }

                echo json_encode(array("result" => "success","title" => "asset Status","message" => $msg));
                exit();
            }
            
            /**
            * delete recored
            *
            * @author Mayur Patel <mayur.datatech@gmail.com>
            */
            function delete_asset()
            {
                //Create model object
                $assetObj=new assetModel();
               
                //delete recored
                $productCount=$assetObj->deleteasset();
                
                echo json_encode(array("result" => "success","title" => "asset","message" => "asset(s) have been deleted successfully"));
                
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
                $assetObj=new assetModel();
                
                //Save sort order of category
                $assetObj->saveSortOrder();

                echo json_encode(array("result" => "success","title" => "asset","message" => "Sort order has been saved successfully"));
                
                exit;
            }
            
        }
?>
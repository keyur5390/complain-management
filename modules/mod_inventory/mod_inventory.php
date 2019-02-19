<?php

//restrict direct access to the page
defined('DMCCMS') or die('Unauthorized access');

class Inventory {

    /**
     * constructor of class page. do initialisation
     *
     * @author Vimal Darji <vimal.datatech@gmail.com>
     */
    function __construct() {
        
    }
 
    /**
     * List all users in admin section
     *
     * @author Vimal Darji <vimal.datatech@gmail.com>
     */
    function user_list() { 
        // load model
        Load::loadModel("inventory");

        // create model object
        $userObj = new UserModel();
        
        // get user listing
        $userObj->getUserList();

        $userData['role'] = $userObj->getRoles();
        $userData['admin'] = $userObj->getAllAdmin();
        $userData['region'] = $userObj->getAllRegion();
//         $userData['allRegion'] = $userObj->getAllRegionListing();
        
        $jsData = Layout::bufferContent(URI::getAbsModulePath() . "/js/user_list.php", $userData);

        // create javascript variable for ajax url			
        Layout::addFooter($jsData);

        // render layout
        Layout::renderLayout($userData);
       
    }

    /**
     * User add/edit
     *
     * @author Vimal Darji <vimal.datatech@gmail.com>
     */
    function inventory_edit() {
        
        
        // load model
        Load::loadModel("inventory");
       
        //Load::loadModel("helpDesk","mod_helpDesk");
        // create model object
        $userObj = new UserModel();
        //$helpdeskObj = new HelpDeskModel();
        // save user record is submitted
         $userObj->saveInventory();

     


        // get user record for update
        $userData = $userObj->getInventoryData(APP::$curId);
         
        Load::loadModel("region","mod_region");
        $regionObj=new RegionModel();

        $userData['role'] = $userObj->getRoles();
        $data['role'] = $userObj->getParentRoles(APP::$curId);
        //$data['helpdesk']= $helpdeskObj->getAllHelpDeskData();
//        $userData['parentRegionData']=$regionObj->getCustomAllRegion($userData['helpdesk_id']);
//        $userData['parentRegionData1']=$regionObj->getCustomParentAllRegion($userData['helpdesk_id']);
//        $userData['parentRegionData2']=$regionObj->getCustomAllRegion();
//        $userData['allRegionData']=$regionObj->getAllRegion();
//        $userData['allRegion']=$userObj->getAllRegionListing();
        $userData['contactRegion']=$userObj->getAllRegionContact($_REQUEST['userid']);
        $data['contactRegion']=$userObj->getAllRegionContact($_REQUEST['userid']);
         $data['service']=$userObj->getServices();
//        $userData['countChildRegion']=$userObj->getCountChileRegionContact();
//        $userData['userState']=$userObj->getAllState();
      
        // include js in footer
        $jsData = Layout::bufferContent(URI::getAbsModulePath() . "/js/inventory_edit.php", $userData);

        // create javascript variable for ajax url			
        Layout::addFooter($jsData);

        // render layout
        
        Layout::renderLayout($data);
    }

    
     /**
     * List all users in admin section
     *
     * @author Vimal Darji <vimal.datatech@gmail.com>
     */
    function inventory_list() { 
        
        // load model
        Load::loadModel("inventory");

        // create model object
        $userObj = new UserModel();
        
        
            if($_REQUEST['userid'] != ""){
            $_SESSION['userid'] = $_REQUEST['userid'];
            }
        
        
        // get user listing
       $userData = $userObj->getInventoryList();
        $data['region'] = $userObj->getAllRegion();
         
        
        $jsData = Layout::bufferContent(URI::getAbsModulePath() . "/js/inventory_list.php", $userData);

        // create javascript variable for ajax url			
        Layout::addFooter($jsData);

        // render layout
        Layout::renderLayout($data);
    }
    
    
    
    /* Delete selected users
     *
     * @author Vimal Darji <vimal.datatech@gmail.com>
     */

    function delete_inventory() {
        // load model
        Load::loadModel("inventory");

        // create model object
        $userObj = new UserModel();

        //change status
        $userObj->deleteInventory();

        echo json_encode(array("result" => "success", "title" => "Delete Inventory", "message" => "Inventory(s) have been deleted successfully"));
        exit;
    }
    function import_csv() {
      if (!empty($_FILES['csvFile']['tmp_name'])) {

         include_once CFG::$absPath . "/feed/import_inventory.php";

         $target_dir = URI::getAbsMediaPath(CFG::$csvDir) . '/';
         $new_file_name = date('d-m-Y') . '-' . basename($_FILES["csvFile"]["name"]);
         $target_file = $target_dir . $new_file_name;
         move_uploaded_file($_FILES["csvFile"]["tmp_name"], $target_file);

         $import = true;

         if ($import === true) {
	 UTIL::redirect(CFG::$livePath . "/feed/importInventoryCSV.php?flag=true");
         } else {
	 $_SESSION['cusErr'] = $import;
	 UTIL::redirect(CFG::$livePath . "/feed/importInventoryCSV.php?flag=false");
         }
      }
   }
   
}
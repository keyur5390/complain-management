<?php

//restrict direct access to the page
defined('DMCCMS') or die('Unauthorized access');

class Service {

    /**
     * constructor of class page. do initialisation
     *
     * @author Vimal Darji <vimal.datatech@gmail.com>
     */
    function __construct() {
        
    }
 
    /**
     * User add/edit
     *
     * @author Vimal Darji <vimal.datatech@gmail.com>
     */
    function service_edit() {
        
        
        // load model
        Load::loadModel("service");
       
        //Load::loadModel("helpDesk","mod_helpDesk");
        // create model object
        $serviceObj = new ServiceModel();
        //$helpdeskObj = new HelpDeskModel();
        // save user record is submitted
         $serviceObj->saveService();

     


        // get user record for update
        $userData = $serviceObj->getServiceData(APP::$curId);
          $data['region'] = $serviceObj->getAllRegion();
        /*Load::loadModel("region","mod_region");
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
        $data['contactRegion']=$userObj->getAllRegionContact($_REQUEST['userid']);*/
//        $userData['countChildRegion']=$userObj->getCountChileRegionContact();
//        $userData['userState']=$userObj->getAllState();
      
        // include js in footer
        $jsData = Layout::bufferContent(URI::getAbsModulePath() . "/js/service_edit.php", $userData);

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
    function service_list() { 
Load::loadModel("service");
        // load model
       $serviceObj = new ServiceModel();
        //$helpdeskObj = new HelpDeskModel();
        // save user record is submitted
      
        
        /*if($_REQUEST['userid'] != ""){
        $_SESSION['userid'] = $_REQUEST['userid'];
        }*/
        
        // get user listing
       $userData = $serviceObj->getServiceList();
       $data['region'] = $serviceObj->getAllRegion();
         
        
        $jsData = Layout::bufferContent(URI::getAbsModulePath() . "/js/service_list.php", $userData);

        // create javascript variable for ajax url			
        Layout::addFooter($jsData);

        // render layout
        Layout::renderLayout($data);
    }
    
    
    
    /* Delete selected users
     *
     * @author Vimal Darji <vimal.datatech@gmail.com>
     */

    function delete_service() {
        // load model
      Load::loadModel("service");
        // load model
       $serviceObj = new ServiceModel();
        //change status
        $serviceObj->deleteService();

        echo json_encode(array("result" => "success", "title" => "Delete Service", "message" => "Service(s) have been deleted successfully"));
        exit;
    }
    function import_csv() {
      if (!empty($_FILES['csvFile']['tmp_name'])) {

         include_once CFG::$absPath . "/feed/import_service.php";

         $target_dir = URI::getAbsMediaPath(CFG::$csvDir) . '/';
         $new_file_name = date('d-m-Y') . '-' . basename($_FILES["csvFile"]["name"]);
         $target_file = $target_dir . $new_file_name;
         move_uploaded_file($_FILES["csvFile"]["tmp_name"], $target_file);

         $import = true;

         if ($import === true) {
	 UTIL::redirect(CFG::$livePath . "/feed/importServiceCSV.php?flag=true");
         } else {
	 $_SESSION['cusErr'] = $import;
	 UTIL::redirect(CFG::$livePath . "/feed/importServiceCSV.php?flag=false");
         }
      }
   }
   
}
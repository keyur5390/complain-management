<?php

//restrict direct access to the page
defined('DMCCMS') or die('Unauthorized access');

class User {

    /**
     * constructor of class page. do initialisation
     *
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    function __construct() {
        
    }

    /**
     * About company action
     *
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    function admin_login() {
        // check user logged in or not
        if (UTIL::isUserLogin())
            UTIL::redirect(URI::getURL("mod_admin", "dashboard")); // redirect user to booking if already logged in

            
// Load helper file
        Load::loadHelper("user", APP::$moduleName);

        // create object of helper
        $userHelper = new UserHelper();

        // proccess login form is submitted
        $userHelper->doLogin();

        // add javascript code
        $returnUrl = "";
        if(isset($_GET['returnURL']) && !empty($_GET['returnURL'])){
            $returnUrl = 'returnURL='. $_GET['returnURL'];//pass the return url to the login ajax
        }
        Layout::addFooter('<script type="text/javascript">var loginPath="' . URI::getURL("mod_user", "admin_login",'',$returnUrl) . '"</script>');
        Layout::addFooter('<script type="text/javascript" src="' . URI::getLiveTemplatePath() . '/js/jquery.validate.js"></script>');
        Layout::addFooter('<script type="text/javascript" src="' . URI::getLiveModulePath() . '/js/user.js"></script>');

        // render layout
        Layout::renderLayout();
    }

    /*
     * Update logged in user's profile
     *
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */

    function update_profile() {
        // get user id
        APP::$curId = Core::getUserData("id");

        // load model
        Load::loadModel("user");

        // create object
        $userObj = new UserModel();

        // save user profile
        $userObj->saveProfile();

        // get page record for update
        $userData = $userObj->getUserData(APP::$curId);

        $userData['country'] = $userObj->getCountry();

        // include js in footer
        $jsData = Layout::bufferContent(URI::getAbsModulePath() . "/js/update_profile.php", $userData);

        // create javascript variable for ajax url			
        Layout::addFooter($jsData);

        // render layout
        Layout::renderLayout();
    }

    /**
     * Logged out logged in user
     *
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    function user_logout() {//echo "dd";exit;
       // if (isset($_SESSION[CFG::$session_key])) {
            // unset user session
            unset($_SESSION[CFG::$session_key]);

//            if (isset($_SESSION[APP::$appType]))
                unset($_SESSION[APP::$appType]);
     //   }

        UTIL::redirect("index.php?m=mod_user&a=admin_login");
        exit;
    }

    /**
     * List all users in admin section
     *
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    function user_list() {

        // load model
        Load::loadModel("user");

        // create model object
        $userObj = new UserModel();

        // get user listing
        $userObj->getUserList();

        $userData['role'] = $userObj->getRoles();
        $userData['admin'] = $userObj->getAllAdmin();
        
       

        $jsData = Layout::bufferContent(URI::getAbsModulePath() . "/js/user_list.php", $userData);

        // create javascript variable for ajax url			
        Layout::addFooter($jsData);

        // render layout
        Layout::renderLayout();
    }

    /**
     * User add/edit
     *
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    function user_edit() {
        // load model
        Load::loadModel("user");

        // create model object
        $userObj = new UserModel();


        // save user record is submitted
        $userObj->saveUser();



        // get user record for update
        $userData = $userObj->getUserAllData(APP::$curId);

//        $userData['country'] = $userObj->getCountry();

        $viewData = $userObj->getRoles();
        $viewData['station'] = $userObj->getAllStation();
        $viewData['group'] = $userObj->getAllGroup();
        // include js in footer
        $jsData = Layout::bufferContent(URI::getAbsModulePath() . "/js/user_edit.php", $userData);

        // create javascript variable for ajax url			
        Layout::addFooter($jsData);

        // render layout
        Layout::renderLayout($viewData);
    }

    /* Change status of user
     *
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */

    function change_status() {
        // load model
        Load::loadModel("user");

        // create model object
        $userObj = new UserModel();

        //change status
        $userObj->changeStatus();

        $msg = "User(s) status have been activated successfully";
        if ($_GET['newstatus'] == "0")
            $msg = "User(s) status have been inactivated successfully";

        echo json_encode(array("result" => "success", "title" => "User Status", "message" => $msg));
        exit;
    }

    /* Delete selected users
     *
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */

    function delete_user() {
        // load model
        Load::loadModel("user");

        // create model object
        $userObj = new UserModel();

        //change status
        $userObj->deleteUser();


        exit;
    }

    /* Send mail
     *
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */

    function send_mail() {
        // load model
        Load::loadModel("user");

        // create model object
        $userObj = new UserModel();

        if (App::$curId != "") {
            $userObj->mailSendUser(App::$curId);
        }
    }

    /* Forgot Password helps to retrive password
     *
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */

    function forgot_password() {
        if (UTIL::isUserLogin())
            UTIL::redirect(URI::getURL("mod_admin", "booking")); // redirect user to booking if already logged in

            
// Load helper file
        Load::loadHelper("user", APP::$moduleName);

        // create object of helper
        $userHelper = new UserHelper();

        // proccess login form is submitted
        $userHelper->sendEmail();

        Layout::addFooter('<script type="text/javascript" src="' . URI::getLiveModulePath() . '/js/user.js"></script>');
        // render layout

        Layout::renderLayout();
    }

    /**
     * Front User Registration 
     * 
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    function user_register() {
        // render layout 
        Layout::renderLayout();
    }

    /**
     * access_edit
     * @author parth parikh <parth.datatechmedia@gmail.com>
     * @date: 17/5/2016
     * */
    function access_edit() {
        
        Load::loadModel("user");
        $userObj = new UserModel();
//        print_r($_POST);exit;
        
        $userObj->saveActionData();
        $data['list'] = $userObj->getActionData();
        $data['access'] = $userObj->getAccessData();
        $data['name'] = $userObj->getAccessName();

        $jsData = Layout::bufferContent(URI::getAbsModulePath() . "/js/access_edit.php", $data);
        // create javascript variable for ajax url			
        Layout::addFooter($jsData);

        Layout::renderLayout($data);
    }
    /*
     * User Access List
     * @author  vishal vasnai <vishal.datatech@gmail.com> 
     * @date: 23-05-2016
     */
    
    function access_list()
    {
        // load model
        Load::loadModel("user");
        
        //create model object
        $userObj = new UserModel();
        
        // get User Access List
        $userObj->getAccessList();
        
        // create javascript variable for ajax url	
        $jsData = Layout::bufferContent(URI::getAbsModulePath() . "/js/access_list.php");
        
        // include js in footer
        Layout::addFooter($jsData);
        // render layout
        Layout::renderLayout();
    }
    /*
     * Delete records of user
     * authoer: vishal vassani <vishal.datatech@gmail.com>
     * date: 24-05-2016
     */
    
    
    function access_delete()
    {
        // load model
        Load::loadModel("user");
        // create model object
        $userObj = new UserModel();
        // delete user access
        $userObj->access_delete();
        
        	echo json_encode(array("result" => "success","title" => "Delete User","message" => "User(s) have been deleted successfully"));
			exit;
    }
    
     function set_modules() {
       //print_r($_POST);exit;// load model
        Load::loadModel("user");
        // create model object
        $userObj = new UserModel();

        $userObj->saveActiveModule();
        
        $mod = $userObj->getModuleList();

        $jsData = Layout::bufferContent(URI::getAbsModulePath() . "/js/module_edit.php");

        // include js in footer
        Layout::addFooter($jsData);

        Layout::renderLayout($mod);
    }
    
    /* Check Email and username exist
     *
     * @author Ratan Desai <ratan.datatech@gmail.com>
     */

    function check_user() {
        // load model
        Load::loadModel("user");
        // create model object
        $userObj = new UserModel();
        $isExist = false;
        if (isset($_POST['email']) && $_POST['email'] != '') {
            $isExist = ($userObj->checkAjaxEmail($_POST['email']) == '') ? true : false;
        } else if (isset($_POST['username']) && $_POST['username'] != '') {
            $isExist = ($userObj->checkAjaxUser($_POST['username']) == '') ? true : false;
        }

        if (!$isExist) {
            echo 'false';
        } else {
            echo 'true';
        }

        exit;
    }

}
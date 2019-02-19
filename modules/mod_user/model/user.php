<?php

//restrict direct access to the page
defined('DMCCMS') or die('Unauthorized access');

class UserModel {

    /** Store fields of page record
      @var $fields array
     */
    public $records = array();

    /**
     * constructor of class UserModel. do initialisation
     *
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    function __construct() {
        
    }

    /**
     * Retrun user data
     *
     * @param int $id user id
     *
     * @return array user data
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    function getUserData($id) {
        //return DB::queryFirstRow("SELECT u.id,u.name,u.username,u.password,u.email,u.phone,u.mobile FROM ".CFG::$tblPrefix."user as u where u.id=%d ",$id);                    
        return DB::queryFirstRow("SELECT id,name,username,password,email,suburb,state,country as country_id,address,postcode,phone,mobile,fax,roll_id  FROM " . CFG::$tblPrefix . "user where id=%d ", $id);
    }

    /**
     * save user profile detail
     *
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    function saveProfile() {
        if (isset($_POST['name'])) {
            $this->CheckEmailForSaveProfile(trim($_POST['email']));
            $arrFields = array("name" => $_POST['name'], "username" => $_POST['username'], "email" => $_POST['email'], "phone" => Stringd::removeWhitespace($_POST['phone']), "mobile" => Stringd::removeWhitespace($_POST['mobile']), "fax" => Stringd::removeWhitespace($_POST['fax']), "address" => $_POST['address'], "suburb" => $_POST['suburb'], "state" => $_POST['state'], "country" => (int) $_POST['country'], "postcode" => $_POST['postcode']);

            if (isset($_POST['password']) && trim($_POST['password']) != "")
                $arrFields['password'] = Core::encryptPass($_POST['password']);

            // update record
            DB::update(CFG::$tblPrefix . "user", Stringd::processString($arrFields), " id=%d ", APP::$curId);

            // pass action result
            $_SESSION["actionResult"] = array("success" => "User profile has been updated successfully");

            UTIL::redirect(URI::getURL(APP::$moduleName, "update_profile"));
        }
    }

    /**
     * get User detail by its id
     *
     * @param int $id User id
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public function getUserById($id) {
        $this->records = DB::queryFirstRow("SELECT * FROM " . CFG::$tblPrefix . "user where active='1' and id=%d limit 1", $id);
    }
    
    public function getAllStation(){ 
                return DB::query("SELECT id,name FROM ".CFG::$tblPrefix."station  where status='1'");
    }
    public function getAllGroup(){
                return DB::query("SELECT id,name FROM ".CFG::$tblPrefix."group  where status='1'");
    }
    
    public function getRoles() {
        $where = "";
        if ($_SESSION[CFG::$session_key]['roll_id'] == 3) {
            $where.=" where id in (3,4)";
        }
        return DB::query("SELECT id,name FROM " . CFG::$tblPrefix . "rolls" . $where);
    }

    /**
     * get user record list. 
     *
     * @author Rutwik Avasthi <php@datatechmedia@gmail.com>
     */
    public function getUserList() {
        $orderBy = "id desc";
        if (isset($_GET['o_type']))
            $orderBy = $_GET['o_field'] . " " . $_GET['o_type'];
        $where = "";
        $flag = true;
        $whereParam = array();
        if (isset($_GET['searchForm']['user_name']) && trim($_GET['searchForm']['user_name']) != "" && isset($_GET['searchForm']['role']) && trim($_GET['searchForm']['role']) != "") {
            $where .= " ((name like %ss_name or username like %ss_username or email like %ss_username) ";
            $where .= " and (roll_id = %d_roll)) ";
            $whereParam["name"] = Stringd::processString($_GET['searchForm']['user_name']);
            $whereParam["username"] = Stringd::processString($_GET['searchForm']['user_name']);
            $whereParam["email"] = Stringd::processString($_GET['searchForm']['user_name']);
            $whereParam["roll"] = Stringd::processString($_GET['searchForm']['role']);
            $flag = false;
        } else if (isset($_GET['searchForm']['user_name']) && trim($_GET['searchForm']['user_name']) != "") {
            $where .= " name like %ss_name or username like %ss_username or email like %ss_username ";
            $whereParam["name"] = Stringd::processString($_GET['searchForm']['user_name']);
            $whereParam["username"] = Stringd::processString($_GET['searchForm']['user_name']);
            $whereParam["email"] = Stringd::processString($_GET['searchForm']['user_name']);
            $flag = false;
        } else if (isset($_GET['searchForm']['role']) && trim($_GET['searchForm']['role']) != "") {
            $where .= " roll_id = %d_roll ";
            $whereParam["roll"] = Stringd::processString($_GET['searchForm']['role']);
            $flag = false;
        }

        if ($_SESSION[CFG::$session_key]['roll_id'] == 3) {
            if ($flag == false) {
                $where.=" and ";
            }
            $where.=" roll_id in (3,4) ";
        }


        //DB::debugMode();
        UTIL::doPaging("totalUsers", "id,name,username,email,phone,created_by,roll_id,updated_by,active", CFG::$tblPrefix . "user", $where, $whereParam, $orderBy);   //exit;
    }

    /**
     * get user record with its slug. 
     *
     * @author Rutwik Avasthi <php@datatechmedia@gmail.com>
     */
    public function getUserAllData($id) {
        return DB::queryFirstRow("SELECT id,name,username,password,email,suburb,state,country as country_id,address,postcode,phone,mobile,fax,roll_id,active,station_id,group_id  FROM " . CFG::$tblPrefix . "user where id=%d ", $id);
    }

    /**
     *  Save user data if submitted
     *
     *  @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public function saveUser() {
        if (isset($_POST['name'])) {
            //echo "<pre>";print_r($_POST);exit;
            $user = $this->checkUser(trim($_POST['username']));
            $this->checkEmail(trim($_POST['email']));

            if (count($user) != 0) {
                $_SESSION["actionResult"] = array("error" => "User name is already exists");
                if ($_POST['edit'] == 1) {
                    if (APP::$curId == "") {
                        UTIL::redirect(URI::getURL(APP::$moduleName, "user_list"));
                    } else {
                        UTIL::redirect(URI::getURL(APP::$moduleName, "user_edit", APP::$curId));
                    }
                    exit;
                } else {
                    UTIL::redirect(URI::getURL(APP::$moduleName, "user_list"));
                    exit;
                }
            }

            if (isset($_POST['active']))
                $varStatus = '1';
            else
                $varStatus = '0';


            $arrFields = array("name" => $_POST['name'], "email" => $_POST['email'], "username" => $_POST['username'], "phone" => Stringd::removeWhitespace($_POST['phone']), "mobile" => Stringd::removeWhitespace($_POST['mobile']), "fax" => Stringd::removeWhitespace($_POST['fax']), "address" => $_POST['address'], "suburb" => $_POST['suburb'], "state" => $_POST['state'], "country" => (int) $_POST['country'], "postcode" => $_POST['postcode'], "active" => $varStatus,"station_id"=>$_REQUEST['station'],"group_id"=>$_REQUEST['group'], "roll_id" => (int) $_POST['role']);

            //print_r($arrFields); exit;

            if (isset($_POST['password']) && trim($_POST['password']) != "")
                $arrFields['password'] = Core::encryptPass($_POST['password']);

            // insert new record
            if (isset($_SESSION[CFG::$session_key])) {
                $userID = $_SESSION[CFG::$session_key]['id'];
            }
            if (APP::$curId == "") {
                // store created and updated date
                $arrFields['created_date'] = date("Y-m-d H:i:s");
                $arrFields['updated_date'] = date("Y-m-d H:i:s");
                $arrFields['created_by'] = $userID;

                // insert record
                DB::insert(CFG::$tblPrefix . "user", Stringd::processString($arrFields));

                // get current id
                APP::$curId = DB::insertId();
            } else {
                // store updated date
                $arrFields['updated_date'] = date("Y-m-d H:i:s");
                $arrFields['updated_by'] = $userID;
                // update record
                DB::update(CFG::$tblPrefix . "user", Stringd::processString($arrFields), " id=%d ", APP::$curId);
            }
            if (isset($_POST['send_email']) == true) {
                $this->mailSendUser(APP::$curId);
            }
            // pass action result
            $_SESSION["actionResult"] = array("success" => "User has been saved successfully");

            if ($_POST['edit'] == 1)
                UTIL::redirect(URI::getURL(APP::$moduleName, "user_edit", APP::$curId));
            else
                UTIL::redirect(URI::getURL(APP::$moduleName, "user_list"));
        }
    }

    /** Change Status of users
     *
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    function changeStatus() {
        $newStatus = $_GET['newstatus'];

        foreach ($_POST['status'] as $key => $val) {
            if ($key != $_SESSION[CFG::$session_key]['id']) {
                DB::update(CFG::$tblPrefix . "user", array("active" => $newStatus), " id=%d ", $key);
            }
        }
    }

    /** delete selected users
     *
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    function deleteUser() {
        $userArray = array();
        foreach ($_POST['status'] as $key => $val) {
            if ($key != $_SESSION[CFG::$session_key]['id']) {
                if ($this->checkQCUser($key) == true) {
                    DB::delete(CFG::$tblPrefix . "user", "id=%d ", $key);
                } else {
                    $userArray[] = $key;
                }
            }
        }

        if (count($userArray) != 0) {
            echo json_encode(array("result" => "error", "title" => "Delete User - " . Delete_User, "message" => "User with id (" . implode(',', $userArray) . ") have not been deleted.It is assigned to PO." . User_with_assigned_to_PO));
        } else {
            echo json_encode(array("result" => "success", "title" => "Delete User - " . Delete_User, "message" => "User(s) have been deleted successfully - " . User_have_been_deleted_successfully));
        }
    }

    /**
     * Check whether PO is assigned or not
     *
     * @author Kushan Antani <kushan.datatechmedia@gmail.com> 
     */
    function checkQCUser($id) {
        $qc = array();
        $getRoll = DB::queryFirstRow("select roll_id from " . CFG::$tblPrefix . "user where id=%d", $id);
        if ((int) $getRoll['roll_id'] == 4) {
            $qc = DB::queryFirstRow("select count(qc_consultant) as cnt from " . CFG::$tblPrefix . "po where qc_consultant=%d and  ( level <>5 OR resolution <>1 )", $id);
        }
        if ((int) $getRoll['roll_id'] == 3) {
            $qc = DB::queryFirstRow("select count(qc_manager) as cnt from " . CFG::$tblPrefix . "po where qc_manager=%d and  ( level <>5 OR resolution <>1 )", $id);
        }

        if (count($qc) != 0 && isset($qc['cnt']) == true && (int) $qc['cnt'] != 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * check users
     *
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    function checkUser($userName) {
        return DB::query("SELECT username FROM " . CFG::$tblPrefix . "user where username=%s and id <> %d", $userName, APP::$curId);
    }

    /**
     * check email
     *
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    function checkEmail($email) {
        //Check for email already exists
        if (APP::$curId != "") {
            $id = APP::$curId;
            $email = DB::query("select id from " . CFG::$tblPrefix . "user where email = %s and id <>" . $id, $_POST['email']);
        } else {
            $email = DB::query("select id from " . CFG::$tblPrefix . "user where email = %s", $_POST['email']);
        }

        if (count($email) != 0) {
            $_SESSION["actionResult"] = array("error" => "Email is already exists");

            if ($_POST['edit'] == 1) {
                $_SESSION['error'] = $_POST;
                UTIL::redirect(URI::getURL(APP::$moduleName, "user_edit", APP::$curId));
            } else {
                UTIL::redirect(URI::getURL(APP::$moduleName, "user_list"));
            }
        }
    }

    /**
     * get all admins 
     *
     * @author Rutwik Avasthi <php@datatechmedia@gmail.com>
     */
    public function getAllAdmin() {
        return DB::query("SELECT id,name FROM " . CFG::$tblPrefix . "user where roll_id in (1,3)");
    }

    /**
     * send agent mail
     *
     * @param int $id
     *  
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    function mailSendUser($id) {
        $user = DB::queryFirstRow("SELECT name,email,username,password FROM " . CFG::$tblPrefix . "user where id=%d", $id);

        $this->mailSend($user['email'], $user['name'], $user['username'], $user['password']);
    }

    /**
     * send Mail
     *
     * @param string $to
     * @param string $name
     * @param string $username
     * @param string $password
     * 
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    function mailSend($to, $name, $username, $password) {
        if ($username != "") {
            Load::loadLibrary("sender.php", "phpmailer");
            $content = "";
            $subject = CFG::$siteConfig['site_name'] . " - Login Details";
            $content = "<strong>Username:</strong> " . $username . "<br><strong>Password:</strong> " . Core::decryptPass($password) . "<br><br>Please <a href='" . CFG::$livePath . "/myAdmin' target='_blank'>click here</a> to login";
            $content = Core::loadTextMailTempleate($subject, $content);
            echo $content;
            exit;
            mosMail(CFG::$siteConfig['site_email'], CFG::$siteConfig['site_name'], $to, $subject, $content, 1);
        }
    }

    /** Gets all countries
     * 
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    function getCountry() {

        return DB::query("SELECT id,country_name FROM `" . CFG::$tblPrefix . "country`");
    }

    /**
     * check email
     *
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    function CheckEmailForSaveProfile($email) {
        //Check for email already exists
        if (APP::$curId != "") {
            $id = APP::$curId;
            $email = DB::query("select id from " . CFG::$tblPrefix . "user where email = %s and id <>" . $id, $_POST['email']);
        } else {
            $email = DB::query("select id from " . CFG::$tblPrefix . "user where email = %s", $_POST['email']);
        }

        if (count($email) != 0) {
            $_SESSION["actionResult"] = array("error" => "Email is already exists");

            if ($_POST['edit'] == 1) {
                $_SESSION['error'] = $_POST;
                UTIL::redirect(URI::getURL(APP::$moduleName, "update_profile", APP::$curId));
            } else {
                UTIL::redirect(URI::getURL(APP::$moduleName, "update_profile"));
            }
        }
    }

    function getActionData() {
        return $actionList = DB::query("select ma.id as action_id, m.id as module_id ,ma.name as action_name, m.name as module_name,ma.module_key,ma.action 
            from " . CFG::$tblPrefix . "module_action as ma 
                left join " . CFG::$tblPrefix . "modules as m on ma.module_key = m.module_key
                where -- admin_menu = '1'
                 access_level = '1' 
                order by module_key asc");
//        pre($actionList,1);
    }

    function getAccessData() {
        $actionList['roll_action'] = DB::query("select *
            from " . CFG::$tblPrefix . "roll_action
                where roll_id = '" . APP::$curId . "' ");
        $actionList['rolls'] = DB::queryFirstRow("select access_type
            from " . CFG::$tblPrefix . "rolls
                where id = '" . APP::$curId . "' ");

        return $actionList;
//        pre($actionList,1);
    }

    function getAccessName() {

        return DB::queryFirstField("select name
            from " . CFG::$tblPrefix . "rolls
                where id = '" . APP::$curId . "' ");
    }

    function saveActionData() {

        if (isset($_POST['name']) && !empty($_POST['name'])) {
            //print_r($_POST);exit;
            if (APP::$curId == "") {
                DB::insert(CFG::$tblPrefix . "rolls", array("name" => $_POST['name'], "access_level" => "admin", "access_type" => "selected", "created_date" => date("Y-m-d H:i:s"), "updated_date" => date("Y-m-d H:i:s")));
                APP::$curId = DB::insertId();
            } else {
                DB::update(CFG::$tblPrefix . "rolls", array("name" => $_POST['name'], "updated_date" => date("Y-m-d H:i:s")), "id = %d", APP::$curId);
            }
        }
        if (isset($_POST['selNodes']) && count($_POST['selNodes']) > 0) {

            DB::delete(CFG::$tblPrefix . "roll_action", "roll_id = %s", APP::$curId);
            if (in_array("all", $_POST['selNodes'])) {
                DB::update(CFG::$tblPrefix . "rolls", array("access_type" => "all"), "id = %d", APP::$curId);
            } else {
                DB::update(CFG::$tblPrefix . "rolls", array("access_type" => "selected"), "id = %d", APP::$curId);
                foreach ($_POST['selNodes'] as $k => $v) {
                    if (strpos($v, "m_") === false)
                        DB::insert(CFG::$tblPrefix . "roll_action", array("roll_id" => APP::$curId, "action_id" => $v));
                }
//                exit;
//                UTIL::redirect(URI::getURL(APP::$moduleName, APP::$actionName, APP::$curId));
            }
            echo trim(APP::$curId);
            exit;
        }
    }

    /*
     * user  access list
     * author: vishal vasani <vishal.datatech@gmail.com>
     * date: 24-05-2016
     */

    function getAccessList() {
        $orderBy = "id desc";
        if (isset($_GET['o_type']))
            $orderBy = $_GET['o_field'] . " " . $_GET['o_type'];
        $where = "";
        $whereParam = array();

        if (isset($_GET['searchForm']['name']) && trim($_GET['searchForm']['name']) != "") {
            $where .= "  name like %ss_name";
            $whereParam["name"] = Stringd::processString($_GET['searchForm']['name']);
        }

        UTIL::doPaging("totalPages", "id, name ", CFG::$tblPrefix . "rolls", $where, $whereParam, $orderBy);
    }

    /*
     * delete records from user
     * author:vishal vasnai <vishal.datatech@gmail.com>
     * date: 24-05-2016
     */

    function access_delete() {

        foreach ($_POST['status'] as $key => $val) {
            DB::query("delete from " . CFG::$tblPrefix . "rolls where id=%d", $key);
            DB::query("delete from " . CFG::$tblPrefix . "roll_action where roll_id=%d", $key);
        }
    }
    
     function getModuleList() {
        $data = DB::query("select m.name,ma.module_key,ma.admin_menu_label,ma.active_module,ma.active_action from " . CFG::$tblPrefix . "modules as m LEFT JOIN " . CFG::$tblPrefix . "module_action as ma ON m.module_key=ma.module_key where m. module_key != 'mod_user' and m.module_key != 'mod_error' and m.module_key != 'mod_sitemap'");





        //print_r($data);exit;
        //  print_r($data);exit;

        return $data;
    }

    function saveActiveModule() {
        
        //echo '4613132';exit;
        
        
        
          print_r($_POST['activeModule']);
        
        

        if (isset($_POST['activeModule']) && count($_POST['activeModule']) > 0) {

           
       // $activeData = DB::query("select module_key from " . CFG::$tblPrefix . "modules where is_active = '1'");

        $activeModule = DB::query("select module_key from " . CFG::$tblPrefix . "module_action where active_module = '1'");
        $activeAction = DB::query("select admin_menu_label from " . CFG::$tblPrefix . "module_action where module_key = 'mod_enquiry' and active_action = '1'");



           foreach ($activeModule as $v) {
                $activeM[] = $v['module_key'];
            }
$uactiveM = array_unique($activeM);
            
            print_r($uactiveM);

            foreach ($activeAction as $v) {
                $activeA[] = $v['admin_menu_label'];
                
            }

        //      print_r($activeA);
//print_r($activeM);
            
$uactiveA = array_unique($activeA);

print_r($uactiveA);


            // print_r($_POST['activeModule']);

            foreach ($_POST['activeModule'] as $v) {
                
               if(($searchM = array_search($v, $uactiveM)) !== false)
              {
                   unset($uactiveM[$searchM]);               
                   
              }
                //print_r($activeM);
                //print_r($activeM);exit;
               if(($searchA = array_search($v, $uactiveA)) !== false)
               {

                unset($uactiveA[$searchA]);
                
               }
                
                //print_r($activeA);
                
                DB::update(CFG::$tblPrefix . "module_action", array('active_module' => '1','active_action' => '1'), "module_key=%s", $v);
                DB::update(CFG::$tblPrefix . "module_action", array('active_module' => '1','active_action' => '1'), "admin_menu_label=%s", $v);
                
//                $mod = DB::query("select module_key from ".CFG::$tblPrefix."module_action where admin_menu_label=%s",$v);
//                
//                
//                
//                foreach ($mod as $ve)
//                {
//                     DB::update(CFG::$tblPrefix . "module_action", array('active_module' => '1'), "module_key=%s", $ve['module_key']);
//                }
                //$activeModule = DB::query("select module_key from ".CFG::$tblPrefix."module_action where active_action = '1'");
                
                //print_r($activeModule);exit;
                
//                foreach ($activeModule as $v)
//                {
//                    DB::update(CFG::$tblPrefix . "modules", array('is_active' => '1'), "module_key=%s", $v['module_key']);
//                }
                
            }
            print_r($uactiveM);
            print_r($uactiveA);
            
            
            foreach ($uactiveM as $value) {
                if($value != 'mod_enquiry')
                {
                    DB::update(CFG::$tblPrefix . "module_action", array('active_module' => '0','active_action' => '0'), "module_key=%s", $value);
                }
            }
            //print_r($activeA);exit;
            foreach ($uactiveA as $val) {
                DB::update(CFG::$tblPrefix . "module_action", array('active_module' => '0','active_action' => '0'), "admin_menu_label=%s", $val);
            }exit;
            
        }
    }


}

?>
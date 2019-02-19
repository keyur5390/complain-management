<?php

//restrict direct access to the page
defined('DMCCMS') or die('Unauthorized access');

class UserModel {

    /** Store fields of page record
      @var $fields array
     */
    public $records = array();
    public static $adminMail = "";

    /**
     * constructor of class UserModel. do initialisation
     *
     * @author Vimal Darji <vimal.datatech@gmail.com>
     */
    function __construct() {
      
    }

    
     
    function getAllCustomer()
    {
        return DB::query("SELECT u.id,u.name FROM ".CFG::$tblPrefix."user as u LEFT JOIN ".CFG::$tblPrefix."rolls as r  ON  u.roll_id=r.id where r.name='Customer' and u.active='1'");
    }
    
     function getCustomerName($id)
    {
        return DB::queryFirstField("SELECT u.name FROM ".CFG::$tblPrefix."user as u where u.id=%d",$id);
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
    function getAllRegionContact($id) {
        //return DB::queryFirstRow("SELECT u.id,u.name,u.username,u.password,u.email,u.phone,u.mobile FROM ".CFG::$tblPrefix."user as u where u.id=%d ",$id);        
        return DB::query("SELECT u.id,u.region_id,u.user_id,u.name as person,r.name as region_name,r.parent_region,u.address,u.phone  FROM " . CFG::$tblPrefix . "user_region as u left join ".CFG::$tblPrefix."region as r on r.id=u.region_id  where u.user_id in (%d) ", $id);
    }
     function getCountChileRegionContact() {
        //return DB::queryFirstRow("SELECT u.id,u.name,u.username,u.password,u.email,u.phone,u.mobile FROM ".CFG::$tblPrefix."user as u where u.id=%d ",$id);                    
        return DB::queryFirstRow("SELECT count(r.id) as total FROM ".CFG::$tblPrefix."region as r left join ".CFG::$tblPrefix."region as r1 on r.parent_region=r1.id where r.status='1' and r.parent_region!='0' and r1.status='1' ");
    }
    

    
    
    public function getRoles() {
        $where = "";
        
        if ($_SESSION['user_login']['roll_id'] == 5) {
            $where.=" where id in (6,7)";
        }
        else if($_SESSION['user_login']['roll_id'] == 6)
        {
              $where.=" where id in (6,7)";
        }
        else if($_SESSION['user_login']['roll_id'] == 7)
        {
              $where.=" where id in (7)";
        }
        else
        {
            
            $where.=" where id not in (1,8)";
        }
        return DB::query("SELECT id,name FROM " . CFG::$tblPrefix . "rolls" . $where);
    }
    public function getParentRoles($user="")
    {
         $where = "";
        
        if ($_SESSION['user_login']['roll_id'] == 5) {
            $where.=" where id in (6,7)";
        }
        else if($_SESSION['user_login']['roll_id'] == 6)
        {
              $where.=" where id in (6,7)";
        }
        else if($_SESSION['user_login']['roll_id'] == 7)
        {
              $where.=" where id in (7)";
        }
        else
        {
            if(!empty($user))
            {
                $userData=  $this->getValue("user","roll_id","id",$user);
                if($userData['roll_id']==7)
                {
                    $where.=" where id not in (1,5,6,8)";
                }
                else if($userData['roll_id']==5)
                {
                    $where.=" where id not in (1,7,8)";
                }
                else if($userData['roll_id']==6)
                {
                    $where.=" where id not in (1,7,8)";
                }
            }
            else
            {
                $where.=" where id not in (1,8)";
            }
        }
        
        return DB::query("SELECT id,name FROM " . CFG::$tblPrefix . "rolls" . $where);
    }
    
    /**
     * get user record list. 
     *
     * @author Vimal Darji <vimal.datatech@gmail.com>
     */
    public function getUserList() {
        
        $orderBy = "id desc";
        if (isset($_GET['o_type']))
            $orderBy = $_GET['o_field'] . " " . $_GET['o_type'];
        $where = "";
        $flag = true;
        $whereParam = array();
        
        
        if (isset($_GET['searchForm']['user_name']) && trim($_GET['searchForm']['user_name']) != "") {
            
            if(!empty($where)){
                $where.=" and ";
            }
            
            $where .= " (u.name like %ss_name or u.username like %ss_username or u.email like %ss_username or u.phone like %ss_phone) ";
            $whereParam["name"] = Stringd::processString($_GET['searchForm']['user_name']);
            $whereParam["username"] = Stringd::processString($_GET['searchForm']['user_name']);
            $whereParam["email"] = Stringd::processString($_GET['searchForm']['user_name']);
            $whereParam["phone"] = Stringd::processString($_GET['searchForm']['user_name']);
            $flag = false;
        } 
         if (isset($_GET['searchForm']['region']) && trim($_GET['searchForm']['region']) != "") {
            
            if(!empty($where)){
                $where.=" and ";
            }
            
            $where .= " find_in_set('".$_GET['searchForm']['region']."',u.region) ";
            $flag = false;
        } 
        
        
        
        if(isset($_SESSION['user_login']) && $_SESSION['user_login']["id"] > 0)
        {
             if ($flag == false) {
                $where.=" and ";
            }
             $where .= " u.id != %d_id ";
             $whereParam["id"] = $_SESSION['user_login']["id"];
             
               
             $flag = false;
        }
         
      
        $where .= " and  u.roll_id = 7 ";
        
       //DB::debugMode();
        UTIL::doPaging("totalUsers", "u.id,u.name,u.username,u.email,u.phone,u.created_by,u.all_region,u.roll_id,u.updated_by,u.active,u.sort_order,u.helpdesk_id,u.region,if(u.region=0,'-',sr.name) as sub_region,r.name as role_name", CFG::$tblPrefix . "user as u left join ".CFG::$tblPrefix."rolls as r on u.roll_id=r.id  left join ".CFG::$tblPrefix."region as sr ON sr.id=u.region", $where, $whereParam, $orderBy);  // exit;
    }
    
    
    /**
     * get user record list. 
     *
     * @author Vimal Darji <vimal.datatech@gmail.com>
     */
    public function getInventoryList() {   $orderBy = "id desc";
        if (isset($_GET['o_type']))
            $orderBy = $_GET['o_field'] . " " . $_GET['o_type'];
        $where = "";
        $flag = true;
        $whereParam = array();
        
        
       if (isset($_GET['searchForm']['user_name']) && trim($_GET['searchForm']['user_name']) != "") {
            
            if(!empty($where)){
                $where.=" and ";
            }
            
            $where .= " (u.product_model like %ss_product_model or u.product_name like %ss_product_name or u.product_sr_no like %ss_product_sr_no) ";
            $whereParam["product_model"] = Stringd::processString($_GET['searchForm']['user_name']);
            $whereParam["product_name"] = Stringd::processString($_GET['searchForm']['user_name']);
            $whereParam["product_sr_no"] = Stringd::processString($_GET['searchForm']['user_name']);
           
            $flag = false;
        } 
           if (isset($_GET['searchForm']['region']) && trim($_GET['searchForm']['region']) != "") {
            
            if(!empty($where)){
                $where.=" and ";
            }
            
            $where .= " (u.region_id=%d_region) ";
              $whereParam["region"] = Stringd::processString($_GET['searchForm']['region']);
            $flag = false;
        } 
         
        if(isset($_SESSION['user_login']) && $_SESSION['user_login']["id"] > 0)
        {
             if ($flag == false) {
                $where.=" and ";
            }
             $where .= " user_id = ".$_SESSION['userid'];
             $whereParam["user_id"] = $_SESSION['userid'];
             
               
             $flag = false;
        } 
         $date = "";
                if ($_GET['searchForm']['dateFrom'] != '' || $_GET['searchForm']['dateTo'] != '') {
                     if(!empty($where)){
                        $where.=" and ";
                    }
                    if ($_GET['searchForm']['dateFrom'] != $_GET['searchForm']['dateTo'] && $_GET['searchForm']['dateFrom'] != "" && $_GET['searchForm']['dateTo'] != "") {
                        $where .= " (date(u.warranty_start_date) between '" . date("Y-m-d", strtotime($_GET['searchForm']['dateFrom'])) . "' and '" . date("Y-m-d", strtotime($_GET['searchForm']['dateTo'])) . "' or date(u.warranty_end_date) between '" . date("Y-m-d", strtotime($_GET['searchForm']['dateFrom'])) . "' and '" . date("Y-m-d", strtotime($_GET['searchForm']['dateTo'])) . "')";
                    } else if ($_GET['searchForm']['dateFrom'] == $_GET['searchForm']['dateTo'] && $_GET['searchForm']['dateTo'] != "") {
                        $where .= " (u.warranty_start_date like '" . date("Y-m-d", strtotime($_GET['searchForm']['dateFrom'])) . "%' or u.warranty_end_date like '" . date("Y-m-d", strtotime($_GET['searchForm']['dateFrom'])) . "%')";
                    } else if (isset($_GET['searchForm']['dateFrom']) == true && $_GET['searchForm']['dateFrom'] != "") {
                       $where .= " (u.warranty_start_date like '" . date("Y-m-d", strtotime($_GET['searchForm']['dateFrom'])) . "%' or u.warranty_end_date like '" . date("Y-m-d", strtotime($_GET['searchForm']['dateFrom'])) . "%')";
                    } else if (isset($_GET['searchForm']['dateTo']) == true && $_GET['searchForm']['dateTo'] != "") {
                        $where .= " (u.warranty_start_date like '" . date("Y-m-d", strtotime($_GET['searchForm']['dateFrom'])) . "%' or u.warranty_end_date like '" . date("Y-m-d", strtotime($_GET['searchForm']['dateFrom'])) . "%')";
                    }
                }
                 if ($_GET['searchForm']['sellDate'] != '') {
                     if(!empty($where)){
                        $where.=" and ";
                    }
                 $where .= " (u.sell_date like '" . date("Y-m-d", strtotime($_GET['searchForm']['sellDate'])) . "%')";
                }
      
//        $where .= " and  u.roll_id = 7 ";
       //DB::debugMode();
        //UTIL::doPaging("totalUsers", " product_sr_no,product_name,region_id,warranty_start_date,warranty_end_date,sell_date", CFG::$tblPrefix . "inventory", $where, $whereParam, $orderBy);  // exit;
        
        UTIL::doPaging("totalUsers", "u.id,u.user_id,u.product_model,u.product_name,u.product_sr_no,u.region_id,u.warranty_start_date,u.warranty_end_date,u.sell_date,  sr.name as region_name,u.created_by ", CFG::$tblPrefix . "inventory as u left join ".CFG::$tblPrefix."region as sr ON sr.id=u.region_id", $where, $whereParam, $orderBy);
        
    }
    function getServices(){
        return DB::query("SELECT product_model as id,product_name as name FROM ".CFG::$tblPrefix."service");
    }
    

    /**
     * get user record with its slug. 
     *
     * @author Vimal Darji <vimal.datatech@gmail.com>
     */
    public function getInventoryData($id) {
       
        DB::$param_char = '##';
        
        $result=DB::queryFirstRow("SELECT product_model,product_name,product_sr_no,region_id,DATE_FORMAT(warranty_start_date, '%d-%m-%Y') as warranty_start_date,DATE_FORMAT(warranty_end_date, '%d-%m-%Y') as warranty_end_date,DATE_FORMAT(sell_date, '%d-%m-%Y') as sell_date,qty  FROM " . CFG::$tblPrefix . "inventory where id=##d ", $id);
        DB::$param_char = '%';
        return $result;
        
       
    }
      
    /**
     *  Save user data if submitted
     *
     *  @author Vimal Darji <vimal.datatech@gmail.com>
     */
    public function saveInventory() {
      
          
         
        if (isset($_POST['product_model'])) {
            
            
            if (isset($_SESSION['user_login'])) {
                $login_id = $_SESSION['user_login']['id'];
            }
            
            $warranty_start_date = date("Y-m-d",strtotime($_POST['warranty_start_date']));
            $warranty_end_date = date("Y-m-d",strtotime($_POST['warranty_end_date']));
            $sell_date = date("Y-m-d",strtotime($_POST['sell_date']));
                $userid = $_POST['userid'];
            
            $arrFields = array("login_id" => $login_id, 
                               "user_id" => $userid, 
                               "product_model" => $_POST['product_model'], 
                               "product_name" => $_POST['product_name'], 
                               "product_sr_no" => $_POST['product_sr_no'], 
                               "region_id" => $_POST['region_id'], 
                               "warranty_start_date" => $warranty_start_date, 
                               "warranty_end_date" => $warranty_end_date, 
                               "sell_date" => $sell_date
//                "qty" => $_POST['qty']
                    );

           
            // insert new record
          
           //insert new record
            if(APP::$curId == "")
            {   
                //Created user name and date
                $arrFields['created_by'] = $_SESSION['user_login']['id'];
                $arrFields['created_date'] = date("Y-m-d H:i:s");
                 
                 DB::insert(CFG::$tblPrefix."inventory",Stringd::processString($arrFields));

                 //get current id
                 APP::$curId=DB::insertId();
                 // pass action result
                    $_SESSION["actionResult"] = array("success" => "Inventory has been saved successfully");

                   if ($_POST['edit'] == 1)
                   {
                       UTIL::redirect(URI::getURL(APP::$moduleName, "inventory_edit"."&userid=".$_REQUEST['userid']."&id=".APP::$curId));
                   }else{
                       UTIL::redirect(URI::getURL(APP::$moduleName, "inventory_list")."&userid=".$_REQUEST['userid']); 
                   }
            }
            else
            {
                 $arrFields['updated_date'] = date("Y-m-d H:i:s");
                // Update Record
                DB::update(CFG::$tblPrefix."inventory",Stringd::processString($arrFields)," id=%d ",APP::$curId);
                $_SESSION["actionResult"] = array("success" => "Inventory has been saved successfully");

                   if ($_POST['edit'] == 1)
                   {
                       UTIL::redirect(URI::getURL(APP::$moduleName, "inventory_edit")."&userid=".$_REQUEST['userid']."&id=".$_REQUEST['id']);
                   }else{
                       UTIL::redirect(URI::getURL(APP::$moduleName, "inventory_list")."&userid=".$_REQUEST['userid']); 
                   }
            }
            
                 
            
        }
    }
    
     function getUserRole($id)
    {
        if((int)$id != 0)
        {
            //DB::debugMode();
            return DB::queryFirstRow("SELECT name FROM ".CFG::$tblPrefix."rolls where id=%d",$id);
        }  
         
    }
    function getUserRegion(){
        return DB::query("SELECT id,name FROM " . CFG::$tblPrefix ."region WHERE find_in_set(id,(select group_concat(region_id) from " . CFG::$tblPrefix ."inventory where user_id=%d))",$_REQUEST['userid']);
    }
   
    /** delete selected inventory
     *
     * @author Vimal Darji <vimal.datatech@gmail.com>
     */
    function deleteInventory() {
            // DB::delete(CFG::$tblPrefix . "inventory", "id=%d ", $id);
          //  echo json_encode(array("result" => "success", "title" => "Inventory", "message" => "User(s) have been deleted successfully"));
        foreach ($_POST['status'] as $key => $val) {
         
            DB::query("delete from " . CFG::$tblPrefix . "inventory where id=%d", $key);
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

    
   function getValue($table,$field,$where,$wherevalue)
   {
       if($wherevalue!='')
       {
            $array=array();
            $result=DB::query("SELECT ".$field." FROM " . CFG::$tblPrefix .$table. " where ".$where."=".$wherevalue);
            foreach($result as $key=>$value)
            {
               
                $array[$field]=$value[$field];
            }
            
            return $array;
       }
   }
   function getAllRegion(){
         $query="SELECT r.id,r.name,r.parent_region FROM ".CFG::$tblPrefix."region as r where r.status='1' and parent_region='0'";
        if($helpdesk!='' && $helpdesk > 0)
        {
            $query.=" and helpDesk=".$helpdesk;
        }
        
        $result=DB::query($query);
        $regionArray=array();
        foreach($result as $key=>$value)
        {
            
            $sub_query="SELECT r.id,r.name,r.parent_region FROM ".CFG::$tblPrefix."region as r where r.status='1'  and r.parent_region='".$value['id']."'";
            if($helpdesk!='' && $helpdesk > 0)
            {
                $sub_query.=" and helpDesk=".$helpdesk;
            }
            
            $sub_region=DB::query($sub_query);
            if(count($sub_region) > 0)
            {
                array_push($regionArray,$value);
                foreach($sub_region as $skey=>$svalue)
                {
                    array_push($regionArray,$svalue);
                }
            }
            
        }
        return $regionArray;
    } 
    
}

?>
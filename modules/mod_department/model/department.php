<?php 
/* Category model class. Contains all attributes and method related to department. */
//restrict direct access to the testimonial 
defined( 'DMCCMS' ) or die( 'Unauthorized access' );

Class departmentModel
{
    /**Store field for department record
    * @var fields array
    *
    */

    public $records=array();

    /**
    * constructor of class department model. do initialization
    *
    * @author Bhavin Lunagariya <bhavin.datatech@gmail.com>
    */

    function __construct()
    {
        // To Check If Current Id Not Match Than Redirect To Listing
//        if (APP::$actionName == 'category_edit') {
//            if (APP::$curId != "") {
//                $isRecordExist = DB::queryFirstField("SELECT id FROM " . CFG::$tblPrefix . "category where id=%d", APP::$curId);
//                if (empty($isRecordExist)) {
//                    UTIL::redirect(URI::getURL(APP::$moduleName, "category_list"));
//                }
//            }
//        }
    }
    
    /*
     * Get All Parentdepartment Recored By Its Child department Id
     * 
     * @author Mayur Patel <mayur.datatech@gmail.com>
     * 
     * This Function Use As Global For Whole Project So Make Sure To Change It.
     */
    public function getParentdepartment($id)
    {
        return DB::query("select id,name from ".CFG::$tblPrefix."department where parent_department=0 and id !=%d and status='1'",$id);
    }
    
    /**
    * get all department record. 
    *
    * @author Mayur Patel <mayur.datatech@gmail.com>
    * 
    * This Function Use As Global For Whole Project So Make Sure To Change It.
    */
    function getAlldepartment()
    {
        return DB::query("SELECT r.id,r.name,r.parent_department FROM ".CFG::$tblPrefix."department as r where r.status='1'");
    }
    function getequipemtnData()
    {
        return DB::query("SELECT r.id,r.name FROM ".CFG::$tblPrefix."equipment as r where r.status='1' and r.is_deleted='0' ");
    }

    /*
     * Check Unique department Code
     * 
     * @author Mayur Patel<mayur.datatech@gmail.com>
     * 
     * This Function Use As Global For Whole Project So Make Sure To Change It.
     */
    function check_department_code($checkcode)
    {
        if (isset($_REQUEST['id']) && $_REQUEST['id'] != '') 
        {
        return DB::queryFirstField("SELECT code FROM " . CFG::$tblPrefix . "department where code=%s and id!=%d", $checkcode, $_REQUEST['id']);
        } 
        else 
        {
        return DB::queryFirstField("SELECT code FROM " . CFG::$tblPrefix . "department where code=%s", $checkcode);
        }
        
    }
    
    
    
    /**
    * get all list
    *
    * @author Mayur Patel <mayur.datatech@gmail.com>
    */
    function getdepartmentList()
    {
        $orderBy = "r.id desc";
        if (isset($_GET['o_type']))
            $orderBy = $_GET['o_field'] . " " . $_GET['o_type'];
        $where = "";
        $whereParam = array();
        if(isset($_GET['searchForm']['name']) && trim($_GET['searchForm']['name'])!="")
        {
                $where .= "  r.name like %ss_name ";
                $whereParam["name"] = Stringd::processString($_GET['searchForm']['name']);
        }
        $where_helpDesk="";
        $teamLeader_project_maping_where="";
        
        $wheredepartment = "";
        if (isset($_GET['searchForm']['parentdepartment']) && trim($_GET['searchForm']['parentdepartment']) != "") 
        {
            if(empty($where))
            {
                if($_GET['searchForm']['parentdepartment']!="") 
                    $wheredepartment.=" r.parent_department = ".$_GET['searchForm']['parentdepartment'] . " ";
            }
            else
            {
                if($_GET['searchForm']['parentdepartment']!="")
                $wheredepartment.=" and r.parent_department = ".$_GET['searchForm']['parentdepartment'] . " ";
            }
        }
        $where.=$wheredepartment;
        
        
//        echo $where;
//        pre($whereParam);
//        die();
        
        
        
        
        UTIL::doPaging("totalPages", "r.id,r.name,r.sort_order,r.created_date,r.status", CFG::$tblPrefix . "department as r", $where, $whereParam, $orderBy);
    }
    
    /**
    * get record with its id. 
    *
    * @author Mayur Patel <mayur.datatech@gmail.com>
    */
    function getdepartmentData($id)
    {
        if((int)$id != 0){
        return DB::queryFirstRow("SELECT r.id,r.name,r.sort_order,r.status,r.code  FROM ".CFG::$tblPrefix."department as r where r.id=%d ",$id);}else{
            return false;
        }
    }
    
    
    

    
   

    
    
    

    /**
    *  Save data if submitted
    *
    * @author Mayur Patel <mayur.datatech@gmail.com>
    */
    function savedepartment()
    {
//        pre($_POST,1);
        if(isset($_POST['name'])!='')
        {
            $varName=trim($_POST['name']);
            
            $vardealer=$_POST['dealer'];
            
            $varequipment=$_POST['equipment'];
            
//            foreach ($varequipment as $a){
//                $varequipmentDa.= $a.",";
//            }
//            $varequipmentDa = rtrim($varequipmentDa,',');
            
                        // following for make new code and check if its unique
            if(empty($_POST['code']))
            {
                $makeNewCode=strtolower($varName);
                
                $isExist = ($this->check_station_code($makeNewCode) == '') ? true : false;
                
                if (!$isExist) {
                    //Is Code Already Exist so Bind Random Number between  1 to 100
                    $appendDigit=(rand(1,100));
                    $varCode=trim($makeNewCode."_".$appendDigit);
                }
                else
                {
                    // Assign new code
                    $varCode=trim($makeNewCode);
                }
            }else{
                $varCode = $_POST['code'];
            }
            
            
            if(isset($_POST['status']))
                $varStatus = '1';
            else
                $varStatus = '0';
            
            $sortOrder = "";
            if($_POST['sortOrder']=='')
            {
                $maxsortOrder=Core::maxId("department");
                $sortOrder=$maxsortOrder['maxId']+1;
            }
            else
            {
                $sortOrder=$_POST['sortOrder'];
            }
            
            
            //create array of fields
            $arrFields=array("name"=>$varName,"code"=>$varCode,"status"=>$varStatus,"sort_order"=>$sortOrder,"updated_by"=>$_SESSION['user_login']['id'],"updated_date"=>date("Y-m-d H:i:s"));
           
            //insert new record
            if(APP::$curId=="")
            {
                 //Created user name and date
                $arrFields['created_by'] = $_SESSION['user_login']['id'];
                 $arrFields['created_date'] = date("Y-m-d H:i:s");
                 DB::insert(CFG::$tblPrefix."department",Stringd::processString($arrFields));

                 //get current id
                 APP::$curId=DB::insertId();
            }
            else
            {
                // Update Record
                DB::update(CFG::$tblPrefix."department",Stringd::processString($arrFields)," id=%d ",APP::$curId);
            }
            
            //Pass Action Result
            $_SESSION['actionResult']=array("success"=>"Department has been saved successfully");  // different type success, info, warning, error
            if($_POST['edit']==1)
            {
                UTIL::redirect(URI::getURL(APP::$moduleName,"department_edit",APP::$curId));
            }
            else
            {
                UTIL::redirect(URI::getURL(APP::$moduleName,"department_list"));
            }  
        }
    }
      /*
     * Check Unique station Code
     * 
     * @author Mayur Patel<mayur.datatech@gmail.com>
     * 
     * This Function Use As Global For Whole Project So Make Sure To Change It.
     */
    function check_station_code($checkcode)
    {
        if (isset($_REQUEST['id']) && $_REQUEST['id'] != '') 
        {
        return DB::queryFirstField("SELECT code FROM " . CFG::$tblPrefix . "department where code=%s and id!=%d", $checkcode, $_REQUEST['id']);
        } 
        else 
        {
        return DB::queryFirstField("SELECT code FROM " . CFG::$tblPrefix . "department where code=%s", $checkcode);
        }
        /* 2nd Way*/
        /*
        $checkAvailability=DB::query("SELECT code FROM ".CFG::$tblPrefix."station where code like '%".$checkcode."%'");
        $flag=(sizeof($checkAvailability)==0) ? "true" :  "false";
        return $flag;
         */
        
        
        /* 1st Way */
        /*
        if($_SESSION['station_code']!="") { $checkcode=$_SESSION['station_code']; }
        $checkAvailability=DB::query("SELECT code FROM ".CFG::$tblPrefix."station where code like '%".$checkcode."%'");
        if(sizeof($checkAvailability)==0)
        {
            return $checkcode;
        }
        else
        {
            $appendDigit=(rand(0,100));
            $_SESSION['station_code']=$checkcode."_".$appendDigit;
            $this->check_station_code($_SESSION['station_code']);
        }
        */
    }
    /*
    * change status
    * 
    * @author Mayur Patel <mayur.datatech@gmail.com>
    */
    function changeStatus()
    {
        $newstatus=$_GET['newstatus'];

        foreach($_POST['status'] as $key=>$value)
        {
            DB::update(CFG::$tblPrefix."department",array("status" => $newstatus)," id=%d ",$key);
        }
    }
    
    /*
    * delete of recored
    *
    * @author Mayur Patel <mayur.datatech@gmail.com>
    */
    function deletedepartment()
    {
        foreach($_POST['status'] as $key=>$value)
        {
            DB::query("delete from ".CFG::$tblPrefix."department where id=%d ",$key);
        }
    }
    
     /**
    * save sort order
    *
    * @author Mayur Patel <mayur.datatech@gmail.com>
    */
    function saveSortOrder()
    {
        $newValue=$_GET['val'];
        $id=$_GET['id'];
        $sortOrder = "";
        if ($_GET['val'] == "") {
            $sortOrder = Core::maxId("department");
            $newValue = $sortOrder['maxId'] + 1;
        }
        else
        {
            $newValue = $_GET['val'];
        }
        DB::update(CFG::$tblPrefix."department",array("sort_order" => $newValue)," id=%d ",$id);
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
   
}   
    
    

?>
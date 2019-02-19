<?php 
/* Category model class. Contains all attributes and method related to employee. */
//restrict direct access to the testimonial 
defined( 'DMCCMS' ) or die( 'Unauthorized access' );

Class employeeModel
{
    /**Store field for employee record
    * @var fields array
    *
    */

    public $records=array();

    /**
    * constructor of class employee model. do initialization
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
     * Get All Parentemployee Recored By Its Child employee Id
     * 
     * @author Mayur Patel <mayur.datatech@gmail.com>
     * 
     * This Function Use As Global For Whole Project So Make Sure To Change It.
     */
    public function getParentemployee($id)
    {
        return DB::query("select id,name from ".CFG::$tblPrefix."employee where parent_employee=0 and id !=%d and status='1'",$id);
    }
    
    /**
    * get all employee record. 
    *
    * @author Mayur Patel <mayur.datatech@gmail.com>
    * 
    * This Function Use As Global For Whole Project So Make Sure To Change It.
    */
    function getAllemployee()
    {
        return DB::query("SELECT r.id,r.name,r.parent_employee FROM ".CFG::$tblPrefix."employee as r where r.status='1'");
    }
    function getequipemtnData()
    {
        return DB::query("SELECT r.id,r.name FROM ".CFG::$tblPrefix."equipment as r where r.status='1' and r.is_deleted='0' ");
    }
    function getstationData()
    {
        return DB::query("SELECT r.id,r.name FROM ".CFG::$tblPrefix."station as r where r.status='1'");
    }
    function getassetData()
    {
        return DB::query("SELECT r.id,r.name FROM ".CFG::$tblPrefix."asset as r where r.status='1' ");
    }
    
    /*
     * Check Unique employee Code
     * 
     * @author Mayur Patel<mayur.datatech@gmail.com>
     * 
     * This Function Use As Global For Whole Project So Make Sure To Change It.
     */
    function check_employee_code($checkcode)
    {
        if (isset($_REQUEST['id']) && $_REQUEST['id'] != '') 
        {
        return DB::queryFirstField("SELECT code FROM " . CFG::$tblPrefix . "employee where code=%s and id!=%d", $checkcode, $_REQUEST['id']);
        } 
        else 
        {
        return DB::queryFirstField("SELECT code FROM " . CFG::$tblPrefix . "employee where code=%s", $checkcode);
        }
        /* 2nd Way*/
        /*
        $checkAvailability=DB::query("SELECT code FROM ".CFG::$tblPrefix."employee where code like '%".$checkcode."%'");
        $flag=(sizeof($checkAvailability)==0) ? "true" :  "false";
        return $flag;
         */
        
        
        /* 1st Way */
        /*
        if($_SESSION['employee_code']!="") { $checkcode=$_SESSION['employee_code']; }
        $checkAvailability=DB::query("SELECT code FROM ".CFG::$tblPrefix."employee where code like '%".$checkcode."%'");
        if(sizeof($checkAvailability)==0)
        {
            return $checkcode;
        }
        else
        {
            $appendDigit=(rand(0,100));
            $_SESSION['employee_code']=$checkcode."_".$appendDigit;
            $this->check_employee_code($_SESSION['employee_code']);
        }
        */
    }
    
    
    
    /**
    * get all list
    *
    * @author Mayur Patel <mayur.datatech@gmail.com>
    */
    function getemployeeList()
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
        
        $whereemployee = "";
        if (isset($_GET['searchForm']['parentemployee']) && trim($_GET['searchForm']['parentemployee']) != "") 
        {
            if(empty($where))
            {
                if($_GET['searchForm']['parentemployee']!="") 
                    $whereemployee.=" r.parent_employee = ".$_GET['searchForm']['parentemployee'] . " ";
            }
            else
            {
                if($_GET['searchForm']['parentemployee']!="")
                $whereemployee.=" and r.parent_employee = ".$_GET['searchForm']['parentemployee'] . " ";
            }
        }
        $where.=$whereemployee;
        
        
//        echo $where;
//        pre($whereParam);
//        die();
        
        
        
        
        UTIL::doPaging("totalPages", "r.id,r.name,r.sort_order,r.created_date,r.status", CFG::$tblPrefix . "employee as r", $where, $whereParam, $orderBy);
    }
    
    /**
    * get record with its id. 
    *
    * @author Mayur Patel <mayur.datatech@gmail.com>
    */
    function getemployeeData($id)
    {
        if((int)$id != 0){
        return DB::queryFirstRow("SELECT *  FROM ".CFG::$tblPrefix."employee as r where r.id=%d ",$id);}else{
            return false;
        }
    }
    
    /**
    *  Save data if submitted
    *
    * @author Mayur Patel <mayur.datatech@gmail.com>
    */
    function saveemployee()
    {
//        pre($_POST,1);
        if(isset($_POST['name'])!='')
        {
            $varName=trim($_POST['name']);
            $varType=trim($_POST['type']);
            $varMobile=trim($_POST['mobile']);
            $varEmail=trim($_POST['email']);
            $varCode=trim($_POST['code']);
            $varDealer=$_POST['dealer'];
            $varStation=$_POST['station'];
            $varEquipment=$_POST['equipment_type'];
            $varAsset=$_POST['asset'];
            
            // following for make new code and check if its unique
            
            
            
            if(isset($_POST['status']))
                $varStatus = '1';
            else
                $varStatus = '0';
            
            $sortOrder = "";
            if($_POST['sortOrder']=='')
            {
                $maxsortOrder=Core::maxId("employee");
                $sortOrder=$maxsortOrder['maxId']+1;
            }
            else
            {
                $sortOrder=$_POST['sortOrder'];
            }
            
            //create array of fields
            $arrFields=array("name"=>$varName,"code"=>$varCode,"type"=>$varType,"dealer"=>$varDealer,"station_id"=>$varStation,"assets_id"=>$varAsset,"mobile_no"=>$varMobile,"email"=>$varEmail,"equipment"=>$varEquipment,"status"=>$varStatus,"sort_order"=>$sortOrder,"updated_by"=>$_SESSION['user_login']['id'],"updated_date"=>date("Y-m-d H:i:s"));
           
            //insert new record
            if(APP::$curId=="")
            {
                 //Created user name and date
                $arrFields['created_by'] = $_SESSION['user_login']['id'];
                 $arrFields['created_date'] = date("Y-m-d H:i:s");
                 DB::insert(CFG::$tblPrefix."employee",Stringd::processString($arrFields));

                 //get current id
                 APP::$curId=DB::insertId();
            }
            else
            {
                // Update Record
                DB::update(CFG::$tblPrefix."employee",Stringd::processString($arrFields)," id=%d ",APP::$curId);
            }
            
            //Pass Action Result
            $_SESSION['actionResult']=array("success"=>"Employee has been saved successfully");  // different type success, info, warning, error
            if($_POST['edit']==1)
            {
                UTIL::redirect(URI::getURL(APP::$moduleName,"employee_edit",APP::$curId));
            }
            else
            {
                UTIL::redirect(URI::getURL(APP::$moduleName,"employee_list"));
            }  
        }
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
            DB::update(CFG::$tblPrefix."employee",array("status" => $newstatus)," id=%d ",$key);
        }
    }
    
    /*
    * delete of recored
    *
    * @author Mayur Patel <mayur.datatech@gmail.com>
    */
    function deleteemployee()
    {
        foreach($_POST['status'] as $key=>$value)
        {
            DB::query("delete from ".CFG::$tblPrefix."employee where id=%d ",$key);
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
            $sortOrder = Core::maxId("employee");
            $newValue = $sortOrder['maxId'] + 1;
        }
        else
        {
            $newValue = $_GET['val'];
        }
        DB::update(CFG::$tblPrefix."employee",array("sort_order" => $newValue)," id=%d ",$id);
    }
    /**
    * get all employee record. 
    *
    * @author Bhavin Lunagariya <bhavin.datatech@gmail.com>
    * 
    * This Function Use As Global For Whole Project So Make Sure To Change It.
    */
    function getCustomAllemployee($helpdesk='')
    {
        
        $query="SELECT r.id,r.name,r.parent_employee FROM ".CFG::$tblPrefix."employee as r where r.status='1' and parent_employee='0'";
        if($helpdesk!='' && $helpdesk > 0)
        {
            $query.=" and helpDesk=".$helpdesk;
        }
        
        $result=DB::query($query);
        $employeeArray=array();
        foreach($result as $key=>$value)
        {
            
            $sub_query="SELECT r.id,r.name,r.parent_employee FROM ".CFG::$tblPrefix."employee as r where r.status='1'  and r.parent_employee='".$value['id']."'";
            if($helpdesk!='' && $helpdesk > 0)
            {
                $sub_query.=" and helpDesk=".$helpdesk;
            }
            
            $sub_employee=DB::query($sub_query);
            if(count($sub_employee) > 0)
            {
                array_push($employeeArray,$value);
                foreach($sub_employee as $skey=>$svalue)
                {
                    array_push($employeeArray,$svalue);
                }
            }
            
        }
        return $employeeArray;
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
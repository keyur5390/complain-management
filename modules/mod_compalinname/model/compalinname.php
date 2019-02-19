<?php 
/* Category model class. Contains all attributes and method related to compalinname. */
//restrict direct access to the testimonial 
defined( 'DMCCMS' ) or die( 'Unauthorized access' );

Class compalinnameModel
{
    /**Store field for compalinname record
    * @var fields array
    *
    */

    public $records=array();

    /**
    * constructor of class compalinname model. do initialization
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
     * Get All Parentcompalinname Recored By Its Child compalinname Id
     * 
     * @author Mayur Patel <mayur.datatech@gmail.com>
     * 
     * This Function Use As Global For Whole Project So Make Sure To Change It.
     */
    public function getParentcompalinname($id)
    {
        return DB::query("select id,name from ".CFG::$tblPrefix."compalinname where parent_compalinname=0 and id !=%d and status='1'",$id);
    }
    
    /**
    * get all compalinname record. 
    *
    * @author Mayur Patel <mayur.datatech@gmail.com>
    * 
    * This Function Use As Global For Whole Project So Make Sure To Change It.
    */
    function getAllcompalinname()
    {
        return DB::query("SELECT r.id,r.name,r.parent_compalinname FROM ".CFG::$tblPrefix."compalinname as r where r.status='1'");
    }
    function getequipemtnData()
    {
        return DB::query("SELECT r.id,r.name FROM ".CFG::$tblPrefix."equipment as r where r.status='1' and r.is_deleted='0' ");
    }

    /*
     * Check Unique compalinname Code
     * 
     * @author Mayur Patel<mayur.datatech@gmail.com>
     * 
     * This Function Use As Global For Whole Project So Make Sure To Change It.
     */
    function check_compalinname_code($checkcode)
    {
        if (isset($_REQUEST['id']) && $_REQUEST['id'] != '') 
        {
        return DB::queryFirstField("SELECT code FROM " . CFG::$tblPrefix . "compalinname where code=%s and id!=%d", $checkcode, $_REQUEST['id']);
        } 
        else 
        {
        return DB::queryFirstField("SELECT code FROM " . CFG::$tblPrefix . "compalinname where code=%s", $checkcode);
        }
        
    }
    
    
    
    /**
    * get all list
    *
    * @author Mayur Patel <mayur.datatech@gmail.com>
    */
    function getcompalinnameList()
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
        
        $wherecompalinname = "";
        if (isset($_GET['searchForm']['parentcompalinname']) && trim($_GET['searchForm']['parentcompalinname']) != "") 
        {
            if(empty($where))
            {
                if($_GET['searchForm']['parentcompalinname']!="") 
                    $wherecompalinname.=" r.parent_compalinname = ".$_GET['searchForm']['parentcompalinname'] . " ";
            }
            else
            {
                if($_GET['searchForm']['parentcompalinname']!="")
                $wherecompalinname.=" and r.parent_compalinname = ".$_GET['searchForm']['parentcompalinname'] . " ";
            }
        }
        $where.=$wherecompalinname;
        
        
//        echo $where;
//        pre($whereParam);
//        die();
        
        
        
        
        UTIL::doPaging("totalPages", "r.id,r.name,r.sort_order,r.created_date,r.status", CFG::$tblPrefix . "compalinname as r", $where, $whereParam, $orderBy);
    }
    
    /**
    * get record with its id. 
    *
    * @author Mayur Patel <mayur.datatech@gmail.com>
    */
    function getcompalinnameData($id)
    {
        if((int)$id != 0){
        return DB::queryFirstRow("SELECT r.id,r.name,r.description,r.sort_order,r.status,r.equipment  FROM ".CFG::$tblPrefix."compalinname as r where r.id=%d ",$id);}else{
            return false;
        }
    }
    
    
    

    
   

    
    
    

    /**
    *  Save data if submitted
    *
    * @author Mayur Patel <mayur.datatech@gmail.com>
    */
    function savecompalinname()
    {
//        pre($_POST,1);
        if(isset($_POST['name'])!='')
        {
            $varName=trim($_POST['name']);
            $varcomplainDescription=trim($_POST['complainDescription']);
            
            $vardealer=$_POST['dealer'];
            
            $varequipment=$_POST['equipment'];
            
//            foreach ($varequipment as $a){
//                $varequipmentDa.= $a.",";
//            }
//            $varequipmentDa = rtrim($varequipmentDa,',');
            
                        
            
            if(isset($_POST['status']))
                $varStatus = '1';
            else
                $varStatus = '0';
            
            $sortOrder = "";
            if($_POST['sortOrder']=='')
            {
                $maxsortOrder=Core::maxId("compalinname");
                $sortOrder=$maxsortOrder['maxId']+1;
            }
            else
            {
                $sortOrder=$_POST['sortOrder'];
            }
            
            
            //create array of fields
            $arrFields=array("name"=>$varName,"description"=>$varcomplainDescription,"equipment"=>$varequipment,"status"=>$varStatus,"sort_order"=>$sortOrder,"updated_by"=>$_SESSION['user_login']['id'],"updated_date"=>date("Y-m-d H:i:s"));
           
            //insert new record
            if(APP::$curId=="")
            {
                 //Created user name and date
                $arrFields['created_by'] = $_SESSION['user_login']['id'];
                 $arrFields['created_date'] = date("Y-m-d H:i:s");
                 DB::insert(CFG::$tblPrefix."compalinname",Stringd::processString($arrFields));

                 //get current id
                 APP::$curId=DB::insertId();
            }
            else
            {
                // Update Record
                DB::update(CFG::$tblPrefix."compalinname",Stringd::processString($arrFields)," id=%d ",APP::$curId);
            }
            
            //Pass Action Result
            $_SESSION['actionResult']=array("success"=>"Complain Name has been saved successfully");  // different type success, info, warning, error
            if($_POST['edit']==1)
            {
                UTIL::redirect(URI::getURL(APP::$moduleName,"compalinname_edit",APP::$curId));
            }
            else
            {
                UTIL::redirect(URI::getURL(APP::$moduleName,"compalinname_list"));
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
            DB::update(CFG::$tblPrefix."compalinname",array("status" => $newstatus)," id=%d ",$key);
        }
    }
    
    /*
    * delete of recored
    *
    * @author Mayur Patel <mayur.datatech@gmail.com>
    */
    function deletecompalinname()
    {
        foreach($_POST['status'] as $key=>$value)
        {
            DB::query("delete from ".CFG::$tblPrefix."compalinname where id=%d ",$key);
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
            $sortOrder = Core::maxId("compalinname");
            $newValue = $sortOrder['maxId'] + 1;
        }
        else
        {
            $newValue = $_GET['val'];
        }
        DB::update(CFG::$tblPrefix."compalinname",array("sort_order" => $newValue)," id=%d ",$id);
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
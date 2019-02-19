<?php 
/* Category model class. Contains all attributes and method related to asset. */
//restrict direct access to the testimonial 
defined( 'DMCCMS' ) or die( 'Unauthorized access' );

Class assetModel
{
    /**Store field for asset record
    * @var fields array
    *
    */

    public $records=array();

    /**
    * constructor of class asset model. do initialization
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
     * Get All Parentasset Recored By Its Child asset Id
     * 
     * @author Mayur Patel <mayur.datatech@gmail.com>
     * 
     * This Function Use As Global For Whole Project So Make Sure To Change It.
     */
    public function getParentasset($id)
    {
        return DB::query("select id,name from ".CFG::$tblPrefix."asset where parent_asset=0 and id !=%d and status='1'",$id);
    }
    
    /**
    * get all asset record. 
    *
    * @author Mayur Patel <mayur.datatech@gmail.com>
    * 
    * This Function Use As Global For Whole Project So Make Sure To Change It.
    */
    function getAllasset()
    {
        return DB::query("SELECT r.id,r.name,r.parent_asset FROM ".CFG::$tblPrefix."asset as r where r.status='1'");
    }
    function getequipemtnData()
    {
        return DB::query("SELECT r.id,r.name FROM ".CFG::$tblPrefix."equipment as r where r.status='1' and r.is_deleted='0' ");
    }
    function getstationData()
    {
        return DB::query("SELECT r.id,r.name FROM ".CFG::$tblPrefix."station as r where r.status='1'");
    }
    function getemployeeData()
    {
        return DB::query("SELECT r.id,r.name FROM ".CFG::$tblPrefix."employee as r where r.status='1' and r.type='1'");
    }
    function getvendorData()
    {
        return DB::query("SELECT r.id,r.name FROM ".CFG::$tblPrefix."employee as r where r.status='1' and r.type='2'");
    }
    function getAllTicketassetStatus()
    {
        //return DB::query("SELECT r.id,r.name,r.parent_asset FROM ".CFG::$tblPrefix."asset as r left join ".CFG::$tblPrefix."asset as r1 on r.parent_asset=r1.id where r.status='1' and r1.status=''");
        $query="SELECT r.id,r.name,r.parent_asset FROM ".CFG::$tblPrefix."asset as r where r.status='1' and parent_asset='0'";
        if($helpdesk!='' && $helpdesk > 0)
        {
            $query.=" and helpDesk=".$helpdesk;
        }
        
        $result=DB::query($query);
        $assetArray=array();
        foreach($result as $key=>$value)
        {
            
            $sub_query="SELECT r.id,r.name,r.parent_asset FROM ".CFG::$tblPrefix."asset as r where r.status='1'  and r.parent_asset='".$value['id']."'";
            if($helpdesk!='' && $helpdesk > 0)
            {
                $sub_query.=" and helpDesk=".$helpdesk;
            }
            
            $sub_asset=DB::query($sub_query);
            if(count($sub_asset) > 0)
            {
                array_push($assetArray,$value);
                foreach($sub_asset as $skey=>$svalue)
                {
                    array_push($assetArray,$svalue);
                }
            }
            
        }
        return $assetArray;
    }
    /*
     * Check Unique asset Code
     * 
     * @author Mayur Patel<mayur.datatech@gmail.com>
     * 
     * This Function Use As Global For Whole Project So Make Sure To Change It.
     */
    function check_asset_code($checkcode)
    {
        if (isset($_REQUEST['id']) && $_REQUEST['id'] != '') 
        {
        return DB::queryFirstField("SELECT code FROM " . CFG::$tblPrefix . "asset where code=%s and id!=%d", $checkcode, $_REQUEST['id']);
        } 
        else 
        {
        return DB::queryFirstField("SELECT code FROM " . CFG::$tblPrefix . "asset where code=%s", $checkcode);
        }
        /* 2nd Way*/
        /*
        $checkAvailability=DB::query("SELECT code FROM ".CFG::$tblPrefix."asset where code like '%".$checkcode."%'");
        $flag=(sizeof($checkAvailability)==0) ? "true" :  "false";
        return $flag;
         */
        
        
        /* 1st Way */
        /*
        if($_SESSION['asset_code']!="") { $checkcode=$_SESSION['asset_code']; }
        $checkAvailability=DB::query("SELECT code FROM ".CFG::$tblPrefix."asset where code like '%".$checkcode."%'");
        if(sizeof($checkAvailability)==0)
        {
            return $checkcode;
        }
        else
        {
            $appendDigit=(rand(0,100));
            $_SESSION['asset_code']=$checkcode."_".$appendDigit;
            $this->check_asset_code($_SESSION['asset_code']);
        }
        */
    }
    
    
    
    /**
    * get all list
    *
    * @author Mayur Patel <mayur.datatech@gmail.com>
    */
    function getassetList()
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
        
        $whereasset = "";
        if (isset($_GET['searchForm']['parentasset']) && trim($_GET['searchForm']['parentasset']) != "") 
        {
            if(empty($where))
            {
                if($_GET['searchForm']['parentasset']!="") 
                    $whereasset.=" r.parent_asset = ".$_GET['searchForm']['parentasset'] . " ";
            }
            else
            {
                if($_GET['searchForm']['parentasset']!="")
                $whereasset.=" and r.parent_asset = ".$_GET['searchForm']['parentasset'] . " ";
            }
        }
        $where.=$whereasset;
        
        
//        echo $where;
//        pre($whereParam);
//        die();
        
        
        
        
        UTIL::doPaging("totalPages", "r.id,r.name,r.sort_order,r.created_date,r.status", CFG::$tblPrefix . "asset as r", $where, $whereParam, $orderBy);
    }
    
    /**
    * get record with its id. 
    *
    * @author Mayur Patel <mayur.datatech@gmail.com>
    */
    function getassetData($id)
    {
        if((int)$id != 0){
        return DB::queryFirstRow("SELECT r.id,r.name,r.code,r.sort_order,r.status,r.dealer,r.station_id,r.equipment_id,r.employee,r.vendor  FROM ".CFG::$tblPrefix."asset as r where r.id=%d ",$id);}else{
            return false;
        }
    }
    
    
    

    
   

    
    
    

    /**
    *  Save data if submitted
    *
    * @author Mayur Patel <mayur.datatech@gmail.com>
    */
    function saveasset()
    {
//        pre($_POST,1);
        if(isset($_POST['name'])!='')
        {
            $varName=trim($_POST['name']);
            
            $vardealer=$_POST['dealer'];
            $varstation=$_POST['station'];
            $varequipment=$_POST['equipment_type'];
            $varemployee=$_POST['employee'];
            $varvendor=$_POST['vendor'];
            
            $varCode=trim($_POST['code']);
            
            // following for make new code and check if its unique
            if(empty($_POST['code']))
            {
                $makeNewCode=strtolower($varName);
                
                $isExist = ($this->check_asset_code($makeNewCode) == '') ? true : false;
                
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
            }
            
            
            if(isset($_POST['status']))
                $varStatus = '1';
            else
                $varStatus = '0';
            
            $sortOrder = "";
            if($_POST['sortOrder']=='')
            {
                $maxsortOrder=Core::maxId("asset");
                $sortOrder=$maxsortOrder['maxId']+1;
            }
            else
            {
                $sortOrder=$_POST['sortOrder'];
            }
            
            
            //create array of fields
            $arrFields=array("name"=>$varName,"code"=>str_replace(" ","-",$varCode),"dealer"=>$vardealer,"station_id"=>$varstation,"equipment_id"=>$varequipment,"employee"=>$varemployee,"vendor"=>$varvendor,"status"=>$varStatus,"sort_order"=>$sortOrder,"updated_by"=>$_SESSION['user_login']['id'],"updated_date"=>date("Y-m-d H:i:s"));
           
            //insert new record
            if(APP::$curId=="")
            {
                 //Created user name and date
                $arrFields['created_by'] = $_SESSION['user_login']['id'];
                 $arrFields['created_date'] = date("Y-m-d H:i:s");
                 DB::insert(CFG::$tblPrefix."asset",Stringd::processString($arrFields));

                 //get current id
                 APP::$curId=DB::insertId();
            }
            else
            {
                // Update Record
                DB::update(CFG::$tblPrefix."asset",Stringd::processString($arrFields)," id=%d ",APP::$curId);
            }
            
            //Pass Action Result
            $_SESSION['actionResult']=array("success"=>"asset has been saved successfully");  // different type success, info, warning, error
            if($_POST['edit']==1)
            {
                UTIL::redirect(URI::getURL(APP::$moduleName,"asset_edit",APP::$curId));
            }
            else
            {
                UTIL::redirect(URI::getURL(APP::$moduleName,"asset_list"));
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
            DB::update(CFG::$tblPrefix."asset",array("status" => $newstatus)," id=%d ",$key);
        }
    }
    
    /*
    * delete of recored
    *
    * @author Mayur Patel <mayur.datatech@gmail.com>
    */
    function deleteasset()
    {
        foreach($_POST['status'] as $key=>$value)
        {
            DB::query("delete from ".CFG::$tblPrefix."asset where id=%d ",$key);
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
            $sortOrder = Core::maxId("asset");
            $newValue = $sortOrder['maxId'] + 1;
        }
        else
        {
            $newValue = $_GET['val'];
        }
        DB::update(CFG::$tblPrefix."asset",array("sort_order" => $newValue)," id=%d ",$id);
    }
    /**
    * get all asset record. 
    *
    * @author Bhavin Lunagariya <bhavin.datatech@gmail.com>
    * 
    * This Function Use As Global For Whole Project So Make Sure To Change It.
    */
    function getCustomAllasset($helpdesk='')
    {
        
        $query="SELECT r.id,r.name,r.parent_asset FROM ".CFG::$tblPrefix."asset as r where r.status='1' and parent_asset='0'";
        if($helpdesk!='' && $helpdesk > 0)
        {
            $query.=" and helpDesk=".$helpdesk;
        }
        
        $result=DB::query($query);
        $assetArray=array();
        foreach($result as $key=>$value)
        {
            
            $sub_query="SELECT r.id,r.name,r.parent_asset FROM ".CFG::$tblPrefix."asset as r where r.status='1'  and r.parent_asset='".$value['id']."'";
            if($helpdesk!='' && $helpdesk > 0)
            {
                $sub_query.=" and helpDesk=".$helpdesk;
            }
            
            $sub_asset=DB::query($sub_query);
            if(count($sub_asset) > 0)
            {
                array_push($assetArray,$value);
                foreach($sub_asset as $skey=>$svalue)
                {
                    array_push($assetArray,$svalue);
                }
            }
            
        }
        return $assetArray;
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
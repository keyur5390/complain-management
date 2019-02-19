<?php 
/* Category model class. Contains all attributes and method related to complain. */
//restrict direct access to the testimonial 
defined( 'DMCCMS' ) or die( 'Unauthorized access' );

Class complainModel
{
    /**Store field for complain record
    * @var fields array
    *
    */

    public $records=array();

    /**
    * constructor of class complain model. do initialization
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
     * Get All Parentcomplain Recored By Its Child complain Id
     * 
     * @author Mayur Patel <mayur.datatech@gmail.com>
     * 
     * This Function Use As Global For Whole Project So Make Sure To Change It.
     */
    public function getParentcomplain($id)
    {
        return DB::query("select id,name from ".CFG::$tblPrefix."complain where parent_complain=0 and id !=%d and status='1'",$id);
    }
    
    /**
    * get all complain record. 
    *
    * @author Mayur Patel <mayur.datatech@gmail.com>
    * 
    * This Function Use As Global For Whole Project So Make Sure To Change It.
    */
    function getAllcomplain()
    {
        return DB::query("SELECT r.* FROM ".CFG::$tblPrefix."complain as r where r.status='1'");
    }
    function getAllcomplainName()
    {
        $data = DB::query("SELECT r.* FROM ".CFG::$tblPrefix."compalinname as r where r.status='1'");
        foreach($data as $key=>$val)
        {
          $dataC=array($val['id']=>$val['name']);  
        }
        return $dataC;
//        print_r($dataC);exit;
        //$resultArray = DB::query("SELECT id,name  FROM ".CFG::$tblPrefix."compalinname where equipment='".$_REQUEST['equipment_type']."'");
//    echo json_encode($resultArray);
    }
    
    public function getcomplainType(){ 
                return DB::query("SELECT id,name FROM ".CFG::$tblPrefix."problem  where status='1'");
    }
    public function getdepartment(){ 
                return DB::query("SELECT id,name FROM ".CFG::$tblPrefix."department  where status='1'");
    }
    public function getpersonData(){ 
                return DB::query("SELECT id,name FROM ".CFG::$tblPrefix."user  where active='1'");
    }
    public function getstationData(){ 
                return DB::query("SELECT id,name FROM ".CFG::$tblPrefix."station  where status='1'");
    }
    public function getemployee(){ 
                return DB::query("SELECT id,name FROM ".CFG::$tblPrefix."employee  where type='1'");
    }
    public function getvendor(){ 
                return DB::query("SELECT id,name FROM ".CFG::$tblPrefix."employee  where type='2'");
    }
    public function getgroupData(){ 
                return DB::query("SELECT id,name FROM ".CFG::$tblPrefix."group  where status='1'");
    }
    
    function getAllTicketcomplainStatus()
    {
        //return DB::query("SELECT r.id,r.name,r.parent_complain FROM ".CFG::$tblPrefix."complain as r left join ".CFG::$tblPrefix."complain as r1 on r.parent_complain=r1.id where r.status='1' and r1.status=''");
        $query="SELECT r.id,r.name,r.parent_complain FROM ".CFG::$tblPrefix."complain as r where r.status='1' and parent_complain='0'";
        if($helpdesk!='' && $helpdesk > 0)
        {
            $query.=" and helpDesk=".$helpdesk;
        }
        
        $result=DB::query($query);
        $complainArray=array();
        foreach($result as $key=>$value)
        {
            
            $sub_query="SELECT r.id,r.name,r.parent_complain FROM ".CFG::$tblPrefix."complain as r where r.status='1'  and r.parent_complain='".$value['id']."'";
            if($helpdesk!='' && $helpdesk > 0)
            {
                $sub_query.=" and helpDesk=".$helpdesk;
            }
            
            $sub_complain=DB::query($sub_query);
            if(count($sub_complain) > 0)
            {
                array_push($complainArray,$value);
                foreach($sub_complain as $skey=>$svalue)
                {
                    array_push($complainArray,$svalue);
                }
            }
            
        }
        return $complainArray;
    }
    /*
     * Check Unique complain Code
     * 
     * @author Mayur Patel<mayur.datatech@gmail.com>
     * 
     * This Function Use As Global For Whole Project So Make Sure To Change It.
     */
    function check_complain_code($checkcode)
    {
        if (isset($_REQUEST['id']) && $_REQUEST['id'] != '') 
        {
        return DB::queryFirstField("SELECT code FROM " . CFG::$tblPrefix . "complain where code=%s and id!=%d", $checkcode, $_REQUEST['id']);
        } 
        else 
        {
        return DB::queryFirstField("SELECT code FROM " . CFG::$tblPrefix . "complain where code=%s", $checkcode);
        }
        /* 2nd Way*/
        /*
        $checkAvailability=DB::query("SELECT code FROM ".CFG::$tblPrefix."complain where code like '%".$checkcode."%'");
        $flag=(sizeof($checkAvailability)==0) ? "true" :  "false";
        return $flag;
         */
        
        
        /* 1st Way */
        /*
        if($_SESSION['complain_code']!="") { $checkcode=$_SESSION['complain_code']; }
        $checkAvailability=DB::query("SELECT code FROM ".CFG::$tblPrefix."complain where code like '%".$checkcode."%'");
        if(sizeof($checkAvailability)==0)
        {
            return $checkcode;
        }
        else
        {
            $appendDigit=(rand(0,100));
            $_SESSION['complain_code']=$checkcode."_".$appendDigit;
            $this->check_complain_code($_SESSION['complain_code']);
        }
        */
    }
    
    
    
    /**
    * get all list
    *
    * @author Mayur Patel <mayur.datatech@gmail.com>
    */
    function getcomplainList()
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
        
        $wherecomplain = "";
        if (isset($_GET['searchForm']['parentcomplain']) && trim($_GET['searchForm']['parentcomplain']) != "") 
        {
            if(empty($where))
            {
                if($_GET['searchForm']['parentcomplain']!="") 
                    $wherecomplain.=" r.parent_complain = ".$_GET['searchForm']['parentcomplain'] . " ";
            }
            else
            {
                if($_GET['searchForm']['parentcomplain']!="")
                $wherecomplain.=" and r.parent_complain = ".$_GET['searchForm']['parentcomplain'] . " ";
            }
        }
        $where.=$wherecomplain;
        
        
//        echo $where;
//        pre($whereParam);
//        die();
        
        
        
        
        UTIL::doPaging("totalPages", "r.*,r.id as comid,s.id,s.name as stationname,e.id,e.name as euiname,a.id,a.name as assetname,u.id,u.name as updatedBy,p.id,p.name as complaintype,d.id,d.name as departmentname,cn.id,cn.name as compname", CFG::$tblPrefix . "complain as r inner join ".CFG::$tblPrefix . "station as s on s.id=r.station_id inner join ".CFG::$tblPrefix . "equipment as e on e.id=r.equipment_id inner join ".CFG::$tblPrefix . "department as d on d.id=r.department inner join ".CFG::$tblPrefix . "asset as a on a.id=r.assets_id inner join ".CFG::$tblPrefix . "compalinname as cn on cn.id=r.name inner join ".CFG::$tblPrefix . "user as u on u.id=r.updated_by   inner join ".CFG::$tblPrefix . "problem as p on p.id=r.complain_type", $where, $whereParam, $orderBy);
    }
    /**
    * get all list
    *
    * @author Mayur Patel <mayur.datatech@gmail.com>
    */
    function getreportList()
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
        
        $wherecomplain = "";
        if (isset($_GET['searchForm']['date_from']) && trim($_GET['searchForm']['date_from']) != "") 
        {
            if(empty($where))
            {
                if($_GET['searchForm']['date_from']!="") 
                    $wherecomplain.=" r.recived_time > '".$_GET['searchForm']['date_from'] . "'";
            }
            else
            {
                if($_GET['searchForm']['date_from']!="")
                $wherecomplain.=" and r.recived_time > '".$_GET['searchForm']['date_from'] . "' ";
            }
        }
        if (isset($_GET['searchForm']['date_to']) && trim($_GET['searchForm']['date_to']) != "") 
        {
            if(empty($where) && empty($wherecomplain))
            {
                if($_GET['searchForm']['date_to']!="") 
                    $wherecomplain.=" r.recived_time < '".$_GET['searchForm']['date_to'] . "' ";
            }
            else
            {
                if($_GET['searchForm']['date_to']!="")
                $wherecomplain.=" and r.recived_time < '".$_GET['searchForm']['date_to'] . "' ";
            }
        }
        if (isset($_GET['searchForm']['complain_type']) && trim($_GET['searchForm']['complain_type']) != "") 
        {
            if(empty($where) && empty($wherecomplain))
            {
                if($_GET['searchForm']['complain_type']!="") 
                    $wherecomplain.=" r.complain_type = '".$_GET['searchForm']['complain_type'] . "' ";
            }
            else
            {
                if($_GET['searchForm']['complain_type']!="")
                $wherecomplain.=" and r.complain_type = '".$_GET['searchForm']['complain_type'] . "' ";
            }
        }
        if (isset($_GET['searchForm']['station_name']) && trim($_GET['searchForm']['station_name']) != "") 
        {
            if(empty($where) && empty($wherecomplain))
            {
                if($_GET['searchForm']['station_name']!="") 
                    $wherecomplain.=" r.station_id = '".$_GET['searchForm']['station_name'] . "' ";
            }
            else
            {
                if($_GET['searchForm']['station_name']!="")
                $wherecomplain.=" and r.station_id = '".$_GET['searchForm']['station_name'] . "' ";
            }
        }
        if (isset($_GET['searchForm']['department_name']) && trim($_GET['searchForm']['department_name']) != "") 
        {
            if(empty($where) && empty($wherecomplain))
            {
                if($_GET['searchForm']['department_name']!="") 
                    $wherecomplain.=" r.department = '".$_GET['searchForm']['department_name'] . "' ";
            }
            else
            {
                if($_GET['searchForm']['department_name']!="")
                $wherecomplain.=" and r.department = '".$_GET['searchForm']['department_name'] . "' ";
            }
        }
        $where.=$wherecomplain;
        
        
//        echo $where;
//        pre($whereParam);
//        die();
        
        
        
        
        UTIL::doPaging("totalPages", "r.*,r.id as comid,s.id,s.name as stationname,e.id,e.name as euiname,a.id,a.name as assetname,u.id,u.name as updatedBy,p.id,p.name as complaintype,d.id,d.name as departmentname,cn.id,cn.name as compname", CFG::$tblPrefix . "complain as r inner join ".CFG::$tblPrefix . "station as s on s.id=r.station_id inner join ".CFG::$tblPrefix . "equipment as e on e.id=r.equipment_id inner join ".CFG::$tblPrefix . "department as d on d.id=r.department inner join ".CFG::$tblPrefix . "asset as a on a.id=r.assets_id inner join ".CFG::$tblPrefix . "compalinname as cn on cn.id=r.name inner join ".CFG::$tblPrefix . "user as u on u.id=r.updated_by   inner join ".CFG::$tblPrefix . "problem as p on p.id=r.complain_type", $where, $whereParam, $orderBy);
    }
    
    /**
    * get record with its id. 
    *
    * @author Mayur Patel <mayur.datatech@gmail.com>
    */
    function getcomplainData($id)
    {
        if((int)$id != 0){
        return DB::queryFirstRow("SELECT r.* FROM ".CFG::$tblPrefix."complain as r where r.id=%d ",$id);}else{
            return false;
        }
    }
    
    /**
    *  Save data if submitted
    *
    * @author Mayur Patel <mayur.datatech@gmail.com>
    */
    function savecomplain()
    {
//        pre($_POST,1);
        if(isset($_POST['complain_type'])!='' || isset($_REQUEST['forwardC']))
        {
            $varName=trim($_POST['name']);
            $varcomplain_type=trim($_POST['complain_type']);
            $vardealer=trim($_POST['dealer']);
            $varstation=(isset($_POST['station']) && $_POST['station']!='')?$_POST['station']:null;//trim($_POST['station']);
            $varequipment_type=trim($_POST['equipment_type']);
            $varasset=trim($_POST['asset']);
            $varasset_extra=trim($_POST['asset_extra']);
            $varcomplain_name=trim($_POST['complain_name']);
            $varcomplain_description=trim($_POST['complain_description']);
            $vardepartment=trim($_POST['department']);
            $varpriority=trim($_POST['priority']);
            //$varreceived_time=date("Y-m-d H:i:s");
            $varreach_time=(isset($_POST['reach_time']) && $_POST['reach_time']!='')?$_POST['reach_time']:'0000-00-00 00:00:00';
            $varclose_time=(isset($_POST['close_time']) && $_POST['close_time']!='')?$_POST['close_time']:'0000-00-00 00:00:00';
            $varremark=trim($_POST['remark']);
            $varsms_type1=(isset($_POST['sms_type1']) && $_POST['sms_type1']!='')?$_POST['sms_type1']:0;
            $varsms_type2=(isset($_POST['sms_type2']) && $_POST['sms_type2']!='')?$_POST['sms_type2']:0;
            if (isset($_POST['active']))
                $varStatus = '1';
            else
                $varStatus = '0';
            // following for make new code and check if its unique
            /*
            if($_REQUEST['txtrelaed']=='1'){
                $varrelated_id=$_REQUEST['person_id'];
                $userData = DB::query("SELECT id,name,phone,email FROM ".CFG::$tblPrefix."user  where id='".$_REQUEST['person_id']."' and active='1'");
                foreach ($userData as $key=>$val){
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL,"https://www.smsjust.com/blank/sms/user/urlsms.php");
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS,"username=username&pass=password&senderid=AGLGAS&dest_mobileno='".$val['phone']."'&message=test&response=Y");
                // Receive server response ...
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $server_output = curl_exec($ch);
                curl_close ($ch);
                // Further processing ...
                //if ($server_output == "OK") { ... } else { ... }    
                }
               // https://www.smsjust.com/blank/sms/user/urlsms.php?username=username&pass=password&senderid=AGLGAS&dest_mobileno=8401922488&message=test&response=Y
                                                
            }else if($_REQUEST['txtrelaed']=='2'){
                $varrelated_id=$_REQUEST['station_id'];
                $userData = DB::query("SELECT id,name,phone,email FROM ".CFG::$tblPrefix."user  where station_id='".$_REQUEST['station_id']."' and active='1'");
//                print_r($userData);
                foreach ($userData as $key=>$val){
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL,"https://www.smsjust.com/blank/sms/user/urlsms.php");
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS,"username=username&pass=password&senderid=AGLGAS&dest_mobileno='".$val['phone']."'&message=test&response=Y");
                // Receive server response ...
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $server_output = curl_exec($ch);
                curl_close ($ch);
                // Further processing ...
                //if ($server_output == "OK") { ... } else { ... }
                }
            }else if($_REQUEST['txtrelaed']=='3'){
                $varrelated_id=$_REQUEST['group_id'];
                $userData = DB::query("SELECT id,name,phone,email FROM ".CFG::$tblPrefix."user  where group_id='".$_REQUEST['group_id']."' and active='1'");
//                print_r($userData);exit;
                foreach ($userData as $key=>$val){
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL,"https://www.smsjust.com/blank/sms/user/urlsms.php");
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS,"username=username&pass=password&senderid=AGLGAS&dest_mobileno='".$val['phone']."'&message=test&response=Y");
                // Receive server response ...
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $server_output = curl_exec($ch);
                curl_close ($ch);
                // Further processing ...
                //if ($server_output == "OK") { ... } else { ... }
                }
            }else{
                $varrelated_id='';
            }*/
            
            //create array of fields
            //$arrFields=array("name"=>$varName,"related"=>$_REQUEST['txtrelaed'],"related_id"=>$varrelated_id,"description"=>$varDescription,"type"=>$_REQUEST['complain_type'],"status"=>$varStatus,"sort_order"=>$sortOrder,"updated_by"=>$_SESSION['user_login']['id'],"updated_date"=>date("Y-m-d H:i:s"));
       //    $arrFields=array("name"=>$varcomplain_name,"description"=>$varcomplain_description,"complain_type"=>$varcomplain_type,"company_dealer"=>$vardealer,"station_id"=>$varstation,"equipment_id"=>$varequipment_type,"assets_id"=>$varasset,"asset_extra"=>$varasset_extra,"department"=>$vardepartment,"complain_priority"=>$varpriority,"reach_time"=>$varreach_time,"close_time"=>$varclose_time,"sms_enable"=>$varsms_type1, "sap_enable"=>$varsms_type2,"status"=>$varStatus, "remark"=>$varremark,"updated_by"=>$_SESSION['user_login']['id'],"updated_date"=>date("Y-m-d H:i:s"));
            //insert new record
           if(isset($_REQUEST['forwardC']) && $_REQUEST['forwardC']!="") {
               $arrFields['forward'] = $_REQUEST['forwardC'];
               $arrFields['updated_by'] = $_SESSION['user_login']['id'];
               $arrFields['department'] = $vardepartment;
           }else{
                $arrFields=array("name"=>$varcomplain_name,"description"=>$varcomplain_description,"complain_type"=>$varcomplain_type,"company_dealer"=>$vardealer,"station_id"=>$varstation,"equipment_id"=>$varequipment_type,"assets_id"=>$varasset,"asset_extra"=>$varasset_extra,"department"=>$vardepartment,"complain_priority"=>$varpriority,"sms_enable"=>$varsms_type1, "sap_enable"=>$varsms_type2,"status"=>$varStatus, "remark"=>$varremark,"updated_by"=>$_SESSION['user_login']['id'],"updated_date"=>date("Y-m-d H:i:s")); //"reach_time"=>$varreach_time,"close_time"=>$varclose_time
           }
           if(isset($_REQUEST['employee']) && count($_REQUEST['employee'])>0){
               if (in_array("all", $_REQUEST['employee']))
               {
                   $arrFields['employee'] = 'all';
               }else
               {
                  $arrFields['employee'] = implode("+",$_REQUEST['employee']);
               }
           }
           if($_REQUEST['vendor'] && count($_REQUEST['vendor'])>0){
               if (in_array("all", $_REQUEST['vendor']))
               {
                   $arrFields['vendor'] = 'all';
               }else
               {
                    $arrFields['vendor'] = implode("+",$_REQUEST['vendor']);
               }
           }
            if(APP::$curId=="")
            {
                 //Created user name and date
                $arrFields['created_by'] = $_SESSION['user_login']['id'];
                 $arrFields['created_date'] = date("Y-m-d H:i:s");
                 $varreceived_time=date("Y-m-d H:i:s");
                $arrFields['recived_time']=$varreceived_time;
                if($varStatus==0)
                {
                   $arrFields['close_by']=$_SESSION['user_login']['name'];
                }
                 DB::insert(CFG::$tblPrefix."complain",Stringd::processString($arrFields));

                 //get current id
                 APP::$curId=DB::insertId();
            }
            else
            {
                if($varStatus==0)
                {
                   $arrFields['close_by']=$_SESSION['user_login']['name'];
                }
                // Update Record
                DB::update(CFG::$tblPrefix."complain",Stringd::processString($arrFields)," id=%d ",APP::$curId);
            }
            
            //Pass Action Result
            $_SESSION['actionResult']=array("success"=>"complain has been saved successfully");  // different type success, info, warning, error
            if($_POST['edit']==1)
            {
                UTIL::redirect(URI::getURL(APP::$moduleName,"complain_edit",APP::$curId));
            }
            else
            {
                UTIL::redirect(URI::getURL(APP::$moduleName,"complain_list"));
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
            DB::update(CFG::$tblPrefix."complain",array("status" => $newstatus)," id=%d ",$key);
        }
    }
    
    /*
    * delete of recored
    *
    * @author Mayur Patel <mayur.datatech@gmail.com>
    */
    function deletecomplain()
    {
        foreach($_POST['status'] as $key=>$value)
        {
            DB::query("delete from ".CFG::$tblPrefix."complain where id=%d ",$key);
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
            $sortOrder = Core::maxId("complain");
            $newValue = $sortOrder['maxId'] + 1;
        }
        else
        {
            $newValue = $_GET['val'];
        }
        DB::update(CFG::$tblPrefix."complain",array("sort_order" => $newValue)," id=%d ",$id);
    }
    /**
    * get all complain record. 
    *
    * @author Bhavin Lunagariya <bhavin.datatech@gmail.com>
    * 
    * This Function Use As Global For Whole Project So Make Sure To Change It.
    */
    function getCustomAllcomplain($helpdesk='')
    {
        
        $query="SELECT r.id,r.name,r.parent_complain FROM ".CFG::$tblPrefix."complain as r where r.status='1' and parent_complain='0'";
        if($helpdesk!='' && $helpdesk > 0)
        {
            $query.=" and helpDesk=".$helpdesk;
        }
        
        $result=DB::query($query);
        $complainArray=array();
        foreach($result as $key=>$value)
        {
            
            $sub_query="SELECT r.id,r.name,r.parent_complain FROM ".CFG::$tblPrefix."complain as r where r.status='1'  and r.parent_complain='".$value['id']."'";
            if($helpdesk!='' && $helpdesk > 0)
            {
                $sub_query.=" and helpDesk=".$helpdesk;
            }
            
            $sub_complain=DB::query($sub_query);
            if(count($sub_complain) > 0)
            {
                array_push($complainArray,$value);
                foreach($sub_complain as $skey=>$svalue)
                {
                    array_push($complainArray,$svalue);
                }
            }
            
        }
        return $complainArray;
    }
    function getCustomParentAllcomplain($helpdesk='')
    {
        
        $query="SELECT r.id,r.name,r.parent_complain  FROM ".CFG::$tblPrefix."complain as r where r.status='1' and parent_complain='0'";
        if($helpdesk!='' && $helpdesk > 0)
        {
            $query.=" and helpDesk=".$helpdesk;
        }
        
        $result=DB::query($query);
        $complainArray=array();
        foreach($result as $key=>$value)
        {
            
            $sub_query="SELECT h.id,h.name,h.parent_complain FROM ".CFG::$tblPrefix."helpdesk as h where h.status='1'  and find_in_set('".$value['id']."',parent_complain) <> 0";
            if($helpdesk!='' && $helpdesk > 0)
            {
                $sub_query.=" and id=".$helpdesk;
            }
            
            $sub_complain=DB::query($sub_query);
            if(count($sub_complain) > 0)
            {
                array_push($complainArray,$value);
                /*foreach($sub_complain as $skey=>$svalue)
                {
                    array_push($complainArray,$svalue);
                }*/
            }
            
        }
        return $complainArray;
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
   function getParentAllcomplain()
    {
        
        $query="SELECT r.id,r.name,r.parent_complain FROM ".CFG::$tblPrefix."complain as r where r.status='1' and parent_complain='0'";
       
        $result=DB::query($query);
        $complainArray=array();
        foreach($result as $key=>$value)
        {
            array_push($complainArray,$value);
        }
        return $complainArray;
    }
    function getRemainParentcomplain()
    {
        $query="SELECT dm.id,dm.name,dm.parent_complain 
        FROM dtm_complain AS dm
        WHERE FIND_IN_SET( dm.id, (

        SELECT group_concat( parent_complain )
        FROM `dtm_helpdesk` )
        ) =0
        AND dm.parent_complain =0";
       
        $result=DB::query($query);
        $complainArray=array();
        foreach($result as $key=>$value)
        {
            array_push($complainArray,$value);
            
           
        }
        return $complainArray;
    }
    function getAssignParentcomplain()
    {
       
        $query="SELECT parent_complain FROM ".CFG::$tblPrefix."helpdesk  where status='1' and id=%d";
       
        $result=DB::query($query, APP::$curId);
        $complainArray=array();
        foreach($result as $key=>$value)
        {
            
            $sub_query="SELECT r.id,r.name,r.parent_complain FROM ".CFG::$tblPrefix."complain as r where r.status='1' and parent_complain='0' and id in (".$value['parent_complain'].") ";      
           $sub_complain=DB::query($sub_query);

           foreach($sub_complain as $skey=>$svalue)
           {
                array_push($complainArray,$svalue);
           }
        }
        return $complainArray;
    }
    
    
    function getParentSubcomplain($varcomplain)
    {
        if(!empty($varcomplain))
        {
            $query="SELECT id FROM ".CFG::$tblPrefix."complain as r where r.status='1' and parent_complain='0' and id in (".$varcomplain.")";


            $result=DB::query($query);
            $complainArray=array();
            foreach($result as $key=>$value)
            {
                $sub_query="SELECT id FROM ".CFG::$tblPrefix."complain as r where r.status='1'  and r.parent_complain='".$value['id']."'";
                

                $sub_complain=DB::query($sub_query);
                foreach($sub_complain as $skey=>$svalue)
                {
                    array_push($complainArray,$svalue['id']);
                }

            }
            return $complainArray;
        }
    }
    function updateChilecomplain($helpdesk,$complain)
    {
        if(!empty($helpdesk) && !empty($complain))
        {
            $query="select * from ". CFG::$tblPrefix ."complain where status='1' and  parent_complain ='".$complain."'";
            $result=DB::query($query);
            if(count($result) > 0)
            {
                foreach($result as $key=>$value)
                {
                    $arrFields['helpDesk'] = $helpdesk;

                    // update record
                    DB::update(CFG::$tblPrefix . "complain", Stringd::processString($arrFields), " id=%d ",$value['id'] );
                }
            }
        }
    }
}   
    
    

?>
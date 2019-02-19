<?php 
/* Category model class. Contains all attributes and method related to Help Desk. */
//restrict direct access to the testimonial 
defined( 'DMCCMS' ) or die( 'Unauthorized access' );

Class HelpDeskModel
{
    /**Store field for help desk record
    * @var fields array
    *
    */

    public $records=array();

    /**
    * constructor of class help desk model. do initialization
    *
    * @author Mayur Patel <mayur.datatech@gmail.com>
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
     * Check Unique Region Code
     * 
     * @author Mayur Patel<mayur.datatech@gmail.com>
     */
    function check_helpDesk_code($checkcode)
    {
        if (isset($_REQUEST['id']) && $_REQUEST['id'] != '') 
        {
        return DB::queryFirstField("SELECT code FROM " . CFG::$tblPrefix . "helpdesk where code=%s and id!=%d", $checkcode, $_REQUEST['id']);
        } 
        else 
        {
        return DB::queryFirstField("SELECT code FROM " . CFG::$tblPrefix . "helpdesk where code=%s", $checkcode);
        }
    }
    
    
    /**
    * get all help desk manager data. 
    *
    * @author Mayur Patel <mayur.datatech@gmail.com>
    * 
    * This Function Use As Global For Whole Project So Make Sure To Change It.
    */
    function getAllHelpDeskData()
    {
        return DB::query("SELECT hd.id,hd.name FROM ".CFG::$tblPrefix."helpdesk as hd where hd.status='1'");
    }
    
    /**
    * get all list
    *
    * @author Mayur Patel <mayur.datatech@gmail.com>
    */
    //function getHelpDeskList($assignHelpDeskManagerId)
    function getHelpDeskList()
    {
        $orderBy = "hd.id desc";
        if (isset($_GET['o_type']))
            $orderBy = $_GET['o_field'] . " " . $_GET['o_type'];
        $where = "";
        /*
        ($assignHelpDeskManagerId != "" && $assignHelpDeskManagerId != "0" ) ? $where = " find_in_set('".$assignHelpDeskManagerId."',manager) <> 0 " : $where = "";
         * 
         */
        
        
        $whereParam = array();
        if(isset($_GET['searchForm']['name']) && trim($_GET['searchForm']['name'])!="")
        {
                $where .= "  hd.name like %ss_name ";
                $whereParam["name"] = Stringd::processString($_GET['searchForm']['name']);
                
//                if (isset($_GET['searchForm']['parent_region']) && trim($_GET['searchForm']['parent_region']) != "") 
//                {
//                    $where .= " and r.parent_region = " . Stringd::processString($_GET['searchForm']['parent_region']) . " ";
//                } 
        }
//        else 
//        {
//            if (isset($_GET['searchForm']['parent_region']) && trim($_GET['searchForm']['parent_region']) != "") 
//            {
//                $where .= " r.parent_region = " . Stringd::processString($_GET['searchForm']['parent_region']) . " ";
//            }
//        }
        UTIL::doPaging("totalPages", "hd.id,hd.name,hd.status,hd.sort_order", CFG::$tblPrefix . "helpdesk as hd", $where, $whereParam, $orderBy);
    }
    
    
        /*
        * Check HelpDesk Assign To Particular User Or Not
        * 
        * @author Mayur Patel<mayur.datatech@gmail.com>
        */
//        public function checkHelpDeskAccessRights()
//        {
//        
//        }


    /*
     * Get All ParentRegion Recored By Its Child Region Id
     * 
     * @author Mayur Patel <mayur.datatech@gmail.com>
     */
    public function getParentregion($id)
    {
        return DB::query("select id,name from ".CFG::$tblPrefix."region where parent_region=0 and id !=%d",$id);
    }
   

    /**
    * get record with its id. 
    *
    * @author Mayur Patel <mayur.datatech@gmail.com>
    */
    //function getHelpDeskData($id,$assignHelpDeskManagerId)
    function getHelpDeskData($id)
    {
        if((int)$id != 0)
        {
            $mainQuery="SELECT hd.* FROM ".CFG::$tblPrefix."helpdesk as hd where hd.id=".$id;
            /*($assignHelpDeskManagerId != "" && $assignHelpDeskManagerId != "0" ) 
            ? $where = " and find_in_set('".$assignHelpDeskManagerId."',hd.manager) <> 0 " 
            : $where="";
            $mainQuery.=$where;*/
            return DB::queryFirstRow($mainQuery);
        }
    }
    
    

    /**
    *  Save data if submitted
    *
    * @author Mayur Patel <mayur.datatech@gmail.com>
    */
    function saveHelpDesk()
    {
//        echo implode(",",$_POST['region']);
//        pre($_POST,1);
        if(isset($_POST['name'])!='')
        {
            $varName=trim($_POST['name']);
            $varCode=trim($_POST['code']);
            // following for make new code and check if its unique
            if(empty($_POST['code']))
            {
                $makeNewCode=strtolower($varName);
                
                $isExist = ($this->check_helpDesk_code($makeNewCode) == '') ? true : false;
                
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
            $varManager=implode(",",$_POST['manager']);
            $varRegion=implode(",",$_POST['region']);
            
            if(isset($_POST['status']))
                $varStatus = '1';
            else
                $varStatus = '0';
            
            $sortOrder = "";
            if($_POST['sortOrder']=='')
            {
                $maxsortOrder=Core::maxId("helpdesk");
                $sortOrder=$maxsortOrder['maxId']+1;
            }
            else
            {
                $sortOrder=$_POST['sortOrder'];
            }
           if(!empty($varRegion))
           {
                $sub_region=implode(",",$this->getParentSubRegion($varRegion));
           }
           
            //create array of fields
            $arrFields=array("name"=>$varName,"code"=>str_replace(" ","-",$varCode),"manager"=>$varManager,"region"=>$sub_region,"parent_region"=>$varRegion,"status"=>$varStatus,"sort_order"=>$sortOrder,"updated_by"=>$_SESSION['user_login']['id'],"updated_date"=>date("Y-m-d H:i:s"));
            
             $past_region=$this->getValue("helpdesk","parent_region","id",APP::$curId);
             $past_manager=$this->getValue("helpdesk","manager","id",APP::$curId);
            
            //insert new record
            if(APP::$curId=="")
            {
                //Created user name and date
                $arrFields['created_by'] = $_SESSION['user_login']['id'];
                $arrFields['created_date'] = date("Y-m-d H:i:s");
                 
                 DB::insert(CFG::$tblPrefix."helpdesk",Stringd::processString($arrFields));

                 //get current id
                 APP::$curId=DB::insertId();
            }
            else
            {
                
                // Update Record
                DB::update(CFG::$tblPrefix."helpdesk",Stringd::processString($arrFields)," id=%d ",APP::$curId);
            }
            
            if(!empty(APP::$curId))
            {
                
                $this->updateRegionRecord($varRegion,APP::$curId,$past_region['parent_region']);
                
                $this->updateUserRecord($varManager,APP::$curId,$past_manager['manager']);
            }
            //Pass Action Result
            $_SESSION['actionResult']=array("success"=>"Help Desk has been saved successfully");  // different type success, info, warning, error
            if($_POST['edit']==1)
            {
                UTIL::redirect(URI::getURL(APP::$moduleName,"helpDesk_edit",APP::$curId));
            }
            else
            {
                UTIL::redirect(URI::getURL(APP::$moduleName,"helpDesk_list"));
            }  
            
        }
    }
    function updateRegionRecord($parent_region,$helpdesk,$past_region)
    {
       if(!empty($parent_region))
       {
           
           
            $query="select * from ". CFG::$tblPrefix ."region where parent_region='0' and  id  in (".$parent_region.")";
           
            $result=DB::query($query);

            if(count($result) > 0)
            {
                foreach($result as $key=>$value)
                {
                     $arrFields['helpDesk']=$helpdesk;
                     
                     DB::update(CFG::$tblPrefix . "region", Stringd::processString($arrFields), " id=%d ",$value['id']);
                    $this->updateSubRegion($value['id'],$helpdesk);
                }
            }
            if(!empty($past_region))
            {
                
                $query="select * from ". CFG::$tblPrefix ."region where parent_region='0' and  id  in (".$past_region.")";
                $result=DB::query($query);
                $pass_region=explode(",",$parent_region);
                if(count($result) > 0)
                {
                    foreach($result as $key=>$value)
                    {
                        if(!in_array($value['id'],$pass_region))
                        {
                            $arrFields['helpDesk']="";
                             DB::update(CFG::$tblPrefix . "region", Stringd::processString($arrFields), " id=%d ",$value['id']);
                            $this->updateSubRegion($value['id'],"0");
                        }
                    }
                }
            }
            
       }
       else
       {
           
           if(!empty($past_region))
           {
               
                $query="select * from ". CFG::$tblPrefix ."region where parent_region='0' and  id  in (".$past_region.")";
                
                $result=DB::query($query);

                if(count($result) > 0)
                {
                    foreach($result as $key=>$value)
                    {
                         $arrFields['helpDesk']="";
                         DB::update(CFG::$tblPrefix . "region", Stringd::processString($arrFields), " id=%d ",$value['id']);
                        $this->updateSubRegion($value['id'],"0");
                    }
                }
          }
       }
    }
    
    function updateUserRecord($manager,$helpdesk,$past_manager)
    {
        if(!empty($manager))
       {
          
           
            $query="select * from ". CFG::$tblPrefix ."user where  id  in (".$manager.")";
           
            $result=DB::query($query);

            if(count($result) > 0)
            {
                foreach($result as $key=>$value)
                {
                     $arrFields['helpdesk_id']=$helpdesk;
                     
                     DB::update(CFG::$tblPrefix . "user", Stringd::processString($arrFields), " id=%d ",$value['id']);
                     $parent_region=$this->getValue("helpdesk","parent_region","id",$helpdesk);
                     $region=$this->getValue("helpdesk","region","id",$helpdesk);
                     
                     $this->updateUserHelpdeskRegion($value['id'],$helpdesk,$parent_region['parent_region'],$region['region']);
                     
                }
            }
            if(!empty($past_manager))
            {
                
                $query="select * from ". CFG::$tblPrefix ."user where id  in (".$past_manager.")";
                $result=DB::query($query);
                $pass_manager=explode(",",$manager);
                
                if(count($result) > 0)
                {
                    foreach($result as $key=>$value)
                    {
                        if(!in_array($value['id'],$pass_manager))
                        {
                            $arrFields['helpdesk_id']="0";
                             DB::update(CFG::$tblPrefix . "user", Stringd::processString($arrFields), " id=%d ",$value['id']);
                            
                            $this->updateUserHelpdeskRegion($value['id'],"0","","");
                        }
                    }
                }
            }
       }
    }
    function updateUserHelpdeskRegion($user,$helpdesk,$parent_region,$region)
    {
       if(!empty($user) && !empty($helpdesk))
       {
          
           
            $query="select * from ". CFG::$tblPrefix ."user where  id =".$user." and helpdesk_id=".$helpdesk."";
           
            $result=DB::query($query);
            $parent_region_array=explode(",",$parent_region);
            $region_array=explode(",",$region);
            if(count($result) > 0)
            {
                foreach($result as $key=>$value)
                {
                    $parent_array=explode(",",$value['sub_region']);
                    for($i=0;$i<count($parent_region_array);$i++)
                    {
                        if(!in_array($parent_region_array[$i],$parent_array))
                        {
                            array_push($parent_array,$parent_region_array[$i]);
                        }
                    }
                    

                }
                $manage_array=array_values(array_diff($parent_array,array( "" )));
              
                $arrFields['sub_region'] = implode(",",$manage_array);
                $sub_region=implode(",",$this->getParentSubRegion($arrFields['sub_region']));
                $arrFields['region']=$sub_region;
                 // update record
                
                 DB::update(CFG::$tblPrefix . "user", Stringd::processString($arrFields), " id=%d ",$user );
            }
            
       }
       else
       {
           if(empty($helpdesk))
           {
               $arrFields['helpdesk_id']="0";
               $arrFields['region']="";
               $arrFields['sub_region']="";
               
              
               DB::update(CFG::$tblPrefix . "user", Stringd::processString($arrFields), " id=%d ",$user);
               
           }
            
       }
    }
    function updateSubRegion($region,$helpdesk)
    {
       if(!empty($region))
       {
          
            
            $query="select * from ". CFG::$tblPrefix ."region where parent_region!='0' and parent_region=".$region."";
            $result=DB::query($query);

            if(count($result) > 0)
            {
                foreach($result as $key=>$value)
                {
                     $arrFields['helpDesk']=$helpdesk;
                     DB::update(CFG::$tblPrefix . "region", Stringd::processString($arrFields), " id=%d ",$value['id']);
                }
            }
            
       }
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
            DB::update(CFG::$tblPrefix."helpdesk",array("status" => $newstatus)," id=%d ",$key);
        }
    }
    
    /*
    * delete of recored
    *
    * @author Mayur Patel <mayur.datatech@gmail.com>
    */
    function deleteHelpDesk()
    {
        foreach($_POST['status'] as $key=>$value)
        {
            DB::query("delete from ".CFG::$tblPrefix."helpdesk where id=%d",$key);
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
            $sortOrder = Core::maxId("helpdesk");
            $newValue = $sortOrder['maxId'] + 1;
        }
        else
        {
            $newValue = $_GET['val'];
        }
        DB::update(CFG::$tblPrefix."helpdesk",array("sort_order" => $newValue)," id=%d ",$id);
    }
    function getParentSubRegion($varRegion)
    {
        if(!empty($varRegion))
        {
            $query="SELECT id FROM ".CFG::$tblPrefix."region as r where r.status='1' and parent_region='0' and id in (".$varRegion.")";


            $result=DB::query($query);
            $regionArray=array();
            foreach($result as $key=>$value)
            {
                $sub_query="SELECT id FROM ".CFG::$tblPrefix."region as r where r.status='1'  and r.parent_region='".$value['id']."'";
                

                $sub_region=DB::query($sub_query);
                foreach($sub_region as $skey=>$svalue)
                {
                    array_push($regionArray,$svalue['id']);
                }

            }
            return $regionArray;
        }
    }
    function getRemainManager()
    {
        $query="SELECT u.id,u.name
        FROM ".CFG::$tblPrefix."user AS u
        WHERE FIND_IN_SET( u.id, (

        SELECT group_concat( manager )
        FROM ".CFG::$tblPrefix."helpdesk )
        ) =0
        AND active = '1' AND roll_id = '5'";
       
        $result=DB::query($query);
        $regionArray=array();
        foreach($result as $key=>$value)
        {
            array_push($regionArray,$value);
            
           
        }
        return $regionArray;
    }
}   

?>
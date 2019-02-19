<?php 
/* Category model class. Contains all attributes and method related to groups. */
//restrict direct access to the testimonial 
defined( 'DMCCMS' ) or die( 'Unauthorized access' );

Class groupModel
{
    /**Store field for group record
    * @var fields array
    *
    */

    public $records=array();

    /**
    * constructor of class group model. do initialization
    *
    * @author Sagar Jogi <sagarjogi.datatech@gmail.com>
    */

    function __construct()
    {
        
    }
  
    
    /**
    * get all types of group
    *
    * @author Sagar Jogi <sagarjogi.datatech@gmail.com>
    */
   
    function getgroupList()
    {
        $orderBy = "p.id desc";
        if (isset($_GET['o_type']))
            $orderBy = $_GET['o_field'] . " " . $_GET['o_type'];
        $where = "is_deleted='0'";
    
        $whereParam = array();
        if(isset($_GET['searchForm']['name']) && trim($_GET['searchForm']['name'])!="")
        {
                $where .= "  and p.name like %ss_name ";
                $whereParam["name"] = Stringd::processString($_GET['searchForm']['name']);
               
        }
//      
        UTIL::doPaging("totalPages", "p.id,p.name,p.status", CFG::$tblPrefix . "group as p", $where, $whereParam, $orderBy);
    }
    
     /**
    * save/update types of group
    *
    * @author Sagar Jogi <sagarjogi.datatech@gmail.com>
    */
     public function savegroupData($group) {

        if(isset($group['pname']) && !empty($group['pname'])){
                $arrFields['name'] = $group['pname'];
                $arrFields['is_deleted'] = '0';
                if(isset($group['pid']) && !empty($group['pid'])){
                     $arrFields['updated_date'] = date("Y-m-d H:i:s");
                      DB::update(CFG::$tblPrefix."group",Stringd::processString($arrFields)," id=%d ",$group['pid']);
                } else{
                      $arrFields['status'] = '1';
                     $arrFields['created_date'] = date("Y-m-d H:i:s");
                    DB::insert(CFG::$tblPrefix."group",Stringd::processString($arrFields));
                }
           }
        
    }
    
    /*
    * change status
    * 
    * @author Sagar Jogi <sagarjogi.datatech@gmail.com>
    */
    function changeStatus()
    {
        $newstatus=$_GET['newstatus'];

        foreach($_POST['status'] as $key=>$value)
        {
            DB::update(CFG::$tblPrefix."group",array("status" => $newstatus)," id=%d ",$key);
        }
    }
    
    /*
    * delete of group type
    *
    * @author Sagar Jogi <sagarjogi.datatech@gmail.com>
    */
    function deletegroup()
    {
        foreach($_POST['status'] as $key=>$value)
        {
             DB::update(CFG::$tblPrefix."group",array("is_deleted" => '1')," id=%d ",$key);
        }
    }
    
}   

?>
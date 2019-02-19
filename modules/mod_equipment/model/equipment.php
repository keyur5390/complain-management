<?php 
/* Category model class. Contains all attributes and method related to equipments. */
//restrict direct access to the testimonial 
defined( 'DMCCMS' ) or die( 'Unauthorized access' );

Class equipmentModel
{
    /**Store field for equipment record
    * @var fields array
    *
    */

    public $records=array();

    /**
    * constructor of class equipment model. do initialization
    *
    * @author Sagar Jogi <sagarjogi.datatech@gmail.com>
    */

    function __construct()
    {
        
    }
  
    
    /**
    * get all types of equipment
    *
    * @author Sagar Jogi <sagarjogi.datatech@gmail.com>
    */
   
    function getequipmentList()
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
        UTIL::doPaging("totalPages", "p.id,p.name,p.status", CFG::$tblPrefix . "equipment as p", $where, $whereParam, $orderBy);
    }
    
     /**
    * save/update types of equipment
    *
    * @author Sagar Jogi <sagarjogi.datatech@gmail.com>
    */
     public function saveequipmentData($equipment) {

        if(isset($equipment['pname']) && !empty($equipment['pname'])){
                $arrFields['name'] = $equipment['pname'];
                $arrFields['is_deleted'] = '0';
                if(isset($equipment['pid']) && !empty($equipment['pid'])){
                     $arrFields['updated_date'] = date("Y-m-d H:i:s");
                      DB::update(CFG::$tblPrefix."equipment",Stringd::processString($arrFields)," id=%d ",$equipment['pid']);
                } else{
                      $arrFields['status'] = '1';
                     $arrFields['created_date'] = date("Y-m-d H:i:s");
                    DB::insert(CFG::$tblPrefix."equipment",Stringd::processString($arrFields));
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
            DB::update(CFG::$tblPrefix."equipment",array("status" => $newstatus)," id=%d ",$key);
        }
    }
    
    /*
    * delete of equipment type
    *
    * @author Sagar Jogi <sagarjogi.datatech@gmail.com>
    */
    function deleteequipment()
    {
        foreach($_POST['status'] as $key=>$value)
        {
             DB::update(CFG::$tblPrefix."equipment",array("is_deleted" => '1')," id=%d ",$key);
        }
    }
    
}   

?>
<?php

define('DMCCMS', 1);

require_once('load.php');
Load::loadApplication();
error_reporting(0);

if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'all_customer_email' && $_REQUEST['code'] != '') {


    $code = strtolower($_REQUEST['code']);

    $where = "";
    if (isset($_REQUEST["notid"]) && !empty($_REQUEST['notid'])) {

        $arr = array_filter($_REQUEST['notid']);
        if (count($arr) > 0) {
            $where .= " id not in (" . implode(",", $arr) . ") AND ";
        }
    }

    $resultArray['items'] = DB::query("SELECT email as id,CONCAT(email ,'  <',name , '>') as text FROM " . CFG::$tblPrefix . "user WHERE " . $where . " ( LOWER(name) LIKE %ss_cuname OR LOWER(email) LIKE %ss_cuname) AND email != '' AND is_deleted != '1'", array('cuname' => $code));
    // $resultArray['items'] = array("id"=>'other',"text"=>"Other");
    array_push($resultArray['items'], array("id" => 'other', "text" => "Other"));
    echo json_encode($resultArray);
    exit;
}

if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'all_customer_name' && $_REQUEST['code'] != '') {
    $code = strtolower($_REQUEST['code']);
    $resultArray['items'] = DB::query("SELECT u.id as id,u.name as text FROM " . CFG::$tblPrefix . "user as u LEFT JOIN " . CFG::$tblPrefix . "rolls as r  ON  u.roll_id=r.id where r.name='Customer' and u.active='1' and u.name LIKE '%".$code."%'");
    echo json_encode($resultArray);
    exit;
}
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'all_engineer_name' && $_REQUEST['code'] != '') {
    $code = strtolower($_REQUEST['code']);
    $resultArray['items'] = DB::query("SELECT u.id as id,u.name as text FROM ".CFG::$tblPrefix."user as u LEFT JOIN ".CFG::$tblPrefix."rolls as r  ON  u.roll_id=r.id where r.name='Engineer' and u.active='1' and u.name LIKE '%".$code."%'");
    echo json_encode($resultArray);
    exit;
}
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'all_help_desk' && $_REQUEST['code'] != '') {
    $code = strtolower($_REQUEST['code']);
    $resultArray['items'] = DB::query("SELECT hd.id as id,hd.name as text FROM ".CFG::$tblPrefix."helpdesk as hd where hd.status='1' and hd.name LIKE '%".$code."%'");
    echo json_encode($resultArray);
    exit;
}
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'all_region' && $_REQUEST['code'] != '') {
    $code = strtolower($_REQUEST['code']);
    $resultArray['items'] = DB::query("SELECT hd.id as id,hd.name as text FROM ".CFG::$tblPrefix."helpdesk as hd where hd.status='1' and hd.name LIKE '%".$code."%'");
    $resultArray['items'] = DB::query("SELECT r.id as id,r.name as text FROM ".CFG::$tblPrefix."region as r where r.status='1' and r.name LIKE '%".$code."%'");
    echo json_encode($resultArray);
    exit;
}
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'all_service') {
    $resultArray['items'] = DB::query("SELECT product_model as id,product_name as text FROM ".CFG::$tblPrefix."service");
    echo json_encode($resultArray);
    exit;
}
if (isset($_REQUEST['station_id']) && $_REQUEST['station_id'] != '' && !isset($_REQUEST['action'])) {
    $resultArray = DB::query("SELECT eq.id,eq.name  FROM ".CFG::$tblPrefix."equipment as eq,".CFG::$tblPrefix."station as st where st.id='".$_REQUEST['station_id']."' and  find_in_set(eq.id,st.equipment) ");
    echo json_encode($resultArray);
    exit;
}
if (isset($_REQUEST['dealer']) && $_REQUEST['dealer'] != '' && !isset($_REQUEST['action'])) {
    $resultArray = DB::query("SELECT id,name  FROM ".CFG::$tblPrefix."station where dealer='".$_REQUEST['dealer']."'");
    echo json_encode($resultArray);
    exit;
}
// dealer 	station_id 	equipment_id
if (isset($_REQUEST['equipment_type']) && $_REQUEST['dealer'] != '' && $_REQUEST['station'] != '' && $_REQUEST['action']=="getAssets") {
    $resultArray = DB::query("SELECT id,name  FROM ".CFG::$tblPrefix."asset where dealer='".$_REQUEST['dealer']."' and station_id='".$_REQUEST['station']."' and equipment_id='".$_REQUEST['equipment_type']."'");
    echo json_encode($resultArray);
    exit;
}
if (isset($_REQUEST['equipment_type']) && $_REQUEST['action']=="getComplainname") {
    $resultArray = DB::query("SELECT id,name  FROM ".CFG::$tblPrefix."compalinname where equipment='".$_REQUEST['equipment_type']."'");
    echo json_encode($resultArray);
    exit;
}
if (isset($_REQUEST['complain_name']) && $_REQUEST['action']=="getComplainDesc") {
    $resultArray = DB::query("SELECT id,description  FROM ".CFG::$tblPrefix."compalinname where id='".$_REQUEST['complain_name']."'");
    echo json_encode($resultArray);
    exit;
}
//if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'all_region1' && $_REQUEST['code'] != '') {
//    $code = strtolower($_REQUEST['code']);
//    $resultArray['items'] = DB::query("SELECT hd.id as id,hd.name as text FROM ".CFG::$tblPrefix."helpdesk as hd where hd.status='1' and hd.name LIKE '%".$code."%'");
//    $resultArray['items'] = DB::query("SELECT r.id as id,r.name as text FROM ".CFG::$tblPrefix."region as r where r.status='1' and r.name LIKE '%".$code."%' and parent_region!=0");
//    echo json_encode($resultArray);
//    exit;
//}
//to fetch list of region at user add/edit time added by sagar jogi dt 02/06/2017 start
if (isset($_REQUEST['action']) && $_REQUEST['action'] =='all_region1' && $_REQUEST['code'] !='') {
    
   
        $code = strtolower($_REQUEST['code']);
        
        $where = "";
        if (isset($_REQUEST["notid"]) && !empty($_REQUEST['notid']) ) {
            
            $arr= array_filter($_REQUEST['notid']);
            if(count($arr) > 0)
            {
                $where .= " id not in (" . implode(",", $arr) . ") AND ";
            }
        }
        
        $resultArray['items'] = DB::query("SELECT r.id as id,r.name as text FROM ".CFG::$tblPrefix."region as r WHERE ".$where." r.status='1' and r.name LIKE '%".$code."%' and parent_region!=0");
        echo json_encode($resultArray);
        exit;
}
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'checkSrNo' && $_REQUEST['product_model'] != '') {

    $make_name = trim(strtolower($_POST['product_model']));
    $query = "SELECT LOWER(product_model) FROM " . CFG::$tblPrefix . "service where LOWER(product_model) = '" . $make_name . "'";

    if (isset($_POST['current_id']) && $_POST['current_id'] != '') {
        $id = $_POST['current_id'];
        if ((int) $id != 0) {
            $query .= ' AND id != ' . $id;
        }
    }
    $checkUser = UTIL::getLanguageData($query);
    if (!empty($checkUser) && in_array($make_name, $checkUser)) {
        echo "false";
    } else {
        echo "true";
    }
    exit;
}
/* Vimal Darji */
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'checkProSrNo' && $_REQUEST['product_sr_no'] != '') {

    $product_sr_no = trim(strtolower($_POST['product_sr_no']));
    $product_model = trim(strtolower($_POST['product_model']));
    $query = "SELECT LOWER(product_sr_no) FROM " . CFG::$tblPrefix . "inventory where LOWER(product_sr_no) = '" . $product_sr_no . "' AND LOWER(product_model) = '" . $product_model . "'";

    if (isset($_POST['current_id']) && $_POST['current_id'] != '') {
        $id = $_POST['current_id'];
        if ((int) $id != 0) {
            $query .= ' AND id != ' . $id;
        }
    }
    $checkUser = UTIL::getLanguageData($query);
    if (!empty($checkUser) && in_array($product_sr_no, $checkUser)) {
        echo "false";
    } else {
        echo "true";
    }
    exit;
}
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'forwardcom' && $_REQUEST['comid'] != '') {

    $arrFields['reach_time']=$_REQUEST['reach_time'];
    $arrFields['close_time']=$_REQUEST['close_time'];
    $arrFields['status']=$_REQUEST['status'];
    if($_REQUEST['status']==1)
      {
        $arrFields['close_by']=$_SESSION['user_login']['name'];
      }else
      {
          $arrFields['close_by']="";
      }
    
    DB::update(CFG::$tblPrefix."complain",Stringd::processString($arrFields)," id=%d ",$_REQUEST['comid']);
    echo "true";
    exit;
}
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'updatecom' && $_REQUEST['comid'] != '') {

    $arrFields['reach_time']=$_REQUEST['reach_time'];
    $arrFields['close_time']=$_REQUEST['close_time'];
    $arrFields['status']=$_REQUEST['status'];
    if($_REQUEST['status']==1)
      {
        $arrFields['close_by']=$_SESSION['user_login']['name'];
      }else
      {
          $arrFields['close_by']="";
      }
    
    DB::update(CFG::$tblPrefix."complain",Stringd::processString($arrFields)," id=%d ",$_REQUEST['comid']);
    echo "true";
    exit;
}
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'exportlist') {

//    $arrFields['reach_time']=$_REQUEST['name'];
//    $arrFields['close_time']=$_REQUEST['date_from'];
//    $arrFields['status']=$_REQUEST['date_to'];
    
     header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=ComplainList'.time().'.csv');
       // $csvName = "TicketList".date("Y-m-d_H-i",time()).".csv";
     
          $output = fopen('php://output', 'w');
     
        
        fputcsv($output, array('Id','Date', 'Complain Name', 'Complain Dealer', 'Complain Type', 'Station','Department', 'Equipement Type', 'Assets','Assets Extra', 'Priority','Received Time','Reach Time','Close Time','Status','Remark','Logged By','Closed By'));
        
        $where = "";
        $whereParam = array();
        if(isset($_REQUEST['name']) && trim($_REQUEST['name'])!="")
        {
                $where .= " where r.name like '".$_REQUEST['name']."'";
           
        }
        if (isset($_REQUEST['date_from']) && trim($_REQUEST['date_from']) != "") 
        {
            if(empty($where))
            {
                if($_REQUEST['date_from']!="") 
                    $wherecomplain.=" where r.recived_time > '".$_REQUEST['date_from'] . "'";
            }
            else
            {
                if($_REQUEST['date_from']!="")
                $wherecomplain.=" and r.recived_time > '".$_REQUEST['date_from'] . "' ";
            }
        }
        if (isset($_REQUEST['date_to']) && trim($_REQUEST['date_to']) != "") 
        {
            if(empty($where) && empty($wherecomplain))
            {
                if($_REQUEST['date_to']!="") 
                    $wherecomplain.=" where r.recived_time < '".$_REQUEST['date_to'] . "' ";
            }
            else
            {
                if($_REQUEST['date_to']!="")
                $wherecomplain.=" and r.recived_time < '".$_REQUEST['date_to'] . "' ";
            }
        }
        if (isset($_REQUEST['complain_type']) && trim($_REQUEST['complain_type']) != "") 
        {
            if(empty($where) && empty($wherecomplain))
            {
                if($_REQUEST['complain_type']!="") 
                    $wherecomplain.=" where r.complain_type = '".$_REQUEST['complain_type'] . "' ";
            }
            else
            {
                if($_REQUEST['complain_type']!="")
                $wherecomplain.=" and r.complain_type = '".$_REQUEST['complain_type'] . "' ";
            }
        }
        if (isset($_REQUEST['station_name']) && trim($_REQUEST['station_name']) != "") 
        {
            if(empty($where) && empty($wherecomplain))
            {
                if($_REQUEST['station_name']!="") 
                    $wherecomplain.=" where r.station_id = '".$_REQUEST['station_name'] . "' ";
            }
            else
            {
                if($_REQUEST['station_name']!="")
                $wherecomplain.=" and r.station_id = '".$_REQUEST['station_name'] . "' ";
            }
        }
        if (isset($_REQUEST['department_name']) && trim($_REQUEST['department_name']) != "") 
        { 
            if(empty($where) && empty($wherecomplain))
            { 
                if($_REQUEST['department_name']!="") 
                    $wherecomplain.=" where r.department = '".$_REQUEST['department_name'] . "' ";
            }
            else
            {
                if($_REQUEST['department_name']!="")
                $wherecomplain.=" and r.department = '".$_REQUEST['department_name'] . "' ";
            }
        }
        
        $where.=$wherecomplain;
        
        $sql="select r.*,r.id as comid,s.id,s.name as stationname,e.id,e.name as euiname,a.id,a.name as assetname,u.id,u.name as updatedBy,d.id,d.name as departmentname,p.id,p.name as 
complaintype from dtm_complain as r inner join dtm_station as s on s.id=r.station_id inner join dtm_equipment as e on e.id=r.station_id inner join dtm_asset as a on a.id=r.assets_id inner join ".CFG::$tblPrefix . "department as d on d.id=r.department inner join dtm_user as u on u.id=r.updated_by inner join dtm_problem as p on p.id=r.complain_type  $where  order by r.id desc";
        $result=DB::query($sql);
        if(count($result) > 0)
       {//print_r($result);exit;
           foreach($result as $key=>$value)
           {
               //fputcsv($output, array('Id','Date', 'Complain Name', 'Complain Dealer', 'Complain Type', 'Station', 'Equipement Type', 'Assets','Assets Extra', 'Priority','Received Time','Reach Time','Close Time','Status','Remark','Logged By','Closed By'));
               fputcsv($output, array($value['id'],$value['created_date'],$value['name'], $value['company_dealer'], $value['complaintype'], $value['stationname'],$value['departmentname'], $value['euiname'],$value['assetname'], $value['asset_extra'], CFG::$priorityArray[$value['complain_priority']],$value['recived_time'],$value['reach_time'],$value['close_time'],($value['status']==0)?"Open":"Close",$value['remark'],$value['updatedBy'],$value['close_by']));
           }
       }
        fclose($output);
        
        
    exit;
}
//to fetch list of region at user add/edit time added by sagar jogi dt 02/06/2017 end
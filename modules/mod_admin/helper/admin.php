<?php

//restrict direct access to the page
defined('DMCCMS') or die('Unauthorized access');

class AdminHelper {

    /**
     * constructor of class admin. do initialisation
     *
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    function __construct() {
        
    }

    function getAllValues() {

        if ($_REQUEST['selFromMonth'] != "" && $_REQUEST['selToMonth'] != '') {
            $date = "";
            //$numberDaysFrom = cal_days_in_month(CAL_GREGORIAN, $_REQUEST['selFromMonth'], $_REQUEST['selFromYear']);
            $numberDaysTo = cal_days_in_month(CAL_GREGORIAN, $_REQUEST['selToMonth'], $_REQUEST['selToYear']);
            $fromDateAnalytic = $_REQUEST['selFromYear'] . '-' . $_REQUEST['selFromMonth'] . '-1';
            $toDateAnalytic = $_REQUEST['selToYear'] . '-' . $_REQUEST['selToMonth'] . '-' . $numberDaysTo;
        } else {
            $fromdate = strtotime(date('y-m-01') . '-1 year');
            $fromDateAnalytic = date('Y-m-d', $fromdate);
            $toDateAnalytic = date('Y-m-t');
        }
        // if(isset($_REQUEST['fromdate'])==true && isset($_REQUEST['todate'])==true){
        if ($fromDateAnalytic != $toDateAnalytic && $fromDateAnalytic != "" && $toDateAnalytic != "") {
            $date = " date(start_date) between '" . date("Y-m-d", strtotime($fromDateAnalytic)) . "' and '" . date("Y-m-d", strtotime($toDateAnalytic)) . "'";
        } else if ($fromDateAnalytic == $toDateAnalytic && $toDateAnalytic != "") {
            $date = " start_date like '" . date("Y-m-d", strtotime($fromDateAnalytic)) . "%'";
        } else if (isset($fromDateAnalytic) == true && $fromDateAnalytic != "") {
            $date = " start_date >= '" . date("Y-m-d", strtotime($fromDateAnalytic)) . "'";
        } else if (isset($toDateAnalytic) == true && $toDateAnalytic != "") {
            $date = " date(start_date) <= '" . date("Y-m-d", strtotime($toDateAnalytic)) . "'";
        }
        if ($date != '') {
            $date = " where " . $date;
        }

        //  echo "Select *  from ".CFG::$tblPrefix."analytics_feed ".$date." order by  start_date desc limit 0,4";
        $totFeed = DB::query("Select *  from " . CFG::$tblPrefix . "analytics_feed " . $date . " order by  start_date desc ");

        //echo "<pre>";print_r($totFeed);
        $totFeed = array_reverse($totFeed);
        //echo "<pre>";
        // print_r($totFeed);
        //exit;

        $summa = "";
        for ($i = 0; $i < count($totFeed); $i++) {
            $v = $totFeed[$i];
            $month_data = date('m', strtotime($v['start_date']));
            // $month=date('m', strtotime($v['start_date']));
            $month = strtotime($v['start_date']);
            $year = date('Y', strtotime($v['start_date']));

            //  if($i==0)
            $summa = $v['top_organic_traffic'] . "@@@" . $v['top_keywords_organic'] . "@@@" . $v['top_keywords_ppc'] . "@@@" . $v['top_entry_page'];
//                            /$month_data."_".$year
            $total_traffic[(int) $month_data . "_" . $year] = array((int) $month, (int) $v['total_traffic']);
            $new_traffic[(int) $month_data . "_" . $year] = array((int) $month, (int) $v['new_traffic']);
            $return_traffic[(int) $month_data . "_" . $year] = array((int) $month, (int) $v['returning_traffic']);

            $ref_traffic[(int) $month_data . "_" . $year] = array((int) $month, (int) $v['total_referral_traffic']);
            $dir_traffic[(int) $month_data . "_" . $year] = array((int) $month, (int) $v['direct_traffic']);

            $aus_traffic[(int) $month_data . "_" . $year] = array((int) $month, (int) $v['australia_traffic']);
            $uni_visitor[(int) $month_data . "_" . $year] = array((int) $month, (int) $v['unique_visitors']);

            $ser_engine[(int) $month_data . "_" . $year] = array((int) $month, (int) $v['search_engine']);
            $organic[(int) $month_data . "_" . $year] = array((int) $month, (int) $v['organic']);
            $ppc[(int) $month_data . "_" . $year] = array((int) $month, (int) $v['ppc']);
            $page_views[(int) $month_data . "_" . $year] = array((int) $month, (int) $v['total_page_views']);
        }
        $tot_trafic = $oth_trafic = $oth_data = array();
        //echo "<pre>";
        //print_r($total_traffic);
        if (count($totFeed) > 0) {
            $tot_trafic[] = array("label" => "Total Traffic", "data" => $total_traffic, "lines" => array("fillColor" => "#f2f7f9"), "points" => array("fillColor" => "#88bbc8"));
            $tot_trafic[] = array("label" => "New Traffic", "data" => $new_traffic, "lines" => array("fillColor" => "#fff8f2"), "points" => array("fillColor" => "#ed7a53"));
            $tot_trafic[] = array("label" => "Return Traffic", "data" => $return_traffic, "lines" => array("fillColor" => "#fff8f2"), "points" => array("fillColor" => "#ed7a53"));
            $tot_trafic[] = array("label" => "Referral Traffic", "data" => $ref_traffic, "lines" => array("fillColor" => "#f2f7f9"), "points" => array("fillColor" => "#88bbc8"));
            $tot_trafic[] = array("label" => "Direct Traffic", "data" => $dir_traffic, "lines" => array("fillColor" => "#fff8f2"), "points" => array("fillColor" => "#ed7a53"));

            $oth_trafic[] = array("label" => "Australia traffic", "data" => $aus_traffic, "lines" => array("fillColor" => "#fff8f2"), "points" => array("fillColor" => "#ed7a53"));
            $oth_trafic[] = array("label" => "Unique Visitors", "data" => $uni_visitor, "lines" => array("fillColor" => "#fff8f2"), "points" => array("fillColor" => "#ed7a53"));
            $oth_trafic[] = array("label" => "Number of page views", "data" => $page_views, "lines" => array("fillColor" => "#fff8f2"), "points" => array("fillColor" => "#ed7a53"));

            $oth_data[] = array("label" => "Search Engine", "data" => $ser_engine, "lines" => array("fillColor" => "#f2f7f9"), "points" => array("fillColor" => "#88bbc8"));
            $oth_data[] = array("label" => "Organic", "data" => $organic, "lines" => array("fillColor" => "#fff8f2"), "points" => array("fillColor" => "#ed7a53"));
            $oth_data[] = array("label" => "PPC", "data" => $ppc, "lines" => array("fillColor" => "#fff8f2"), "points" => array("fillColor" => "#ed7a53"));
        }


        $record['final_graph']['main_trafic'] = $tot_trafic;
        $record['final_graph']['other_trafic'] = $oth_trafic;
        $record['final_graph']['other_data'] = $oth_data;
        $record['final_graph']['summary'] = $summa;

        //echo "<pre>";print_r($record);exit;
        if ($_REQUEST['selFromMonth'] != "" && $_REQUEST['selToMonth'] != '') {
            echo json_encode($record);
            exit;
        } else {
            return $record;
        }
    }

    function getGoogleAnalyticSummary() {
        if (isset($_REQUEST['selMonthSummary']) != '') {
            $numberDaysTo = cal_days_in_month(CAL_GREGORIAN, $_REQUEST['selMonthSummary'], $_REQUEST['selYearSummary']);
            $fromDateSummary = $_REQUEST['selYearSummary'] . '-' . $_REQUEST['selMonthSummary'] . '-1';
            $toDateSummary = $_REQUEST['selYearSummary'] . '-' . $_REQUEST['selMonthSummary'] . '-' . $numberDaysTo;
            $date = "where  date(start_date) between '" . date("Y-m-d", strtotime($fromDateSummary)) . "' and '" . date("Y-m-d", strtotime($toDateSummary)) . "'";
            $totFeed = DB::query("Select *  from " . CFG::$tblPrefix . "analytics_feed " . $date . " order by  start_date desc ");
            $summa = $totFeed[0]['top_organic_traffic'] . "@@@" . $totFeed[0]['top_keywords_organic'] . "@@@" . $totFeed[0]['top_keywords_ppc'] . "@@@" . $totFeed[0]['top_entry_page'];
            echo json_encode($summa);
            exit;
        }
    }

    /**
     * Get all page status
     *
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    function getPageStatus() {
        $pageData = DB::query("Select IF(status = '1', 'Active','Inactive') as status,count(id) as cnt  from " . CFG::$tblPrefix . "page where status <>'' and is_deleted='0'  group by status order by status asc");
        return $pageData;
    }

    function getCouponStatus() {
        $testimonialData = DB::query("Select IF(status = '1', 'Active','Inactive') as status,count(id) as cnt from " . CFG::$tblPrefix . "coupon where status <>''  group by status order by status asc");
        return $testimonialData;
    }

    function getSectionStatus() {
        $testimonialData = DB::query("Select IF(status = '1', 'Active','Inactive') as status,count(id) as cnt from " . CFG::$tblPrefix . "section where status <>''  group by status order by status asc");
        return $testimonialData;
    }

    function getHeadingStatus() {
        $newsData = DB::query("Select IF(status = '1', 'Active','Inactive') as status,count(id) as cnt  from " . CFG::$tblPrefix . "heading where status <>''  group by status order by status asc");
        return $newsData;
    }

    function getAreaStatus() {
        $newsData = DB::query("Select IF(status = '1', 'Active','Inactive') as status,count(id) as cnt  from " . CFG::$tblPrefix . "area where status <>''  group by status order by status asc");
        return $newsData;
    }

    function getSuburbStatus() {
        $newsData = DB::query("Select IF(status = '1', 'Active','Inactive') as status,count(id) as cnt  from " . CFG::$tblPrefix . "suburb where status <>''  group by status order by status asc");
        return $newsData;
    }

    function displayStatus($data, $moduleClass) {
        $active = "icomoon-icon-checkmark greenColor";
        $inactive = "icomoon-icon-cancel redColor";

        if (is_array($data) && count($data) != 0) {
            if (count($data) == 1) {
                // Check both active and inactive record is exists or not
                if ($data[0]['status'] == "Active") {
                    // create inactive record with value zero
                    $data[1]['status'] = "Inactive";
                    $data[1]['cnt'] = 0;
                } else if ($data[0]['status'] == "Inactive") { // create active record with value zero
                    // store inactive record count in temp variable
                    $varCnt = $data[0]['cnt'];

                    // create active record at 0 position to maintain order
                    $data[0]['status'] = "Active";
                    $data[0]['cnt'] = 0;

                    // create inactive record at 1 position to maintain order
                    $data[1]['status'] = "Inactive";
                    $data[1]['cnt'] = $varCnt;
                }
            }
            echo '<ul>';
            $total = 0;
            foreach ($data as $val) {
                $total+=$val['cnt'];

                echo '<li class="clearfix">
						  <div class="icon"> <span class="' . (($val['status'] == "Active") ? $active : $inactive) . '"></span> </div>
						  <span class="txt txtformat">' . $val['status'] . '</span><span class="number">' . $val['cnt'] . '
						  </span> </li>';
            }
            echo '<li class="clearfix">
					  <div class="icon"> <span class="' . $moduleClass . '"></span> </div>
					  <span class="txt txtformat">
					   Total
					  </span><span class="number">' . $total . '
					  </span> </li>
					 </ul>';
        }
        else
            echo 'No records avliable';
    }

    /**
     * Return total enqury count of last 7 days from ticket tables.
     *
     * @author Mayur Patel <mayur.datatech@gmail.com>
     */
    function gettTicketData() {
        if (isset($_GET['status'])) {
            $typeCond = "";

            if ($_GET['status'] != "All Ticket")
                //$typeCond = " and ticket_status='".$_GET['status']."'";
                $typeCond = " and ticket_status='" . strtolower(str_replace(" ", "", $_GET['status'])) . "'";
            // DB::debugMode();
            //$data = DB::query('select sum(ticket_status) as cntTicket, date( created_date ) AS reqDate,( DATE_SUB(DATE(NOW()),INTERVAL ' . (CFG::$graphDays - 1) . ' DAY) ) as startDate from ' . CFG::$tblPrefix . ' where enquiry_date > ( DATE_SUB(DATE(NOW()),INTERVAL ' . (CFG::$graphDays + 60) . ' DAY) ) ' . $typeCond . ' GROUP BY enqDate');

            $query='select count(t.ticket_status) as cntTicket, date( t.created_date ) AS enqDate,( DATE_SUB(DATE(NOW()),INTERVAL ' . (CFG::$graphDays - 1) . ' DAY) ) as startDate from ' . CFG::$tblPrefix . 'ticket as t INNER JOIN ' . CFG::$tblPrefix . 'user AS u ON u.id = t.user_id LEFT JOIN ' . CFG::$tblPrefix . 'region AS r ON r.id = t.region_id LEFT JOIN ' . CFG::$tblPrefix . 'helpdesk AS h ON h.id = t.helpdesk_id where t.created_date > ( DATE_SUB(DATE(NOW()),INTERVAL ' . (CFG::$graphDays + 60) . ' DAY) ) ' ;
           
            if(isset($_SESSION['user_login']) && $_SESSION['user_login']["id"]>0 && $_SESSION['user_login']["roll_id"]==6)
            {
                 $query .= " and t.engineer_id = %d_id ";
                 $whereParam["id"] = $_SESSION['user_login']["id"];
            }
             
            if(isset($_SESSION['user_login']) && $_SESSION['user_login']["id"]>0 && $_SESSION['user_login']["roll_id"]==5)
            {
               
                $helpdesk=$this->getValue("user","helpdesk_id","id",$_SESSION['user_login']["id"]);
                
                if(!empty($helpdesk['helpdesk_id']))
                {

                    $parent_region=$this->getValue("helpdesk","parent_region","id",$helpdesk['helpdesk_id']);

                }
                $query .= " and t.helpdesk_id in ('".$helpdesk['helpdesk_id']."')";
               
                if(!empty($parent_region['parent_region']))
                {
                    $region_query="select * from ".CFG::$tblPrefix . "region where id in (".$parent_region['parent_region'].") and parent_region='0'";
                    $region_result=DB::query($region_query);
                    if(count($region_result))
                    {
                      $region_array=array();
                      foreach($region_result as $key=>$value)
                      {
                          $sub_region=DB::query("select id from ".CFG::$tblPrefix . "region where parent_region ='".$value['id']."' and parent_region!='0'");
                            if(count($sub_region))
                            {
                              foreach($sub_region as $skey=>$svalue)
                              {
                                  array_push($region_array,$svalue['id']);
                              }
                            }

                      }
                      $arr_string=array_unique($region_array);
                      $region_sting=implode(",".$arr_string);
                      if(!empty($region_string))
                      {
                          $query .= " or t.region_id in (".$region_string.")) ";
                      }

                    }

                }
               


            }
            if(isset($_SESSION['user_login']) && $_SESSION['user_login']["id"]>0 && $_SESSION['user_login']["roll_id"]==7)
            {
                
                 $query .= " and t.user_id = %d_id ";
                 $whereParam["id"] = $_SESSION['user_login']["id"];
                 
            }
//            DB::debugMode(true);
            $query.= $typeCond . ' GROUP BY enqDate';
           
            $data=DB::query($query,$whereParam);
            echo json_encode($data);
            exit;
        }
    }

    /**
     *  Defination      :   Get All Ticket Based On Ticket Current Status
     *
     *  @author         :   Mayur Patel <mayur.datatech@gmail.com>
     * 
     *  created date    :   10-03-2017  12:10 PM
     */
    function getAllTicketDataByStatus() {
        if (isset($_GET['piechart'])) {
            $typeCond = "";

            //if($_GET['type'] != "All")
            //	$typeCond = " and enquiry_from='".strtolower(str_replace(" ","_",$_GET['type']))."'";
            // print_r($_REQUEST);
            // DB::debugMode();
            $date = "";
            // if(isset($_REQUEST['fromdate'])==true && isset($_REQUEST['todate'])==true){
            if ($_REQUEST['fromdate'] != $_REQUEST['todate'] && $_REQUEST['fromdate'] != "" && $_REQUEST['todate'] != "") {
                $date = " date(created_date) between '" . date("Y-m-d", strtotime($_REQUEST['fromdate'])) . "' and '" . date("Y-m-d", strtotime($_REQUEST['todate'])) . "'";
            } else if ($_REQUEST['fromdate'] == $_REQUEST['todate'] && $_REQUEST['todate'] != "") {
                $date = " created_date like '" . date("Y-m-d", strtotime($_REQUEST['fromdate'])) . "%'";
            } else if (isset($_REQUEST['fromdate']) == true && $_REQUEST['fromdate'] != "") {
                $date = " created_date >= '" . date("Y-m-d", strtotime($_REQUEST['fromdate'])) . "'";
            } else if (isset($_GET['todate']) == true && $_REQUEST['todate'] != "") {
                $date = " date(created_date) <= '" . date("Y-m-d", strtotime($_REQUEST['todate'])) . "'";
            }
            //}
            $data = DB::query('select count(ticket_status) as cntTicket, date( created_date ) AS enqDate,( DATE_SUB(DATE(NOW()),INTERVAL ' . (CFG::$graphDays - 1) . ' DAY) ) as startDate from ' . CFG::$tblPrefix . 'ticket where ' . $date . ' GROUP BY enqDate');
            
            
            // DB::debugMode(true);

            echo json_encode($data);
            exit;
        }
    }

    
    /*
     * Defination   :   Get All Unread ticket data tables.
     * 
     * @author      :   Mayur Patel <mayur.datatech@gmail.com>
     * 
     * Created Date :   10-03-2017 2:00 PM
     * 
     */
    function getAllUnreadTicketData($unreadArr) {
        
        if (isset($_GET['unreadtype'])) {
            $typeCond = "";
            $whereTicketStatus=$_GET['unreadtype'];
//            print_r($unreadArr);
            $intC = 0;
            foreach ($unreadArr as $unreadArrKey => $unreadArrVal) {
                //if ($_GET['unreadtype'] == $unreadArrVal['type']) {
                if ( in_array($whereTicketStatus, $unreadArrVal['type']) ) {
                    $typeCond = $this->getTicketDataUnread($unreadArrVal['tableName'], $unreadArrVal['fields'],$whereTicketStatus);
                    break;
                } else {
                    if ($intC > 0) {
                        $typeCond.= ' UNION ';
                    }
                    $typeCond .= $this->getTicketDataUnread($unreadArrVal['tableName'], $unreadArrVal['fields'],$whereTicketStatus);
                    //print_r($typeCond);exit;
                }
                $intC++;
            }

            //DB::debugMode(true);
            
            $data = DB::query($typeCond);
            //DB::debugMode(true);

            echo json_encode($data);
            exit;
        }
    }

    /*
     * Defination   :   Get All Unread Ticket Data Based On Selected Status
     * 
     * @author      :   Mayur Patel <mayur.datatech@gmail.com>
     * 
     * Created Date :   10-03-2017 3:00 PM
     * 
     */
    function getTicketDataUnread($tableName, $fields,$whereTicketStatus) {
        
        //$where=" where t.is_read = '0' "; // Working When Read / Unread Wise Filtering
        $where="";
        
          
        //$functionCond = "(select $fields from " . $tableName . " as t inner join ".CFG::$tblPrefix . "user as u on u.id=t.engineer_id left join ".CFG::$tblPrefix ."region as r on r.id=t.region_id left join ".CFG::$tblPrefix ."helpdesk as h on h.id=t.helpdesk_id  " . $where . " limit 0,20)";
        $functionCond = "(select $fields from " . $tableName . " as t inner join ".CFG::$tblPrefix . "user as u on u.id=t.user_id left join ".CFG::$tblPrefix ."region as r on r.id=t.region_id left join ".CFG::$tblPrefix ."helpdesk as h on h.id=t.helpdesk_id ";
        $flag = true;
        if(isset($_SESSION['user_login']) && $_SESSION['user_login']["id"]>0 && $_SESSION['user_login']["roll_id"]==6)
        {
            $where.=" where ";
            if ($flag == false) {
                $where.=" and ";
            }
             $where .= " t.engineer_id =".$_SESSION['user_login']["id"];
             
             $flag = false;
        }
        if(isset($_SESSION['user_login']) && $_SESSION['user_login']["id"]>0 && $_SESSION['user_login']["roll_id"]==5)
        {
            $where.=" where ";
            if ($flag == false) {
                $where.=" and ";
            }
            $helpdesk=$this->getValue("user","helpdesk_id","id",$_SESSION['user_login']["id"]);
            
            if(!empty($helpdesk['helpdesk_id']))
            {
                
                $parent_region=$this->getValue("helpdesk","parent_region","id",$helpdesk['helpdesk_id']);
                
            }
            $where .= " t.helpdesk_id in ('".$helpdesk['helpdesk_id']."')";
           
            if(!empty($parent_region['parent_region']))
            {
                $region_query="select * from ".CFG::$tblPrefix . "region where id in (".$parent_region['parent_region'].") and parent_region='0'";
                $region_result=DB::query($region_query);
                if(count($region_result))
                {
                  $region_array=array();
                  foreach($region_result as $key=>$value)
                  {
                      $sub_region=DB::query("select id from ".CFG::$tblPrefix . "region where parent_region ='".$value['id']."' and parent_region!='0'");
                        if(count($sub_region))
                        {
                          foreach($sub_region as $skey=>$svalue)
                          {
                              array_push($region_array,$svalue['id']);
                          }
                        }

                  }
                  $arr_string=array_unique($region_array);
                  $region_sting=implode(",".$arr_string);
                  if(!empty($region_string))
                  {
                      $where .= " or t.region_id in (".$region_string.")) ";
                  }

                }
                
            }
            $flag = false;
            
            
        }
        if(isset($_SESSION['user_login']) && $_SESSION['user_login']["id"]>0 && $_SESSION['user_login']["roll_id"]==7)
        {
            $where.=" where ";
            if ($flag == false) {
                $where.=" and ";
            }
             $where .= " t.user_id =".$_SESSION['user_login']["id"];
             
             $flag = false;
        }
        if(!empty($where))
        {
            $functionCond.=$where;
        
           if(!empty($whereTicketStatus) && $whereTicketStatus !="All")
            {
                //$where.=" and t.ticket_status='".$whereTicketStatus."'"; // Working When Read / Unread Wise Filtering
                $where_query.=" AND t.ticket_status='".$whereTicketStatus."'";
            }
        }
        else
        {
            if(!empty($whereTicketStatus) && $whereTicketStatus !="All")
            {
                //$where.=" and t.ticket_status='".$whereTicketStatus."'"; // Working When Read / Unread Wise Filtering
                $where_query.=" where t.ticket_status='".$whereTicketStatus."'";
            }
        }
        $functionCond.= $where_query . " order by t.created_date desc limit 0,20)";
        return $functionCond;
    }

    /*
     * Defination   :   Get All Recentlly Added Ticket
     * 
     * @author      :   Mayur Patel <mayur.datatech@gmail.com>
     * 
     * Created Date :   10-03-2017 3:00 PM
     * 
     */
    function getTicketDataRecent($tableName, $fields,$whereTicket) {
        
        $where="";
        
        
        
        //$functionCond = "(select $fields from " . $tableName . " as t inner join ".CFG::$tblPrefix . "user as u on u.id=t.engineer_id left join ".CFG::$tblPrefix ."region as r on r.id=t.region_id left join ".CFG::$tblPrefix ."helpdesk as h on h.id=t.helpdesk_id " . $where . " order by t.created_date desc limit 0,20)";
        
        $functionCond = "(select $fields from " . $tableName . " as t inner join ".CFG::$tblPrefix . "user as u on u.id=t.user_id left join ".CFG::$tblPrefix ."region as r on r.id=t.region_id left join ".CFG::$tblPrefix ."helpdesk as h on h.id=t.helpdesk_id ";
        $flag = true;
        if(isset($_SESSION['user_login']) && $_SESSION['user_login']["id"]>0 && $_SESSION['user_login']["roll_id"]==6)
        {
            $where.=" where ";
            if ($flag == false) {
                $where.=" and ";
            }
             $where .= " t.engineer_id =".$_SESSION['user_login']["id"];
             
             $flag = false;
        }
        if(isset($_SESSION['user_login']) && $_SESSION['user_login']["id"]>0 && $_SESSION['user_login']["roll_id"]==5)
        {
            $where.=" where ";
            if ($flag == false) {
                $where.=" and ";
            }
            $helpdesk=$this->getValue("user","helpdesk_id","id",$_SESSION['user_login']["id"]);
            
            if(!empty($helpdesk['helpdesk_id']))
            {
                
                $parent_region=$this->getValue("helpdesk","parent_region","id",$helpdesk['helpdesk_id']);
                
            }
            $where .= " t.helpdesk_id in ('".$helpdesk['helpdesk_id']."')";
           
            if(!empty($parent_region['parent_region']))
            {
                $region_query="select * from ".CFG::$tblPrefix . "region where id in (".$parent_region['parent_region'].") and parent_region='0'";
                $region_result=DB::query($region_query);
                if(count($region_result))
                {
                  $region_array=array();
                  foreach($region_result as $key=>$value)
                  {
                      $sub_region=DB::query("select id from ".CFG::$tblPrefix . "region where parent_region ='".$value['id']."' and parent_region!='0'");
                        if(count($sub_region))
                        {
                          foreach($sub_region as $skey=>$svalue)
                          {
                              array_push($region_array,$svalue['id']);
                          }
                        }

                  }
                  $arr_string=array_unique($region_array);
                  $region_sting=implode(",".$arr_string);
                  if(!empty($region_string))
                  {
                      $where .= " or t.region_id in (".$region_string.")) ";
                  }

                }
                
            }
            $flag = false;
            
            
        }
        if(isset($_SESSION['user_login']) && $_SESSION['user_login']["id"]>0 && $_SESSION['user_login']["roll_id"]==7)
        {
            $where.=" where ";
            if ($flag == false) {
                $where.=" and ";
            }
             $where .= " t.user_id =".$_SESSION['user_login']["id"];
             
             $flag = false;
        }
        if(!empty($where))
        {
            $functionCond.=$where;
        
            if(!empty($whereTicket) && $whereTicket !="All")
            {
                $where_query.=" and t.ticket_status='".$whereTicket."'";
            }
        }
        else
        {
            if(!empty($whereTicket) && $whereTicket !="All")
            {
                $where_query.=" where t.ticket_status='".$whereTicket."'";
            }
        }
        $functionCond.= $where_query . " order by t.created_date desc limit 0,20)";
        return $functionCond;
    }
    
    
    
    function getMostPopularEnquiryData($unreadArr) {
        if (isset($_GET['mostpopular'])) {
            $typeCond = "";
            //print_r($unreadArr);
            $typeCond = "select count(*) as cntRec,pe.id as peid,pe.title,pe.first_name,pe.last_name,pe.status,pe.enquiry_date,pe.pid,p.name,p.id from " . CFG::$tblPrefix . "product_enquiry as pe," . CFG::$tblPrefix . "products as p where p.id=pe.pid group by pid order by cntRec DESC";

            //DB::debugMode(true);
            $data = DB::query($typeCond);
            //DB::debugMode(true);

            echo json_encode($data);
            exit;
        }
    }

    
    /*
     * Defination   :   Get All Recentlly Added Ticket
     * 
     * @author      :   Mayur Patel <mayur.datatech@gmail.com>
     * 
     * Created Date :   10-03-2017 3:00 PM
     * 
     */
    function getAllRecentTicketData($recentArr) {

        if (isset($_GET['recentTicket'])) {

            $typeCond = "";
            $whereTicket=$_GET['recentTicket'];
            $intC = 0;
            foreach ($recentArr as $recentArrKey => $recentArrVal) {
                //if ($_GET['recenttype'] == $recentArrVal['type']) {
                //if ($_GET['recenttype'] == $recentArrVal['type']) {
                if ( in_array($whereTicket, $unreadArrVal['type']) ) {
                    $typeCond = $this->getTicketDataRecent($recentArrVal['tableName'], $recentArrVal['fields'],$whereTicket);

                    break;
                } else {
                    if ($intC > 0) {
                        $typeCond.= ' UNION ';
                    }
                    $typeCond .= $this->getTicketDataRecent($recentArrVal['tableName'], $recentArrVal['fields'],$whereTicket);
                }
                $intC++;
            }
            
            //DB::debugMode(true);
            
            $data = DB::query($typeCond);

            //DB::debugMode(true);

            echo json_encode($data);
            exit;
        }
    }

    /*
     * get ticket status from log table 
     * Mayur Patel <mayur.datatech@gmail.com>
     */

    function getTicketStatus() {
        $data = DB::query('select count(ticket_status) as cntTicket, date( created_date ) AS enqDate,( DATE_SUB(DATE(NOW()),INTERVAL ' . (CFG::$graphDays - 1) . ' DAY) ) as startDate from ' . CFG::$tblPrefix . 'ticket  GROUP BY enqDate');
        return $data;
    }

    function getCityList($state) {
        $data = DB::query('select city from ' . CFG::$tblPrefix . 'zones where state = %s order by city asc', $state);
        echo json_encode($data);
        exit;
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
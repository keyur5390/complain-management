<?php 
/* Category model class. Contains all attributes and method related to category. */
//restrict direct access to the testimonial 
defined( 'DMCCMS' ) or die( 'Unauthorized access' );

Class TicketModel
{
    /**Store field for category record
    * @var fields array
    *
    */

    public $records=array();

    public $count=0;
    function __construct()
    {
        
    }

    /**
    * get ticket records
    *
    * @author Bhavin Lunagariya <bhavin.datatech@gmail.com>
    */
    function getTicketList()
    {
       
        if (isset($_GET['o_type']))
            $orderBy = $_GET['o_field'] . " " . $_GET['o_type'];
        $where = "";
        $whereParam = array();
        $flag = true;
        
        if(isset($_GET['searchForm']['customer_name']) && trim($_GET['searchForm']['customer_name'])!="")
        {
                $where .= "  (u.name like %ss_sortOrder or u.email like %ss_sortOrder or t.id  like %ss_sortOrder or  t.subject like %ss_sortOrder) ";
                $whereParam["sortOrder"] = Stringd::processString($_GET['searchForm']['customer_name']);
                $flag = false;
        }
        if(isset($_GET['searchForm']['ticket_subject']) && trim($_GET['searchForm']['ticket_subject'])!="")
        {
                $where .= "  (t.subject like %ss_sortOrder or t.id like %ss_sortOrder)";
                $whereParam["sortOrder"] = Stringd::processString($_GET['searchForm']['ticket_subject']);
                $flag = false;
        }
        $date = "";
        if (isset($_GET['searchForm']['dateFrom']) == true && isset($_GET['searchForm']['dateTo']) == true) {
            if ($_GET['searchForm']['dateFrom'] != $_GET['searchForm']['dateTo'] && $_GET['searchForm']['dateFrom'] != "" && $_GET['searchForm']['dateTo'] != "") {
                $date = " date(t.created_date) between '" . date("Y-m-d", strtotime($_GET['searchForm']['dateFrom'])) . "' and '" . date("Y-m-d", strtotime($_GET['searchForm']['dateTo'])) . "'";
            } else if ($_GET['searchForm']['dateFrom'] == $_GET['searchForm']['dateTo'] && $_GET['searchForm']['dateTo'] != "") {
                $date = " t.created_date like '" . date("Y-m-d", strtotime($_GET['searchForm']['dateFrom'])) . "%'";
            } else if (isset($_GET['searchForm']['dateFrom']) == true && $_GET['searchForm']['dateFrom'] != "") {
                $date = " t.created_date >= '" . date("Y-m-d", strtotime($_GET['searchForm']['dateFrom'])) . "'";
            } else if (isset($_GET['searchForm']['dateTo']) == true && $_GET['searchForm']['dateTo'] != "") {
                $date = " date(t.created_date) <= '" . date("Y-m-d", strtotime($_GET['searchForm']['dateTo'])) . "'";
            }
           
        }

        if ($date != "") {
            if ($where == "") {
                $where.=$date;
            } else {
                $where.=" and " . $date;
            }
             $flag = false;
        }
        if(isset($_SESSION['user_login']) && $_SESSION['user_login']["id"]>0 && $_SESSION['user_login']["roll_id"]==6)
        {
            if ($flag == false) {
                $where.=" and ";
            }
             $where .= " t.engineer_id = %d_id ";
             $whereParam["id"] = $_SESSION['user_login']["id"];
             $flag = false;
        }
        if(isset($_SESSION['user_login']) && $_SESSION['user_login']["id"]>0 && $_SESSION['user_login']["roll_id"]==5)
        {
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
            if ($flag == false) {
                $where.=" and ";
            }
             $where .= " t.user_id = %d_id ";
             $whereParam["id"] = $_SESSION['user_login']["id"];
             $flag = false;
        }
        if (isset($_GET['searchForm']['region']) && $_GET['searchForm']['region'] > 0)
        {
            if ($flag == false) {
                $where.=" and ";
            }
            $where .= "  t.region_id =".$_GET['searchForm']['region'];
            $flag = false;
                    
        }
        if (isset($_GET['searchForm']['helpdesk']) && $_GET['searchForm']['helpdesk'] > 0)
        {
            if ($flag == false) {
                $where.=" and ";
            }
            $where .= "  t.helpdesk_id =".$_GET['searchForm']['helpdesk'];
            $flag = false;
        }
        
        if (isset($_GET['searchForm']['status']) && $_GET['searchForm']['status'] !='')
        {
            
            if ($flag == false) {
                $where.=" and ";
            }
            if($_GET['searchForm']['status']=='unassignedEng'){
                 $where .= "  (t.engineer_id='0' or t.engineer_id='') ";
            } else {
            $where .= "  t.ticket_status ='".$_GET['searchForm']['status']."'";
             }
            $flag = false;
        }
        if(empty($orderBy))
        {
            $orderBy = " FIELD(t.ticket_status,'open','inprogress','hold','closed','closedwithoutreport'),t.created_date desc,t.id desc";
        }
       
        UTIL::doPaging("totalPages", "t.id,t.subject,t.status,t.sort_order,u.name,h.name as helpdesk_name,r.name as region_name,t.ticket_status,t.created_date", CFG::$tblPrefix . "ticket as t inner join ".CFG::$tblPrefix . "user as u on u.id=t.user_id left join ".CFG::$tblPrefix ."region as r on r.id=t.region_id left join ".CFG::$tblPrefix ."helpdesk as h on h.id=t.helpdesk_id", $where, $whereParam, $orderBy);
        //exit;
        
    }
   /**
    * LIst of Problems
    * 
    * @author Sagar Jogi<sagarjogi.datatech@gmail.com>
    */
    function getProblemData(){
         return DB::query("SELECT id,name FROM " . CFG::$tblPrefix . "problem where is_deleted='0' and status='1' order by id asc");
    }
    
    
    /**
    * save ticket record
    * 
    * @author Bhavin Lunagariya<bhavin.datatech@gmail.com>
    */
   function saveTicket()
   {
       
        Load::loadLibrary("sender.php", "phpmailer");
        
       if($_POST['txtSubject']!='')
       {
         

           $varSubject=(isset($_POST['txtSubject'])) ? $_POST['txtSubject'] : "";
           $varOtherSerialNo=(isset($_POST['other_serial_no'])) ? $_POST['other_serial_no'] : "";
           $varSerialNo=(isset($_POST['serial_no'])) ? $_POST['serial_no'] : "";
           if($varOtherSerialNo != ''){
               $varOtherSerialNo=$_POST['other_serial_no'];
               $varSerialNo='';
           } else {
               $varOtherSerialNo='';
           }
           $varTicketProblem=(isset($_POST['ticket_problem'])) ? $_POST['ticket_problem'] : "";
           $varDescription=(isset($_POST['txaDescription'])) ? $_POST['txaDescription'] : "";
           if(isset($_POST['customer']) && $_POST['customer'] > 0)
           {
               $varCustomer=(isset($_POST['customer'])) ? $_POST['customer'] : "";
           }
           else
           {
              $varCustomer=$_SESSION['user_login']['id'];
           }
           if(isset($_POST['engineer']) && $_POST['engineer'] > 0)
           {
               $varEngineer=(isset($_POST['engineer'])) ? $_POST['engineer'] : "";
           }
           else if(isset($_SESSION['user_login']) && $_SESSION['user_login']['roll_id']==6)
           {
               $varEngineer=$_SESSION['user_login']['id'];
           }
           
          $varRegion=(isset($_POST['parent_region'])) ? $_POST['parent_region'] : "";
          $varTicketStatus=(isset($_POST['ticket_status'])) ? $_POST['ticket_status'] : "open";
         
          if(isset($_POST['ticket_status']) && $_POST['ticket_status']!='')
          {
              $varTicketStatus=$_POST['ticket_status'];
          }
          else
          {
              $varTicketStatus="open";
          }
        
          $varHelpDesk=$this->getValue("region","helpDesk","id",$varRegion);
          $helpdesk=$varHelpDesk['helpDesk'];
            $arrContactData['Ticket No']="";
            if (!empty($varSubject)) 
            { 
                $arrContactData['Ticket Subject'] = trim(ucfirst($varSubject));
            }
            if (!empty($varCustomer)) 
            { 
                $name=$this->getData("user","name,email","id",$varCustomer);
                $varName=$name[0]['name'];
                $varEmail=$name[0]['email'];
                $arrContactData['Name'] = trim(ucfirst($name[0]['name']));
            }
            if (!empty($helpdesk)) {
                $helpdesk_name=$this->getData("helpdesk","name","id",$helpdesk);
                $arrContactData['Help Desk'] = trim(ucfirst($helpdesk_name[0]['name']));

            }
            if (!empty($varRegion)) {
                $region=$this->getData("region","name","id",$varRegion);
                $arrContactData['Region'] = trim(ucfirst($region[0]['name']));

            }
            if (!empty($varEngineer)) {
                $engineer=$this->getData("user","name","id",$varEngineer);
                $arrContactData['Engineer'] = trim(ucfirst($engineer[0]['name']));
            }
            if (!empty($varTicketStatus)) {
              
               $arrContactData['Status']=CFG::$ticketStatusArray[$varTicketStatus];
            }
            if (!empty($varTicketProblem)) 
            { 
//                $arrContactData['Problem Type'] = CFG::$ticketProblemArray[$varTicketProblem];
                $arrContactData['Problem Type'] = $varTicketProblem;//CFG::$ticketProblemArray[$varTicketProblem];
            }
            if (!empty($varSerialNo)) 
            { 
                $arrContactData['Serial No'] = trim($varSerialNo);
            } else {
                $arrContactData['Other Serial No'] = trim($varOtherSerialNo);
            }
            
            $varProductModel = (isset($_POST['product_model'])) ? $_POST['product_model'] : "";
            if (!empty($varProductModel)) {
                $arrContactData['Model No'] = trim(ucfirst(nl2br($varProductModel)));
            }
            
            $varProductName = (isset($_POST['product_name'])) ? $_POST['product_name'] : "";
            if (!empty($varProductName)) {
                $arrContactData['Model Name'] = trim(ucfirst(nl2br($varProductName)));
            }
            
            if (!empty($varDescription)) {
                $arrContactData['Description'] = trim(ucfirst(nl2br($varDescription)));
            }
            
//            pre($arrContactData);exit;
           if(isset($_POST['status']))
               $varStatus = '1';
           else
               $varStatus = '0';
           $sortOrder = "";
           if($_POST['sortOrder']=='')
           {
               $sortOrder=Core::maxId("ticket");
               $_POST['sortOrder']=$sortOrder['maxId']+1;
           }

           // fill gallery data if uploaded
           if(isset($_POST['flImage_hdn']))
           {
               $image_name=$_POST['flImage_hdn'];
           }
           if(isset($_POST['flImage1_hdn']))
           {
               $attach_report=$_POST['flImage1_hdn'];
           }
           $varStatus = '1';
            //create array of fields
           // store updated date
           
           $arrFields=array("subject"=>$varSubject,"user_id"=>$varCustomer,"user_name"=>$varName,"region_id"=>$varRegion,"helpdesk_id"=>$helpdesk,"engineer_id"=>$varEngineer,"status"=>$varStatus,"image_name" => $_POST['flImage_hdn'],"image_title" => $_POST['flImage_title_hdn'][0],"image_alt" => $_POST['flImage_alt_hdn'][0],"ticket_status"=>$varTicketStatus,"problem_type"=>$varTicketProblem,"serial_no"=>$varSerialNo,"other_serial_no"=>$varOtherSerialNo,"product_model"=>$varProductModel,"product_name"=>$varProductName,"sort_order"=>$_POST['sortOrder'],"updated_date"=>date("Y-m-d H:i:s"),"is_read"=>"1");
           if(isset($_POST['ticket_status']) && $_POST['ticket_status']!='' && ($_POST['ticket_status']=='closed' || $_POST['ticket_status']=='closedwithoutreport')) {
              $arrFields['close_date']=date("Y-m-d");
          } else {
              $arrFields['close_date']='';
          }
           $roll_name=$this->getValue("rolls","name","id",$_SESSION['user_login']['roll_id']);
           $subject = "New Ticket for ".$roll_name['name']." to ". ucfirst(CFG::$siteConfig['site_name']);
           $content = Core::loadMailTempleate($subject, $arrContactData);
           if(APP::$curId=="")
           {
               //store cretaed date
               $arrFields['created_date']=date("Y-m-d");
               $arrFields['created_by'] = $_SESSION['user_login']['id'];
               $arrFields['is_read'] = "0";
               $arrFields['description'] = nl2br($varDescription);
               //Insert product
                DB::Insert(CFG::$tblPrefix."ticket",Stringd::processString($arrFields));
               //get current Id
                APP::$curId=DB::insertId(); 
               $arrContactData['Ticket No']=APP::$curId;
               $attachmentArr=NULL;
                if($image_name!='' && file_exists(URI::getAbsMediaPath(CFG::$ticketDir) . "/" .$image_name))
                {
                     $path = CFG::$absPath . "/" . CFG::$mediaDir . '/' . CFG::$ticketDir . '/';

                     $filename = $image_name;

                     // To send multiple attachments.....
                    $attachmentArr = $path . $filename;


                }  
               $subject = "New Ticket for ".trim(ucfirst($name[0]['name']))." from ". ucfirst(CFG::$siteConfig['site_name']);
               $content = Core::loadMailTempleate($subject, $arrContactData);
               
                $copySubject="Copy of New Ticket for ".trim(ucfirst($name[0]['name']))." from ". ucfirst(CFG::$siteConfig['site_name']); 
                $copyContent = Core::loadMailTempleate($copySubject, $arrContactData);
            //    echo $content;exit;
                switch ($_SESSION['user_login']['roll_id']) 
                {
                    case '1':
                        $this->customer_mail($varEmail,CFG::$siteConfig['site_email'],$subject,$content,$copySubject,$copyContent,$attachmentArr);
                        //help desk mail
                        
                        $helpdesk_email=$this->getHelpdeskEmails($_POST['parent_region']);
                        if(!empty($helpdesk_email))
                        {
                            $this->helpdesk_mail($helpdesk_email,CFG::$siteConfig['site_email'],$subject,$content,$attachmentArr);
                        }
                        //Engineer mail
                        $engineerEmail=$this->getValue("user","email","id",$varEngineer);
                        if(!empty($engineerEmail['email']))
                        { //echo $content;exit;
                              $subject = "New Ticket for ".trim(ucfirst($name[0]['name']))." assigned to you";
                            $this->single_mail($engineerEmail['email'],CFG::$siteConfig['site_email'],$subject,$content,$attachmentArr);
                        }
                         break;
                    case '8':
                        $this->customer_mail($varEmail,CFG::$siteConfig['site_email'],$subject,$content,$copySubject,$copyContent,$attachmentArr);
                        //help desk mail
                        
                        $helpdesk_email=$this->getHelpdeskEmails($_POST['parent_region']);
                        if(!empty($helpdesk_email))
                        {
                            $this->helpdesk_mail($helpdesk_email,CFG::$siteConfig['site_email'],$subject,$content,$attachmentArr);
                        }
                        //Engineer mail
                        $engineerEmail=$this->getValue("user","email","id",$varEngineer);
                        if(!empty($engineerEmail['email']))
                        { //echo $content;exit;
                              $subject = "New Ticket for ".trim(ucfirst($name[0]['name']))." assigned to you";
                            $this->single_mail($engineerEmail['email'],CFG::$siteConfig['site_email'],$subject,$content,$attachmentArr);
                        }
                         break;
                    case '5':
                        //customer mail
                       
                        $this->customer_mail($varEmail,CFG::$siteConfig['site_email'],$subject,$content,$copySubject,$copyContent,$attachmentArr);
                        //help desk mail
                        $helpdesk_email=$this->getHelpdeskEmails($_POST['parent_region']);
                        if(!empty($helpdesk_email))
                        {
                            $this->helpdesk_mail($helpdesk_email,CFG::$siteConfig['site_email'],$subject,$content,$attachmentArr);
                        }
                        //Engineer mail
                        $engineerEmail=$this->getValue("user","email","id",$varEngineer);
                        if(!empty($engineerEmail['email']))
                        {  $subject = "New Ticket for ".trim(ucfirst($name[0]['name']))." assigned to you";
                            $this->single_mail($engineerEmail['email'],CFG::$siteConfig['site_email'],$subject,$content,$attachmentArr);
                        }
                         break;
                        
                    case '7':
                        //customer mail
                       
                        $this->customer_mail($varEmail,CFG::$siteConfig['site_email'],$subject,$content,$copySubject,$copyContent,$attachmentArr);
                        //help desk mail
                        $helpdesk_email=$this->getHelpdeskEmails($_POST['parent_region']);
                        if(!empty($helpdesk_email))
                        {
                            $this->helpdesk_mail($helpdesk_email,CFG::$siteConfig['site_email'],$subject,$content,$attachmentArr);
                        }
                         break;
                    case '6':
                         //customer mail
                        $this->customer_mail($varEmail,CFG::$siteConfig['site_email'],$subject,$content,$copySubject,$copyContent,$attachmentArr);
                        //help desk manager
                        $helpdesk_email=$this->getHelpdeskEmails($_POST['parent_region']);
                        if(!empty($helpdesk_email))
                        {
                            $this->helpdesk_mail($helpdesk_email,CFG::$siteConfig['site_email'],$subject,$content,$attachmentArr);
                        }
                        //Engineer mail
                        $engineerEmail=$this->getValue("user","email","id",$varEngineer);
                        if(!empty($engineerEmail))
                        { $subject = "New Ticket for ".trim(ucfirst($name[0]['name']))." assigned to you";
                            $this->single_mail($engineerEmail['email'],CFG::$siteConfig['site_email'],$subject,$content,$attachmentArr);
                        }
                         break;
                }
                if($_POST['edit']!=1)
                {
                    $_SESSION['ticket'] = $_SERVER['HTTP_REFERER'];
                    UTIL::redirect(URI::getURL("mod_ticket", "ticket_thank_you"));
                    exit;
                }
           }
           else
           {
              
              $this->checkAssignEngineer(APP::$curId,$varEngineer,$subject,$contnet);
              $arrFields['updated_by'] = $_SESSION['user_login']['id'];
              $past_status=$this->getValue("ticket","ticket_status","id",APP::$curId);
              DB::Update(CFG::$tblPrefix."ticket",Stringd::processString($arrFields)," id = %d ",APP::$curId);   
              $this->edit_ticket_comment(APP::$curId,$past_status,$attach_report);
           }
           
           //Pass action result
           $_SESSION['actionResult']=array("success"=>"Ticket has been saved successfully");  // different type success, info, warning, error
           
           
           if($_POST['edit']==1)
           {
               UTIL::redirect(URI::getUrl(APP::$moduleName,APP::$actionName,APP::$curId));
           }
           else
           {

               UTIL::redirect(URI::getURL(APP::$moduleName,"ticket_list"));
           }

       }
   }
   
   /*
    * 
    * Defination    :   Update ticket is_read status
    * 
    * @author       :   Mayur Patel<mayur.datatech@gmail.com>
    * 
    * created date  :   10-03-2017  11:30 Pm
    * 
    */
   function updateTicketIsRead($readValue,$id)
   {
       $arrFields['is_read']=$readValue;
       DB::Update(CFG::$tblPrefix."ticket",Stringd::processString($arrFields)," id = %d ",$id);
   }
   
   
   
    /**
    * get ticket record . 
    *
    * @author Bhavin Lunagariya <bhavin.datatech@gmail.com>
    */
   function getTicketData($id)
   {
      
        if((int)$id != 0)
            return DB::queryFirstRow("SELECT t.id,t.subject,t.ticket_status,t.description,t.image_name,t.image_title,t.image_alt,t.sort_order,t.status,t.user_id,t.region_id,t.helpdesk_id,t.engineer_id,t.problem_type,t.serial_no,t.attach_report,t.other_serial_no,t.product_model FROM ".CFG::$tblPrefix."ticket as t where t.id=%d",$id);
            //return DB::queryFirstRow("SELECT p.id,p.category_name,s.slug,p.description,p.image_name,p.image_title,p.image_alt,p.sort_order,p.status,p.meta_title,p.meta_description,p.meta_keyword FROM ".CFG::$tblPrefix."category as p left join ".CFG::$tblPrefix."slug as s on p.id=s.entity_id and s.module_key = '".APP::$moduleName."' where p.id=%d",$id);
    
   }
   /*
    * get customer record  
    * 
    * @author Bhavin Lunagariya<bhavin.datatech@gmail.com>
    */
   function getCustomerData()
   {
       if(isset($_SESSION['user_login']) && $_SESSION['user_login']['roll_id']==6)
       {
            /* @changes: all customer display if all_region=1
          * @author: Sagar Jogi dt: 09/08/2017
          */
           $check=DB::query("SELECT all_region FROM " . CFG::$tblPrefix . "user WHERE id=%d",$_SESSION['user_login']['id']);
           if($check[0]['all_region']=='1') {
               return DB::query("SELECT id,name FROM " . CFG::$tblPrefix . "user where roll_id='7' and active='1' order by id desc");
           } else {
           $customer_array=array();
           //$query="SELECT GROUP_CONCAT(DISTINCT(ID)) as id FROM " . CFG::$tblPrefix . "region WHERE find_in_set('".$_SESSION['user_login']['id']."',engineer) <> 0";
           $query="SELECT region as id FROM " . CFG::$tblPrefix . "user WHERE id=".$_SESSION['user_login']['id'];
           
           $result=DB::query($query);
          
           if(count($result) > 0)
           {
               foreach($result as $key=>$value)
               {
                   $region=explode(",",$value["id"]);
                   for($i=0;$i<count($region);$i++)
                   {
                        $customer_query="SELECT u.id, u.name
                                FROM " . CFG::$tblPrefix . "user AS u
                                WHERE active='1' and FIND_IN_SET( u.id, (

                                SELECT GROUP_CONCAT( DISTINCT (
                                ID
                                ) ) AS id
                                FROM " . CFG::$tblPrefix . "user
                                WHERE find_in_set( '".$region[$i]."', region ) <>0 )
                                ) and roll_id=7 ";
                        
                        $customer_result=DB::query($customer_query);
                        if(count($customer_result) > 0)
                        {
                            foreach($customer_result as $ckey=>$cvalue)
                            {
                                
                                array_push($customer_array,$cvalue);
                            }
                        } 
                   }
               }
               $customer_unique_array = array_map("unserialize", array_unique(array_map("serialize", $customer_array)));
             
               return $customer_unique_array;
           }
           }
           
       }
       else    
            return DB::query("SELECT id,name FROM " . CFG::$tblPrefix . "user where roll_id='7' and active='1' order by id desc");
   }
   /*
    * Get Particular cutomer region
    * 
    * @author Bhavin Lunagariya<bhavin.datatech@gmail.com>
    */
   function getCustomerRegion($customer_id)
   {
       return DB::query("SELECT r.id,r.name FROM " . CFG::$tblPrefix . "region AS r LEFT JOIN " . CFG::$tblPrefix . "user AS u ON FIND_IN_SET( r.id, u.region ) >0
WHERE u.id =%d and u.active='1' and r.status='1'",$customer_id);
   }
   function getCustomerEngRegion($customer_id)
   {
      
       /*return DB::query("SELECT r.id,r.name FROM " . CFG::$tblPrefix . "region AS r LEFT JOIN " . CFG::$tblPrefix . "user AS u ON FIND_IN_SET( r.id, u.region ) >0
WHERE FIND_IN_SET( r.id, (SELECT group_concat(region)
                FROM " . CFG::$tblPrefix . "user as h where h.id = ".$_SESSION['user_login']["id"].")) and u.id =%d and u.active='1' and r.status='1'",$customer_id);*/
         /* @changes: intersect of region
          * @author: Sagar Jogi dt: 09/08/2017
          */
       $user=DB::query("SELECT r.region FROM " . CFG::$tblPrefix . "user AS r WHERE active='1' and r.id=%d",$_SESSION['user_login']['id']);
       $cust=DB::query(" SELECT c.region_id as cregion FROM " . CFG::$tblPrefix . "user_region AS c WHERE c.user_id=%d",$customer_id);
        foreach($cust as $k=>$v){
                     $abc.=$cust[$k]['cregion'].',';
         }
        $check=DB::query("SELECT all_region FROM " . CFG::$tblPrefix . "user WHERE id=%d",$_SESSION['user_login']['id']);
        if($check[0]['all_region']=='1') {
            return DB::query("SELECT r.id,r.name FROM " . CFG::$tblPrefix . "region r WHERE status='1' and FIND_IN_SET( r.id, '$abc') order by name asc");
        } else {
       
                
//     pre($abc);exit;
       $userexp=  explode(',',$user[0]['region']);
       $custexp=  explode(',',$abc);
       
//       pre($cust);exit;
       $result=array_intersect($userexp,$custexp);
       $resimp=  implode(',', $result);
//       pre($cust);exit;
       return DB::query("SELECT r.id,r.name FROM " . CFG::$tblPrefix . "region AS r WHERE FIND_IN_SET( r.id, '$resimp')"); 
           }
       /*return DB::query("SELECT r.id,r.name FROM " . CFG::$tblPrefix . "region AS r LEFT JOIN " . CFG::$tblPrefix . "user AS u ON FIND_IN_SET( r.id, u.region ) >0
WHERE u.id =%d and u.active='1' and r.status='1'",$customer_id); */
       
   }
   /*
    * @changes: fetch engineer if all region is 1 or check individual
    * @author: Sagar Jogi dt: 11/08/2017
    */
   function getRegionEngineer($region_id)
   {
       
       return DB::query("SELECT u.id,u.name FROM " . CFG::$tblPrefix . "user AS u LEFT JOIN " . CFG::$tblPrefix . "region AS r ON (FIND_IN_SET( r.id, u.region ) >0 or u.all_region='1') WHERE r.id =%d and u.active='1' and r.status='1' and u.roll_id=6",$region_id);
   }
   function getData($table,$field,$where,$value)
   {
       if($value!='')
       {
            return DB::query("SELECT ".$field." FROM " . CFG::$tblPrefix .$table. " where ".$where."=".$value);
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
   /*function getTicketRegion($ticket_id)
   {
       
       return DB::query("SELECT r.id,r.name FROM " . CFG::$tblPrefix . "region AS r LEFT JOIN " . CFG::$tblPrefix . "user AS u ON FIND_IN_SET( r.id, u.region ) >0 LEFT JOIN " . CFG::$tblPrefix . "ticket as t on t.user_id=u.id WHERE t.id =%d and u.roll_id=6",$ticket_id);
   }*/
   function getTicketRegion($ticket_id)
   {
       
       return DB::query("SELECT r.id,r.name FROM " . CFG::$tblPrefix . "region AS r LEFT JOIN " . CFG::$tblPrefix . "user AS u ON FIND_IN_SET( r.id, u.region ) >0 LEFT JOIN " . CFG::$tblPrefix . "ticket as t on t.user_id=u.id WHERE t.id =%d",$ticket_id);
   }
   /** Change Status of ticket
    *
    * @author Bhavin Lunagariya <bhavin.datatech@gmail.com>
    */
   function changeStatus() {

       $newStatus = $_GET['newstatus'];

       foreach ($_POST['status'] as $key => $val) {
          
          DB::update(CFG::$tblPrefix . "ticket", array("status" => $newStatus), " id=%d ", $key);
           
       }
   }
   /*
    * delete ticket
    * 
    */
   function deleteTicket()
   {
       foreach($_POST['status'] as $key=>$value)
       {
           $record = DB::queryFirstRow("SELECT image_name FROM ".CFG::$tblPrefix."ticket where id=%d",$key);    
            // delete uploaded image
           UTIL::unlinkFile($record['image_name'],URI::getAbsMediaPath(CFG::$categoryDir));
           
           $query="delete from ".CFG::$tblPrefix."ticket_comment where ticket_id in ('".$key."')";
           DB::query($query);
           DB::query("delete from ".CFG::$tblPrefix."ticket where id=%d ",$key);

       }
   }
   public function getTicketViewData($id) 
   { 
        $this->updateTicketIsRead("1",$id);
        return DB::queryFirstRow("SELECT t.*,h.name as helpdesk_name,r.name as region_name FROM " . CFG::$tblPrefix . "ticket as t left join " . CFG::$tblPrefix . "user as u on u.id=t.user_id left join " . CFG::$tblPrefix . "helpdesk as h on h.id=t.helpdesk_id left join " . CFG::$tblPrefix . "region as r on r.id=t.region_id where t.id=%d and t.status='1'", $id);   
    }
   public function getTicketCommentData($id)
   {
       return DB::query("SELECT tc.*  FROM " . CFG::$tblPrefix . "ticket_comment as tc left join " . CFG::$tblPrefix . "ticket as t on t.id=tc.ticket_id  where t.id=%d and t.status='1' and tc.parent_commentId='0' and tc.is_deleted='0'", $id); 
   }
   /*
    * Save Comment
    * 
    * @author Bhavin Lunagariya <bhavin.datatech@gmail.com>
    */
   function saveComment()
   {
       Load::loadLibrary("sender.php", "phpmailer");
       
       if(isset($_REQUEST['comment']) && $_REQUEST['comment']!='')
       {
           $varTicketStatus=(isset($_POST['ticket_status'])) ? $_POST['ticket_status'] : "";
           $varComment=(isset($_POST['comment'])) ? $_POST['comment'] : "";
           $varParentId=(isset($_POST['parent_id'])) ? $_POST['parent_id'] : "";
           $arrFields=array("comment"=>nl2br($varComment),"user_id"=>$_POST['user_id'],"ticket_id"=>$_POST['ticket_id'],"parent_commentId"=>$varParentId);
          
           if(APP::$curId!="" && $_POST['id']=='')
           {
               //store cretaed date
               $arrFields['created_date']=date("Y-m-d");
               $arrFields['status'] = "1";
              
                
                $past_status=$this->getValue("ticket","ticket_status","id",$_POST['ticket_id']);
                
                if($past_status['ticket_status']!=$varTicketStatus)
                {
                   
                    $arrFields['ticket_status']=$varTicketStatus;
                }
                DB::Insert(CFG::$tblPrefix."ticket_comment",Stringd::processString($arrFields));
                if(!empty($varTicketStatus))
                {
                    $arrFields1['ticket_status']=$varTicketStatus;

                    DB::Update(CFG::$tblPrefix."ticket",Stringd::processString($arrFields1)," id = %d ",$_POST['ticket_id']);
                }
                if(!empty($_POST['ticket_id']))
                {
                    $arrContactData['Ticket No'] = trim($_POST['ticket_id']);
                }
                if (!empty($_POST['user_id'])) 
                { 
                    $user=$this->getValue("ticket","user_id","id",$_POST['ticket_id']);
                    $name=$this->getValue("user","name","id",$user['user_id']);
                    $userEmail=$this->getValue("user","email","id",$user['user_id']);
                    $engineer=$this->getValue("ticket","engineer_id","id",$_POST['ticket_id']);
                    
                    $varEmail=$userEmail['email'];
                    $arrContactData['Name'] = trim(ucfirst($name['name']));
                }

                if (!empty($_POST['ticket_id'])) {
                    $ticket_subject=  $this->getValue("ticket","subject","id",$_POST['ticket_id']);
                    $arrContactData['Ticket Subject'] = trim(ucfirst($ticket_subject['subject']));
                    $ticket_description=  $this->getValue("ticket","description","id",$_POST['ticket_id']);
                    if($ticket_description['description']!='')
                    {
                        $arrContactData['Ticket Descripion'] = trim(ucfirst($ticket_description['description']));
                    }
                }
                  
                if (!empty($varComment)) {
                   $arrContactData['Comment']=trim(ucfirst(nl2br($varComment)));
                }
                if (!empty($varTicketStatus)) {
                   $arrContactData['Status']=CFG::$ticketStatusArray[$varTicketStatus];
                }
                $arrContactData["Ticket View"]='<a href="'.URI::getURL(APP::$moduleName, 'ticket_view',$_POST['ticket_id']).'" title="view ticket" target="_blank">'.URI::getURL(APP::$moduleName, 'ticket_view',$_POST['ticket_id']).'</a>';
                $roll_name=$this->getValue("rolls","name","id",$_SESSION['user_login']['roll_id']);
                if(empty($varParentId))
                {
                    $subject = "New Comment from ".$roll_name['name']." to ". ucfirst(CFG::$siteConfig['site_name']);
                    $copySubject="Copy of New Comment for ".$roll_name['name']." to ". ucfirst(CFG::$siteConfig['site_name']);
                }
                else
                {
                    $subject = "New Comment from ".$roll_name['name']." to ". ucfirst(CFG::$siteConfig['site_name']);
                    $copySubject="Copy of New Comment for ".$roll_name['name']." to ".ucfirst(CFG::$siteConfig['site_name']);
                }
               
               $content = Core::loadMailTempleate($subject, $arrContactData);
               
               $copyContent=Core::loadMailTempleate($copySubject, $arrContactData);
                switch ($_SESSION['user_login']['roll_id']) 
                {
                    case '1':
                       
                        $this->customer_mail($varEmail,CFG::$siteConfig['site_email'],$subject,$content,$copySubject,$copyContent);
                        //help desk mail
                        $region=$this->getValue("user","region","id",$user['user_id']);
                        $helpdesk_email=$this->getHelpdeskEmails($region['region']);
                        if(!empty($helpdesk_email))
                        {
                            $this->helpdesk_mail($helpdesk_email,CFG::$siteConfig['site_email'],$subject,$content);
                        }
                        
                        if(!empty($engineer['engineer_id']))
                        { 
                            $engineerEmail=$this->getValue("user","email","id",$engineer['engineer_id']);
                            
                            $this->single_mail($engineerEmail['email'],CFG::$siteConfig['site_email'],$subject,$content);
                        }
                        
                         break;
                    case '5':
                    case '7':
                        //customer mail
                       
                        $this->customer_mail($varEmail,CFG::$siteConfig['site_email'],$subject,$content,$copySubject,$copyContent);
                        //help desk mail
                        $region=$this->getValue("user","region","id",$user['user_id']);
                        $helpdesk_email=$this->getHelpdeskEmails($region['region']);
                        if(!empty($helpdesk_email))
                        {
                            $this->helpdesk_mail($helpdesk_email,CFG::$siteConfig['site_email'],$subject,$content);
                        }
                        
                        if(!empty($engineer['engineer_id']))
                        { 
                            $engineerEmail=$this->getValue("user","email","id",$engineer['engineer_id']);
                            
                            $this->single_mail($engineerEmail['email'],CFG::$siteConfig['site_email'],$subject,$content);
                        }
                        break;
                    case '6':
                       
                         //customer mail
                        $this->customer_mail($varEmail,CFG::$siteConfig['site_email'],$subject,$content,$copySubject,$copyContent);

                        //Engineer mail
                        $engineerEmail=$this->getValue("user","email","id",$_SESSION['user_login']['id']);
                        
                        $this->single_mail($engineerEmail['email'],CFG::$siteConfig['site_email'],$subject,$content);
                        
                        //help desk mail
                        $region=$this->getValue("user","region","id",$user['user_id']);
                        $helpdesk_email=$this->getHelpdeskEmails($region['region']);
                        if(!empty($helpdesk_email))
                        {
                            $this->helpdesk_mail($helpdesk_email,CFG::$siteConfig['site_email'],$subject,$content);
                        }
                        break;
                }
               //get current Id
               //APP::$curId=DB::insertId();  
           }
           else
           {
              $arrFields['updated_by'] = $_SESSION['user_login']['id'];
              APP::$curId=$_POST['ticket_id'];
               DB::Update(CFG::$tblPrefix."ticket_comment",Stringd::processString($arrFields)," id = %d ",$_POST['id']);   
           }

           //Pass action result
           $_SESSION['actionResult']=array("success"=>"Comment has been saved successfully");  // different type success, info, warning, error
          
           UTIL::redirect(URI::getUrl(APP::$moduleName,"ticket_view",APP::$curId));
           
       }
   }
   function getTicketComment($row)
   {
            $this->count++;
            $user=$this->getData("user","name","id",$row['user_id']);
           
            $user_name=$user[0]['name'];
            echo "<li class='comment'>"; 
            if($row['ticket_status']=='closed')
            {
                
               
                if($row['attach_report']!='' && file_exists(URI::getAbsMediaPath(CFG::$ticketDir) . "/" .$row['attach_report']))
                {
                   
                     $path=URI::getAbsMediaPath(CFG::$ticketDir) . "/" .$row['attach_report']; 
                     
                     $ext = pathinfo($path, PATHINFO_EXTENSION);
                   
//                     echo URI:: getLiveTemplatePath().'/images/file-icons';
//                     exit;
                    echo "<div class='comment-image'>";
                   
                  
                        if($ext=='jpg' || $ext=='JPG' || $ext=='gif' || $ext=='GIF' || $ext=='png' || $ext=='PNG'){
                              echo '<div class="commentImageZoom"><div class="zoomImg1" data-src="'.URI::getliveMediaPath(CFG::$ticketDir) . "/" .$row['attach_report'].'">';
                        echo '<img src="'.UTIL::getResizedImageSrc(CFG::$ticketDir,$row['attach_report'], "small", "no-image.jpg").'" alt="'.$row['attach_report'].'" class="absoImg" style="position: relative;">';
                         echo '</div></div>';
                        }else if($ext=='doc' ||  $ext=='DOC' || $ext=='docx' || $ext=='DOCX'){
                            echo '<a href="'.CFG::$livePath .'/download.php?file='.$row['attach_report'].'" title="'.$row['attach_report'].'"  id="'.$row['attach_report'].'" target="_blank">';
                             echo '<img src="'. URI:: getLiveTemplatePath().'/images/file-icons/word_icon.png'.'" alt="'.$row['attach_report'].'" class="absoImg" style="position: relative;"></a>';
                        } else if($ext=='pdf' ||  $ext=='PDF'){
                             echo '<a href="'.CFG::$livePath .'/download.php?file='.$row['attach_report'].'" title="'.$row['attach_report'].'"  id="'.$row['attach_report'].'" target="_blank">';
                             echo '<img src="'. URI:: getLiveTemplatePath().'/images/file-icons/pdf_icon.png'.'" alt="'.$row['attach_report'].'" class="absoImg" style="position: relative;"></a>';
                        }
                   
                    echo "</div>";
                }                               
                
            } 
            echo "<div class='ticketDetail'><div class='aut'><div>".$user_name."</div>";
            if(Core::hasAccess(APP::$moduleName, "delete_comment")) 
            {
            echo "<a href='#comment' class='delComm' title='Delete' onclick=deleteComment('".URI::getUrl(APP::$moduleName,"delete_comment").'&comment_id='.$row['id'].'&id='.APP::$curId."')></a>";  
            }
            echo "</div>";
            echo "<div class='timestamp'>".date("dS M,Y",strtotime($row['created_date']))."</div>"; 
            echo "<div class='comment-text'>";
            if($row['ticket_status']!='')
            {
                
                echo "<div class='comment-status'>Ticket Status : ".CFG::$ticketStatusArray[$row['ticket_status']]."</div>";  
            }
            echo "<div class='comment-body'>".$row['comment']."</div>";  
            echo "</div></div>";
            
            if(Core::hasAccess(APP::$moduleName, "edit_comment")) 
            {
                if($_SESSION['user_login']['id']==$row['user_id'])
                {
                    //echo "<a href='#comment_form' class='reply showCommentBox' id='".$row['id']."'>Edit</a>";  
                }
            }
            // echo "<div class='reply_body".$row['id']."' id='reply_body".$row['id']."'></div>";  
            /* The following sql checks whether there's any reply for the comment */  
            
            $result=DB::query("select * from " . CFG::$tblPrefix . "ticket_comment where parent_commentId=%d and is_deleted='0'",$row['id']);
            
         
            if(count($result)>0) // there is at least reply  
             {  
             echo "<ul>";  
             foreach($result as $key=>$value)
             {  
              $this->getTicketComment($value);  
             }  
             echo "</ul>";  
             }  
            echo "</li>"; 
   }

   function deleteComment()
   {
       /*
        * Delete comment for tree (parent-child)
        * 
        * @author Bhavin Lunagariya<bhavin.datatech@gmail.com>
        */
       /*if(isset($_REQUEST['comment_id']) && $_REQUEST['comment_id']>0 && $_REQUEST['id'] > 0)
       {
            $result=DB::query("select * from " . CFG::$tblPrefix . "ticket_comment where id=%d",$_REQUEST['comment_id']);
            if(count($result)>0)
            {
                foreach($result as $key=>$value)
                {
                   
                    $sub_comment=DB::query("select * from " . CFG::$tblPrefix . "ticket_comment where parent_commentId=%d",$value['id']);
                    if(count($sub_comment)>0)
                    {
                        foreach($sub_comment as $skey=>$svalue)
                        {
                            
                            $arrFields['is_deleted'] = "1";
                            DB::Update(CFG::$tblPrefix."ticket_comment",Stringd::processString($arrFields)," id = %d ",$svalue['id']); 
                            $this->sub_comment_delete($svalue['id']);
                        }
                    }
                    $arrFields['is_deleted'] = "1";
                    DB::Update(CFG::$tblPrefix."ticket_comment",Stringd::processString($arrFields)," id = %d ",$value['id']); 
                }
            }
            
           $_SESSION['actionResult']=array("success"=>"Comment have been deleted successfully");  // different type success, info, warning, error
          
           UTIL::redirect(URI::getUrl(APP::$moduleName,"ticket_view",$_REQUEST['id']));
       }
       else
       {
           $_SESSION['actionResult']=array("error"=>"Comment have not been deleted successfully");  // different type success, info, warning, error
           UTIL::redirect(URI::getUrl(APP::$moduleName,"ticket_view",$_REQUEST['id']));
       }*/
       
       /*
        * 
        * Delete for single comment
        */
       if(isset($_REQUEST['comment_id']) && $_REQUEST['comment_id']>0 && $_REQUEST['id'] > 0)
       {
            $result=DB::query("select * from " . CFG::$tblPrefix . "ticket_comment where id=%d",$_REQUEST['comment_id']);
            if(count($result)>0)
            {
                foreach($result as $key=>$value)
                {
                    $arrFields['is_deleted'] = "1";
                    DB::Update(CFG::$tblPrefix."ticket_comment",Stringd::processString($arrFields)," id = %d ",$value['id']); 
                }
                $_SESSION['actionResult']=array("success"=>"Comment have been deleted successfully");  // different type success, info, warning, error
          
                UTIL::redirect(URI::getUrl(APP::$moduleName,"ticket_view",$_REQUEST['id']));
            }
            else
            {
                $_SESSION['actionResult']=array("error"=>"Comment have not been deleted successfully");  // different type success, info, warning, error
                UTIL::redirect(URI::getUrl(APP::$moduleName,"ticket_view",$_REQUEST['id']));
            }
           
       }
       else
       {
           $_SESSION['actionResult']=array("error"=>"Comment have not been deleted successfully");  // different type success, info, warning, error
           UTIL::redirect(URI::getUrl(APP::$moduleName,"ticket_view",$_REQUEST['id']));
       }
       
   }
   function sub_comment_delete($id)
   {
        $result=DB::query("select * from " . CFG::$tblPrefix . "ticket_comment where id=%d",$id);
        if(count($result)>0)
        {
            foreach($result as $key=>$value)
            {
                DB::debugMode();
                $sub_comment=DB::query("select * from " . CFG::$tblPrefix . "ticket_comment where parent_commentId=%d",$value['id']);
                if(count($sub_comment)>0)
                {
                    foreach($sub_comment as $skey=>$svalue)
                    {
                        
                        $arrFields['is_deleted'] = "1";
                        DB::Update(CFG::$tblPrefix."ticket_comment",Stringd::processString($arrFields)," id = %d ",$svalue['id']); 
                        $this->sub_comment_delete($svalue['id']);
                    }
                }
                $arrFields['is_deleted'] = "1";
                DB::Update(CFG::$tblPrefix."ticket_comment",Stringd::processString($arrFields)," id = %d ",$value['id']); 
            }
        }
   }
   public function customer_mail($to,$from,$subject,$content,$copySubject,$copyContent,$attchment=NULL)
   {
        
        $mail_from = $to;
        $mail_from_name = $varName;
        $mail_to = $from;
        
        if (!$send = mosMail($mail_from, $mail_from_name, $mail_to, $subject, $content, 1,NULL,NULL,$attchment)) {
            
            $_SESSION['message'] = "<span style='color:#ff0000;font-family:Arial;font-size:12px;font-weight:bold;'>Error in sending mail.</span>";
        }
        
        $csubject = $copySubject;
        $mail_from = $from;

        $mail_from_name = CFG::$siteConfig['site_name'];
        $mail_to = array($to);
       

        if (!$send = mosMail($mail_from, $mail_from_name, $mail_to, $csubject, $copyContent, 1,NULL,NULL,$attchment)) {
            $_SESSION['message'] = "<span style='color:#ff0000;font-family:Arial;font-size:12px;font-weight:bold;'>Error in sending mail.</span>";
        } 
        
   }
   function single_mail($to,$from,$subject,$content,$attchment=NULL)
   {
        $subject = $subject;
        $mail_from = $from;
        $mail_from_name = $varName;
        $mail_to = $to;
      //   echo $content;exit;
        if (!$send = mosMail($mail_from, $mail_from_name, $mail_to, $subject, $content, 1,NULL,NULL,$attchment)) {
            $_SESSION['message'] = "<span style='color:#ff0000;font-family:Arial;font-size:12px;font-weight:bold;'>Error in sending mail.</span>";
        }
   }
   function helpdesk_mail($to,$from,$subject,$content,$attchment=NULL)
   {
       if(!empty($to))
       {
           for($i=0;$i<count($to);$i++)
           {
                $subject = $subject;
                $mail_from = $from;
                $mail_from_name = $varName;
                $mail_to =$to[$i] ;
                if (!$send = mosMail($mail_from, $mail_from_name, $mail_to, $subject, $content, 1,NULL,NULL,$attchment)) {
                    $_SESSION['message'] = "<span style='color:#ff0000;font-family:Arial;font-size:12px;font-weight:bold;'>Error in sending mail.</span>";
                }
               
           }
           
       }
   }
   function getCommentRecord($id)
   {
       if((int)$id!=0)
       {
           $commentString="";
           $result=DB::query("SELECT *  FROM " . CFG::$tblPrefix . "ticket_comment where id=%d and is_deleted='0'", $id);
           if(count($result) > 0)
           {
              
               foreach($result as $key=>$value)
               {
               $commentString.='<form id="frmReply'.$value['user_id'].'" novalidate="novalidate" method="POST" name="frmReply" action="'.URI::getURL(APP::$moduleName,"edit_comment").'">';
                $commentString.='<div>
                     <textarea name="comment" maxlength="250" id="comment'.$value['user_id'].'" class="txt required">'.$value['comment'].'</textarea>
                         <small>Maximum character length 250</small>
                    <div id="error_text"> </div>
                </div>
                <div>           
                    <input type="hidden" name="parent_id" id="parent_id" class="parent_class" value="'.$value['parent_commentId'].'"/> 
                    <input type="hidden" name="ticket_id" id="ticket_id" value="'.$value['ticket_id'].'">
                    <input type="hidden" name="user_id" id="user_id" value="'.$value['user_id'].'">
                    <input type="hidden" name="id" id="id" value="'.$value['id'].'">
                    <input type="submit" value="Comment" name="Submit" class="trans comBtn" onclick="return submitPost('.$value['user_id'].');">
                </div>';
                 $commentString.='</form>';
               }
              
           }
           return $commentString;
       }
           
   }
   function getHelpdeskEmails($region)
   {
       if(substr($region, -2)==',,'){
           $region=substr($region,0,-2);
       } 
       
       if($region!='')
       {
        $query="SELECT u.id,u.email
                FROM " . CFG::$tblPrefix . "user AS u
                WHERE u.active='1' and FIND_IN_SET( u.id, (

                SELECT group_concat( manager )
                FROM " . CFG::$tblPrefix . "helpdesk as h left join dtm_region as r on r.helpDesk =h.id  where r.id in (".trim($region, ",")."))
        ) 
";
        $result=DB::query($query);
        if(count($result) > 0)
        {
             $emailArray=array();
             foreach($result as $key=>$value)
             {
                array_push($emailArray,$value['email']);     
             }
        }
        return $emailArray;
       }
   }
   function getTicketExist($id)
   {
       
       $result=DB::query("select * from " . CFG::$tblPrefix . "ticket where status='1' and id=%d",$id);
       
       if(count($result) > 0)
       {
           return true;
       }
       else
       {
           return false;
       }
   }
   function checkAssignEngineer($ticket_id,$engineer_id,$subject,$content)
   {
       $result=DB::query("select * from " . CFG::$tblPrefix . "ticket where status='1' and id=%d",$ticket_id);
       
       if(count($result) > 0)
       {
           foreach($result as $key=>$value)
           {
              
               if($value['engineer_id']=='0' && $engineer_id!='')
               {
                   //Engineer mail
              
                    $engineerEmail=$this->getValue("user","email","id",$engineer_id);

                    $this->single_mail($engineerEmail['email'],CFG::$siteConfig['site_email'],$subject,$content);
               }
               else if($value['engineer_id']!=$engineer_id && $value['engineer_id']!='0')
               {
                   //Engineer mail
                    $engineerEmail=$this->getValue("user","email","id",$engineer_id);

                    $this->single_mail($engineerEmail['email'],CFG::$siteConfig['site_email'],$subject,$content);
               }
           }
       }
       
   }
   function edit_ticket_comment($ticket_id,$past_status,$attach_report='')
   {
        
        
          
        $varTicketStatus=(isset($_POST['ticket_status'])) ? $_POST['ticket_status'] : "";
        $varComment=(isset($_POST['comment'])) ? $_POST['comment'] : "";
        
        if (!empty($varComment)) 
        {
            
            
            $arrFields1=array("comment"=>nl2br($varComment),"user_id"=>$_SESSION['user_login']['id'],"ticket_id"=>$ticket_id,"attach_report"=>$attach_report);
            $arrFields1['created_date']=date("Y-m-d");
            $arrFields1['status'] = "1";
            
             if($past_status['ticket_status']!=$varTicketStatus || $past_status['ticket_status']=='closed')
             {
                 $arrFields1['ticket_status']=$varTicketStatus;
             }
             
             $attachmentArr=NULL;
             if($attach_report!='' && file_exists(URI::getAbsMediaPath(CFG::$ticketDir) . "/" .$attach_report) && $varTicketStatus=='closed')
            {
                 $path = CFG::$absPath . "/" . CFG::$mediaDir . '/' . CFG::$ticketDir . '/';
                
                 $filename = $attach_report;

                 // To send multiple attachments.....
                $attachmentArr = $path . $filename;
               

            }  
             
             
             DB::Insert(CFG::$tblPrefix."ticket_comment",Stringd::processString($arrFields1));
             if(!empty($ticket_id))
             {
                 $arrContactData['Ticket No'] = trim($ticket_id);
             }
             if (!empty($_POST['customer'])) 
             { 
                 $user=$this->getValue("ticket","user_id","id",$ticket_id);
                 $name=$this->getValue("user","name","id",$user['user_id']);
                 $userEmail=$this->getValue("user","email","id",$user['user_id']);
                 $engineer=$this->getValue("ticket","engineer_id","id",$ticket_id);
                 
                 $varEmail=$userEmail['email'];
                 $arrContactData['Name'] = trim(ucfirst($name['name']));
             }

             if (!empty($_POST['ticket_id'])) {
                 $ticket_subject=  $this->getValue("ticket","subject","id",$ticket_id);
                 $arrContactData['Ticket Subject'] = trim(ucfirst($ticket_subject['subject']));
                 $ticket_description=  $this->getValue("ticket","description","id",$ticket_id);
                 if($ticket_description['description']!='')
                 {
                    $arrContactData['Ticket Descripion'] = trim(ucfirst($ticket_description['description']));
                 }
             }

             if (!empty($varComment)) {
                $arrContactData['Comment']=trim(ucfirst(nl2br($varComment)));
             }
             if (!empty($ticket_id)) {
                $arrContactData['Status']=ucfirst(CFG::$ticketStatusArray[$varTicketStatus]);
             }
             $arrContactData["Ticket View"]='<a href="'.URI::getURL(APP::$moduleName, 'ticket_view',$ticket_id).'" title="view ticket" target="_blank">'.URI::getURL(APP::$moduleName, 'ticket_view',$ticket_id).'</a>';
             $roll_name=$this->getValue("rolls","name","id",$_SESSION['user_login']['roll_id']);
             if(empty($varParentId))
             {
                 $subject = "New Comment from ".$roll_name['name']." to ". ucfirst(CFG::$siteConfig['site_name']);
                 $copySubject="Copy of New Comment from ".$roll_name['name']." to ". ucfirst(CFG::$siteConfig['site_name']);
             }
             else
             {
                 $subject = "Reply Comment from ".$roll_name['name']." to ". ucfirst(CFG::$siteConfig['site_name']);
                 $copySubject="Copy of New Comment from ".$roll_name['name']." to ".ucfirst(CFG::$siteConfig['site_name']);
             }

            $content = Core::loadMailTempleate($subject, $arrContactData);
            
            $copyContent=Core::loadMailTempleate($copySubject, $arrContactData);
             switch ($_SESSION['user_login']['roll_id']) 
             {
                 case '1':

                     $this->customer_mail($varEmail,CFG::$siteConfig['site_email'],$subject,$content,$copySubject,$copyContent,$attachmentArr);
                     //help desk mail
                     $region=$this->getValue("user","region","id",$user['user_id']);
                   
                     $helpdesk_email=$this->getHelpdeskEmails($region['region']);
                     if(!empty($helpdesk_email))
                     {
                        $this->helpdesk_mail($helpdesk_email,CFG::$siteConfig['site_email'],$subject,$content,$attachmentArr);
                     }

                     if(!empty($engineer['engineer_id']))
                     { 
                         $engineerEmail=$this->getValue("user","email","id",$engineer['engineer_id']);

                         $this->single_mail($engineerEmail['email'],CFG::$siteConfig['site_email'],$subject,$content,$attachmentArr);
                     }

                      break;
                 case '5':
                 case '7':
                     //customer mail

                     $this->customer_mail($varEmail,CFG::$siteConfig['site_email'],$subject,$content,$copySubject,$copyContent,$attachmentArr);
                     //help desk mail
                     $region=$this->getValue("user","region","id",$user['user_id']);
                     $helpdesk_email=$this->getHelpdeskEmails($region['region']);
                     if(!empty($helpdesk_email))
                     {
                        $this->helpdesk_mail($helpdesk_email,CFG::$siteConfig['site_email'],$subject,$content,$attachmentArr);
                     }

                     if(!empty($engineer['engineer_id']))
                     { 
                         $engineerEmail=$this->getValue("user","email","id",$engineer['engineer_id']);

                         $this->single_mail($engineerEmail['email'],CFG::$siteConfig['site_email'],$subject,$content,$attachmentArr);
                     }
                     break;
                 case '6':

                      //customer mail
                     $this->customer_mail($varEmail,CFG::$siteConfig['site_email'],$subject,$content,$copySubject,$copyContent,$attachmentArr);

                     //Engineer mail
                     $engineerEmail=$this->getValue("user","email","id",$_SESSION['user_login']['id']);
                     if(!empty($engineerEmail))
                     {
                        $this->single_mail($engineerEmail['email'],CFG::$siteConfig['site_email'],$subject,$content,$attachmentArr);
                     }
                     //help desk mail
                     $region=$this->getValue("user","region","id",$user['user_id']);
                     $helpdesk_email=$this->getHelpdeskEmails($region['region']);
                     if(!empty($helpdesk_email))
                     {
                        $this->helpdesk_mail($helpdesk_email,CFG::$siteConfig['site_email'],$subject,$content,$attachmentArr);
                     }
                     break;
             }
        }
   }
      function getServices($cid){
        $data=DB::query("SELECT product_model,product_sr_no as id,product_name as name,DATE_FORMAT(warranty_start_date,'%e-%m-%Y')as warranty_start_date,DATE_FORMAT(warranty_end_date,'%e-%m-%Y')as warranty_end_date FROM ".CFG::$tblPrefix."inventory where user_id=%d",$cid);
        if(isset($data) && !empty($data)){
            $str='';
            foreach($data as $k=>$v){
                $psn = ($v['id'] != "") ? " (".$v['id'].")" : '';
                $str.="<option value='".$v['id']."' data-sd='".$v['warranty_start_date']."' data-ed='".$v['warranty_end_date']."' data-model='".$v['product_model']."' data-productname='".$v['name']."'>".$v['name'].$psn."</option>";
}   
            echo $str;
            exit;
        } else {
            echo '';
            exit;
        }
    }
}   

?>
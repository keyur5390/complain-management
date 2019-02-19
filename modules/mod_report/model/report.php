<?php 
/* Category model class. Contains all attributes and method related to category. */
//restrict direct access to the testimonial 
defined( 'DMCCMS' ) or die( 'Unauthorized access' );

Class ReportModel
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
    function getTicketList($type)
    {
        //$orderBy = "id desc";
        if (isset($_GET['o_type']))
            $orderBy = $_GET['o_field'] . " " . $_GET['o_type'];
        $where = "";
        $whereParam = array();
        $flag = true;
        if(isset($_GET['searchForm']['customer_name']) && trim($_GET['searchForm']['customer_name'])!="")
        {
                $where .= "  u.name like %ss_sortOrder ";
                $whereParam["sortOrder"] = Stringd::processString($_GET['searchForm']['customer_name']);
                $flag = false;
        }
        if(isset($_GET['searchForm']['ticket_subject']) && trim($_GET['searchForm']['ticket_subject'])!="")
        {
                $where .= " (t.subject like %ss_sortOrder or t.id like %ss_sortOrder) ";
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
        if (isset($_GET['region']) && $_GET['region'] > 0)
        {
            if ($flag == false) {
                $where.=" and ";
            }
            $where .= "  t.region_id =".$_GET['region'];
            $flag = false;
                    
        }
        if (isset($_GET['helpdesk']) && $_GET['helpdesk'] > 0)
        {
            if ($flag == false) {
                $where.=" and ";
            }
            $where .= "  t.helpdesk_id =".$_GET['helpdesk'];
            $flag = false;
        }
        if (isset($_GET['engineer']) && $_GET['engineer'] > 0)
        {
            if ($flag == false) {
                $where.=" and ";
            }
            $where .= "  t.engineer_id =".$_GET['engineer'];
            $flag = false;
        }
        if (isset($_GET['ticket_status']) && $_GET['ticket_status'] !='')
        {
            
            if ($flag == false) {
                $where.=" and ";
            }
            $where .= "  t.ticket_status ='".$_GET['ticket_status']."'";
            $flag = false;
        }
        if (isset($_GET['searchForm']['customer']) && $_GET['searchForm']['customer'] > 0)
        {
            if ($flag == false) {
                $where.=" and ";
            }
            $where .= "  t.user_id =".$_GET['searchForm']['customer'];
            $flag = false;
        }
         if(empty($orderBy))
        {
            $orderBy = " FIELD(t.ticket_status,'open','inprogress','hold','closed','closedwithoutreport'),t.created_date desc,t.id desc";
        }
        //DB::debugMode();
        if($type=="customer")
        {
            $groupBy=" t.user_id "; 
        }
        UTIL::doPaging("totalPages", "t.id,u.id as user_id,t.subject,t.status,t.sort_order,u.name,h.name as helpdesk_name,r.name as region_name,t.ticket_status,t.engineer_id,t.close_date,(select name from ".CFG::$tblPrefix."user where id=t.engineer_id)as engineer_name", CFG::$tblPrefix . "ticket as t inner join ".CFG::$tblPrefix . "user as u on u.id=t.user_id left join ".CFG::$tblPrefix ."region as r on r.id=t.region_id left join ".CFG::$tblPrefix ."helpdesk as h on h.id=t.helpdesk_id", $where, $whereParam, $orderBy,$groupBy);
        //exit;
        
    }
    
   public function getTicketDetails()
    {
      $user_id = $_REQUEST['user_id'];
      
      
      
      
      $invoices = DB::query("SELECT id, subject , ticket_status,created_date FROM " .CFG::$tblPrefix. "ticket WHERE user_id = %d",$user_id);
      $count=0;
      $html = "";
      
      $html='
            <td id="phpDetail-'.$user_id.'" class="phpdetails open" colspan="5" valign="top">
                <h4 class="table-title">Ticket Details</h4>
                    <table class="custom-table" style="width: 100%">
                        <thead>
                          <tr>
                              <th>Sr#</th>
                              <th>Ticket Subject</th>
                              <th>Status</th>
                              <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
              ';
            if(count($invoices) > 0)
            {
             foreach ($invoices as $invoicedata)
             {

               $count++;

               $html .= '<tr> 
                   <td class="alignCenter chekMain">'.$count.'</td>
                  <td class="alignCenter">'.$invoicedata['subject'].'</td>


                     <td class="alignCenter">'.$invoicedata['ticket_status'].'</td>
                     <td class="alignCenter">'.UTIL::dateDisplay($invoicedata['created_date']).'</td>


                 </li>';
             }
            }
            else
            {
              $html .= '<tr><td colspan="3">No Invoice Records Found.</td></tr>';
            }
      $html .=  '</tbody></table></td>';
             
      echo $html;
      exit;
      
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
            return DB::queryFirstRow("SELECT t.id,t.subject,t.ticket_status,t.description,t.image_name,t.image_title,t.image_alt,t.sort_order,t.status,t.user_id,t.region_id,t.helpdesk_id,t.engineer_id FROM ".CFG::$tblPrefix."ticket as t where t.id=%d",$id);
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
           $customer_array=array();
           $query="SELECT GROUP_CONCAT(DISTINCT(ID)) as id FROM " . CFG::$tblPrefix . "region WHERE find_in_set('".$_SESSION['user_login']['id']."',engineer) <> 0";
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
                                WHERE FIND_IN_SET( u.id, (

                                SELECT GROUP_CONCAT( DISTINCT (
                                ID
                                ) ) AS id
                                FROM " . CFG::$tblPrefix . "user
                                WHERE find_in_set( '".$region[$i]."', region ) <>0 )
                                ) and roll_id=7";
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
               return array_unique($customer_array);
           }
           
       }
       else    
            return DB::query("SELECT id,name FROM " . CFG::$tblPrefix . "user where roll_id='7' order by id desc");
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
   function getRegionEngineer($region_id)
   {
       return DB::query("SELECT u.id,u.name FROM " . CFG::$tblPrefix . "user AS u LEFT JOIN " . CFG::$tblPrefix . "region AS r ON FIND_IN_SET( u.id, r.engineer ) >0 WHERE r.id =%d and u.active='1' and r.status='1' and u.roll_id=6",$region_id);
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
        return DB::queryFirstRow("SELECT t.*,h.name as helpdesk_name,r.name as region_name FROM " . CFG::$tblPrefix . "ticket as t left join " . CFG::$tblPrefix . "user as u on u.id=t.user_id left join " . CFG::$tblPrefix . "helpdesk as h on h.id=t.helpdesk_id left join " . CFG::$tblPrefix . "region as r on r.id=t.region_id  where t.id=%d and t.status='1'", $id);   
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
           $arrFields=array("comment"=>$varComment,"user_id"=>$_POST['user_id'],"ticket_id"=>$_POST['ticket_id'],"parent_commentId"=>$varParentId);
          
           if(APP::$curId!="" && $_POST['id']=='')
           {
               //store cretaed date
               $arrFields['created_date']=date("Y-m-d");
               $arrFields['status'] = "1";
              
               //Insert product
               DB::Insert(CFG::$tblPrefix."ticket_comment",Stringd::processString($arrFields));
                if(!empty($varTicketStatus))
              {
                  $arrFields1['ticket_status']=$varTicketStatus;
                  
                  DB::Update(CFG::$tblPrefix."ticket",Stringd::processString($arrFields1)," id = %d ",$_POST['ticket_id']);
              }
                if (!empty($_POST['user_id'])) 
                { 
                    $user=$this->getValue("ticket","user_id","id",$_POST['ticket_id']);
                    $name=$this->getValue("user","name","id",$user['user_id']);
                    $userEmail=$this->getValue("user","email","id",$user['user_id']);
                    $engineer=$this->getValue("ticket","engineer_id","id",$_POST['ticket_id']);
                    
                    $varEmail=$userEmail['email'];
                    $arrContactData['Name'] = trim($name['name']);
                }

                if (!empty($_POST['ticket_id'])) {
                    $ticket_subject=  $this->getValue("ticket","subject","id",$_POST['ticket_id']);
                    $arrContactData['Ticket Subject'] = trim($ticket_subject['subject']);
                    $ticket_description=  $this->getValue("ticket","description","id",$_POST['ticket_id']);
                    $arrContactData['Ticket Descripion'] = trim($ticket_description['description']);
                }
                  
                if (!empty($varComment)) {
                   $arrContactData['Comment']=$varComment;
                }
                if (!empty($varTicketStatus)) {
                   $arrContactData['Status']=$varTicketStatus;
                }
                $arrContactData["Ticket View"]='<a href="'.URI::getURL(APP::$moduleName, 'ticket_view',$_POST['ticket_id']).'" title="view ticket" target="_blank">'.URI::getURL(APP::$moduleName, 'ticket_view',$_POST['ticket_id']).'</a>';
                if(empty($varParentId))
                {
                    $subject = "New Comment for " . ucfirst(CFG::$siteConfig['site_name']);
                    $copySubject="Copy of New Comment for " . ucfirst(CFG::$siteConfig['site_name']);
                }
                else
                {
                    $subject = "Reply Comment for " . ucfirst(CFG::$siteConfig['site_name']);
                    $copySubject="Copy of New Comment for " . ucfirst(CFG::$siteConfig['site_name']);
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
                       
                        $this->helpdesk_mail($helpdesk_email,CFG::$siteConfig['site_email'],$subject,$content);
                        
                        
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
                       
                        $this->helpdesk_mail($helpdesk_email,CFG::$siteConfig['site_email'],$subject,$content);
                        
                        
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
                        
                        $this->helpdesk_mail($helpdesk_email,CFG::$siteConfig['site_email'],$subject,$content);
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
            echo "<div class='aut'><div>".$user_name."</div>";
            if(Core::hasAccess(APP::$moduleName, "delete_comment")) 
            {
            echo "<a href='#comment' class='delComm' onclick=deleteComment('".URI::getUrl(APP::$moduleName,"delete_comment").'&comment_id='.$row['id'].'&id='.APP::$curId."')></a>";  
            }
            echo "</div>";
            echo "<div class='timestamp'>".date("d/m/Y",strtotime($row['created_date']))."</div>"; 
            
            echo "<div class='comment-body'>".$row['comment']."</div>";  
             
            if(Core::hasAccess(APP::$moduleName, "edit_comment")) 
            {
                if($_SESSION['user_login']['id']==$row['user_id'])
                {
                    echo "<a href='#comment_form' class='reply showCommentBox' id='".$row['id']."'>Edit</a>";  
                }
            }
             echo "<div class='reply_body".$row['id']."' id='reply_body".$row['id']."'></div>";  
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
   public function customer_mail($to,$from,$subject,$content,$copySubject,$copyContent)
   {
        
        $mail_from = $to;
        $mail_from_name = $varName;
        $mail_to = $from;
        
        if (!$send = mosMail($mail_from, $mail_from_name, $mail_to, $subject, $content, 1)) {
            
            $_SESSION['message'] = "<span style='color:#ff0000;font-family:Arial;font-size:12px;font-weight:bold;'>Error in sending mail.</span>";
        }
        
        $csubject = $copySubject;
        $mail_from = $from;

        $mail_from_name = CFG::$siteConfig['site_name'];
        $mail_to = array($to);
       

        if (!$send = mosMail($mail_from, $mail_from_name, $mail_to, $csubject, $copyContent, 1)) {
            $_SESSION['message'] = "<span style='color:#ff0000;font-family:Arial;font-size:12px;font-weight:bold;'>Error in sending mail.</span>";
        } 
        
   }
   function single_mail($to,$from,$subject,$content)
   {
        $subject = $subject;
        $mail_from = $from;
        $mail_from_name = $varName;
        $mail_to = $to;
        if (!$send = mosMail($mail_from, $mail_from_name, $mail_to, $subject, $content, 1)) {
            $_SESSION['message'] = "<span style='color:#ff0000;font-family:Arial;font-size:12px;font-weight:bold;'>Error in sending mail.</span>";
        }
   }
   function helpdesk_mail($to,$from,$subject,$content)
   {
       if(!empty($to))
       {
           for($i=0;$i<count($to);$i++)
           {
                $subject = $subject;
                $mail_from = $from;
                $mail_from_name = $varName;
                $mail_to =$to[$i] ;
                if (!$send = mosMail($mail_from, $mail_from_name, $mail_to, $subject, $content, 1)) {
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
       if($region!='')
       {
        $query="SELECT u.id,u.email
                FROM " . CFG::$tblPrefix . "user AS u
                WHERE FIND_IN_SET( u.id, (

                SELECT group_concat( manager )
                FROM " . CFG::$tblPrefix . "helpdesk as h left join dtm_region as r on r.helpDesk =h.id  where r.id in (".$region."))
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
   
   
    function sendMail($saveEmail = true) {
        
        $templateFile = "/mailTemplate/reports.php";
        
        $SITE_EMAIL = CFG::$siteConfig['site_mail'];
         $arrTemplateHeader['livePath'] = CFG::$livePath;
        $arrTemplateHeader['logoImagePath'] = URI::getLiveTemplatePath() . "/images/logo.png";
        $arrTemplateHeader['logoImageWidth'] = "";
        $arrTemplateHeader['logoImageHeight'] = "";
        $arrTemplateHeader['headerText'] = $_POST['subject'];
          $PATH = $arrTemplateHeader['livePath'];
         $SITE_LOGO = "<img src='" . $arrTemplateHeader['logoImagePath'] . "' style='margin-bottom:10px;' border='0' width='" . $arrTemplateHeader['logoImageWidth'] . "' height='" . $arrTemplateHeader['logoImageHeight'] . "' alt='" . CFG::$siteConfig['site_name'] . "' title='" . CFG::$siteConfig['site_name'] . "'/>";
           $HEADER = $arrTemplateHeader['headerText'];
        $content = file_get_contents(CFG::$absPath . "$templateFile");
        
        ob_start();
        
        $html = "";
        
        $CONTENT = $_POST['comment'];
        
        $CONTENT .= ob_get_contents();

        ob_end_clean();

        $content = addslashes($content);

        eval("\$content = \"$content\";");
        
        
        Load::loadLibrary("sender.php", "phpmailer");
        
       // $attachmentArr = array();
      //  $attachmentURLs = array();
      //  $attachmentNameTitle = array();
//        if (isset($_POST['flImage3_hdn']) && !empty($_POST['flImage3_hdn'])) {
            $attachmentPath = CFG::$absPath . "/" . CFG::$mediaDir . '/' . CFG::$ticketDir . '/';
//            foreach ($_POST['flImage3_hdn'] as $ka => $va) {
//               echo  $attachmentArr[] = $attachmentPath . $va;
//              echo  $attachmentURLs[] = CFG::$livePath . "/" . CFG::$mediaDir . '/' . CFG::$ticketDir . '/' . $va;
//                $attachmentNameTitle[] = $va;
//            }
            $attachmentArr = $attachmentPath . $_POST['attachementD'];
            $attachmentURLs = CFG::$livePath . "/" . CFG::$mediaDir . '/' . CFG::$ticketDir . '/' . $_POST['attachementD'];
            $attachmentNameTitle = $_POST['attachementD'];
       // }
        
        
      //  exit;
        $mail_to = array();
        if($_REQUEST['send_to_all'])
        {
          $emails = DB::query("SELECT email FROM ".CFG::$tblPrefix."customer WHERE email != ''");
          foreach ($emails as $value) {
            $mail_to[] = $value['email'];
          }
          $emailsadd = DB::query("SELECT email FROM ".CFG::$tblPrefix."customer_address WHERE email != ''");
          foreach ($emailsadd as $valueadd) {
            
            $mail_to[] = $valueadd['email'];

          }
        }
        else
        {
//            if (strtolower($_POST['selSendTo']) == "other") {
//              $_POST['selSendTo'] = $_POST['txtOther'];
//            }
//           $mail_to = explode(",", $_POST['selSendTo']);
             $mail_to2=array();
             $mail_to1=array();
            foreach($_POST['selSendTo'] as $key=>$val)
            {
                
                 
                 if (strtolower($val) == "other") {
                    $Others = $_POST['txtOther'];
                     $mail_to2 = explode(",", $Others);
                  }else
                  {
                       $mail_to1[] = $val;
                  }
                
            }
            $mail_to=  array_merge($mail_to1,$mail_to2);
        }
        $mail_from = CFG::$siteConfig['site_email'];
        $mail_from_name = CFG::$siteConfig['site_name'];
         $mail_to[]=$_SESSION['user_login']['email'];
//        print_r($attachmentArr);
//        print_r($content);
//        print_r($mail_from);
//        print_r($mail_from_name); 
//        print_r($mail_to);exit;
        $subject = $_POST['subject'];
        
        foreach ($mail_to as $mailAddress) {
          if (!$send = mosMail($mail_from, $mail_from_name, $mailAddress, $subject, $content, 1, NULL, NULL, $attachmentArr)) {
            
          }
        }
        return true;
        exit;
    }
    
    function exportReport($val)
    {
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=TicketList'.time().'.csv');
        $csvName = "TicketList".date("Y-m-d_H-i",time()).".csv";
    $csv_filename = URI::getAbsMediaPath()."/".CFG::$ticketDir ."/".$csvName;
     if(isset($_REQUEST['ajax']) && $_REQUEST['ajax']==true){
         $output = fopen($csv_filename, 'w');
     }else {
          $output = fopen('php://output', 'w');
     }
        
        fputcsv($output, array('Ticket No','Subject', 'Description', 'Problem Type', 'Customer Name', 'Engineer', 'Region', 'Help Desk','Serial No', 'Image','Date','Closing Date'));
        
        $flag = true;
        if(isset($_REQUEST['searchForm']['customer_name']) && trim($_REQUEST['searchForm']['customer_name'])!="")
        {
                $where .= "  u.name like '%".Stringd::processString($_REQUEST['searchForm']['customer_name'])."%'";
                //$whereParam["sortOrder"] = Stringd::processString($_REQUEST['searchForm']['customer_name']);
                $flag = false;
        }
        if(isset($_REQUEST['searchForm']['ticket_subject']) && trim($_REQUEST['searchForm']['ticket_subject'])!="")
        {
                $where .= " (t.subject like '%".Stringd::processString($_REQUEST['searchForm']['ticket_subject'])."%') ";
               // $whereParam["sortOrder"] = Stringd::processString($_REQUEST['searchForm']['ticket_subject']);
                $flag = false;
        }
        $date = "";
        if (isset($_REQUEST['searchForm']['dateFrom']) == true && isset($_REQUEST['searchForm']['dateTo']) == true) {
            if ($_REQUEST['searchForm']['dateFrom'] != $_REQUEST['searchForm']['dateTo'] && $_REQUEST['searchForm']['dateFrom'] != "" && $_REQUEST['searchForm']['dateTo'] != "") {
                $date = " date(t.created_date) between '" . date("Y-m-d", strtotime($_REQUEST['searchForm']['dateFrom'])) . "' and '" . date("Y-m-d", strtotime($_REQUEST['searchForm']['dateTo'])) . "'";
            } else if ($_REQUEST['searchForm']['dateFrom'] == $_REQUEST['searchForm']['dateTo'] && $_REQUEST['searchForm']['dateTo'] != "") {
                $date = " t.created_date like '" . date("Y-m-d", strtotime($_REQUEST['searchForm']['dateFrom'])) . "%'";
            } else if (isset($_REQUEST['searchForm']['dateFrom']) == true && $_REQUEST['searchForm']['dateFrom'] != "") {
                $date = " t.created_date >= '" . date("Y-m-d", strtotime($_REQUEST['searchForm']['dateFrom'])) . "'";
            } else if (isset($_REQUEST['searchForm']['dateTo']) == true && $_REQUEST['searchForm']['dateTo'] != "") {
                $date = " date(t.created_date) <= '" . date("Y-m-d", strtotime($_REQUEST['searchForm']['dateTo'])) . "'";
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
 if (isset($_REQUEST['region']) && $_REQUEST['region'] > 0)
        {
            if ($flag == false) {
                $where.=" and ";
            }
            $where .= "  t.region_id =".$_REQUEST['region'];
            $flag = false;
                    
        }
        if (isset($_REQUEST['helpdesk']) && $_REQUEST['helpdesk'] > 0)
        {
            if ($flag == false) {
                $where.=" and ";
            }
            $where .= "  t.helpdesk_id =".$_REQUEST['helpdesk'];
            $flag = false;
        }
        if (isset($_REQUEST['engineer']) && $_REQUEST['engineer'] > 0)
        {
            if ($flag == false) {
                $where.=" and ";
            }
            $where .= "  t.engineer_id =".$_REQUEST['engineer'];
            $flag = false;
        }
        if (isset($_REQUEST['ticket_status']) && $_REQUEST['ticket_status'] !='')
        {
            
            if ($flag == false) {
                $where.=" and ";
            }
            $where .= "  t.ticket_status ='".$_REQUEST['ticket_status']."'";
            $flag = false;
        }
        if (isset($_REQUEST['searchForm']['customer']) && $_REQUEST['searchForm']['customer'] > 0)
        {
            if ($flag == false) {
                $where.=" and ";
            }
            $where .= "  t.user_id =".$_REQUEST['searchForm']['customer'];
            $flag = false;
        }
        if($where!="")
        {
            $where1 =  " where ".$where;
        }else{
            $where1="";
        }
        
        $sql="select t.id,u.id as user_id,t.subject,t.serial_no,t.image_name,t.created_date,t.description,t.status,t.sort_order,u.name,h.name as helpdesk_name,r.name as region_name,t.ticket_status,t.engineer_id,(select name from dtm_user where id=t.engineer_id)as engineer_name,IF(t.close_date!='0000-00-00',t.close_date,'-')as close_date from dtm_ticket as t inner join dtm_user as u on u.id=t.user_id left join dtm_region as r on r.id=t.region_id left join dtm_helpdesk as h on h.id=t.helpdesk_id ".$where1."  order by  FIELD(t.ticket_status,'open','inprogress','hold','closed','closedwithoutreport'),t.created_date desc,t.id desc ";
        $result=DB::query($sql);
        if(count($result) > 0)
       {
           foreach($result as $key=>$value)
           {
              if($value['image_name']!='' && file_exists(URI::getAbsMediaPath(CFG::$ticketDir) . "/" . $value['image_name']))
               {
               $image= CFG::$livePath . "/media/". CFG::$ticketDir . "/" . $value['image_name'];
               }else
               {
                    $image= "";
               }
               fputcsv($output, array($value['id'],$value['subject'], strip_tags($value['description']), $value['ticket_status'], $value['name'], $value['engineer_name'],$value['region_name'], $value['helpdesk_name'], $value['serial_no'],$image,$value['created_date'],$value['close_date']));
           }
       }
        fclose($output);
        if(isset($_REQUEST['filenamedata'])) {
         if( file_exists(URI::getAbsMediaPath()."/".CFG::$ticketDir ."/".$_REQUEST['filenamedata']) ) {
                unlink(URI::getAbsMediaPath()."/".CFG::$ticketDir ."/".$_REQUEST['filenamedata']);
               // $response['status'] = true;
                exit;
            }
     }
         if(isset($_REQUEST['ajax']) && $_REQUEST['ajax']==true){
             echo $csvName;exit;
         }
exit;
     //   print_r($result);exit;
    }
    
}   

?>
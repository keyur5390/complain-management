<?php 
	//restrict direct access to the category
	defined( 'DMCCMS' ) or die( 'Unauthorized access' );

        Class Report
        {
            /**
            * constructor of class category. do initialization
            *
            * @author Bhavin Lunagariya <bhavin.datatech@gmail.com>
            */

            function __construct()
            {
                // load model
                Load::loadModel("report");
                
            }

            /**
            * List of all the ticket
            *
            * @author Bhavin Lunagariya <bhavin.datatech@gmail.com>
            */
            function report_ticket_list()
            {
                //Create model object
                $ticketObj=new ReportModel();
                //get category listing
                $ticketObj->getTicketList("ticket");
                
                //load region model
                Load::loadModel("region","mod_region");
                Load::loadModel("user","mod_user");
                
                //create region object
                $regionObj=new RegionModel();
                //get all region
                $data['region']=$regionObj->getAllRegion();
                
                //create user object
                $userObj=new UserModel();
                $data['engineer']=$userObj->getAllEngineer();
                
                $data['customer']=$userObj->getAllCustomer();
                
                //load helpdesk model
                Load::loadModel("helpDesk","mod_helpDesk");
        
                
                //create helpdesk object
                $helpdeskObj=new HelpDeskModel();
                //get all helpdesk
                $data['helpdesk']=$helpdeskObj->getAllHelpDeskData();
               
                $jsData = Layout::bufferContent(URI::getAbsModulePath()."/js/ticket.php");
                
                //create javascript variable for ajax url
                Layout::addFooter($jsData);

                //render layout
                Layout::renderLayout($data);
                
            }
            /**
            * List of all the ticket
            *
            * @author Bhavin Lunagariya <bhavin.datatech@gmail.com>
            */
            function report_customer_list()
            {
                
                if(isset($_REQUEST['action']) && $_REQUEST['action'] = 'getTicketDetails' && $_REQUEST['user_id'] != "")
                {
                       
                        $ticketObj=new TicketModel();
                        
                        echo $ticketObj->getTicketDetails();
                        exit;
                }
                else
                {
                    //Create model object
                    $ticketObj=new TicketModel();
                    //get category listing
                    $ticketObj->getTicketList("customer");

                    //load region model
                    Load::loadModel("region","mod_region");


                    //create region object
                    $regionObj=new RegionModel();
                    //get all region
                    $data['region']=$regionObj->getAllRegion();

                    //load helpdesk model
                    Load::loadModel("helpDesk","mod_helpDesk");


                    //create helpdesk object
                    $helpdeskObj=new HelpDeskModel();
                    //get all helpdesk
                    $data['helpdesk']=$helpdeskObj->getAllHelpDeskData();

                    $jsData = Layout::bufferContent(URI::getAbsModulePath()."/js/customer.php");

                    //create javascript variable for ajax url
                    Layout::addFooter($jsData);

                    //render layout
                    Layout::renderLayout($data);

                }
               
            }
            
            function send_email() {
                //    Load::loadModel("product");
                    $model = new ReportModel();
                    if (isset($_REQUEST['send_mail'])) {
                       // $model->exportReport(2);
                        $model->sendMail();
                        echo "mail sent";
                        exit;
                    }
                }
            function export_report() {
                //    Load::loadModel("product");
                    $model = new ReportModel();
                   // if (isset($_REQUEST['send_mail'])) {
                        $model->exportReport(1);
                       // echo "mail sent";
                        exit;
                   // }
                }
           
            
           
 }
?>
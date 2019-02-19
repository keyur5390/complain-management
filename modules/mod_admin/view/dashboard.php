<?php
//restrict direct access to the page
defined('DMCCMS') or die('Unauthorized access');
// Load helper file
//print_r($data);exit;
//Load::loadHelper("admin", APP::$moduleName);

// create object of helper
$adminHelper = new AdminHelper();
//echo "<pre>";
$summary = $data['data'][0]['final_graph']['summary'];
//print_r($data['data'][0]);exit;
if (trim($summary) != "") {
    $summary = explode("@@@", $summary);
}
//  echo "<pre>";
//print_r($summary);
?>

<section>
    <div class="container-fluid">
        <div class="row">

            <!-- Dashboard left part start -->
          <?php /*?>      <div class="dashLeft">
                <div class="dashRow clearDiv openAccdiv">
                    <div class="titleDiv">
                        <i class="fa fa-file-text-o"></i>
                        <span class="titSpan">Ticket</span>
                    </div>

                    <div class="rowBtm clearDiv">
                        <div class="btmInner">
                            <div class="enQsel">	
                                <select  id="showGraphdata" class="selectBox" >
                                    <option value="All Ticket">All Ticket</option>
                                    <?php
                                    foreach(CFG::$ticketStatusArray as $key=>$value)
                                    {?>
                                        <option value="<?php echo $value;?>"><?php echo $value;?></option>
                                   <? }
                                    ?>
                                </select>
                            </div>

                            <ul class="tabUl">	
                                <li title="All Ticket" class="trans current" data-tab="allTicket">All Ticket</li>

                            </ul>   

                            <div class="tabMain">
                                <div class="accMain">All Ticket</div>
                                <div id="allTicket" class="accDiv tabDiv current">
                                    <div id="allTicketchart" style="width:100%;height:250px;"></div> 
                                </div>

                            </div>

                        </div>
                    </div>

                </div>                 
            </div> <?php */?>
            <!-- Dashboard left part start -->


            <!-- Dashboard right part start -->
    <?php /*?>        <div class="dashRight">
                <div class="dashRow clearDiv">
                    <div class="titleDiv">
                        <i class="fa fa-file-text-o"></i>
                        <span class="titSpan">Ticket Summary</span>
                    </div>
                    <div class="rowBtm clearDiv">
                        <div class="btmInner">
                            <ul class="tabUl">	
<!--                                <li title="Unread Ticket" class="trans current" data-tab="unread">Unread Ticket</li>-->

                                <!-- Its Name Only Change But Method Name Not Change And Work As Ticket Status Wise -->
                                <li title="Unread Ticket" class="trans current" data-tab="unread">Ticket Status</li> 
                                <li title="Recent Ticket" class="trans" data-tab="recent">Recent Ticket</li>
                            </ul>

                            <div class="tabMain">

                                <div class="accDiv tabDiv current" id="unread">
                                    <div class="enQsel">	
                                        <select class="selectBox" id="unreadUlData"  data-trigger="focus"  data-title="Ticket Type" rel="popover" data-placement="right" data-content="Select ticket status." >
                                            <option value="All">All Ticket</option>
                                            <?php
//                                            foreach(CFG::$ticketStatusArray as $key=>$value)
//                                            {?>
                                                <!--<option value="<?php // echo $value;?>"><?php // echo $value;?></option>-->
                                           <? // }
                                            ?>
                                        </select>
                                    </div>                                
                                    <div id="gridBlock">
                                        <!-- loader -->
                                        <div class="qLoverlay-new"></div>
                                        <div class="qLbar-new"></div>
                                        <!-- loader -->
                                        <form id="frmGrid" class="scrForm">
                                            <ul class="table tableu" id="checkAll">
                                                <li class="topLi">
                                                    <div class="hashBox">#</div>
                                                    <div id="user_name" class="sort">Customer Name</div>
                                                    <div id="subject" class="sort">Subject</div>
                                                    <div id="engineer_id" class="sort">Engineer</div>
                                                    <div id="region_id" class="sort">Region</div>
                                                    <div id="helpdesk_id" class="sort">HelpDesk</div>
                                                    <div id="created_date" class="sort">Created Date</div>
                                                </li>

                                            </ul>
                                        </form>
                                    </div>
                                    <div id="noGrid" class="content hideBlock" >
                                        Ticket records not found
                                    </div> 
                                </div>

                                <div class="accDiv tabDiv" id="recent">
                                    <!--
                                    <div class="enQsel">	
                                        <select class="selectBox" id="recentUlData"  data-trigger="focus"  data-title="Ticket status" rel="popover" data-placement="right" data-content="Select ticket status." >
                                            <option value="All">All Ticket</option>
                                        </select>                                        
                                    </div>
                                    -->
                                    <div id="gridBlock">
                                        <!-- loader -->
                                        <div class="qLoverlay-new"></div>
                                        <div class="qLbar-new"></div>
                                        <!-- loader -->
                                        <form id="frmGrid" class="scrForm">
                                            <ul class="table tabler" id="checkAll">
                                                <li class="topLi">
                                                    <div class="hashBox">#</div>
                                                    <div id="user_name" class="sort">Customer Name</div>
                                                    <div id="subject" class="sort">Subject</div>
                                                    <div id="engineer_id" class="sort">Engineer</div>
                                                    <div id="region_id" class="sort">Region</div>
                                                    <div id="helpdesk_id" class="sort">HelpDesk</div>
                                                    <div id="created_date" class="sort">Created Date</div>
                                                </li>

                                            </ul>
                                        </form>
                                    </div>

                                    <div id="noGrid" class="content hideBlock" >
                                        Ticket records not found
                                    </div>

                                </div>
                            </div>

                        </div>    
                    </div>
                </div>
            </div> <?php */?>
            <!-- Dashboard right part end -->
            
        </div>
    </div>
</section>



<script language="javascript" type="text/javascript">
    //alert("hfd");
<?php // echo Stringd::createJsObject("final_graph", $data['data']['final_graph']); ?>
</script>
<?php
//restrict direct access to the testimonial
defined('DMCCMS') or die('Unauthorized access');

                                  
?><section>
    <div class="midTop">
        <div class="container-fluid">
            <div class="row">
                <div class="fullColumn">
                    <div class="topLeft">
                        <div class="pageTitle blc-<?php echo APP::$moduleRecord['icon_class']; ?>"><span>Ticket List</span></div>
                       
                    </div>
                    <div class="topRight">
                        <?php if(Core::hasAccess(APP::$moduleName, "delete_ticket")) { ?>
                            <div class="dropbox bulkDrop">
                                
                                <select title="Please select actions">
                                    <option value="">Actions</option>
                                    
                                    <?php /*if(Core::hasAccess(APP::$moduleName, "change_status")) { ?>
                                    <option value="" onclick="changeStatus('index.php?m=mod_ticket&a=change_status', '', '1')">Active</option>
                                    <option value="" onclick="changeStatus('index.php?m=mod_ticket&a=change_status', '', '0')">Inactive</option>
                                    <?php }*/?>
                                    
                                    <?php if(Core::hasAccess(APP::$moduleName, "delete_ticket")) { ?>
                                    <option value="" onclick="deleteRecord('index.php?m=mod_ticket&a=delete_ticket', '')">Delete</option>
                                    <?php }?>
                                    
                                </select>     
                                
                            </div>
                            <?php }?>                            
                            
                    </div>
                    <div class="topRight custSearchRight leftAlign">
                        
                        <div class="topRight" style="margin-right:0px;">
                            
                            <?php 
                            if(isset($_SESSION['user_login']) && $_SESSION['user_login']['roll_id']=='1'){?>
                        <form id="frmSearchHelpDesk">
                            <div class="customeSearch">
                            <div class="dropbox" style="width:100%">
                                <select title="Please select helpdesk" id="searchByHelpDesk" name="helpdesk"  >
                                    <option value="">Select HelpDesk</option>
                                    <?php
                                   
                                    foreach($data['helpdesk'] as $key=>$value)
                                    {?>
                                        <option value="<?php echo $value['id'];?>"><?php echo $value['name'];?></option>
                                    <?php }
                                    ?>
                                </select>                        	
                            </div>
                            </div>
                        </form>
                            <?php }?>
                        <form id="frmSearchRegion">
                            <div class="customeSearch">
                            <div class="dropbox " style="width:100%">
                                <select title="Please select region" id="searchByRegion" name="region"  >
                                    <option value="">Select Region</option>
                                    <?php
                                   
                                    foreach($data['region'] as $key=>$value)
                                    {?>
                                        <option value="<?php echo $value['id'];?>" <?php if($value['parent_region']=='0'){?>disabled="true"<?} ?>><?php echo $value['name'];?></option>
                                    <?php }
                                    ?>
                                </select>                        	
                            </div>
                            </div>
                        </form>
                           
                        </div>
                        <div class="topRight">
                        <form id="searchForm" >

                            
                            <div class="cust_searchBox">	
                                <div class="customeSearch">
                                    <?php 
                                    if(isset($_SESSION['user_login']) && $_SESSION['user_login']['roll_id']!='7'){?>
                                    <input type="text" id="customer_name" name="searchForm[customer_name]" class="txt" title="Search Customer" placeholder="Search Customer" />
                                    <?php }
                                    else
                                    {?>
                                        <input type="text" id="ticket_subject" name="searchForm[ticket_subject]" class="txt" title="Search Ticket Subject" placeholder="Search Ticket Subject" />
                                    <?}
                                    ?>
                                    
                                    
                                </div>
                                <div class="customeDate">
                                    <input  type="text" name="searchForm[dateFrom]" id="txtDFrom" class="txt " maxlength="85" data-content="Select from date" data-placement="top" rel="popover" data-title="From date" data-trigger="focus" readonly="readonly" title="From date" placeholder="From date">
                                </div>
                                <div class="customeDate">
                                    <input  type="text" name="searchForm[dateTo]" id="txtDTo" class="txt " maxlength="85" data-content="Select to date" data-placement="top" rel="popover" data-title="To date" data-trigger="focus" readonly="readonly" title="To date" placeholder="To date" >
                                </div>
                                 <button class="btn" type="submit" data-title="Search form">Search</button>
                                <!--<button class="trans searchIcon" type="submit" ></button>-->
							</div>
                            <a href="javascript:;" title="Search" class="searchBtn">Search</a>
                            <input type="reset" value="Reset" title="Reset" class="trans resetBtn" onclick="resetForm()">
                            
                            
                        </form>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
        if(isset($_SESSION['message']))
        {
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ?>
    <div class="tableBox" id="gridBlock">
        <div class="container-fluid">
            <!-- loader -->
            <div class="qLoverlay-new"></div>
            <div class="qLbar-new"></div>
            <!-- loader -->
            <div class="row">
                <div class="fullColumn">
                    <form id="frmGrid">
                        <ul class="table">
                            <li class="topLi">
                                <div class="chekMain">
                                    <div class="chkInn">
                                        <label>
                                            <input type="checkbox" id="masterCh" name="status" value="all" class="checkbox" />
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="hashBox">Sr #</div>
                                <?php  if(isset($_SESSION['user_login']) && $_SESSION['user_login']['roll_id']!='7'){?><div id="name" class="sorting sort"><span>Customer</span></div><?}else{?><div id="subject" class="sorting sort"><span>Subject</span></div><?}?>
                                <div id="ticket_status" class="sorting sort"><span>Ticket Status</span></div>
                                <div id="region_id" class="sorting sort"><span>Region</span></div>
                                <div id="u.helpdesk_id" class="sorting sort"><span>HelpDesk</span></div>
                                 <!--<div id="sort_order" class="sortOrder sorting sort"><span>Sort Order</span></div>
                               <div id="status" class="statusBox sorting sort"><span>Status</span></div>-->
                            </li>
                        </ul>
                    </form>                                
                    <div class="tableBtm">
                        <div class="leftSelect">
<!--                            <div class="dropbox bulkDrop">
                                <select title="Please select actions">
                                    <option value="">Actions</option>
                                    <option value="" onclick="changeStatus('index.php?m=mod_ticket&a=change_status', '', '1')">Active</option>
                                    <option value="" onclick="changeStatus('index.php?m=mod_ticket&a=change_status', '', '0')">Inactive</option>
                                    <option value="" onclick="deleteRecord('index.php?m=mod_ticket&a=delete_ticket', '')">Delete</option>
                                </select>                         	
                            </div>-->

                            <?php if(Core::hasAccess(APP::$moduleName, "delete_ticket")) { ?>
                            <div class="dropbox bulkDrop">
                                
                                <select title="Please select actions">
                                    <option value="">Actions</option>
                                    
                                    <?php /*if(Core::hasAccess(APP::$moduleName, "change_status")) { ?>
                                    <option value="" onclick="changeStatus('index.php?m=mod_ticket&a=change_status', '', '1')">Active</option>
                                    <option value="" onclick="changeStatus('index.php?m=mod_ticket&a=change_status', '', '0')">Inactive</option>
                                    <?php }*/?>
                                    
                                    <?php if(Core::hasAccess(APP::$moduleName, "delete_ticket")) { ?>
                                    <option value="" onclick="deleteRecord('index.php?m=mod_ticket&a=delete_ticket', '')">Delete</option>
                                    <?php }?>
                                    
                                </select>     
                                
                            </div>
                            <?php }?>

                            <div class="dropbox numDrop ">
                                <form id="numOfRecordForm" >
                                    <select class="numOfRecord" name="searchForm[numOfRecord]" title="Please select no. pages">
                                        <option value="10" selected='selected'>10 per page</option>
                                        <option value="20">20 per page</option>
                                        <option value="30">30 per page</option>
                                    </select>                        	
                                </form>
                            </div>

                        </div>
                        <div class="content pagination">
                            <div id="pagingNo" class="recordCount"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="noGrid" class="content noRecord hideBlock"> Ticket records not found </div>
    <div class="mobiAction" style="display:none;">
        <div class="counterDiv">0</div>
        
        <?php if(Core::hasAccess(APP::$moduleName, "delete_ticket")) { ?>
        <option value="" onclick="deleteRecord('index.php?m=mod_ticket&a=delete_ticket', '')">Delete</option>
        <?php }?>
        <button class="closeAction" title="Close"></button>
    </div>
</section>
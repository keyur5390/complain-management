<?php
//restrict direct access to the testimonial
defined('DMCCMS') or die('Unauthorized access');

                                  
?><section>
    <div class="midTop">
        <div class="container-fluid">
            <div class="row">
                <div class="fullColumn">
                    <div class="topLeft">
                        <div class="pageTitle blc-<?php echo APP::$moduleRecord['icon_class']; ?>"><span>Customer Report List</span></div>
                        
                    </div>
                    
                    <div class="topRight custSearchRight">
                        
                       
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
                        
                        <table class="custom-table" width="100%">
                        <thead class="hide-mobile">
                          <tr>
                           
                            <th>Sr #</th>
                            <th id="name" class="sorting sort sort_both"><span>Customer</span></th>
                            <th id="region_id" class="sorting sort sort_both"><span>Region</span></th>
                            <th id="u.helpdesk_id" class="sorting sort sort_both"><span>HelpDesk</span></th>
                            <th  id="action"class="sorting"><span></span></th>
                            
                          </tr>
                        </thead>
                        <tbody>
                          
                        </tbody>
                      </table>
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
    <div id="noGrid" class="content noRecord hideBlock"> Customer report records not found </div>
    <div class="mobiAction" style="display:none;">
        <div class="counterDiv">0</div>
        
        <?php if(Core::hasAccess(APP::$moduleName, "delete_ticket")) { ?>
        <option value="" onclick="deleteRecord('index.php?m=mod_ticket&a=delete_ticket', '')">Delete</option>
        <?php }?>
        <button class="closeAction" title="Close"></button>
    </div>
</section>
<?php
//restrict direct access to the page
defined('DMCCMS') or die('Unauthorized access');
?>

<script>
    function roleFilter(parent) 
    {
        $(parent).attr("data-source","1");
        $(".searchIcon").trigger("click");
    }
</script>
<section>
    <div class="midTop">
        <div class="container-fluid">
            <div class="row">
                <div class="fullColumn">
                    <div class="topLeft">
                        <div class="pageTitle blc-<?php echo APP::$moduleRecord['icon_class']; ?>"><span>station List</span></div>
                        <?php 
                                /* Dynamic Button Call */
                                $actions = array("module" => APP::$moduleName, "action" => "station_edit", "text" => "New station");
                                $buttonData = array("title" => "New station", "class" => "trans addNew");
                                Core::getButtonLink($actions, $buttonData);
                                /* Dynamic Button Call */
                        ?>
                       <!-- </div>-->
                    </div>
                    <div class="topRight ipadShowSrc ipad-right-sec innerpage-form-wrap">
                        <form id="searchForm" class="innerpage-form cust_searchBox ipaid-sec">
                            <?php if (Core::hasAccess(APP::$moduleName, "delete_station")) { ?>
                            <div class="dropbox bulkDrop">
                                <select title="Please select actions">
                                    <option value="">Actions</option>
                                    <option value="" onclick="changeStatus('index.php?m=mod_station&a=change_status', '', '1')">Active</option>
                                    <option value="" onclick="changeStatus('index.php?m=mod_station&a=change_status', '', '0')">Inactive</option>
                                    <option value="" onclick="deleteRecord('index.php?m=mod_station&a=delete_station', '')">Delete</option>
                                </select>                        	
                            </div>
                            <?php } ?>
                            
                            <div class="dropbox searchBox">
                                <select name="searchForm[helpDesk]" id="helpDesk" title="Select Help Desk" onchange='roleFilter(this);' data-source="0">
                                </select>                                            	
                            </div>

                            <div class="searchBox">
                                <input type="text" id="name" name="searchForm[name]" class="txt" title="Search by station" placeholder="Search by station" value=""/>
                            </div>
                            <button id="filterSearch" title="Search" type="submit" class="btn">Search</button>
                            <input type="reset" value="Reset" title="Reset" class="trans resetBtn" onclick="resetForm()">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                            <thead>
                                <tr>
                                    <?php if(Core::hasAccess(APP::$moduleName, "delete_station")) { ?>
                                    <th class="chekMain">
                                        <div class="chkInn">
                                            <label>
                                                <input type="checkbox" id="masterCh" name="status" value="all" class="checkbox">
                                                <span></span> 
                                            </label>
                                        </div>
                                    </th>
                                    <?php } ?>
                                    <th>#</th>
                                    <th id="name" class="sorting sort"><span>station Name</span></th>
                                    <th id="parent_station" class="sorting sort"><span>Parent station Name</span></th>
                                    <th id="helpDesk"><span>Help Desk</span></th>
                                    <th id="sort_order" class="sortOrder sorting sort"><span>Sort Order</span></th>
                                    <th id="status" class="sorting sort"><span>Status</span></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </form>                                
                    <div class="tableBtm">
                        <div class="leftSelect">
                            <?php if (Core::hasAccess(APP::$moduleName, "delete_station")) { ?>
                            <div class="dropbox bulkDrop">
                                <select title="Please select actions">
                                    <option value="">Actions</option>
                                    <option value="" onclick="changeStatus('index.php?m=mod_station&a=change_status', '', '1')">Active</option>
                                    <option value="" onclick="changeStatus('index.php?m=mod_station&a=change_status', '', '0')">Inactive</option>
                                    <option value="" onclick="deleteRecord('index.php?m=mod_station&a=delete_station', '')">Delete</option>
                                </select>                         	
                            </div>
                            <?php } ?>

                            <div class="dropbox numDrop ">
                                <form id="numOfRecordForm" >
                                    <select class="numOfRecord" name="searchForm[numOfRecord]" title="Please select no. pages">
                                        <!--<option value="">No. Pages</option>-->
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
    <div id="noGrid" class="content noRecord hideBlock">station records not found</div>
    <?php if(Core::hasAccess(APP::$moduleName, "delete_station")) { ?>
    <div class="mobiAction" style="display:none;">
        <div class="counterDiv">0</div>
        <a href="#" onclick="changeStatus('index.php?m=mod_station&a=change_status', '', '1')" title="Active" class="activeStatus"></a>
        <a href="#" onclick="changeStatus('index.php?m=mod_station&a=change_status', '', '0')" title="Inactive" class="inactiveStatus"></a>
        <a href="#" onclick="deleteRecord('index.php?m=mod_station&a=delete_station', '')" title="Delete" class="delIcon">Delete</a>
        <button class="closeAction" title="Close"></button>
    </div>
    <?php } ?>
</section>
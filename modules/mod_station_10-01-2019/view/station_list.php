<?php
//restrict direct access to the testimonial
defined('DMCCMS') or die('Unauthorized access');
?>
<script>
    function parentFilter(parent) {
        //console.log(parent.value);
        $(parent).attr("data-source", "1");

    }
</script>
<section>
    <div class="midTop">
        <div class="container-fluid">
            <div class="row">
                <div class="fullColumn">
                    <div class="topLeft">
                        <div class="pageTitle blc-<?php echo APP::$moduleRecord['icon_class']; ?>"><span>station List</span></div>
                        <a href="<?php echo URI::getURL(APP::$moduleName, "station_edit"); ?>" class="trans addNew" title="New station">New station</a>
                    </div>
                    <div class="topRight">
                        <div class="dropbox bulkDrop">
                            <select title="Please select actions">
                                <option value="">Actions</option>
                                <option value="" onclick="changeStatus('index.php?m=mod_station&a=change_status', '', '1')">Active</option>
                                <option value="" onclick="changeStatus('index.php?m=mod_station&a=change_status', '', '0')">Inactive</option>
                                <option value="" class="hideDeleteOption" onclick="deleteRecord('index.php?m=mod_station&a=delete_station', '')">Delete</option>
                            </select>                        	
                        </div>
                        <form id="searchForm">
                            <div class="cust_searchBox searchBox">

                                
                                <div class="customeSearch">
                                    <input type="text" id="name" name="searchForm[name]" class="txt" title="Search station name" placeholder="Search station name" />
                                </div>
                                <button data-title="Search form" type="submit" title="Search" class="btn searchIcon1">Search</button>

                            </div>
                            <a href="javascript:;" title="Search" class="searchBtn">Search</a>
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
                        <ul class="table">
                            <li class="topLi">
<?php if (isset($_SESSION['user_login']) && $_SESSION['user_login']['roll_id'] == '1') { ?>
                                    <div class="chekMain">
                                        <div class="chkInn">
                                            <label>
                                                <input type="checkbox" id="masterCh" name="status" value="all" class="checkbox" />
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
<?php } ?>
                                <div class="hashBox">Sr #</div>
                                <div id="name" class="sorting sort"><span>station Name</span></div>
                                <!--<div id="sort_order" class="sortOrder sorting sort"><span>Sort Order</span></div>-->
                                <div id="status" class="statusBox sorting sort"><span>Status</span></div>
                            </li>
                        </ul>
                    </form>                                
                    <div class="tableBtm">
                        <div class="leftSelect">
                            <div class="dropbox bulkDrop">
                                <select title="Please select actions">
                                    <option value="">Actions</option>
                                    <option value="" onclick="changeStatus('index.php?m=mod_station&a=change_status', '', '1')">Active</option>
                                    <option value="" onclick="changeStatus('index.php?m=mod_station&a=change_status', '', '0')">Inactive</option>
                                    <option value="" class="hideDeleteOption" onclick="deleteRecord('index.php?m=mod_station&a=delete_station', '')">Delete</option>
                                </select>                         	
                            </div>

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
    <div id="noGrid" class="content noRecord hideBlock"> station records not found </div>
    <div class="mobiAction" style="display:none;">
        <div class="counterDiv">0</div>
        <a href="#" onclick="changeStatus('index.php?m=mod_station&a=change_status', '', '1')" title="Active" class="activeStatus"></a>
        <a href="#" onclick="changeStatus('index.php?m=mod_station&a=change_status', '', '0')" title="Inactive" class="inactiveStatus"></a>
        <a href="#" onclick="deleteRecord('index.php?m=mod_station&a=delete_station', '')" title="Delete" class="delIcon hideDeleteOption">Delete</a>
        <button class="closeAction" title="Close"></button>
    </div>
</section>
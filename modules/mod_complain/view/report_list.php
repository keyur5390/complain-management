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
                        <div class="pageTitle blc-<?php echo APP::$moduleRecord['icon_class']; ?>"><span>complain List</span></div>
                        
                        <a href="#" onclick="exportlist()" class="trans addNew" title="Export">Export</a>
                        
                    </div>
                   
                    <div class="topRight">
                   
                        <form id="searchForm">
                            <div class="cust_searchBox searchBox">

                                <div class="customeSearch">
                                    <select name="searchForm[complain_type]" id="complain_type" ><option value="">Select Complain Type</option>
                                        <?php 
                                                // print_r($data);
                                                foreach($data['complainType'] as $key=>$val){?>
                                                <option value="<?php echo $val['id'];?>"><?php echo $val['name'];?></option>
                                                <?php }?>
                                    </select>
                                </div>
                                <div class="customeSearch">
                                    <select name="searchForm[station_name]" id="station_name"><option value="">Select Station Name</option>
                                        <?php 
                                                // print_r($data);
                                                foreach($data['stationName'] as $key=>$val){?>
                                                <option value="<?php echo $val['id'];?>"><?php echo $val['name'];?></option>
                                                <?php }?>
                                    </select>
                                </div>
                                <div class="customeSearch">
                                    <select name="searchForm[department_name]" id="department_name"><option value="">Select Department Name</option>
                                        <?php 
                                                // print_r($data);
                                                foreach($data['departmentName'] as $key=>$val){?>
                                                <option value="<?php echo $val['id'];?>"><?php echo $val['name'];?></option>
                                                <?php }?>
                                    </select>
                                </div>
                                <br/>
                                <br/>
                                <br/>
                                <br/>
                                <div class="customeSearch">
                                    <input type="text" id="name" name="searchForm[name]" class="txt" title="Search complain name" placeholder="Search complain name" /></div> <div class="customeSearch">
                                        <input type="text" id="date_from" name="searchForm[date_from]" class="txt" value="" title="Search date from" placeholder="Search date from" /></div> <div class="customeSearch">
                                            <input type="text" id="date_to" name="searchForm[date_to]" class="txt" value="" title="Search date to" placeholder="Search date to" />
                                </div>
                                <button data-title="Search form" type="submit" title="Search" class="btn searchIcon1">Search</button>
<input type="reset" value="Reset" title="Reset" class="trans resetBtn" onclick="resetForm()">
                            </div>
                            <a href="javascript:;" title="Search" class="searchBtn">Search</a>
                            
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
                            <?php if(!isset($_REQUEST['type']) && $_REQUEST['type']==''){?>        <div class="chekMain">
                                        <div class="chkInn">
                                            <label>
                                                <input type="checkbox" id="masterCh" name="status" value="all" class="checkbox" />
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
<?php } ?>
<?php } ?>
                                <div class="hashBox">Sr #</div>
                                <div class="">Date</div>
                                <div id="name" class="sorting sort"><span>complain Name</span></div>
                                <div id="dealer" class=""><span>Complain Dealer</span></div>
                                <div id="dealer" class=""><span>Complain Type</span></div>
                                <div id="dealer" class=""><span>Station</span></div>
                                <div id="dealer" class=""><span>Equipment Type</span></div>
                                <div id="dealer" class=""><span>Assets</span></div>
                                <div id="dealer" class=""><span>Asset Extra</span></div>
                                <!--<div id="sort_order" class="sortOrder sorting sort"><span>Sort Order</span></div>-->
                                <div id="status" class=""><span>Priority</span></div>
                                <div id="status" class=""><span>Complain Receive Time</span></div>
<!--                                <div id="status" class=""><span>Reach Time</span></div>-->
                            </li>
                        </ul>
                    </form>                                
                    <div class="tableBtm">
                        <div class="leftSelect">
                            <?php if(!isset($_REQUEST['type']) && $_REQUEST['type']==''){?><div class="dropbox bulkDrop">
                                <select title="Please select actions">
                                    <option value="">Actions</option>
                                    <option value="" onclick="changeStatus('index.php?m=mod_complain&a=change_status', '', '1')">Active</option>
                                    <option value="" onclick="changeStatus('index.php?m=mod_complain&a=change_status', '', '0')">Inactive</option>
                                    <option value="" class="hideDeleteOption" onclick="deleteRecord('index.php?m=mod_complain&a=delete_complain', '')">Delete</option>
                                </select>                         	
                            </div><?php }?>

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
    <div id="noGrid" class="content noRecord hideBlock"> complain records not found </div>
    <?php if(!isset($_REQUEST['type']) && $_REQUEST['type']==''){?><div class="mobiAction" style="display:none;">
        <div class="counterDiv">0</div>
        <a href="#" onclick="changeStatus('index.php?m=mod_complain&a=change_status', '', '1')" title="Active" class="activeStatus"></a>
        <a href="#" onclick="changeStatus('index.php?m=mod_complain&a=change_status', '', '0')" title="Inactive" class="inactiveStatus"></a>
        <a href="#" onclick="deleteRecord('index.php?m=mod_complain&a=delete_complain', '')" title="Delete" class="delIcon hideDeleteOption">Delete</a>
        <button class="closeAction" title="Close"></button>
    </div><?php }?>
</section>
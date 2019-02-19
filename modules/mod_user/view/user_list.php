<?php
//restrict direct access to the page
defined('DMCCMS') or die('Unauthorized access');
?>
<script>
    function roleFilter(parent) {
        $(parent).attr("data-source", "1");
        $(".searchIcon").trigger("click");
    }
</script>

<section>
    <div class="midTop">
        <div class="container-fluid">
            <div class="row">
                <div class="fullColumn">
                    <div class="topLeft">
                        <div class="pageTitle blc-<?php echo APP::$moduleRecord['icon_class']; ?>"><span>User List</span></div>
                        <a href="index.php?m=mod_user&a=user_edit" class="trans addNew" title="New User">New User</a>
                    </div>
                    <div class="topRight riCatMain ipadShowSrc">

                        <div class="dropbox bulkDrop">
                            <select title="Please select actions">
                                <option value="">Actions</option>
                                <option value="" onclick="changeStatus('index.php?m=mod_user&a=change_status', '', '1')">Active</option>
                                <option value="" onclick="changeStatus('index.php?m=mod_user&a=change_status', '', '0')">Inactive</option>
                                <?php if (Core::hasAccess(APP::$moduleName, "delete_user")) { ?>
                                    <option value="" class="hideDeleteOption" onclick="deleteRecord('index.php?m=mod_user&a=delete_user', '')">Delete</option>
                                <?php } ?>
                            </select>                        	
                        </div>

                        <form id="searchForm">
                            <div class="cust_searchBox searchBox">
                                <div class="dropbox" style="margin:0 15px 0 0px;">
                                    <select name="searchForm[role]" id="selRole" title="User Role" onchange='roleFilter(this);' data-source="0">
                                    </select>                      	
                                </div>
                                <div class="customeSearch">
                                    <input type="text" id="user_name" name="searchForm[user_name]" class="txt" title="Search by name, username or email" placeholder="Search by name, username or email" value=""/>

                                </div>

                                <!--                            <a href="javascript:;" title="Search" class="searchBtn">Search</a>-->
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
                                <div class="chekMain">
                                    <div class="chkInn">
                                        <label>
                                            <input type="checkbox" id="masterCh" name="status" value="all" class="checkbox" />
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="hashBox">#</div>
                                <div id="name" class="sorting sort"><span>Name</span></div>
                                <div id="username" class="sorting sort"><span>Username</span></div>
                                <div id="roll_id" class="sorting sort"><span>Role</span></div>
                                <div id="email" class="sorting sort"><span>Email</span></div>
                                <div id="phone" class="sorting sort"><span>Phone</span></div>
<!--                                <div id="created_by" class="sorting sort"><span>Created By</span></div>
                                <div id="updated_by" class="sorting sort"><span>Updated By</span></div>-->
                                <div id="active" class="statusBox sorting sort"><span>Status</span></div>
                            </li>
                        </ul>
                    </form>                                
                    <div class="tableBtm">
                        <div class="leftSelect">
                            <div class="dropbox bulkDrop">
                                <select title="Please select actions">
                                    <option value="">Actions</option>
                                    <option value="" onclick="changeStatus('index.php?m=mod_user&a=change_status', '', '1')">Active</option>
                                    <option value="" onclick="changeStatus('index.php?m=mod_user&a=change_status', '', '0')">Inactive</option>
                                    <option value="" onclick="deleteRecord('index.php?m=mod_user&a=delete_user', '')">Delete</option>
                                </select>                         	
                            </div>

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
    <div id="noGrid" class="content noRecord hideBlock">User records not found</div>
    <div class="mobiAction" style="display:none;">
        <div class="counterDiv">0</div>
        <a href="#" onclick="changeStatus('index.php?m=mod_user&a=change_status', '', '1')" title="Active" class="activeStatus"></a>
        <a href="#" onclick="changeStatus('index.php?m=mod_user&a=change_status', '', '0')" title="Inactive" class="inactiveStatus"></a>
        <a href="#" onclick="deleteRecord('index.php?m=mod_user&a=delete_user', '')" title="Delete" class="delIcon">Delete</a>
        <button class="closeAction" title="Close"></button>
    </div>
</section>
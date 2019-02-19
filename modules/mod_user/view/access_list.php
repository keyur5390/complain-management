<?php
//restrict direct access to the User
defined('DMCCMS') or die('Unauthorized access');
?>
<section>
    <div class="midTop">
        <div class="container-fluid">
            <div class="row">
                <div class="fullColumn">
                    <div class="topLeft">
                        <div class="pageTitle blc-<?php echo APP::$moduleRecord['icon_class']; ?>"><span>User</span></div>
                        <a href="index.php?m=mod_user&a=access_edit" class="trans addNew" title="Add new">Add new</a>
                    </div>
                    <div class="topRight">
                        <form id="searchForm" >
                            <div class="dropbox bulkDrop">
                                <select title="Please select actions">
                                    <option value="">Actions</option>
                                    <option value="" onclick="deleteRecord('index.php?m=mod_user&a=access_delete', '')">Delete</option>
                                </select>                        	
                            </div>

                            <div class="searchBox">
                                <input type="text" id="name" name="searchForm[name]" class="txt" title="Search role" placeholder="Search role" />
                                <button class="trans searchIcon" type="submit" ></button>
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
            <div class="row">
                <div class="fullColumn">
                    <!-- loader -->
                    <div class="qLbar-new showProcess"></div>
                    <!-- loader -->
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
                            </li>
                        </ul>
                    </form>                                
                    <div class="tableBtm">
                        <div class="leftSelect">
                            <div class="dropbox bulkDrop">
                                <select title="Please select actions">
                                    <option value="">Actions</option>
                                    <option value="" onclick="deleteRecord('index.php?m=mod_user&a=access_delete', '')">Delete</option>
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
    <div id="noGrid" class="content noRecord hideBlock"> User records not found </div>
    <div class="mobiAction" style="display:none;">
        <div class="counterDiv">0</div>
        <a href="#" onclick="deleteRecord('index.php?m=mod_user&a=access_delete', '')" title="Delete" class="delIcon">Delete</a>
        <button class="closeAction" title="Close"></button>
    </div>
</section>
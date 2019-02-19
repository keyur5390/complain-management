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
                        <div class="pageTitle blc-<?php echo APP::$moduleRecord['icon_class']; ?>"><span>Customer List</span></div>
                        
                    </div>
                     <?php if(Core::hasAccess(APP::$moduleName, "import_csv") && CORE::getUserData('roll_id') == 1) { ?>
                    <a href="javascript:;" onclick="csvImport();" class="trans addNew import_file" title="Import CSV">Import CSV</a>
                     <?php } ?>
                    <div class="topRight">
                         
                        <form id="searchForm">
                            <div class="cust_searchBox searchBox">
                                
                                <div class="customeSearch">
                                    <input type="text" id="user_name" name="searchForm[user_name]" class="txt" title="Search by Name,Username And Email" placeholder="Search by Name" />
                                   
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
            <?php
            if (isset($_SESSION['message']) && !empty($_SESSION['message'])) 
            {
                ?>
                    <div><?php echo $_SESSION['message']; 
                    unset($_SESSION['message']);
                    ?></div>
                <?php
            }
            ?>
            <div class="row">
                <div class="fullColumn">
                    <form id="frmGrid">
                        <ul class="table">
                            <li class="topLi">
                                 
                                <div class="hashBox">Sr #</div>
                                <div id="name" class="sorting sort"><span>Name</span></div>
                                <div id="username" class="sorting sort"><span>Username</span></div>
                                 <div id="region" class="sorting sort"><span>Region</span></div>
                                <div id="email" class="sorting sort"><span>Email</span></div>
                                <div id="phone" class="sorting sort"><span>Phone</span></div>
                                 
                            </li>
                        </ul>
                    </form>                                
                    <div class="tableBtm">
                        <div class="leftSelect">
                            

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
    <div id="noGrid" class="content noRecord hideBlock"> User records not found </div>
    <div class="mobiAction" style="display:none;">
        <div class="counterDiv">0</div>
        <a href="#" onclick="changeStatus('index.php?m=mod_user&a=change_status', '', '1')" title="Active" class="activeStatus"></a>
        <a href="#" onclick="changeStatus('index.php?m=mod_user&a=change_status', '', '0')" title="Inactive" class="inactiveStatus"></a>
         <?php if(Core::hasAccess(APP::$moduleName, "delete_user")) { ?>
        <option value="" class="hideDeleteOption" onclick="deleteRecord('index.php?m=mod_user&a=delete_user', '')">Delete</option>
        <?php }?>
        <button class="closeAction" title="Close"></button>
    </div>
</section>
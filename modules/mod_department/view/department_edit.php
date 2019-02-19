<?php
//restrict direct access to the testimonial
defined('DMCCMS') or die('Unauthorized access');

?>

<!-- For Dropdown Suggetion  -->
    <style>
        .progControlSelect2 {
            width: 350px;
        }
        .progControlSelect2_1 {
            width: 350px;
        }
        .progControlSelect2_2 {
            width: 350px;
        }
        form {
            margin-top: 2px;
        }
        .select2-results__option[aria-selected=true] {
        display: none;
        }
    </style>


<!-- For Popup Window Open -->
    <style>
        .dialog_intransit, .container_info_dialog{
            width: 1000px!important;
        } 

        .row{min-height: auto !important;}
    </style>
    
    
<!-- middle section part start -->
<section>
    <!-- page title part start -->
    <div class="midTop">
        <div class="container-fluid">
            <div class="row">
                <div class="fullColumn">
                    <div class="topLeft">
                        <div class="pageTitle blc-<?php echo APP::$moduleRecord['icon_class']; ?>"><span><?php echo isset(APP::$curId) && !empty(APP::$curId) ? "Update" : "Add/Edit" ?> Department</span></div>
                    </div>
                    <div class="topRight btnRight">
                        <ul class="btnUl threeBtn">    
                            <li><a href="<?php echo URI::getURL(APP::$moduleName,"department_list");?>" class="trans comBtn backBtn" title="Back to list">Back to list</a></li>
                            <li><a href="#" id="btnEdit" class="trans comBtn" title="Save & continue edit">Save & continue edit</a></li>
                            <li><a href="#" id="btnSave" class="trans comBtn" title="Save">Save</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>            	
    </div>
    <!-- page title part end -->


    <!-- table part start -->
    <div class="middlePart">
        <div class="container-fluid">
            <div class="row">
                <div class="fullColumn">
                    <div class="midWhite">
                        <div class="tabBox">
                            <ul class="tabUl">
                                <li data-tab="tab-1" class="trans current" title="General">General</li>
                                
                            </ul>
                            <form class="form-horizontal" id="frmdepartment" method="post">
                            <div class="tabMain">
                                <div class="accMain arrowDown">General</div>
                                <div class="accDiv tabDiv current" id="tab-1">
                                    <div class="formBox oneCol">
                                        <input type="hidden" name="edit" id="hdnEdit" value="0" />
                                        <ul class="row">
                                            <li class="halfLi">
                                                <span for="name" class="labelSpan star">Department Name:</span>
                                                <div class="txtBox">
                                                    <input type="text" name="name" id="name" maxlength="100" class="txt required" title="Compalin Name" >
                                                    <small>Maximum character length 100</small>
                                                </div>
                                            </li>
                                            <li class="halfLi">
                                                <span for="code" class="labelSpan">Department Code:</span>
                                                
                                                <div class="txtBox">
                                                    
                                                    <input type="text" name="code" id="code" maxlength="50" class="txt required" maxlength="50" title="station Code" >
                                                    <!--<label id="code_check_status"></label>-->
                                                    <small style="position: static;">Enter Unique station Code</small><small>Maximum character length 50</small>
                                                </div>

                                            </li>
                                            
                                            <li class="halfLi">	
                                                <span class="labelSpan">Status:</span>
                                                <div class="optionBox">
                                                    <div class="chkInn">
                                                        <label>
                                                            <input type="checkbox" class="checkbox">
                                                            <input type="checkbox" class="checkbox" id="chkStatus" name="status" value="1" checked="checked" title="Status" data-content="Status">
                                                            <span></span>
                                                        </label>
                                                        <label for="chkStatus" id="checkAct"></label>
                                                    </div>                                                   
                                                </div>
                                            </li>
                                        </ul>      
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="topRight btmBtn">
                    <ul class="btnUl threeBtn">    
                        <li><a href="<?php echo URI::getURL(APP::$moduleName,"department_list");?>" class="trans comBtn backBtn" title="Back to list">Back to list</a></li>
                        <li><a href="#" id="btnFooterEdit" class="trans comBtn" title="Save & continue Edit">Save & continue Edit</a></li>
                        <li><a href="#" id="btnFooterSave" class="trans comBtn" title="Save">Save</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- table part end -->
</section>
<!-- middle section part end -->
<div class="imgPrt modal fade" role="dialog"></div>

<?php // include CFG::$absPath . '/' . CFG::$helper . "/templates/add_new_parent_department.php"; ?>
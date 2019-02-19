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
                        <div class="pageTitle blc-<?php echo APP::$moduleRecord['icon_class']; ?>"><span><?php echo isset(APP::$curId) && !empty(APP::$curId) ? "Update" : "Add/Edit" ?> Employee</span></div>
                    </div>
                    <div class="topRight btnRight">
                        <ul class="btnUl threeBtn">    
                            <li><a href="<?php echo URI::getURL(APP::$moduleName,"employee_list");?>" class="trans comBtn backBtn" title="Back to list">Back to list</a></li>
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
                            <form class="form-horizontal" id="frmemployee" method="post">
                            <div class="tabMain">
                                <div class="accMain arrowDown">General</div>
                                <div class="accDiv tabDiv current" id="tab-1">
                                    <div class="formBox oneCol">
                                        <input type="hidden" name="edit" id="hdnEdit" value="0" />
                                        <ul class="row">
<!--                                            <li class="halfLi">
                                                <span for="name" class="labelSpan star">Company Dealer:</span>
                                                <div class="txtBox">
                                                    <select name="dealer" id="dealer">
                                                        <option value="">Select Company Dealer</option>
                                                        <?php //foreach(CFG::$companydealerArray as $key=>$val){
                                                            ?>
                                                        <option value="<?php //echo  $key;?>"><?php //echo  $val;?></option>
                                                        <?php //}?>
                                                    </select>
                                                </div>
                                            </li>-->
                                            <li class="halfLi">
                                                <span for="name" class="labelSpan star">Type:</span>
                                                <div class="txtBox">
                                                    <select name="type" id="type">
                                                        <option>Select Type</option>
                                                        <option value="1">Employee</option>
                                                        <option value="2">Vendor</option>
                                                    </select>
                                                </div>
                                            </li>
                                            <li class="halfLi">
                                                <span for="name" class="labelSpan star">Name:</span>
                                                <div class="txtBox">
                                                    <input type="text" name="name" id="name" maxlength="100" class="txt required" title="employee Name" >
                                                    <small>Maximum character length 100</small>
                                                </div>
                                            </li>
                                            <li class="halfLi">
                                                <span for="code" class="labelSpan star">Code:</span>
                                                <div class="txtBox">
                                                    <input type="text" name="code" id="code"  class="txt required" title="Code" >
                                                    
                                                </div>
                                            </li>
                                            <li class="halfLi">
                                                <span for="name" class="labelSpan star">Mobile:</span>
                                                <div class="txtBox">
                                                    <input type="text" name="mobile" id="mobile" maxlength="11" class="txt required" title="Mobile" >
                                                    
                                                </div>
                                            </li>
                                            <li class="halfLi">
                                                <span for="email" class="labelSpan star">Email:</span>
                                                <div class="txtBox">
                                                    <input type="text" name="email" id="email"  class="txt required" title="Email" >
                                                    
                                                </div>
                                            </li>
<!--                                            <li class="halfLi">
                                                <span for="code" class="labelSpan">Station Name:</span>
                                                
                                                <div class="txtBox">
                                                    
                                                   <select id="station" name="station">
                                                        <option value="0">Select Station</option>
                                                        <?php //foreach($data['station'] as  $key=>$val){?>
                                                             <option value="<?php //echo  $val['id'];?>"><?php //echo $val['name'];?></option>
                                                        <?php //}?>
                                                    </select>
                                                </div>

                                            </li>-->
<!--                                            <li class="halfLi">
                                                <span for="parent_asset" class="labelSpan">Type Of Equipment:</span>
                                                <div class="txtBox">
                                                    
                                                    <select id="equipment_type" name="equipment_type">
                                                        <option value="0">Select Type</option>
                                                        
                                                    </select>
                                                </div>
                                            </li>-->
<!--                                            <li class="halfLi">
                                                <span for="code" class="labelSpan">Asset Name</span>
                                                
                                                <div class="txtBox">
                                                    
                                                   <select id="asset" name="asset">
                                                        <option value="0">Select Asset</option>
                                                        <?php //foreach($data['asset'] as  $key=>$val){?>
                                                             <option value="<?php //echo  $val['id'];?>"><?php //echo $val['name'];?></option>
                                                        <?php //}?>
                                                    </select>
                                                </div>

                                            </li>-->
                                            
                                            
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
                        <li><a href="<?php echo URI::getURL(APP::$moduleName,"employee_list");?>" class="trans comBtn backBtn" title="Back to list">Back to list</a></li>
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

<?php // include CFG::$absPath . '/' . CFG::$helper . "/templates/add_new_parent_employee.php"; ?>
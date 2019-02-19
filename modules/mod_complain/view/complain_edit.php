<?php
//restrict direct access to the testimonial
defined('DMCCMS') or die('Unauthorized access');
//print_r($data['complainData']['recived_time']);
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
                        <div class="pageTitle blc-<?php echo APP::$moduleRecord['icon_class']; ?>"><span><?php echo isset(APP::$curId) && !empty(APP::$curId) ? "Update" : "Add/Edit" ?> complain</span></div>
                    </div>
                    <div class="topRight btnRight">
                        <ul class="btnUl threeBtn">    
                            <li><a href="<?php echo URI::getURL(APP::$moduleName,"complain_list");?>" class="trans comBtn backBtn" title="Back to list">Back to list</a></li>
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
                            <form class="form-horizontal" id="frmcomplain" method="post">
                                <input type="hidden" name="forwardC" id="forwardC" value="" />
                            <div class="tabMain">
                                <div class="accMain arrowDown">General</div>
                                <div class="accDiv tabDiv current" id="tab-1">
                                    <div class="formBox oneCol">
                                        <input type="hidden" name="edit" id="hdnEdit" value="0" />
                                        <ul class="row">
                                            <li class="halfLi">
                                                <span for="code" class="labelSpan">Complain Id:</span>
                                                
                                                <div class="txtBox" id="complainId">
                                                    <?php echo APP::$curId;?>
                                                    
                                                </div>

                                            </li>
                                            <li class="halfLi">
                                                <span for="code" class="labelSpan">Complain Type:</span>
                                                
                                                <div class="txtBox">
                                                    <select id="complain_type" name="complain_type">
                                                                <option>Select Complain Type</option>
                                                                <?php 
                                                               // print_r($data);
                                                                 foreach($data['complain_type'] as $key=>$val){?>
                                                                <option value="<?php echo $val['id'];?>"><?php echo $val['name'];?></option>
                                                                <?php }?>
                                                            </select>
                                                    
                                                </div>

                                            </li>
                                            <li class="halfLi">
                                                <span for="name" class="labelSpan star">Company Dealer:</span>
                                                <div class="txtBox">
                                                    <select name="dealer" id="dealer">
                                                        <option value="">Select Company Dealer</option>
                                                        <?php foreach(CFG::$companydealerArray as $key=>$val){
                                                            ?>
                                                        <option value="<?php echo  $key;?>"><?php echo  $val;?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                            </li>
                                            <li class="halfLi">
                                                <span for="name" class="labelSpan star">Station Name:</span>
                                                <div class="txtBox">
                                                    <select name="station" id="station">
                                                        <option value="">Select Station Name</option>
                                                    </select>
                                                </div>
                                            </li>
                                            <li class="halfLi">
                                                <span for="name" class="labelSpan star">Equipment Type:</span>
                                                <div class="txtBox">
                                                    <select name="equipment_type" id="equipment_type">
                                                        <option value="">Select Equipment Type</option>
                                                    </select>
                                                </div>
                                            </li>
                                            <li class="halfLi">
                                                <span for="name" class="labelSpan star">Asset Name:</span>
                                                <div class="txtBox">
                                                    <select name="asset" id="asset">
                                                        <option value="">Select Asset Name</option>
                                                    </select>
                                                </div>
                                            </li>
                                            <li class="halfLi">
                                                <span for="name" class="labelSpan star">Asset Extra:</span>
                                                <div class="txtBox">
                                                    <select name="asset_extra" id="asset_extra">
                                                        <option value="">Select Asset Extra</option>
                                                        <option value="blank">Blank</option>
                                                        <option value="a">A</option>
                                                        <option value="b">B</option>
                                                    </select>
                                                </div>
                                            </li>
                                            <li class="halfLi">
                                                <span for="name" class="labelSpan star">Complain Name:</span>
                                                <div class="txtBox">
                                                    <select name="complain_name" id="complain_name">
                                                        <option value="">Select Complain Name</option>
                                                    </select>
                                                </div>
                                            </li>
<!--                                            <li class="halfLi">
                                                <span for="complain_description" class="labelSpan star">Complain Description:</span>
                                                <div class="txtBox">
                                                    <select name="complain_description" id="complain_description">
                                                        <option value="">Select Complain Description</option>
                                                    </select>
                                                </div>
                                            </li>-->
                                            <li class="halfLi">
                                                <span for="name" class="labelSpan star">Department Name:</span>
                                                <div class="txtBox">
                                                    <select name="department" id="department">
                                                        <option value="">Select Department Name</option>
                                                        <?php 
                                                               // print_r($data);
                                                                 foreach($data['department'] as $key=>$val){?>
                                                                <option value="<?php echo $val['id'];?>"><?php echo $val['name'];?></option>
                                                                <?php }?>
                                                    </select>
                                                </div>
                                            </li>
                                            <li class="halfLi">
                                                <span for="name" class="labelSpan ">Employee:</span>
                                                <div class="txtBox">
                                                    <select name="employee[]" id="employee" multiple="multiple">
                                                        <option value="">Select Employee Name</option>
                                                        <?php 
                                                               // print_r($data);
                                                                 foreach($data['employeeAll'] as $key=>$val){?>
                                                                <option value="<?php echo $val['id'];?>"><?php echo $val['name'];?></option>
                                                                <?php }?>
                                                                <option value="all">All</option>
                                                    </select>
                                                </div>
                                            </li>
                                            <li class="halfLi">
                                                <span for="name" class="labelSpan ">Vendor:</span>
                                                <div class="txtBox">
                                                    <select name="vendor[]" id="vendor" multiple="multiple">
                                                        <option value="">Select Vendor Name</option>
                                                        <?php 
                                                               // print_r($data);
                                                                 foreach($data['vendorAll'] as $key=>$val){?>
                                                                <option value="<?php echo $val['id'];?>"><?php echo $val['name'];?></option>
                                                                <?php }?>
                                                                <option value="all">All</option>
                                                    </select>
                                                </div>
                                            </li>
                                            <li class="halfLi">
                                                <span for="name" class="labelSpan star">Priority:</span>
                                                <div class="txtBox">
                                                    <select name="priority" id="priority">
                                                        <option value="">Select Priority</option>
                                                         <?php foreach(CFG::$priorityArray as $key=>$val){
                                                            ?>
                                                        <option value="<?php echo  $key;?>"><?php echo  $val;?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                            </li>
<!--                                            <li class="halfLi">
                                                <span for="name" class="labelSpan star">Complain Received Time:</span>
                                                <received_timediv class="txtBox">
                                                    <input type="text" name="received_time" id="received_time" maxlength="100" class="txt required" title="Complain Received Time"  value="<?php //echo $data['complainData']['recived_time'];?>" >
                                                </div>
                                            </li>-->
<!--                                            <li class="halfLi">
                                                <span for="name" class="labelSpan star">Reach Time:</span>
                                                <div class="txtBox">
                                                    <input type="text" name="reach_time" id="reach_time" maxlength="100" class="txt required" title="Complain Reach Time"  value="<?php //echo $data['complainData']['reach_time'];?>" >
                                                </div>
                                            </li>
                                            
                                            <li class="halfLi">
                                                <span for="name" class="labelSpan star">Complain Close Time:</span>
                                                <div class="txtBox">
                                                    <input type="text" name="close_time" id="close_time" maxlength="100" class="txt required" title="Complain Close Time"  value="<?php //echo $data['complainData']['close_time'];?>" >
                                                </div>
                                            </li>-->
                                            
                                            <li class="halfLi">
                                                <span for="name" class="labelSpan">Remark:</span>
                                                <div class="txtBox">
                                                    <input type="text" name="remark" id="remark" class="txt" title="remark" >
                                                </div>
                                            </li>
                                            <li class="halfLi">
                                                <span for="name" class="labelSpan star">SMS Type:</span>
                                                <div class="txtBox">
                                                    <input type="checkbox" style="-moz-appearance: checkbox;-webkit-appearance: checkbox;" name="sms_type1" id="sms_type1" value="1">   SMS (Auto Enable)<br/>
                                                    <input type="checkbox" style="-moz-appearance: checkbox;-webkit-appearance: checkbox;" name="sms_type2" id="sms_type2" value="1">   SAP (Auto Disable)
                                                </div>
                                            </li>
                                            
                                            
<!--                                            <li class="halfLi">
                                                <span for="parent_complain" class="labelSpan">Complain To:</span>
                                                <div class="txtBox">
                                                    <input type="radio" id="txtrelaed" class="radioBtn" style="-moz-appearance: radio;-webkit-appearance: radio;" name="txtrelaed" value="1" >  Person  
                                                    <input type="radio" id="txtrelaed" class="radioBtn" style="-moz-appearance: radio;-webkit-appearance: radio;" name="txtrelaed" value="2" >  Station  
                                                    <input type="radio" id="txtrelaed" class="radioBtn" style="-moz-appearance: radio;-webkit-appearance: radio;" name="txtrelaed" value="3" >  Group  
                                                    
                                                </div>
                                            </li>-->
<!--                                            <li class="halfLi" id="pesrond">	
                                                <span class="labelSpan">Person:</span>
                                                <div class="txtBox">
                                                    <select id="person_id" name="person_id">
                                                                <option>Select Person</option>
                                                                <?php 
                                                               // print_r($data);
                                               //                  foreach($data['persondata'] as $key=>$val){?>
                                                                <option value="<?php //echo $val['id'];?>"><?php //echo $val['name'];?></option>
                                                                <?php //}?>
                                                            </select>
                                                    
                                                </div>
                                            </li>
                                            <li class="halfLi" id="stationd" style="display: none;">	
                                                <span class="labelSpan">Station:</span>
                                                <div class="txtBox">
                                                    <select id="station_id" name="station_id">
                                                                <option>Select Station</option>
                                                                <?php 
                                                               // print_r($data);
                                                                 //foreach($data['stationdata'] as $key=>$val){?>
                                                                <option value="<?php //echo $val['id'];?>"><?php //echo $val['name'];?></option>
                                                                <?php //}?>
                                                            </select>
                                                    
                                                </div>
                                            </li>
                                            <li class="halfLi" id="groupd" style="display: none;">	
                                                <span class="labelSpan">Group:</span>
                                                <div class="txtBox">
                                                    <select id="group_id" name="group_id">
                                                                <option>Select Group</option>
                                                                <?php 
                                                               // print_r($data);
                                                                 //foreach($data['groupdata'] as $key=>$val){?>
                                                                <option value="<?php //echo $val['id'];?>"><?php //echo $val['name'];?></option>
                                                                <?php //}?>
                                                            </select>
                                                    
                                                </div>
                                            </li>-->
                                            
                                            <li class="halfLi">	
                                                <span class="labelSpan">Complain Status:</span>
                                                <div class="txtBox">
                                                        
                                                            <select id="chkStatus" name="status">
                                                                <option <?php echo ($data['complainData']['status']==0)?"selected='selected'":"";?> value="0">Open</option>
                                                                <option <?php echo ($data['complainData']['status']==1)?"selected='selected'":"";?> value="1">Close</option>
                                                            </select>
                                                        
<!--                                                        <label for="chkStatus" id="checkAct"></label>-->
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
                        <li><a href="<?php echo URI::getURL(APP::$moduleName,"complain_list");?>" class="trans comBtn backBtn" title="Back to list">Back to list</a></li>
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

<?php // include CFG::$absPath . '/' . CFG::$helper . "/templates/add_new_parent_complain.php"; ?>
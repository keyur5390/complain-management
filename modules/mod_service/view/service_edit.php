<?php
//restrict direct access to the testimonial
defined('DMCCMS') or die('Unauthorized access');
 $flag=false;
if(APP::$curId!=0){
    $flag=true;
}                                                          
?>
<!-- For Dropdown Suggetion  -->
    <style>
        .progControlSelect2 {
       width: 350px !important;
      }
      form {
        margin-top: 2px;
      }
      .select2-results__option[aria-selected=true] {
        display: none;
        }
       
    </style>
    

<style type="text/css">

body {counter-reset:section;}
.count:before
{
counter-increment:section;
content:counter(section);
}
</style>


<!-- middle section part start -->
<section>
    <!-- page title part start -->
    <div class="midTop">
        <div class="container-fluid">
            <div class="row">
                <div class="fullColumn">
                    <div class="topLeft">
                        <div class="pageTitle blc-<?php echo APP::$moduleRecord['icon_class']; ?>"><span><?php echo isset(APP::$curId) && !empty(APP::$curId) ? "Update" : "Add" ?> Product</span></div>
                    </div>
                    <div class="topRight btnRight">
                        <ul class="btnUl threeBtn">    
                            <li><a href="<?php echo URI::getURL(APP::$moduleName,"service_list");?>" class="trans comBtn backBtn" title="Back to list">Back to list</a></li>
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
                            <form class="form-horizontal" id="frmUser" method="post">
                            <div class="tabMain">
                                <div class="accMain arrowDown">General</div>
                                <div class="accDiv tabDiv current" id="tab-1">
                                    <div class="formBox fulWidth">
                                        
                                            <input type="hidden" id="lang_id" name="lang_id" value="">
                                            <input type="hidden" name="edit" id="hdnEdit" value="0" />
                                            <!--<input type="hidden" name="userid" id="" value="<?php // echo $_REQUEST['userid'];?>" />-->
                                            <ul class="row">
                                                 
                                                <li class="halfLi">
                                                    <span for="txtTitle" class="labelSpan star">Model No :</span>
                                                    <div class="txtBox">
                                                        <input type="text" name="product_model" id="product_model" class="txt required" title="Please enter product model" >
                                                        
                                                    </div>
                                                </li>
                                                
                                                <li class="halfLi">
                                                    <span for="txtTitle" class="labelSpan star">Model Name :</span>
                                                    <div class="txtBox">
                                                        <input type="text" name="product_name" id="product_name" class="txt required" title="Please enter product name" >
                                                        
                                                    </div>
                                                </li>
                                                
                                                 
                                                <?php //pre($data['role']['id']);
                                               // pre($data['contactRegion'][]);
                                                ?>
                                                
                                           <?php /*     <li class="halfLi">
                                                    <span class="labelSpan star">Region Name:</span>
                                                    <div class="txtBox">
                                                        <select name="region_id" id="region_id" class="required" title="Select region name">
                                                            <option value="">Select Region Name</option>
                                                           <?php

                                            foreach($data['region'] as $key=>$value)
                                            {?>
                                                <option value="<?php echo $value['id'];?>" <?php if($value['parent_region']=='0'){?>disabled="true"<?} ?>><?php echo ($value['parent_region']!='0')? "&nbsp;&nbsp;".$value['name']:$value['name'];?></option>
                                            <?php }
                                            ?>
                                                        </select>
                                                    </div>
                                                </li>
                                                 <li class="halfLi">
                                                    <span for="txtTitle" class="labelSpan star">Sell Date:</span>
                                                    <div class="txtBox">
                                                        <input  type="text" name="sell_date" id="txtSell" class="txt required" maxlength="85" data-content="Select to date" data-placement="top" rel="popover" data-title="To date" data-trigger="focus" readonly title="Please select sell date"  >
                                                       
                                                    </div>
                                                </li>  
                                                
                                                
                                                 <li class="halfLi" id="">
                                                    <span for="txtTitle" class="labelSpan star">Warranty Start Date:</span>
                                                    <div class="txtBox">
                                                        <input  type="text" name="warranty_start_date" id="txtDFrom" class="txt required" maxlength="85" data-content="Select from date" data-placement="top" rel="popover" data-title="From date" data-trigger="focus" readonly title="Please select warranty start date" >
                                                        
                                                    </div>
                                                </li>
                                                
                                                 <li class="halfLi" id="">
                                                    <span for="txtTitle" class="labelSpan star">Warranty End Date:</span>
                                                    <div class="txtBox">
                                                        <input  type="text" name="warranty_end_date" id="txtDTo" class="txt required" maxlength="85" data-content="Select to date" data-placement="top" rel="popover" data-title="To date" data-trigger="focus" readonly title="Please select warranty end date"  >
                                                       
                                                    </div>
                                                </li> 
                                                
                                                
                                               <?php /* <li class="halfLi">
                                                    <span for="txtTitle" class="labelSpan">Qty:</span>
                                                    <div class="txtBox">
                                                        <input type="text" maxlength="4" name="qty" onkeypress="return isNumberic(event);" id="qty" class="txt" title="Please enter quantity" >
                                                        
                                                    </div>
                                                </li>*/ ?>

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
                        <li><a href="<?php echo URI::getURL(APP::$moduleName,"service_list");?>" class="trans comBtn backBtn" title="Back to list">Back to list</a></li>
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
 
<?php
 header('Content-Type: text/html; charset=ISO-8859-1');
//restrict direct access to the testimonial
defined('DMCCMS') or die('Unauthorized access');
$flag=false;
if(APP::$curId!=0){
    $flag=true;
} 
  
?>

<!-- middle section part start -->
<section>
    <div class="qLoverlay-new"></div>
    <!-- page title part start -->
    <div class="midTop">
        <div class="container-fluid">
            <div class="row">
                <div class="fullColumn">
                    <div class="topLeft">
                        <div class="pageTitle blc-<?php echo APP::$moduleRecord['icon_class']; ?>"><span><?php echo isset(APP::$curId) && !empty(APP::$curId) ? "Update" : "Add/Edit" ?> Ticket</span></div>
                    </div>
                    <div class="topRight btnRight">
                        <ul class="btnUl threeBtn">    
                            <li><a href="<?php echo URI::getURL(APP::$moduleName,"ticket_list");?>" class="trans comBtn backBtn" title="Back to list">Back to list</a></li>
                            <?php if(isset($_SESSION['user_login']) && $_SESSION['user_login']['roll_id']!='7' ){?>
                            <li><a href="#" id="btnEdit" class="trans comBtn" title="Save & continue edit">Save & continue edit</a></li>
                            <?php }?>
                            <li><a href="#" id="btnSave" class="trans comBtn" title="Save">Save</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>            	
    </div>
    <!-- page title part end -->


    <!-- table part start -->
    <div class="middlePart ticketMain">
        <div class="container-fluid">
            <div class="row">
                <div class="fullColumn">
                    <div class="midWhite">
                        <div class="tabBox">
                            <ul class="tabUl">
                                <li data-tab="tab-1" class="trans current" title="General">General</li>
                                
                            </ul>
                            <form class="form-horizontal" id="frmTicket" method="post">
                            <div class="tabMain">
                                <div class="accMain arrowDown">General</div>
                                <div class="accDiv tabDiv current" id="tab-1">
                                    <div class="formBox">
                                        
                                            <input type="hidden" id="lang_id" name="lang_id" value="">
                                            <input type="hidden" name="edit" id="hdnEdit" value="0" />
                                            <ul class="row">
                                                <li class="halfLi">
                                                    <span for="txtTitle" class="labelSpan star">Ticket Subject:</span>
                                                    <div class="txtBox">
                                                        <input type="text" name="txtSubject" id="txtSubject" class="txt required" maxlength="100" title="Ticket Subject"  <?php if($flag==true){?>readonly<?}?>>
                                                        <small>Maximum character length 100</small>
                                                    </div>
                                                </li>
                                                <?php
                                                if(isset($_SESSION['user_login']) && $_SESSION['user_login']['roll_id']!='7' )
                                                {
                                                ?>
                                                <li class="halfLi customer">
                                                    <span for="customer" class="labelSpan star">Customer:</span>
                                                    <div class="txtBox">
                                                        <select name="customer" id="customer" title="Customer" class="required" <?php if($flag==true){?>disabled="true"<?}?> >
                                                            <!--<option value="">Select Engineer</option>-->
                                                        </select> 
                                                    </div>
                                                </li>
                                                <?php }?>
                                                 <li class="halfLi">
                                                    <span class="labelSpan star">Serial No:</span>
                                                    <div class="txtBox">
                                                        <select name="serial_no" id="serial_no" class="required" title="Select product sr. no">
                                                            <option value="">Serial No</option>
                                                            <?php /*foreach($data['service'] as $v) { ?>
                                                             <option value="<?php echo $v['id']; ?>" data-name="<?php echo $v['name']; ?>"><?php echo $v['id']; ?></option>
                                                            <?php } */?>
                                                             
                                                        </select>
                                                    </div>
                                                </li>
                                                
                                                <li class="halfLi" id="otherDiv" style="display:none;">
                                                    <span for="other_serial_no" class="labelSpan star">Other Serial No:</span>
                                                    <div class="txtBox">
                                                        <input type="text" name="other_serial_no" id="other_serial_no" class="txt " maxlength="50" title="Other Serial No">
                                                        
                                                    </div>
                                                </li>
                                                <input type="hidden" name="product_model" id="product_model" value="">
                                                <input type="hidden" name="product_name" id="product_name" value="">
                                                <!--<li style="display:none;" id="li_helpdesk">
                                                    <span class="labelSpan star">Help Desk Manager:</span>
                                                    <div class="txtBox">
                                                        <select name="helpdesk" id="helpdesk" title="Help Desk Manager">
                                                            <option value="">Select Help Desk Manager</option>
                                                            <?php foreach ($data['helpdesk'] as $helpdesk) {?>
                                                                <option value="<?php echo $helpdesk['id'] ?>"><?php echo $helpdesk['name'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </li>-->
                                                <li style="<?php if(isset($_SESSION['user_login']) && $_SESSION['user_login']['roll_id']!='7'){?>display:none;<?php }?>" id="li_region" class="halfLi">
                                                    <span class="labelSpan star">Region:</span>
                                                    <div class="txtBox">
                                                       <select name="parent_region" id="parent_region" title="Region" class="progControlSelect2 required" onchange=""  >
                                                       </select>
                                                    </div>
                                                </li>
                                                <li style="display:none;" id="li_engineer" class="halfLi">
                                                    <span class="labelSpan star">Engineer:</span>
                                                    <div class="txtBox">
                                                       <select name="engineer" id="engineer" title="Engineer" class="progControlSelect2 " onchange=""  >
                                                       </select>
                                                    </div>
                                                </li>
                                                <li class="ticket_status halfLi" id="li_ticket" style="display:none;">
                                                    <span for="ticket_status" class="labelSpan">Ticket Status:</span>
                                                    <div class="txtBox">
                                                        <select name="ticket_status" id="ticket_status" title="Ticket Status" >
                                                            
                                                            <?php
                                                            foreach(CFG::$ticketStatusArray as $key=>$value)
                                                            {?>
                                                                <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                                           <? }
                                                            ?>
                                                            
                                                        </select> 
                                                    </div>
                                                </li>
                                                <li class="ticket_status halfLi "  id="li_problem" >
                                                    <span for="ticket_problem" class="labelSpan star">Type Of Problem:</span>
                                                    <div class="txtBox">
                                                        <select name="ticket_problem" id="ticket_problem" title="Type Of Problem" class="required" <?php if($flag==true){?>disabled="true"<?}?>>
                                                            <option value="">Select type of problem</option>
                                                              <?php foreach ($data['problemData'] as $problem) {?>
                                                            <option value="<?php echo $problem['name'];?>"><?php echo ucwords($problem['name']);?></option>
                                                           <? }
                                                            ?>
                                                            
                                                        </select> 
                                                    </div>
                                                </li>
                                                <li class="halfLi datelblLi" id="dateLbl"></li>
                                                <?php /* <li class="halfLi datelblLi" id="productModelLbl"></li> */ ?>
                                                <li style="display:none;" id="li_comment" class="halfLi cusCmt myFullDiv">
                                                    <span class="labelSpan star">Comment :</span>
                                                     <div class="txtBox">
                                                         <textarea name="comment" id="comment" class="txt"></textarea>
                                                        
                                                     </div>

                                               </li>
                                               <li class="resFull" style="display:none;" id="li_attach_report" >
                                                     <div class="uploader_section">
                                                        <span class="labelSpan star">Attach Report:</span>
                                                    <div class="img_upMain1">
                                                        <div class="zoomImg1" id="imageData1" data-src="">
                                                        <ul class="img_thumbMain singleImgUp " id="files1">

                                                        </ul>
                                                        </div>
                                                        <div class="uploaderMain singleDiv">
                                                                <div class="fileProgress1 fileUploadFormat"></div>
                                                                <div class="qq-upload-button">Upload Image
                                                                <input type="file" name="flImage1" id="flImage1" class="up-Btn" data-required="1" title="Please Attach Report" > 
                                                                
                                                        </div>
                                                        <div class="upload_text">Allowed Extensions: jpg, gif, png, doc, pdf</div>
                                                                <input type="hidden" id="hdnImg1" name="flImage1" value="" class="">
                                                                
                                                               
                                                        </div>

                                                       </div>
                                                </li>
                                               
                                                <li class="singCol" <?php if($flag==true){?>style="display:none;"<?php }?>>
                                                    <div class="uploader_section">
                                                        <span class="labelSpan">Attachment:</span>
                                                    <div class="img_upMain">
                                                      
                                                        <div class="zoomImg" id="imageData" data-src="">
                                                        <ul class="img_thumbMain singleImgUp " id="files">

                                                        </ul>
                                                        </div>
                                                        <div class="uploaderMain singleDiv">
                                                                <div class="fileProgress"></div>
                                                                <div class="qq-upload-button">Upload Image
                                                                <input type="file" name="flImage" id="flImage" class="up-Btn" data-required="1" title="Select Ticket Image" <?php if($flag==true){?>disabled="true"<?}?>> 
                                                        </div>
                                                                <input type="hidden" id="hdnImg" name="flImage" value="" class="">
                                                               <div class="upload_text">Allowed Extensions: jpg, gif, png</div>
                                                        </div>
                                                        
                                                       </div>
                                                        <?php
                                                        if($data['ticketData']['image_name']!='' && file_exists(URI::getAbsMediaPath(CFG::$ticketDir) . "/" . $data['ticketData']['image_name']))
                                                        {?>
                                                        <div class="img_upMain" <?php if($flag==false){?>style="display:none;"<?php }?>>
                                                            <img src="<?php echo UTIL::getResizedImageSrc(CFG::$ticketDir,$data['ticketData']['image_name'], "small", "no-image.jpg"); ?>" alt="<?php echo $data['image_alt'];  ?>" class="absoImg" style="position: relative;">
                                                        </div>
                                                        <?php }?>
                                                </li>
                                                <?php
                                                if($data['ticketData']['image_name']!='' && file_exists(URI::getAbsMediaPath(CFG::$ticketDir) . "/" . $data['ticketData']['image_name']))
                                                {?>
                                                <li class="" <?php if($flag==false){?>style="display:none;"<?php }?>>
                                                    <div class="uploader_section">
                                                        <span class="labelSpan">Attachment:</span>
                                                    
                                                       
                                                        <div class="img_upMain" <?php if($flag==false){?>style="display:none;"<?php }?>>
                                                            <div class="zoomImg2 cursor" id="imageData1" data-src="<?php echo UTIL::getResizedImageSrc(CFG::$ticketDir,$data['ticketData']['image_name'], "sl", "no-image.jpg"); ?>" alt="<?php echo $data['image_alt'];  ?>">
                                                            <img src="<?php echo UTIL::getResizedImageSrc(CFG::$ticketDir,$data['ticketData']['image_name'], "small", "no-image.jpg"); ?>" alt="<?php echo $data['image_alt'];  ?>" class="absoImg" style="position: relative;">
                                                            </div>
                                                        </div>
                                                       
                                                </li>
                                                 <?php }?>
                                                
                                                <?php/*
                                                <li class="halfLi">
                                                    <span class="labelSpan">Sort Order:</span>
                                                    <div class="txtBox">
                                                        <input type="text" onkeypress="return isNumberic(event);"  maxlength="3" class="txt" id="sortOrder" name="sortOrder" title="Sort Order" >
                                                        <small>Maximum character length 3</small>
                                                    </div>
                                                </li>


                                                <li class="halfLi">	
                                                    <span class="labelSpan">Status:</span>
                                                    <div class="optionBox">
                                                        <div class="chkInn">
                                                            <label>
                                                                <input type="checkbox" class="checkbox">
                                                                <input type="checkbox" class="checkbox" id="chkStatus" name="status" value="1" checked="checked" title="Product Status" data-content="Product Status">
                                                                <span></span>
                                                            </label>
                                                            <label for="chkStatus" id="checkAct"></label>
                                                        </div>                                                   
                                                    </div>
                                                </li> */?>    

                                            </ul>
                                            <ul class="row fullDesDiv">
                                            	<li id="li_desc">
                                                    <span for="txaDescription">Description:</span>
                                                    <!--<div class="txtBox">
                                                        <textarea class="txt required" name="shortDesc" id="txaDescription" title="Description"></textarea>
                                                    </div>-->
                                                    <div class="txtBox txtDescdiv">
                                                        <?php //echo UTIL::loadTinymce(1,'txaDescription'); ?>           
                                                        <div class="txtBox" id="ticket_desc">
                                                            <?php if($flag==false){?>
                                                        <textarea class="txt"  name="txaDescription" id="txaDescription" title="Description"></textarea>
                                                        <?php }
                                                        else
                                                        {
                                                            
                                                        }
                                                        ?>
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
                        <li><a href="<?php echo URI::getURL(APP::$moduleName,"ticket_list");?>" class="trans comBtn backBtn" title="Back to list">Back to list</a></li>
                         <?php if(isset($_SESSION['user_login']) && $_SESSION['user_login']['roll_id']!='7' ){?>
                        <li><a href="#" id="btnFooterEdit" class="trans comBtn" title="Save & continue Edit">Save & continue Edit</a></li>
                         <?php }?>
                        <li><a href="#" id="btnFooterSave" class="trans comBtn" title="Save">Save</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- table part end -->
</section>
<!-- middle section part end -->

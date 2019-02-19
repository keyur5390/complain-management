<?php
//restrict direct access to the contact_enquiry_list
defined('DMCCMS') or die('Unauthorized access');
//print_r($data);die();
//pre($data);exit;

?>

<!-- middle section part start -->
<section>
    <!-- page title part start -->
    <div class="midTop">
        <div class="container-fluid">
            <div class="row">
                <div class="fullColumn">

                    <div class="topLeft">
                        <div class="pageTitle blc-<?php echo APP::$moduleRecord['icon_class']; ?>">View Ticket</div>
                    </div>
                    <div class="topRight btnRight">
                        <ul class="btnUl">    
                            <li><a <?php if(isset($_GET['loc'])) { ?> href="index.php?m=mod_ticket&a=ticket_list" <?php } ?> href="index.php?m=mod_ticket&a=ticket_list" class="trans comBtn " title="Back to list">Back to list</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>            	
    </div>
    <!-- page title part end -->


    <!-- table part start -->
    <div class="middlePart mid_container">
        <div class="container-fluid">
            <div class="row">
                <div class="fullColumn">
                    <div class="midWhite">
                        <div class="tabBox">
                            <ul class="tabUl">
                                <li data-tab="data-view" class="trans current" title="General">General</li>
                            </ul>
                            <?php
                            if(isset($_SESSION['message']))
                            {
                                echo $_SESSION['message'];
                                unset($_SESSION['message']);
                            }
                            ?>
                            <div class="tabMain">
                                <div class="accMain arrowDown">General</div>
                                <div class="accDiv tabDiv current" id="data-view">
                                    <div class="enqBox">
                                        <ul class="enqUl">
                                            <li>
                                                <div class="leftData">
                                                    <span class="boldSpan">Ticket No :</span>
                                                    <span class="dataSpan">
                                                        <?php if(empty($data['ticketData']['id'])) { echo "-"; }else{ echo ucfirst($data['ticketData']['id']); } ?>
                                                    </span>
                                                </div>
                                                <div class="rightData">
                                                    <span class="boldSpan">Ticket Subject :</span>
                                                    <span class="dataSpan">
                                                        <?php if(empty($data['ticketData']['subject'])) { echo "-"; }else{ echo ucfirst($data['ticketData']['subject']); } ?>
                                                    </span>
                                                </div>
                                               
                                            </li>
                                            <li>
                                                
                                                <div class="leftData">
                                                    <span class="boldSpan">Customer Name :</span>
                                                    <span class="dataSpan"><?php echo ucfirst($data['ticketData']['user_name']); ?></span>
                                                </div>
                                                <div class="rightData">
                                                    <span class="boldSpan">Help Desk :</span>
                                                    <span class="dataSpan">
                                                        <?php if(empty($data['ticketData']['helpdesk_name'])) { echo "-"; }else{ echo ucfirst($data['ticketData']['helpdesk_name']); } ?>
                                                    </span>
                                                    
                                                </div>
                                            </li>
                                            
                                            <li>
                                                <div class="leftData">
                                                    <span class="boldSpan">Region :</span>
                                                    <span class="dataSpan">
                                                        <?php if(empty($data['ticketData']['region_name'])) { echo "-"; }else{ echo ucfirst($data['ticketData']['region_name']); } ?>
                                                    </span>
                                                </div>
                                                <div class="rightData">
                                                    <span class="boldSpan"> Engineer :</span>
                                                    <span class="dataSpan">
                                                        <?php if(empty($data['ticketData']['engineer_name'])) { echo "-"; }else{ echo ucfirst($data['ticketData']['engineer_name']); } ?>
                                                    </span>
                                                    
                                                </div>
                                            </li>
                                            
                                            <li>
                                               <div class="leftData">
                                                    <span class="boldSpan">Created Date :</span>
                                                    <span class="dataSpan">
                                                        <?php if(empty($data['ticketData']['created_date'])) { echo "-"; }else{ echo UTIL::dateDisplay($data['ticketData']['created_date']); } ?>
                                                    </span>
                                                </div>
                                               <div class="rightData">
                                                    <span class="boldSpan">Ticket Status :</span>
                                                    <span class="dataSpan">
                                                        <?php if(empty($data['ticketData']['ticket_status'])) { echo "-"; }else{ echo ucfirst(CFG::$ticketStatusArray[$data['ticketData']['ticket_status']]); } ?>
                                                    </span>
                                                </div>
                                            </li>
                                            <li>
                                                <?php if(!empty($data['ticketData']['problem_type'])) {?>
                                               <div class="leftData">
                                                    <span class="boldSpan">Type Of Problem :</span>
                                                    <span class="dataSpan">
                                                         <?php if(empty($data['ticketData']['problem_type'])) { echo "-"; }else{ echo ucfirst($data['ticketData']['problem_type']); } ?>
                                                    </span>
                                                </div>
                                                <?php } ?>
                                                <?php if(!empty($data['ticketData']['serial_no'])) {?>
                                               <div class="rightData">
                                                    <span class="boldSpan">Serial No :</span>
                                                    <span class="dataSpan">
                                                        <?php if(empty($data['ticketData']['serial_no'])) { echo "-"; }else{ echo $data['ticketData']['serial_no']; } ?>
                                                    </span>
                                                </div>
                                                <?php }?>
                                                  <?php if(!empty($data['ticketData']['other_serial_no'])) {?>
                                               <div class="rightData">
                                                    <span class="boldSpan">Other Serial No :</span>
                                                    <span class="dataSpan">
                                                        <?php if(empty($data['ticketData']['other_serial_no'])) { echo "-"; }else{ echo $data['ticketData']['other_serial_no']; } ?>
                                                    </span>
                                                </div>
                                                <?php }?>
                                                
                                               
                                            </li>
                                            <li>
                                                 <?php if(!empty($data['ticketData']['product_model'])) {?>
                                               <div class="rightData">
                                                    <span class="boldSpan">Model No :</span>
                                                    <span class="dataSpan">
                                                        <?php if(empty($data['ticketData']['product_model'])) { echo "-"; }else{ echo $data['ticketData']['product_model']; } ?>
                                                    </span>
                                                </div>
                                                <?php }?>
                                                
                                                <?php if(!empty($data['ticketData']['product_name'])) {?>
                                               <div class="rightData">
                                                    <span class="boldSpan">Model Name :</span>
                                                    <span class="dataSpan">
                                                        <?php if(empty($data['ticketData']['product_name'])) { echo "-"; }else{ echo $data['ticketData']['product_name']; } ?>
                                                    </span>
                                                </div>
                                                <?php }?>
                                                
                                                
                                                <?php
                                                if($data['ticketData']['image_name']!='' && file_exists(URI::getAbsMediaPath(CFG::$ticketDir) . "/" . $data['ticketData']['image_name']))
                                                {  $path=$ticketDir.$data['ticketData']['image_name']; 
                                                echo $path;
                                               ?>
                                               <!--$ext = pathinfo(, PATHINFO_EXTENSION);--> 
                                                <div class="leftData">
                                                    <span class="boldSpan">Attachment :</span>
                                                    <span class="dataSpan">
                                                        <div class="zoomImg" data-src="<?php echo UTIL::getResizedImageSrc(CFG::$ticketDir,$data['ticketData']['image_name'], "sl", "no-image.jpg"); ?>"> <?php echo $path; ?>
                                                        <img src="<?php echo UTIL::getResizedImageSrc(CFG::$ticketDir,$data['ticketData']['image_name'], "small", "no-image.jpg"); ?>" alt="<?php echo $data['image_alt'];  ?>" class="absoImg" style="position: relative;">
                                                          </div>
                                                    </span>
                                                </div>
                                                <?php }?>
                                                
                                            </li>
                                            <?php if(!empty($data['ticketData']['description'])) { ?>
                                             <li class="tkt_desc">
                                               <div class="rightData">
                                                    <span class="boldSpan">Description :</span>
                                                    <span class="dataSpan">
                                                        <?php if(empty($data['ticketData']['description'])) { echo "-"; }else{ echo $data['ticketData']['description']; } ?>
                                                    </span>
                                                </div>
                                                 
                                            </li>
                                            <?php }?>
                                             <?php if(!empty($data['ticketData']['close_date']) && $data['ticketData']['close_date']!='0000-00-00') {?>
                                             <li>
                                               <div class="leftData">
                                                    <span class="boldSpan">Closing Date :</span>
                                                    <span class="dataSpan">
                                                         <?php $date=  date_create($data['ticketData']['close_date']);echo date_format($date,'d/m/Y'); ?>
                                                    </span>
                                                </div>
                                             </li>
                                                <?php } ?>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                            
                            
                        </div>
                    </div>
                    <div class="ticketBtm customerLogin">
                    
                            <div class="commentMain clearDiv" id="main_comment">
                                <form method="post" name="frmComment" id="frmComment">
                                <div class="formBox">	
									<ul class="row">	
										<?php
                                        /*if(isset($_SESSION['user_login']) && $_SESSION['user_login']['roll_id']!='7' )
                                        {
                                        ?>
                                        <li>
                                            <span for="ticket_status" class="labelSpan">Ticket Status:</span>
                                            <div class="txtBox">
                                                <select name="ticket_status" id="ticket_status" title="Select Ticket Status" >
                                                    
                                                    <?php
                                                    foreach(CFG::$ticketStatusArray as $key=>$value)
                                                    {
                                                        
                                                        ?>
                                                        <option value="<?php echo $key;?>" <?php if($data['ticketData']['ticket_status']==$key){?>selected='true'<?} ?>><?php echo $value;?></option>
                                                        <?
                                                    }
                                                    ?>
        
                                                </select> 
                                            </div>
                                        </li>
                                        <?php }*/?>
                                <li>
                                   <span class="labelSpan star">Comment :</span>
                                    <div class="txtBox">
                                        <textarea name="comment" id="comment" class="txt required"></textarea>
                                       
                                    </div>

                                </li>
                                        <li>
                                            <input type="hidden" name="ticket_id" id="ticket_id" value="<?php echo APP::$curId;?>">
                                            <input type="hidden" name="user_id" id="user_id" value="<?php echo $_SESSION['user_login']['id']; ?>">
                                            <input type='hidden' name='parent_id' id='parent_id' value=''/> 
                                            <a href="#" id="btnSubmit" class="trans comBtn" title="Comment">Comment</a>
                                        </li>
                                     </ul>   
                                </div>
                            </form>
                            </div>
                            <?php 
                            if(count($data['ticketCommentData']) > 0)
                            {?>
                            <ul class="commentUl" >
                                <?php
                                foreach($data['ticketCommentData'] as $key=>$value)
                                {
                                   Ticket::getComments($value);  
                                }

                                ?>
                            </ul>
                            <?php }?>
                            
                                                    
                        <?php 
                            if(count($data['ticketCommentData'])<=0)
                            {
                                    echo "<div class='noRecord noComment'>No Comment Available!!</div>";

                            }
                        ?>
                        
                        <?php
                       /* if(count($data['ticketCommentData']) > 0)
                        {?>
                        <div class="formBox">
                             <form method="post" name="frmComment" id="frmComment1">
                                 <ul class="row">	
                                    <li class="fullLi">
                                         <span class="labelSpan">Comment :</span>
                                         <div class="txtBox">    
                                             <textarea name="comment" maxlength="250" id="comment" class="txt required"></textarea>
                                             <small>Maximum character length 250</small>
                                         </div>

                                 </li>
                                 	<li>
                                     <input type="hidden" name="ticket_id" id="ticket_id" value="<?php echo APP::$curId;?>">
                                     <input type="hidden" name="user_id" id="user_id" value="<?php echo $_SESSION['user_login']['id']; ?>">
                                     <input type='hidden' name='parent_id' id='parent_id' value=''/> 
                                     <a href="#" id="btnOtherSubmit" class="trans comBtn" title="Comment">Reply</a>
                                 </li>
                                 </ul>
                             </form>
                        </div>
                        <?php }*/?>
                        
                    </div>    
                </div>
                <div class="topRight btmBtn">
                    <ul class="btnUl">    
                        <li><a href="index.php?m=mod_ticket&a=ticket_list" class="trans comBtn" title="Back to list">Back to list</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="replymsgbox" style="display: none;">
            <form id="frmReply" novalidate method="POST" name="frmReply">
                <div>
                     <textarea name="comment" maxlength="250" id="comment" rows="5" cols="10" style="border:none" class="txt required"></textarea>
                     <small>Maximum character length 250</small>
                    <div id="error_text"> </div>
                </div>
                <div>           
                    <input type='hidden' name='parent_id' id='parent_id' class="parent_class" value=''/> 
                    <input type="hidden" name="ticket_id" id="ticket_id" value="<?php echo APP::$curId;?>">
                    <input type="hidden" name="user_id" id="user_id" value="<?php echo $_SESSION['user_login']['id']; ?>">
                    <input type="submit" value="Comment" name="Submit">
                </div>
            </form>
        </div>  
    </div>
    
    <!-- table part end -->
</section>

 
<!-- middle section part end -->





<?php
//restrict direct access to the page
defined('DMCCMS') or die('Unauthorized access');
?>
<!-- middle section part start -->
<section>
    <!-- page title part start -->
    <div class="midTop">
        <div class="container-fluid">
            <div class="row">
                <div class="fullColumn">
                    <div class="topLeft">
                        <div class="pageTitle blc-<?php echo APP::$moduleRecord['icon_class']; ?>"><span><?php echo isset(APP::$curId) && !empty(APP::$curId) ? "Update" : "Add" ?> User</span></div>
                    </div>
                    <div class="topRight btnRight">
                        <ul class="btnUl threeBtn">    
                            <li><a href="index.php?m=mod_user&a=user_list" class="trans comBtn backBtn" title="Back to list">Back to list</a></li>
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
                            <div class="tabMain">
                                <div class="accMain">General</div>
                                <div class="accDiv tabDiv current" id="tab-1">
                                    <div class="formBox">
                                        <form class="form-horizontal" id="frmUser" method="post">
                                            <input type="hidden" id="lang_id" name="lang_id" value="">
                                            <?php if (isset(APP::$curId) && !empty(APP::$curId)) { ?>
                                                <input type="hidden" name="edit" id="hdnEdit" value="0" />
                                            <?php } else { ?>
                                                <input type="hidden" name="add" id="hdnAdd" value="0" />
                                            <?php } ?>
                                            <input type="hidden" name="lastupdate" id="hdnLastUpdate"/>
                                            <ul class="row">
                                                <div class="Personal-Info">
                                                    <li class="DefaultAdd fullLi"><span>Personal Information</span></li>

                                                    <li>
                                                        <span class="labelSpan star">Role:</span>
                                                        <div class="txtBox">
                                                            <select name="role" id="txtRole" title="Role">
                                                                <option value="">Select role</option>
                                                                <?php foreach ($data as $role) { ?>
                                                                    <option value="<?php echo $role['id'] ?>"><?php echo $role['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </li>

                                                    <li>
                                                        <span class="labelSpan star">Name:</span>
                                                        <div class="txtBox">
                                                            <input type="text" name="name" id="txtName" class="txt required" maxlength="100" title="Name"><small>Maximum character length 100</small>
                                                        </div>
                                                    </li>

                                                    <li>
                                                        <span class="labelSpan star">Email:</span>
                                                        <div class="txtBox">
                                                            <input type="text" name="email" id="txtEmail"  class="txt required"  title="Email">
                                                        </div>
                                                    </li>

                                                    <li>
                                                        <span class="labelSpan star">Phone:</span>
                                                        <div class="txtBox">
                                                            <input type="tel" maxlength="10" class="txt numericOnly numbers" id="txtPhone" name="phone" title="Phone">
                                                        </div>
                                                    </li>

                                                    <li>
                                                        <span class="labelSpan">Mobile:</span>
                                                        <div class="txtBox">
                                                            <input type="tel"  maxlength="10" class="txt numericOnly numbers" id="txtMobile" name="mobile" title="Mobile">
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <span class="labelSpan">Station:</span>
                                                        <div class="txtBox">
                                                            <select id="station" name="station">
                                                                <option>Select Station</option>
                                                                
                                                              <?php 
                                                               // print_r($data);
                                                                 foreach($data['station'] as $key=>$val){?>
                                                                <option value="<?php echo $val['id'];?>"><?php echo $val['name'];?></option>
                                                                <?php }?>
                                                            </select>
                                                        </div>
                                                    </li><li>
                                                        <span class="labelSpan">Group:</span>
                                                        <div class="txtBox">
                                                            <select id="group" name="group">
                                                                <option>Select Group</option>
                                                                <?php 
                                                               // print_r($data);
                                                                 foreach($data['group'] as $key=>$val){?>
                                                                <option value="<?php echo $val['id'];?>"><?php echo $val['name'];?></option>
                                                                <?php }?>
                                                            </select>
                                                        </div>
                                                    </li>    
                                                   
                                                </div>
                                                <div class="Login-Info">
                                                    <li class="fullLi DefaultAdd"> <span>Login Information</span></li>
                                                    <li>
                                                        <span class="labelSpan star">Username:</span>
                                                        <div class="txtBox">
                                                            <input type="text" name="username" id="txtUsername" class="txt required" maxlength="30" title="Username">
                                                        </div>
                                                    </li>
                                                    <?php
                                                    $class = "";
                                                    if (APP::$curId == "")
                                                        $class = "required";
                                                    ?>

                                                    <li class="halfLi">
                                                        <span class="labelSpan <?php if (!isset(APP::$curId) && empty(APP::$curId)) { ?>star<?php } ?>">New Password:</span>
                                                        <div class="txtBox">
                                                            <input type="password" name="password" id="txtPassword" class="txt <?php echo $class; ?>" maxlength="30" title="New Password" autocomplete="off">
                                                        </div>
                                                    </li>

                                                    <li class="halfLi">
                                                        <span class="labelSpan <?php if (!isset(APP::$curId) && empty(APP::$curId)) { ?>star<?php } ?>">Confirm Password:</span>
                                                        <div class="txtBox">
                                                            <input type="password" name="confirm_password" id="txtConfirmPassword" class="txt <?php echo $class; ?>" maxlength="30" title="Confirm Password">
                                                        </div>
                                                    </li>

                                                </div>



                                                <div class="Address-Info">
                                                   <li class="fullLi DefaultAdd"> <span>Address Information</span></li>


                                                    <li>
                                                        <span class="labelSpan">Address:</span>
                                                        <div class="txtBox">
                                                            <input type="text" name="address" id="txtAddress" class="txt" title="Address">
                                                        </div>
                                                    </li>

                                                    <li>
                                                        <span class="labelSpan">Suburb:</span>
                                                        <div class="txtBox">
                                                            <input type="text" class="txt" id="txtSuburb" name="suburb" title="Suburb">

                                                        </div>
                                                    </li>

                                                    <li>
                                                        <span class="labelSpan">Postcode:</span>
                                                        <div class="txtBox">
                                                            <input type="text" name="postcode" id="txtPostcode" class="txt applyPopover numericOnly numbers" maxlength="4" title="Postcode">
                                                        </div>
                                                    </li>

<!--                                                    <li class="halfLi">	
                                                        <span class="labelSpan">Send Mail:</span>
                                                        <div class="optionBox">
                                                            <div class="chkInn">
                                                                <label>
                                                                    <input type="checkbox" class="checkbox">
                                                                    <input type="checkbox" class="checkbox" id="chkSendMail" name="send_email" value="0" title="Send Mail" data-content="Send Mail">
                                                                    <span></span>
                                                                </label>
                                                            </div>                                                   
                                                        </div>
                                                    </li>-->
                                                </div>
                                                <li class="halfLi">	
                                                    <span class="labelSpan">Status:</span>
                                                    <div class="optionBox">
                                                        <div class="chkInn">
                                                            <label>
                                                                <input type="checkbox" class="checkbox">
                                                                <input type="checkbox" class="checkbox" id="chkStatus" name="active" value="1" checked="checked" title="User Status" data-content="User Status">
                                                                <span></span>
                                                            </label>
                                                        </div>                                                   
                                                    </div>
                                                </li>

<!--                                                <li class="fullLi">
                                                    <span class="labelSpan">Email Signature:</span>
                                                    <div class="txtBox txtDescdiv">
                                                        <?php //echo UTIL::loadTinymce(1, 'txaDescription'); ?>
                                                    </div>
                                                </li>-->

                                            </ul>
                                        </form>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
                
                <div class="topRight btmBtn">
                    <ul class="btnUl threeBtn">    
                        <li><a href="index.php?m=mod_user&a=user_list" class="trans comBtn backBtn" title="Back to list">Back to list</a></li>
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
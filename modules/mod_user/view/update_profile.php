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
                        <div class="pageTitle updatePro">Update Profile</div>
                    </div>
                    <div class="topRight btnRight">
                        <ul class="btnUl">
                            <li><a href="#" id="btnSave" class="trans comBtn" title="Save profile">Save profile</a></li>
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
                                        <form class="form-horizontal" id="frmProfile" method="post">
                                            <input type="hidden" id="lang_id" name="lang_id" value="">
                                            <input type="hidden" name="edit" id="hdnEdit" value="0" />
                                            <ul class="row">
                                                <li>
                                                    <span class="labelSpan star">Name:</span>
                                                    <div class="txtBox">
                                                        <input type="text" name="name" id="txtName" class="txt required" maxlength="100" title="Name">
                                                        <small>Maximum character length 100</small>
                                                    </div>
                                                </li>

                                                <li>
                                                    <span class="labelSpan star">Email:</span>
                                                    <div class="txtBox">
                                                        <input type="text" name="email" id="txtEmail"  class="txt required"  title="Email">
                                                    </div>
                                                </li>

                                                <li>
                                                    <span class="labelSpan star">Username:</span>
                                                    <div class="txtBox">
                                                        <input type="text" name="username" id="txtUsername" class="txt required" maxlength="30" title="Username">
                                                    </div>
                                                </li>

                                                <li class="halfLi">
                                                    <span class="labelSpan">New Password:</span>
                                                    <div class="txtBox">
                                                        <input type="password" name="password" id="txtPassword" class="txt" maxlength="30" title="New Password">
                                                    </div>
                                                </li>

                                                <li class="halfLi">
                                                    <span class="labelSpan">Confirm Password:</span>
                                                    <div class="txtBox">
                                                        <input type="password" name="confirm_password" id="txtConfirmPassword" class="txt" maxlength="30" title="Confirm Password">
                                                    </div>
                                                </li>


                                                <li>
                                                    <span class="labelSpan">Phone:</span>
                                                    <div class="txtBox">
                                                        <input type="tel" onkeypress="return isNumberic(event);"  maxlength="10" class="txt" id="txtPhone" name="phone" title="Phone">
                                                    </div>
                                                </li>


                                                <li>
                                                    <span class="labelSpan">Mobile:</span>
                                                    <div class="txtBox">
                                                        <input type="tel" onkeypress="return isNumberic(event);"  maxlength="10" class="txt" id="txtMobile" name="mobile" title="Mobile">
                                                    </div>
                                                </li>

                                                <li>
                                                    <span class="labelSpan">Fax:</span>
                                                    <div class="txtBox">
                                                        <input type="tel" onkeypress="return isNumberic(event);"  maxlength="10" class="txt" id="txtFax" name="fax" data-title="Fax" title="Fax">
                                                    </div>
                                                </li>


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
                                                    <span class="labelSpan">State:</span>
                                                    <div class="txtBox">
                                                        <input type="text" name="state" id="txtState" class="txt" maxlength="50" title="State">
                                                    </div>
                                                </li>

                                                <li>
                                                    <span class="labelSpan">Country:</span>
                                                    <div class="txtBox">
                                                        <select name="country" id="txtCountry" title="Country">
                                                            <option value="">Select Country</option>
                                                        </select>
                                                    </div>
                                                </li>


                                                <li>
                                                    <span class="labelSpan">Postcode / Zip code:</span>
                                                    <div class="txtBox">
                                                        <input type="text" name="postcode" id="txtPostcode" class="txt applyPopover" maxlength="4" title="Postcode / Zip code" onKeypress="return isNumberic(event)">
                                                    </div>
                                                </li>

                                            </ul>
                                        </form>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                <div class="topRight btmBtn">
                    <ul class="btnUl">
                        <li><a href="#" id="btnFooterSave" class="trans comBtn" title="Save profile">Save profile</a></li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
    <!-- table part end -->
</section>
<!-- middle section part end -->

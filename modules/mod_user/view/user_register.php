<?php
//restrict direct access to the page
defined('DMCCMS') or die('Unauthorized access');
?>
<div class="row">
    <div class="column12 breadcome">
        <a href="index.html" title="Home">Home</a>Registration
    </div>
</div>
<div class="row">
    <div class="column12 page-title">
        <h1>Member Registration</h1>
    </div>
</div>
<div class="member-registration">
    <div class="row">
        <div class="column12">
            <div class="registration-login">Already a member,  Please <a href="#" title="click here">click here</a> to login &amp; update profile. Forgot your password,  Please <a href="#" title="click here">click here.</a></div>
        </div>
    </div>
    <div class="row">
        <div class="column12">
            <div class="register-title">New registration, Please fill our form below</div>
            <div class="orange-title">Please enter your details and click <span>'NEXT'</span> to proceed. Click <span>'RESET'</span> anytime to discard the changes. </div>
            <div class="grey-txt">(Please enter your valid email address. Account activation link will be sent in 24 hours to given emailaddress in this form, you must click on the activation link to activate your 
                membership account)</div>
        </div>
        <div class="column12"><div class="form-titles">Login Details:</div></div>
        <div class="column4">
            <div class="form-fields">
                <div class="form-input">Email Address:</div>
                <input type="text" value="" title="Email Address">
                <small>(Check for unique email address)</small>
                <label class="error">Please enter email address</label>
            </div>
        </div>
        <div class="column4">
            <div class="form-fields">
                <div class="form-input">Password:</div>
                <input type="password" value="" title="Password">
                <small>(Must be minimum 6 characters with 1 number included)</small>
                <label class="error">Please enter password</label>
            </div>
        </div>
        <div class="column4">
            <div class="form-fields">
                <div class="form-input">Retype Password:</div>
                <input type="password" value="" title="Retype Password">
                <small>(Please type same password as above)</small>
                <label class="error">Please retype password</label>
            </div>
        </div>
        <div class="clear"></div>
        <div class="column12"><div class="form-titles">Member Details:</div></div>
        <div class="column4">
            <div class="form-fields">
                <div class="form-input">First Name:</div>
                <input type="text" value="" title="First Name">
            </div>
        </div>
        <div class="column4">
            <div class="form-fields">
                <div class="form-input">Last Name:</div>
                <input type="text" value="" title="Last Name">
            </div>
        </div>
        <div class="column4">
            <div class="form-fields home-phone">
                <div class="form-input">Home Phone:</div>
                <div class="callno">
                    <div class="inputset">
                        <input type="text" value="" title="Country Code">
                        <small>(Country Code)</small>
                    </div>
                    <div class="inputset">
                        <input type="text" value="" title="State Code">
                        <small>(State Code)</small>
                    </div>
                    <div class="inputset">
                        <input class="nomargin" type="text" value="" title="Phone Number">
                        <small>(Phone Number)</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="column4">
            <div class="form-fields home-phone">
                <div class="form-input">Mobile Number:</div>
                <div class="callno">
                    <div class="inputset">
                        <input type="text" value="" title="Country Code">
                        <small>(Country Code)</small>
                    </div>
                    <div class="inputset">
                        <input type="text" value="" title="Mobile / Cell Number">
                        <small>(Mobile / Cell Number) </small>
                    </div>
                    <div class="inputset">
                        <input class="nomargin" type="text" value="" title="Cell Number">
                        <small>(Cell Number)</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="column4">
            <div class="form-fields">
                <div class="form-input">Address:</div>
                <input type="text" value="" title="Address">
            </div>
        </div>
        <div class="column4">
            <div class="form-fields">
                <div class="form-input">City / Town / Village:</div>
                <input type="text" value="" title="City / Town / Village">
            </div>
        </div>
        <div class="clear"></div>
        <div class="column4">
            <div class="form-fields">
                <div class="form-input">State:</div>
                <input type="text" value="" title="State">
            </div>
        </div>
        <div class="column4 regi-id form-fields">
            <div class="form-input">Country:</div>
            <span class="country"></span>
            <select id="country" name="country">
                <option selected="" value="  ">--Please Select Country--</option>
                <option value="AF">Afghanistan </option>
                <option value="AL">Albania </option>
                <option value="DZ">Algeria </option><option value="AS">American Samoa</option>
                <option value="BA">Bosnia and Herzegowina</option>
                <option value="BW">Botswana</option>
                <option value="BV">Bouvet Island </option>
            </select>
        </div>
        <div class="column4">
            <div class="form-fields">
                <div class="form-input">Gnan Vidhi Date:</div>
                <input class="dateicon" type="text" value="" title="Gnan Vidhi Date">
            </div>
        </div>
        <div class="clear"></div>
        <div class="column4">
            <div class="form-fields">
                <div class="form-input">Newsletter Subscription:</div>
                <div class="same-address">
                    <input tabindex="5" type="checkbox" id="minimal-checkbox-1">
                    <label for="minimal-checkbox-1" style="margin-top: 0;">Yes</label>
                    <input tabindex="5" type="checkbox" id="minimal-checkbox-2">
                    <label for="minimal-checkbox-2">No, Thank You</label>
                </div>
            </div>
        </div>
        <div class="column4">
            <div class="form-fields">
                <div class="form-input">Subscription Interest For:</div>
                <div class="same-address">
                    <input tabindex="5" type="checkbox" id="minimal-checkbox-3">
                    <label for="minimal-checkbox-3" style="margin-top: 0;">All</label>
                    <input tabindex="5" type="checkbox" id="minimal-checkbox-4">
                    <label for="minimal-checkbox-4">Live Satsang Schedules</label>
                    <input tabindex="5" type="checkbox" id="minimal-checkbox-5">
                    <label for="minimal-checkbox-5">Satsang Schedules</label>
                    <input tabindex="5" type="checkbox" id="minimal-checkbox-6">
                    <label for="minimal-checkbox-6">Event Schedules</label>
                </div>
            </div>
        </div>
        <div class="column4">
            <div class="form-fields">
                <div class="form-input">Enter the answer:</div>
                <div class="captcha-box">

                    <div class="refresh-icon"> <a onclick="document.getElementById('captcha').src = 'securimage/securimage_show.php?sid=' + Math.random();
                                this.blur();
                                return false" href="#"><img alt="Refresh" title="Refresh" src="templates/front/images/captcha-refresh.png"></a>
                    </div>
                    <div class="captcha-img ">
                        <img id="captcha" title="security image" alt="" src="securimage/securimage_show.php?sid=943d3b4b68b849c9639d42ed72c43634">
                        <span>=</span> 
                    </div>
                    <div class="captcha-input ">
                        <input title="Please enter answer" maxlength="4" onKeyPress="return isNumberKey(event)" class="required" id="verificationCode" name="verificationCode" type="text"> 
                    </div>

                    <div class="clear"></div>
                    <div class="captcha-spam">CAPTCHA</div>


                </div>
                <small>To avoid spam, Please answer this arithmetic question.</small>
            </div>
        </div>
        <div class="column12 sumbit-btn">
            <input type="Submit" value="Reset" title="Reset">
            <input type="Submit" title="Next" value="Next">
        </div>
    </div>
</div>


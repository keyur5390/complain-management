<?php
//restrict direct access to the page
defined('DMCCMS') or die('Unauthorized access');
?>
<div class="loginBox">
    <div class="loginMain">
        <div class="loginCenter">
            <div class="logInn">
                <div class="userIcon"></div>
                <div class="leftLogo">
                    <a href="<?php  echo CFG::$livePath; ?>" title="<?php  echo CFG::$siteConfig['site_name']; ?>">	
                        <img src="<?php echo URI::getLiveTemplatePath() ?>/images/admin-logo.png" alt="<?php echo CFG::$siteConfig['site_name']; ?>" title="<?php echo CFG::$siteConfig['site_name']; ?>" />
                    </a>
                </div>
                <div class="rightFrm">
                    <form class="form-horizontal"  id="frmLogin" method="post" >

                        <div class="alert alert-error" id="alertMsg" style="display:none;"></div>
                        <div class="header-alert header-alert-error" id="alertMsg" style="display:none;"></div>
                        <div class="frmTitle">User Login</div>
                        <div class="frmTxt uname">          
                            <input class="required" id="txtUsername" name="txtUsername" title="User name" placeholder="Username" type="text" tabindex="1" />
                        </div>
                        <div class="frmTxt pwd">
                            <input type="password" id="txtPassword" name="txtPassword" placeholder="Password" title="Password" data-content="Enter your password" data-placement="right" data-title="Password" data-trigger="focus" class="span12 required applyPopover low-line-height" tabindex="2" autocomplete="false" readonly onfocus="this.removeAttribute('readonly');">
                        </div>
                        <div class="subBox">
                            <div class="login-box login-btns">
                                <input type="submit" class="trans addNew loginBtn" id="btnSubmit" title="Login" value="Login">
<!--                                <span class="forgott">Forget your password? <a href="#" title="Click here" class="trans">Click here</a> </span>
                                <span class="forgot"><a href="<?php //echo URI::getURL("mod_user", "forgot_password");       ?>" title="Forgot your password?" tabindex="4">Forgot your password?</a></span>
                                <button style=" float: right;"title="Login" tabindex="3" id="btnSubmit" class="btn btn-primary " type="submit"><i class="ace-icon fa fa-key"></i> Login</button>-->
<!--                                <span class="forgot"><a href="<?php //echo CFG::$livePath; ?>" title="New cms" tabindex="4">Back to website</a></span>-->
                            </div>
                        </div>

                    </form>
                </div>
                <div class="backTo"><a href="<?php echo CFG::$livePath; ?>" title="Back to website" class="trans"><span>Back to website</span></a></div>
            </div>    
        </div>    
    </div>    
</div>    

<!-- Start: Model html -->
<!--<div class="modal hide fade" id="loginModel" style="background:none; border:none; box-shadow:none;">            
    <div class="modal-body" >            	
        <img src="<?php // echo URI::getLiveTemplatePath() ?>/images/loader.gif" alt="Loading..." title="Loading..." align="absmiddle"/>
    </div>            
</div>-->
<!-- End: Model html -->
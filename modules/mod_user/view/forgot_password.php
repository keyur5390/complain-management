<?php
	//restrict direct access to the page
	defined( 'DMCCMS' ) or die( 'Unauthorized access' );
?>
	<style type="text/css">
		.modal{width:200px;margin-left:-100px;}
	</style>    
    <div class="loginContainer">
            <form class="form-horizontal" id="frmPass" method="post" >
            
            	    <div class="alert alert-error" id="alertMsg" style="display:none; margin:15px 0 0px 0 !important"></div>
                    
                <div class="form-row row-fluid">
                    <div class="span12">
                        <div class="row-fluid">
                            <label class="form-label span12" for="txtEmail">
                                Enter Your Email<?php echo " - ".Enter_Your_Email; ?>:    
                            </label>
                            <!--<input class="span12" id="username" type="text" name="username" value="Administrator" />-->
                            <input class="span12 required email applyPopover low-line-height" id="txtEmail" name="txtEmail" placeholder="Email<?php echo " - ".Email; ?>" data-content="Enter your email<?php echo " - ".Enter_Your_Email;?>" data-placement="right" rel="popover" data-title="Email" data-trigger="focus" type="text" tabindex="1" />
                        </div>
                    </div>
                </div>

                
                <div class="form-row row-fluid">                       
                    <div class="span12">
                        <div class="row-fluid">
                            <div class="form-actions loginbtns">
                                <div class="span12 controls">
                                    <button type="button" class="btn btn-info left" id="btnBack" onclick="window.location.href = 'index.php?m=mod_user&a=admin_login'" title="Back to Login<?php echo " - ".Back_To_Login;?>">Back to Login<?php echo " - ".Back_To_Login;?></button>
                                    <button type="submit" class="btn btn-info right" id="btnSubmit" tabindex="3" title="Submit<?php echo " - ".Submit;?>">Submit<?php echo " - ".Submit;?></button>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>

            </form>
        </div>    
    
    <!-- Start: Model html -->
        <div class="modal hide fade" id="loginModel" style="background:none; border:none; box-shadow:none;">            
            <div class="modal-body" >            	
            	<img src="<?php echo URI::getLiveTemplatePath()?>/images/loader.gif" alt="Loading..." title="Loading..." align="absmiddle"/>
            </div>            
    	</div>
    <!-- End: Model html -->
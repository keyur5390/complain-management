<?php
//restrict direct access to the page
defined('DMCCMS') or die('Unauthorized access');
?>
<style>
    #files .delete{display: none;}
</style>
<section>
    <div  id="formLoad" class="showFormLoad"></div>  
    <div class="midTop">
        <div class="container-fluid">
            <div class="row">
                <div class="fullColumn">
                    <div class="topLeft">
                        <div class="pageTitle updatePro">Site Config</div>
                    </div>
                    <div class="topRight btnRight">
                        <ul class="btnUl">
                            <li><a href="#" class="trans comBtn" id="btnEdit">Save</a></li>                    
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="middlePart ">
        <div class="container-fluid">
            <div class="row">
                <div class="fullColumn">
                    <div class="midWhite">
                        <div class="tabBox">
                            <form class="form-horizontal" id="frmConfig" method="post">
                                <ul class="tabUl">
                                    <li data-tab="general" class="trans current" title="General">General</li>
                                    <li data-tab="meta" class="trans" title="Global SEO Content">Global SEO Content</li>
                                    <!--<li data-tab="meta" class="trans" title="Global SEO Content">Global SEO Content</li>-->
                                </ul>
                                <div class="tabMain">
                                    <div class="accMain">General</div>
                                    <div class="accDiv tabDiv current" id="general">
                                        <div class="formBox oneCol" >
                                            <ul class="row">
                                                <li class="mobiHalf">
                                                    <span class="labelSpan star">Site Name:</span>
                                                    <div class="txtBox">
                                                        <input type="text" name="site_name" id="txtSiteName" class="txt required" maxlength="100" title="Please enter site name">
                                                    </div>
                                                </li>
                                                <li class="mobiHalf">
                                                    <span class="labelSpan star">Site Email:</span>
                                                    <div class="txtBox">
                                                        <input type="text" name="site_email" id="txtSiteEmail" class="txt"  maxlength="100" title="Please enter site email"> 
                                                    </div>
                                                </li>
                                                <li class="mobiHalf">
                                                    <span class="labelSpan">Site Phone:</span>
                                                    <div class="txtBox">
                                                        <input type="text" name="site_phone" id="txtSitePhone" class="txt"  onkeypress="return isNumberic(event);" maxlength="10" title="Please enter site phone">
                                                    </div>
                                                </li>
                                                <li class="mobiHalf">
                                                    <span class="labelSpan">Site Address:</span>
                                                    <div class="txtBox">
                                                        <textarea type="text" name="site_address" id="txtSiteAddress" class="txt" maxlength="100" title="Please enter site address"></textarea>
                                                    </div>
                                                </li>
                                                <li class="mobiHalf">
                                                    <span class="labelSpan star">Enquiry Email:</span>
                                                    <div class="txtBox">
                                                        <input type="text" name="enquiry_emails" id="txtEnquiryEmails" class="txt" title="Please enter enquiry email">
                                                    </div>
                                                </li>
                                                <li class="mobiHalf">
                                                    <span class="labelSpan">Google Analytic Code:</span>
                                                    <div class="txtBox">
                                                        <input type="text" name="google_analytic_code" id="txtgcode" class="txt"  title="Please enter google analytic code">
                                                    </div>
                                                </li>
                                                
                                                <li class="mobiHalf">
                                                    <span class="labelSpan">Api Key:</span>
                                                    <div class="txtBox">
                                                        <input type="text" name="apikey" id="txtapi" class="txt"  title="Please enter api key">
                                                        
                                                    </div>
                                                </li>
                                                
                                               <li class="mobiHalf">
                                                    <span class="labelSpan">List Id:</span>
                                                    <div class="txtBox">
                                                        <input type="text" name="listid" id="txtListid" class="txt"  title="Please list id">
                                                    </div>
                                                </li>
                                                <?php /*
                                                <li class="mobiHalf">
                                                    <span class="labelSpan star">Facebook Link:</span>
                                                    <div class="txtBox">
                                                        <input type="text" name="facebook" id="txtFacebook" class="txt url">
                                                    </div>
                                                </li>
                                                <li class="mobiHalf">
                                                    <span class="labelSpan star">YouTube Link:</span>
                                                    <div class="txtBox">
                                                        <input type="text" name="youtube" id="txtYouTube" class="txt url">
                                                    </div>
                                                </li>
                                            
                                            <div class="form-group">
                                                <label for="flImage" class="control-label col-md-2 col-sm-3">Default Slider:</label>
                                                <div  class="col-md-6 col-sm-8">
                                                    <div class="qq-upload-button btn btn-success">
                                                        Upload Image
                                                        <input type="file" name="flImage" id="flImage" class="up-Btn"> 
                                                    </div>
                                                    <div id="files"></div>                    
                                                    <div class="fileProgress"></div> 
                                                    <div class="red-note"><small><strong>Allowed Extensions:</strong> jpg, gif, png<br><strong>Recommended Size:</strong> Width: 2000px, Height: 800px</small></div>
                                                </div>
                                            </div>
                                          */ ?>
                                                </ul>
                                        </div>
                                    </div>

                                    <div class="accMain">Global SEO Content</div>
                                    <div class="accDiv tabDiv" id="meta">
                                        <div class="formBox">	
                                            <ul class="row">
                                                <li class="mobiHalf">
                                                    <span class="labelSpan">Meta Title:</span>
                                                    <div class="txtBox">
														<textarea title="Please enter meta title for site" class="txt" name="site_meta_title" id="txtSiteMetaTitle" maxlength="<?php echo CFG::$metaTitleLen ?>"></textarea>
														<small>Maximum character length 100</small>
                                                    </div>
                                                </li>

                                                <li class="mobiHalf">
                                                    <span class="labelSpan">Meta Description:</span>
                                                    <div class="txtBox">
														<textarea title="Please enter meta title for site" name="meta_description" id="txaMetaDescription" class="txt" maxlength="<?php echo CFG::$metaDescLen ?>"></textarea>
														<small>Maximum character length 255</small>
                                                    </div>
                                                </li>

                                                <li class="mobiHalf">
                                                    <span class="labelSpan">Meta Keyword:</span>
                                                    <div class="txtBox">
														<textarea title="Please enter meta title for site" name="meta_keyword" id="txaMetakeyword" class="txt" maxlength="<?php echo CFG::$metaDescLen ?>"></textarea>
														<small>Maximum character length 255</small>
                                                    </div>
                                                </li>

                                                <li class="mobiHalf">
                                                    <span class="labelSpan">SEO Header Content:</span>
                                                    <div class="txtBox">
                                                        <textarea title="SEO Header Content" name="seo_header_content" id="txaSEOHeaderContent" class="txt"></textarea>
                                                    </div>
                                                </li>

                                                <li class="mobiHalf">
                                                    <span class="labelSpan">SEO Footer Content:</span>
                                                    <div class="txtBox">
                                                        <textarea title="SEO Footer Content" name="seo_footer_content" id="txaSEOFooterContent" class="txt"></textarea>
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
                    <ul class="btnUl">
                        <li><a href="#" class="trans comBtn" id="btnFooterEdit">Save</a></li>     
                    </ul>
                </div>
                
            </div>
        </div>
    </div>
</section>

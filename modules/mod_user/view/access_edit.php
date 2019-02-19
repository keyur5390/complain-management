<?php
//print_r($data);die();
//restrict direct access to the page
defined('DMCCMS') or die('Unauthorized access');
$accessArray = array();
$expand = array();
foreach ($data['list'] as $k => $v) {
    $accessArray[$v['module_name']][] = $v;
    $expand[$v['action_id']] = $v['module_id'];
}
$selectAll = false;
$actionIdArray = array();
$tempArray = array();
foreach ($data['access']['roll_action'] as $k => $v) {
    $actionIdArray[] = $v['action_id'];
    $tempArray[] = $expand[$v['action_id']];
}

if ($data['access']['rolls']['access_type'] == "all") {
    $selectAll = true;
}
?>
<!--
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="box">
            <div class="title ">
                <h4> <span class="icon16 icomoon-icon-equalizer-2"></span> <span>Access Level</span> </h4>
            </div>      
            <div class="content ">
                <div style="margin:0; text-align:right;z-index:1000; width: 100%;float: right;">
                    <ul id="menu" style="margin:0;  text-align:right;z-index:1000; " class="shortcuts scroll">
                        <li class="topBtns"> <a href="#" style="width:60px;" class="btn pd10 applyTooptip" data-title="Save" id="btnSave"><span class="icon16 icomoon-icon-notebook "></span>Save</a> </li>



                    </ul>
                </div>
                <div class="clear"></div>
            </div>
            <div class="content">
                <form class="form-horizontal " id="frmProfile" method="post" autocomplete="off">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#general">General</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="general" class="tab-pane active">
                            <div class="form-row row-fluid">
                                <div class="form-group">                                    
                                    <label for="name" class="col-md-2 col-sm-3 control-label">Name:<em>*</em></label>
                                    <div class="col-md-6 col-sm-8">
                                        <input type="text" name="name" id="name" class="form-control required applyPopover" maxlength="100" data-content="Enter name.<br> Max-length: 100 Characters" data-placement="right" rel="popover" data-title="Name" data-trigger="focus" >
                                    </div>
                                </div>
                                <div class="span12">
                                    <div class="row-fluid" id="accrss_tree"  name="selNodes[]">
                                        <ul style="display:none">
                                            <?php /* <li id="key1" title="Look, a tool tip!">item1 with key and tooltip</li>
                                              <li id="key2" class="selected" >item2: selected on init</li> */ ?>
                                            <li id="all" class="expanded">All Permission's
                                                <ul>
                                                    <?php
                                                    foreach ($accessArray as $k => $v) {
                                                        ?>
                                                        <li id="m_<?php echo $v[0]['module_id']; ?>" class="<?php echo in_array($v[0]['module_id'], $tempArray) ? "expanded" : ""; ?>"><?php echo $k; ?>
                                                            <ul>
                                                                <?php foreach ($v as $kv => $vv) { ?>
                                                                    <li id="<?php echo $vv['action_id']; ?>" class="<?php echo in_array($vv['action_id'], $actionIdArray) || $selectAll == true ? "selected" : ""; ?>"><?php echo $vv['action_name']; ?>
                                                                    </li>
                                                                <?php } ?>
                                                            </ul>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div> 
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>-->



<!--------------------------- New Design --------------------------------->



<!-- middle section part start -->
<section>
    <!-- page title part start -->
    <div class="midTop">
        <div class="container-fluid">
            <div class="row">
                <div class="fullColumn">
                    <div class="topLeft">
                        <div class="pageTitle  blc-<?php echo APP::$moduleRecord['icon_class']; ?>"><?php echo isset(APP::$curId) && !empty(APP::$curId) ? "Update" : "Add" ?> Access Level</div>
                    </div>
                    <div class="topRight btnRight">
                        <ul class="btnUl">    
                            <li><a href="index.php?m=mod_user&a=access_list" class="trans comBtn backBtn" title="Back to list">Back to list</a></li>
                            <li><a href="#" id="btnSave" class="trans comBtn" title="Save & continue edit">Save & continue edit</a></li>
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
                                <div class="accMain arrowDown">General</div>
                                <div class="accDiv tabDiv current" id="tab-1">
                                    <div class="formBox oneCol">
                                        <form class="form-horizontal" id="frmProfile" method="post">
                                            <input type="hidden" id="lang_id" name="lang_id" value="">
                                            <input type="hidden" name="edit" id="hdnEdit" value="0" />
                                            <ul class="row">
                                                <li>
                                                    <span for="name" class="labelSpan star">Name:</span>
                                                    <div class="txtBox">
                                                        <input type="text" name="name" id="name" value="<?php if(isset($data['name'])){ echo $data['name']; } ?>" class="txt required" maxlength="100" title="User Name"><small>Maximum character length 100</small>
                                                    </div>
                                                </li>

                                                <li>

                                                    <div class="span12">
                                                        <div class="row-fluid" id="accrss_tree"  name="selNodes[]">
                                                            <ul style="display:none">
                                                                <?php /* <li id="key1" title="Look, a tool tip!">item1 with key and tooltip</li>
                                                                  <li id="key2" class="selected" >item2: selected on init</li> */ ?>
                                                                <li id="all" class="expanded">All Permission's
                                                                    <ul>
                                                                        <?php
                                                                        foreach ($accessArray as $k => $v) {
                                                                            ?>
                                                                            <li id="m_<?php echo $v[0]['module_id']; ?>" class="<?php echo in_array($v[0]['module_id'], $tempArray) ? "expanded" : ""; ?>"><?php echo $k; ?>
                                                                                <ul>
                                                                                    <?php foreach ($v as $kv => $vv) { ?>
                                                                                        <li id="<?php echo $vv['action_id']; ?>" class="<?php echo in_array($vv['action_id'], $actionIdArray) || $selectAll == true ? "selected" : ""; ?>"><?php echo $vv['action_name']; ?>
                                                                                        </li>
                                                                                    <?php } ?>
                                                                                </ul>
                                                                            </li>
                                                                        <?php } ?>
                                                                    </ul>
                                                                </li>
                                                            </ul>
                                                        </div>
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
                        <li><a href="index.php?m=mod_user&a=access_list" class="trans comBtn backBtn" title="Back to list">Back to list</a></li>
                        <li><a href="#" id="btnFooterSave" class="trans comBtn" title="Save & continue edit">Save & continue edit</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- table part end -->
</section>
<!-- middle section part end -->




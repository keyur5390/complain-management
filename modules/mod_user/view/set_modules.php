<?php 

//print_r($data);exit;
$accessArray = array();
foreach ($data as $k=>$v)
{
    $accessArray[$v['module_key']][] = $v;
}
//print_r($accessArray);exit;

//$labelData = array();
//
//foreach ($data as $v)
//{
//    $labelData[$v['module_key']] =  array();
//    $labelData[$v['module_key']]['label1'] = $v['admin_menu_label'];
//    $labelData[$v['module_key']]['label2'] = $v['admin_menu_label'];
//    
//}



//print_r($labelData);exit;        
?>

<?php // echo print_r($data); exit;?>
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
                                        <form class="form-horizontal" id="frmSetmod" method="post">
                                            <input type="hidden" id="lang_id" name="lang_id" value="">
                                            <input type="hidden" name="edit" id="hdnEdit" value="0" />
                                            <ul class="row">
                                                

                                                <li>

                                                    <div class="span12">
                                                        <div class="row-fluid" id="accrss_tree" name="activeModule[]">
                                                            <ul style="display:none">
                                                                <?php /* <li id="key1" title="Look, a tool tip!">item1 with key and tooltip</li>
                                                                  <li id="key2" class="selected" >item2: selected on init</li> */ ?>
                                                                <li id="all" class="expanded">All Modules
                                                                    <ul>
                                                                        <?php
                                                                        foreach ($accessArray as $k => $v) {
                                                                            
                                                                            
                                                                            ?>
                                                                        <li id="<?php echo $v[0]['module_key']; ?>" <?php if(isset($v[0]['active_module']) && $v[0]['active_module'] == '1'){?> class="selected" <?php } else{?> class="" <?php } ?>><?php echo $v[0]['name']; ?>
                                                                            
                                                                            <?php  if($k == 'mod_enquiry') { ?>
                                                                                <ul>
                                                                                    <?php foreach ($v as $kv => $vv) {
                                                                                        
                                                                                        if(!empty($vv['admin_menu_label']))
                                                                                        {
                                                                                        ?>
                                                                                    <li id="<?php  echo $vv['admin_menu_label']; ?>" <?php if(isset($vv['active_action']) && $vv['active_action'] == '1'){?> class="selected" <?php } else{?> class="" <?php } ?>><?php  echo $vv['admin_menu_label']; ?>
                                                                                        </li>
                                                                                        <?php }} ?>
                                                                                </ul>
                                                                                
                                                                            
                                                                            </li>
                                                                            <?php }} ?>
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




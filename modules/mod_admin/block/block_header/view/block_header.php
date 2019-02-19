<?php
//restrict direct access to the page
defined('DMCCMS') or die('Unauthorized access');
 $custID = $_SESSION['user_login']["id"];
 
$isActiveUser = DB::queryFirstField("SELECT active FROM " . CFG::$tblPrefix . "user where id=%d limit 1", $custID);
if(($isActiveUser=='0' || $isActiveUser=='') && APP::$actionName!='admin_login'  && APP::$actionName!='forgot_password' && APP::$appType=='admin' && trim(APP::$slugParts[0])=='myAdmin')
{
    $_SESSION['error_user']="Your account has been blocked.";
    UTIL::redirect(URI::getURL("mod_user", "user_logout"));
}
?>


<ul class="firstUl">

<!--  <li class="dropdown"> <a href="#" class="dropdown-toggle avatar" data-toggle="dropdown"> <img src="../templates/admin/images/feed.png" alt="" class="image" style="width:32px; height:32px;" /> <span class="txt">Feeds</span> <b class="caret"></b> </a>
            <ul class="dropdown-menu">
                <li class="menu">
                    <ul>
                        <li> <a title="Generate Sitemap XML" href="<?php // echo CFG::$livePath;    ?>/get-sitemap" target="_blank">Generate Sitemap XML</a> </li>
                    </ul>
                </li>
            </ul>
        </li>  -->
<!--    <li><a href="<?php  echo CFG::$livePath ?>" target="_blank" class="visit" title="Visit Website">Visit Website</a></li>-->
    <?php if($data['seo'][0]['active_action'] == '1' && $data['seo'][0]['active_module'] == '1' ) { ?>
    <li><a href="index.php?m=mod_seo&a=seo_list" title="SEO Manager" class="seo"> SEO Manager</a></li>
    <?php } ?>
    <?php if($data['config'][0]['active_action'] == '1' && $data['config'][0]['active_module'] == '1' &&  Core::hasAccess(APP::$moduleName, "site_config")) { ?>
    <?php /*<li class="configLi"><a href="index.php?m=mod_config&a=site_config" title="Site Configuration" class="config">Site Configuration</a></li>*/?>
    <?php } ?>
</ul>
<ul class="userUl">
    <li>
        <a href="javascript:;" title="<?php echo Core::getUserData("name"); ?>" class="trans supAdmin"></a>
        <ul class="trans subUl">
            <li><a href="index.php?m=mod_user&a=update_profile" class="editPro" title="Edit Profile">Edit Profile</a></li>
            <li><a href="index.php?m=mod_user&a=user_logout" class="logout" title="Logout">Logout</a></li>
                <?php /* <li><?php //echo Core::createActionButton("mod_config","site_config","update","Site Config - ".Site_Config); ?></li> */ ?>
        </ul>
    </li>
</ul>





<!-- /.nav-collapse -->
<?php
//restrict direct access to the page
defined('DMCCMS') or die('Unauthorized access');
?>
<nav role="navigation" id="nav-main" class="okayNav">
    <script type="text/javascript">
        $(document).ready(function() {
            if ($(window).width() > 768) {
                $('.navUl li.hiddenLi').remove();
            }
        });
    </script>

    <?php
//    echo "<pre>";
//     print_r($data); exit;
    $arrMenu = array();
    $mi = 0;
    foreach ($data as $menu) {
        $arrMenu[] = $menu['module_key'];
    }
    $cntMenu = array_count_values($arrMenu);
    //echo "<pre>";print_r($cntMenu); exit;
    ?>


    <ul class="navUl" id="nav-bar-filter" aria-labelledby="menulist">
       <li><a href="#" title="Compalinname">Configuration Manager</a><ul start="" class="sub "> 
        <li><a href="<?php echo CFG::$livePath;?>/myAdmin/index.php?m=mod_station&a=station_list" title="Station"> 
                Station</a></li>
        <li class="active"><a href="<?php echo CFG::$livePath;?>/myAdmin/index.php?m=mod_employee&a=employee_list" title="Employee" class="active">Employee</a></li>
        
        <li><a href="<?php echo CFG::$livePath;?>/myAdmin/index.php?m=mod_asset&a=asset_list" title="Asset"> Asset</a></li>
        
        <li><a href="<?php echo CFG::$livePath;?>/myAdmin/index.php?m=mod_department&a=department_list" title="Department Name">Department Name</a></li>
        <li><a href="<?php echo CFG::$livePath;?>/myAdmin/index.php?m=mod_group&a=group_list" title="Group Management"> Group Management</a></li>
        <li><a href="<?php echo CFG::$livePath;?>/myAdmin/index.php?m=mod_equipment&a=equipment_list" title="Equipment Management"> Equipment Management</a></li>
        <li><a href="<?php echo CFG::$livePath;?>/myAdmin/index.php?m=mod_compalinname&a=compalinname_list" title="Compalin Name">Compalin Name</a></li></ul></li>
        <li><a href="<?php echo CFG::$livePath;?>/myAdmin/index.php?m=mod_user&a=user_list" title="Users"> Users</a></li>
        <li><a href="<?php echo CFG::$livePath;?>/myAdmin/index.php?m=mod_complain&a=complain_list" title="Complain"> Complain</a></li>
<!--        <li><a href="<?php //echo CFG::$livePath;?>/myAdmin/index.php?m=mod_complain&a=complain_list&type=view" title="View Complain">View Complain</a></li>-->
        <li><a href="<?php echo CFG::$livePath;?>/myAdmin/index.php?m=mod_complain&a=report_list" title="Reports">Reports</a></li>
<!--        <li><a href="#" title="Compalinname"> <span class="iconSpan"><img src="http://localhost/complain-manager/templates/admin/images/attribute.png" class="fiImg"><img src="http://localhost/complain-manager/templates/admin/images/attribute-active.png" class="secImg"></span>Compalinname</a><ul start="" class="sub "><li><a href="index.php?m=mod_compalinname&amp;a=compalinname_list" title="Compalin Name"><span class="iconSpan"><img src="http://localhost/complain-manager/templates/admin/images/attribute-compalinname_list.png" class="fiImg"><img src="http://localhost/complain-manager/templates/admin/images/attribute-compalinname_list-active.png" class="secImg"></span>Compalin Name</a></li></ul></li>-->
        
        
        <?php /*
        $oldMenu = "";
        $ulStart = false;
        foreach ($data as $key => $val) { //echo "<pre>";print_r($val);exit;
            $class = '';
            $classsub = '';
            if (APP::$moduleName == $val['module_key']) {
                $class = 'class="active"';
            }

            if ($oldMenu != $val['module_key'] && $val['module_key']!='mod_service') {
                if ($oldMenu != "") {
                    if ($ulStart == true) {
                        echo '</ul>';
                        $ulStart = false;
                    }
                    echo "</li>";
//                    echo "</ul></li>";
                }
                $oldMenu = $val['module_key'];

                if ($val['moduleName'] == $val['admin_menu_label']) {
                    /*if($val['module_key'] == 'mod_inventory' && $val['action'] =='user_list' && CORE::getUserData('roll_id') == 5)
                            $val['action']='inventory_list';*//*
                    $link = 'index.php?m=' . $val['module_key'] . '&a=' . $val['action'];
                } else {
                    $link = '#';
                }
                if($val['moduleName'] == 'mod_inventory' || $val['moduleName']== 'mod_service')
                    $class = 'class="active"';
                echo '<li ' . $class . '><a href="' . $link . '" title="' . $val['moduleName'] . '" ' . $class . '> <span class="iconSpan"><img src="' . URI::getLiveTemplatePath() . '/images/' . $val['icon_class'] . '.png" class="fiImg"><img src="' . URI::getLiveTemplatePath() . '/images/' . $val['icon_class'] . '-active.png" class="secImg"></span>' . $val['moduleName'] . '</a>';
                 if($val['module_key'] == 'mod_inventory') {
                         echo '<ul start class="sub "  >';
                           echo '<li><a href="' . $link . '" title="Customer" ' . $class . '><span class="iconSpan"><img src="' . URI::getLiveTemplatePath() . '/images/customer-icon.png" class="fiImg"><img src="' . URI::getLiveTemplatePath() . '/images/customer-icon-active.png" class="secImg"></span>Customer</a></li>';
                           $class1=($_GET['a'] == 'service_list' || $_GET['a'] == 'service_edit')?"class='active'":'';
                              echo '<li><a href="index.php?m=mod_service&a=service_list" title="Products" '.$class1.'><span class="iconSpan"><img src="' . URI::getLiveTemplatePath() . '/images/service-icon.png" class="fiImg"><img src="' . URI::getLiveTemplatePath() . '/images/service-icon-active.png" class="secImg"></span>Products</a></li>';
                           echo '</ul>';
                }
                if ($val['moduleName'] != $val['admin_menu_label']) {
                    echo '<ul start class="sub "  >';
                    $ulStart = true;
                }
            }
           
            if ($val['moduleName'] != $val['admin_menu_label']) {
                $classsub = '';
                if ($_REQUEST['a'] == $val['action']) {
                    $classsub = 'class="active"';
                }
                echo '<li><a href="index.php?m=' . $val['module_key'] . '&a=' . $val['action'] . '" title="' . $val['admin_menu_label'] . '"' . $classsub . '><span class="iconSpan"><img src="' . URI::getLiveTemplatePath() . '/images/' . $val['icon_class'] . '-' . $val['action'] . '.png" class="fiImg"><img src="' . URI::getLiveTemplatePath() . '/images/' . $val['icon_class'] . '-' . $val['action'] . '-active.png" class="secImg"></span>' . $val['admin_menu_label'] . '</a></li>';
            }
            if ($key == (count($data) - 1)) {
                if ($ulStart == true) {
                    echo '</ul>';
                    $ulStart = false;
                }
                echo "</li>";
//                echo '</ul></li>';
            }
        }*/
        ?>
        <!--        <li class="hiddenLi">
                    <a href="<?php // echo CFG::$livePath             ?>" title="Visit Website">
                        <span class="iconSpan">
                            <img src="<?php // echo URI::getLiveTemplatePath();             ?>/images/visite-site.png" class="fiImg">
                        </span>
                        <span>Visit Website</span>
                    </a>
                </li>-->
        <!--        <li class="hiddenLi">
                    <a href="index.php?m=mod_seo&a=seo_list" title="SEO Manager">
                        <span class="iconSpan">
                            <img src="<?php // echo URI::getLiveTemplatePath();             ?>/images/seo-manager.png" class="fiImg">
                            <img src="<?php // echo URI::getLiveTemplatePath();             ?>/images/seo-manager-active.png" class="secImg">
                        </span>
                        <span>SEO Manager</span>
                    </a>
                </li>-->
        <!--        <li class="hiddenLi">
                    <a href="index.php?m=mod_config&a=site_config" title="Site Configuration">
                        <span class="iconSpan">
                            <img src="<?php echo URI::getLiveTemplatePath(); ?>/images/configuration.png" class="fiImg">
                            <img src="<?php echo URI::getLiveTemplatePath(); ?>/images/configuration-active.png" class="secImg">
                        </span>
                        <span>Site Configuration</span>
                    </a>
                </li>-->
        <li class="hiddenLi">
            <a href="index.php?m=mod_user&a=update_profile" title="Edit Profile">
                <span class="iconSpan">
                    <img src="<?php echo URI::getLiveTemplatePath(); ?>/images/edit-user.png" class="fiImg">
                    <img src="<?php echo URI::getLiveTemplatePath(); ?>/images/edit-user-active.png" class="secImg">
                </span>
                <span>Edit Profile</span>
            </a>
        </li>
        <li class="hiddenLi">
            <a href="index.php?m=mod_user&a=user_logout" title="Logout">
                <span class="iconSpan">
                    <img src="<?php echo URI::getLiveTemplatePath(); ?>/images/logout-icon.png" class="fiImg">
                </span>
                <span>Logout</span>
            </a>
        </li>  
    </ul>

    <!--ul id="more-nav">        
        <li><a href="#" class="more-menu">More</a>
            <ul class="subfilter" aria-labelledby="menulist">               
            </ul>
        </li>    
    </ul>
    <script src="<?php echo URI::getLiveTemplatePath(); ?>/js/admin-menu.js" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            /*admin-toggle menu*/
            $('.more-menu').click(function() {
                $('.more-menu').toggleClass('close-menu');
                $('.subfilter').toggleClass('open-menu');
            });
            /*admin-toggle menu*/
            $('.submenuLI a').click(function() {
                $(this).siblings().slideToggle();
            });
        });
    </script>-->



</nav><!-- End .heading-->
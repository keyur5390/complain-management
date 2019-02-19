<?php
//restrict direct access to the page
defined('DMCCMS') or die('Unauthorized access');
//echo Layout::getModuleData();
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if IE 9]><html lang="en" class="ie ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />    
        <!-- Mobile Specific Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
        <!-- Le styles -->
        <?php echo Layout::displayHeader(); ?>    
        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <!-- Le fav and touch icons -->
        <link rel="shortcut icon" href="<?php echo URI::getLiveTemplatePath() ?>/images/favicon.ico" />  
        <script type="text/javascript">
            var defaultLang = <?php echo json_encode(Language::getDefaultLang()); ?>;
        </script>
    </head>
    <body <?php if (!Layout::checkPosition("top")) { ?>class="loginBody"<?php } else { ?>class="okayNav-loaded"<?php } ?>>
        <!--<div class="header-new"></div>-->
        
        <div class="wrapper">
            <?php if (Layout::checkPosition("top")) { ?>
                <header>
                    <!-- header top part start -->
                    <div class="headMain">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="fullColumn">
                                    <div class="headLeft">
                                        <a class="headLogo" href="" title="<?php echo CFG::$siteConfig['site_name']; ?>"><?php echo CFG::$siteConfig['site_name']; ?></a> 
                                    </div>
                                    <div class="headRight">
                                        <?php  echo Layout::getPosition("top"); ?> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- header top part end -->
                    <!-- header menu part start -->
                    <div class="menuPart">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="fullColumn">
                                    <div class="logo">
                                        <div class="menu-icon">
                                            <span class="line1"></span>
                                            <span class="line2"></span>
                                            <span class="line3"></span>
                                        </div>
                                        <a href="index.php?m=mod_complain&a=complain_list" title="<?php echo CFG::$siteConfig['site_name']; ?>"><img src="<?php echo URI::getLiveTemplatePath(); ?>/images/logo.png" alt="<?php echo CFG::$siteConfig['site_name']; ?>" title="<?php echo CFG::$siteConfig['site_name']; ?>"></a>
                                    </div>
                                    <?php  echo Layout::getPosition("breadcrumb"); ?>  
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="alertMessage" class="msgBox"></div>
                </header>
            <?php } ?>
            <?php  echo Layout::getModuleData(); ?> 
            <footer>
                <a href="javascript:;" class="trans img-circle scrollTop" title="Scroll Top"><span class="absoImg"></span></a>
                <div class="footerMain">
                   
                </div><!-- End .row-fluid -->
            </footer>
            <?php   echo Layout::displayFooter(); ?>    
        </div>
    </body>
</html>

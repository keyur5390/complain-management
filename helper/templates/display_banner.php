<?php

//restrict direct access to the page
defined('DMCCMS') or die('Unauthorized access');
$abs_path = CFG::$absPath . DIRECTORY_SEPARATOR . CFG::$mediaDir . DIRECTORY_SEPARATOR . CFG::$bannerDir . DIRECTORY_SEPARATOR;


/* @author:Abhishek Panchal <abhishek.datatech@gmail.com> *@date:10-03-2016 *@changes:get banner image */
Load::loadModel('page', 'mod_page');
$pageObj = new PageModel();

$bannerImages = $pageObj->bannerImages();

//pre($bannerImages);exit;
/* @author:Abhishek Panchal <abhishek.datatech@gmail.com> *@date:10-03-2016 *@changes:set image for banner */
$image = URI::getLiveTemplatePath() . "/images/".CFG::$default_banner;

$bannerImage = isset($bannerImages['image_name']) && $bannerImages['image_name'] != "" ? $bannerImages['image_name'] : $image;

if (is_file($abs_path . $bannerImage) && file_exists($abs_path . $bannerImage)) {
    $image = UTIL::getResizedImageSrc(CFG::$bannerDir, $bannerImage, "ib", CFG::$siteConfig['txtBannerImage']);
}

//pre($data, 1);
?>
<section class="breadcrumMain">
    	<img src="<?php echo $image; ?>" alt="" title="" />
     	<div class="breadinner">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="pageTitle"><?php  echo $mainTitle; ?></div>
                        <div class="breadcrum">
                        	<ul>
                            	<li>
                                	<a href="#" title="Home">Home</a>
                                </li>
                                <span>/</span>
                                    <?php
                if (isset($data) && !empty($data)) {
                    foreach ($data as $kb => $vb) {
                        if (isset($vb['name']) && !empty($vb['name']) && isset($vb['url']) && !empty($vb['url'])) {
                            if ($vb['lastchild'] != 1) {
                                ?>
                                <li>
                                    <a href="<?php echo $vb['url']; ?>" title="<?php echo $vb['name'];?>"><?php echo $vb['name']; ?></a>
                                    <span>/</span>
                                </li>
                                <?php
                            } else {
                                ?>
                                <li>
                                    <span><?php echo $vb['name']; ?></span>
                                </li>
                                <?php
                            }
                        }
                    }
                }
                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<!--<section class="breadcumbs-sec" style="height:329px;background: url('<?php // echo $image; ?>')">
    <div class="inner-breadcumbs">
        <div class="container">
            <div class="row">
                 <?php
             /*   if (isset($mainTitle) && !empty($mainTitle)) {
                    ?>
                    <h1><?php  echo $mainTitle; ?></h1>
                    <?php
                }*/
                ?>
            </div>                
        </div>
    </div>         	
</section>
   end of breadcumbs    
<div class="breadcumbs_menu">
    <div class="container">
        <div class="row">
            <ul class="breadcumbs_menu_ul">
                <li><a href="<?php // echo CFG::$livePath; ?>" title="Home">Home</a>
                    <span>/</span>
                </li> 
                <?php
             /*  if (isset($data) && !empty($data)) {
                    foreach ($data as $kb => $vb) {
                        if (isset($vb['name']) && !empty($vb['name']) && isset($vb['url']) && !empty($vb['url'])) {
                            if ($vb['lastchild'] != 1) {
                                ?>
                                <li>
                                    <a href="<?php echo $vb['url']; ?>" title="<?php echo $vb['name'];?>"><?php echo $vb['name']; ?></a>
                                    <span>/</span>
                                </li>
                                <?php
                            } else {
                                ?>
                                <li>
                                    <span><?php echo $vb['name']; ?></span>
                                </li>
                                <?php
                            }
                        }
                    }
                }
               */ ?>
            </ul> 
        </div>
    </div>  
</div>-->


<?php
//restrict direct access to the page
defined('DMCCMS') or die('Unauthorized access');
error_reporting(E_ALL);
//$abs_path = CFG::$absPath . DIRECTORY_SEPARATOR . CFG::$mediaDir . DIRECTORY_SEPARATOR . CFG::$sliderDir . DIRECTORY_SEPARATOR;
//Load::loadModel('page', 'mod_page');
//$pageObj = new PageModel();
//$bannerImages = $pageObj->bannerImages();
//pre($bannerImages);exit;
//$bannerImage = isset($bannerImages['banner_img']) && $bannerImages['banner_img'] != "" ? $bannerImages['banner_img'] : CFG::$siteConfig['txtBannerImage'];

$image = URI::getLiveTemplatePath() . "/new-images/inner-banner.jpg";
/*if (is_file($abs_path . $bannerImage) && file_exists($abs_path . $bannerImage)) {
    $image = UTIL::getResizedImageSrc(CFG::$banner, $bannerImage, "ib", CFG::$siteConfig['txtBannerImage']);
}*/
//pre($data, 1);
?>



<section class="breadcumbs-sec">
	<div class="inner-breadcumbs">
		<div class="container">
			<div class="row">
				<h1><?php echo $mainTitle;?></h1>
			</div>
		</div>
	</div>
</section>
<!-- end of breadcumbs -->           
<div class="breadcumbs_menu">
	<div class="container">
		<div class="row" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
			<ul class="breadcumbs_menu_ul">
				<li>
					<a itemprop="url" href="<?php echo CFG::$livePath;?>" title="Home"><span itemprop="title">Home</span></a>
					<span>/</span>
				</li>

				<?php if (isset($data) && !empty($data)) {
                            foreach ($data as $kb => $vb) {
                                if (isset($vb['name']) && !empty($vb['name']) && isset($vb['url']) && !empty($vb['url'])) {
                                    if ($vb['lastchild'] != 1) {
                                        ?>
                                        <!-- <li>
											<a href="<?php echo URI::getURL("mod_project", "projects")?>" title="Projects">Projects</a>
											<span>/</span>
										</li> -->
										
										<li>
                                            <!-- <span itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="breadcrumb_title" title="<?php echo $vb['name']; ?>"> -->
												<a href="<?php echo $vb['url']; ?>" itemprop="url"><span itemprop="title"><?php echo $vb['name']; ?></span></a>
												<span>/</span>
											<!-- </span> -->
                                        </li>
                                        <?php
                                    } else {
                                        ?>

										<li><span><a href="<?php echo $_SERVER['REQUEST_URI'];?>" style="cursor: text;" onclick="return false;" itemprop="url"><span itemprop="title"><?php echo $mainTitle;?></span></a></span></li>

                                        <!-- <li>
                                            <span itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="breadcrumb_title" title="<?php echo $vb['name']; ?>"><a style="cursor: text;" href="<?php echo $vb['url']; ?>" onclick="return false" itemprop="url"><span itemprop="title"><?php echo $vb['name']; ?></span></a></span>
                                        </li> -->
                                        <?php
                                    }
                                }
                            }
                        }
						?>
				<!-- <li>
					<a href="<?php echo URI::getURL("mod_project", "projects")?>" title="Projects">Projects</a>
					<span>/</span>
				</li>
				<li><span><?php echo $mainTitle;?></span></li> -->
			</ul> 
		</div>
	</div>  
</div>

<?php /* ?>

<div class="new_inner_banner" style="background: url(<?php echo $image; ?>)">
    <div class="new_container">
        <div class="new_row">
            <div class="banner_main">
                <?php
                if (isset($mainTitle) && !empty($mainTitle)) {
                    ?>
                    <h1 class="inner_title" title="<?php echo $mainTitle; ?>"><?php echo $mainTitle; ?></h1>
                    <?php
                }
                ?>
                <div class="breadcumbs" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
                    <ul>
                        <li>
                            <a itemprop="url" href="<?php echo CFG::$livePath; ?>" title="Home"><span itemprop="title">Home</span></a><span class="devider"> &nbsp;  </span>
                        </li>
                        <?php
                        if (isset($data) && !empty($data)) {
                            foreach ($data as $kb => $vb) {
                                if (isset($vb['name']) && !empty($vb['name']) && isset($vb['url']) && !empty($vb['url'])) {
                                    if ($vb['lastchild'] != 1) {
                                        ?>
                                        <li>
                                            <span itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="breadcrumb_title" title="<?php echo $vb['name']; ?>"><a href="<?php echo $vb['url']; ?>" itemprop="url"><span itemprop="title"><?php echo $vb['name']; ?></span></a><span class="devider"> &nbsp;  </span></span>
                                        </li>
                                        <?php
                                    } else {
                                        ?>
                                        <li>
                                            <span itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="breadcrumb_title" title="<?php echo $vb['name']; ?>"><a style="cursor: text;" href="<?php echo $vb['url']; ?>" onclick="return false" itemprop="url"><span itemprop="title"><?php echo $vb['name']; ?></span></a></span>
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

<?php */ ?>
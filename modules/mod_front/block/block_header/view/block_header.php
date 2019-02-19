<?php
	//restrict direct access to the page
	defined( 'DMCCMS' ) or die( 'Unauthorized access' );
	//Declare path variable for get live template file
	$path=URI::getLiveTemplatePath();
?>

<?php
	//restrict direct access to the page
	defined( 'DMCCMS' ) or die( 'Unauthorized access' );
	//Declare path variable for get live template file
	$path=URI::getLiveTemplatePath();

?>
<header id="header">
<!--    <div>
        <div>Header Start...</div>
        <div><strong>Module:</strong>mod_front
        <strong>Block:</strong>block_header
        <strong>file path:</strong><?php // echo CFG::$livePath."/".CFG::$modules."/mod_front/".CFG::$block."/block_header/".CFG::$view."/block_header.php"; ?></div>
    </div> -->
    <div class="container">
        <div class="row">
            <div class="col-md-14">
                <div class="logo"><a href="<?php echo CFG::$livePath; ?>"><img src="<?php echo $path; ?>/images/logo.png" alt="<?php echo CFG::$siteConfig['site_name']; ?>" title="<?php echo CFG::$siteConfig['site_name']; ?>" /></a></div>

            <div class="header_right">
                <div class="header_top">
                    <div class="header_tel"><span class="d_tel"><?php echo CFG::$siteConfig['site_phone']; ?></span><a class="m_tel" href="tel:<?php echo CFG::$siteConfig['site_phone']; ?>"><?php echo CFG::$siteConfig['site_phone']; ?></a></div>

                <div class="top_social"> <a class="fb_icon" href="" target="_blank" title="Facebook"></a> <a class="linkdin_icon" href="" target="_blank" title="LinkedIn "></a> </div>
            </div>
            <div class="navigation_bar">
                <div class="menu-icon"> <span class="line line1"></span> <span class="line line2"></span> <span class="line line3"></span> </div>
                <nav class="menu">
                    <ul>

                                            <li><a href="<?php echo URI::getURL("mod_enquiry","enquiry"); ?>">Contact Enquiry</a></li>
                                            <li><a href="<?php echo URI::getURL("mod_page","view_page",1); ?>">About Us</a></li>
                                            <li><a href="<?php echo URI::getURL("mod_page","view_page",2); ?>">Why choose us</a></li>

                   </ul>
                </nav>
            </div>
            </div>
            </div>
        </div>
    </div>
</header>




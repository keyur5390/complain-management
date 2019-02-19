<?php 
	//restrict direct access to the page
	defined( 'DMCCMS' ) or die( 'Unauthorized access' );
	
	$path=URI::getLiveTemplatePath();	
?>
<footer>
<!--    <div>
        <div>Footer Start...</div>
        <div><strong>Module:</strong>mod_front
        <strong>Block:</strong>block_footer
        <strong>filepath:</strong><?php // echo CFG::$livePath."/".CFG::$modules."/mod_front/".CFG::$block."/block_footer/".CFG::$view."/block_footer.php"; ?></div>
    </div> -->
<div class="navigation_bar">
                <div class="menu-icon"> <span class="line line1"></span> <span class="line line2"></span> <span class="line line3"></span> </div>
                <nav class="menu">
                    <ul>
                                            
                                            <li><a href="<?php echo URI::getURL("mod_enquiry","enquiry"); ?>">Contact Enquiry</a></li>
                                            <li><a href="<?php echo URI::getURL("mod_page","view_page",1); ?>">About Us</a></li>
                                             <li><a href="<?php echo URI::getURL("mod_sitemap","sitemap"); ?>">Sitemap</a></li>
                   </ul>
                </nav>
            </div>
    
    <form id="mailchimp" name="mailchimp" method="post" >
                                        <input class="news_box" type="text" id="subscribe" name="email_chimp" placeholder="Email address">
                                        <input type="submit" value="Submit">
                                        <div><?php if(isset($data)){ echo $data; } ?></div>
                                    </form>
    
    <?php  if(isset($data))  { ?>
                <div id="status"></div>
    <?php } ?>
    
</footer>

<?php if(isset($data)) { ?>
<script type="text/javascript">
    location.href = location.href + "#status";
</script>
<?php } ?>
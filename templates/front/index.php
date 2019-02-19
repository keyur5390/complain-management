<?php
	//restrict direct access to the page
	defined( 'DMCCMS' ) or die( 'Unauthorized access' );	
?>
<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">       
        <meta name="robots" content="index, follow">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<?php echo Layout::displayHeader(); ?> 
        
         <?php if(isset(CFG::$siteConfig['google_analytic_code']) && !empty(CFG::$siteConfig['google_analytic_code'])) { ?>
        
        <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
        ga('create', '<?php  echo CFG::$siteConfig['google_analytic_code']; ?>' ,'auto');
        ga('send', 'pageview');

      </script>
      
        <?php } ?>
    </head>
    <body>
       
        <?php  echo Layout::getPosition('top');?>
        
        <?php  if(APP::$actionName == 'home') { echo Layout::getPosition('slider'); }  ?>
        
        
     
        <?php echo Layout::getModuleData(); ?>
        
       <?php echo Layout::getPosition('bottom');?>
		
        <?php echo Layout::displayFooter(); ?>        
        
    </body>
</html>
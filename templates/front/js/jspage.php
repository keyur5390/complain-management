<?php
	//restrict direct access to the page
	defined( 'DMCCMS' ) or die( 'Unauthorized access' );
	$path = URI::getLiveTemplatePath();

Layout::addHeader('<script src="' . $path . '/js/jquery.min.js" type="text/javascript"></script>');
Layout::addHeader('<script src="' . $path . '/js/datepicker.js" type="text/javascript"></script>');

?>
<script type="text/javascript">
    $(document).ready(function(){
        
        $("#txtDFrom").datepicker({ dateFormat: "dd-mm-yy",changeMonth: true,changeYear: true});
        
        
 });
    
</script>


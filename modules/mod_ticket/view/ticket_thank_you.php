<?php
defined('DMCCMS') or die('Unauthorized access');
$path = URI::getLiveTemplatePath();

if (isset($_SESSION['ticket']) && $_SESSION['ticket'] == true) {
    unset($_SESSION['ticket']);
} else {

    UTIL::redirect(URI::getURL("mod_ticket", "ticket_list"));
}
?>

<div class="layout">
    <div class="container-fluid">
        <div class="row">
            <div class="fullColumn"> 
            	<div class="thankYouPage">
                <div class="thanksMain">
                	<div class="thankImg">
                    	<img src="<?php echo $path; ?>/images/thank-you.png" alt="">
                    </div>
                	<h2 class="thanks_line">Thank You</h2>
                    <div class="enq-successfully"><span>Your ticket has been generated successfully, we will get back to you shortly.</span></div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {
	setMinheight()
		
	//alert($(document).height());
});

$(window).resize(function() {
    setMinheight()
});
	function setMinheight(){
		var documentHeight = $('.wrapper').height();
			winHeight = $(window).height();
			headerHeight = $('header').height();
			footerHeight = $('.footerMain').height();
			midHeight = winHeight - (headerHeight + footerHeight);
			//alert(documentHeight)
		
		if(winHeight > documentHeight){
			$('body').addClass('middleMain')
			$('.layout .thankYouPage').css('height', midHeight)
		}
		else{
			$('body').removeClass('middleMain')
			$('.layout .thankYouPage').removeAttr('style')
		}
	}

</script>


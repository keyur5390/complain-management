<?php
	//restrict direct access to the page
	defined( 'DMCCMS' ) or die( 'Unauthorized access' );
	$path = URI::getLiveTemplatePath();
?>
<script type="text/javascript">
    

    $(document).ready(function(){
       $("#enquiry_Form").validate({
           
           onkeyup:false,
           ignore:[],
           rules:{
               
              name:{required: true},
               email:{required: true, email: true},
               phone: {required: true, minlength: 10, maxlength: 10},
               
               secureImg1: {required: true}
           },
           messages:{
                name: {required: 'Please enter name'},
               email: {required: 'Please enter email address', email: 'Please enter valid email address'},
                phone: {required: 'Please enter phone number', minlength: "Phone number must be 10 digit long"},
                
                secureImg1: {required: 'Please select checkbox'}
           }
       });
       
             $("#mailchimp").validate({
           onkeyup:false,
           ignore:[],
            rules:{
                
                email_chimp:{required: true,email: true}
            },
            
             messages:{
                email_chimp:{required:'Please enter email',email: "Please enter valid email"} 
             }
           
       });
       
       
       
    });
    
    
    function isNumberic(evt)
    {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 46 && charCode != 8)
            return false;
        if (charCode == 46)
            return false;
        return true;
    }
    document.getElementById("captcha1").addEventListener('click', function() {
            changeBg();
            $('#secureImg1').val($('#encriptNum1').text());
            $('#cptchaError1').hide();

        });
    function changeBg() {
            animate = 0;
            var stopAnimation = setInterval(function() {
                document.getElementById('captcha1').style.backgroundPosition = animate + 'px 27px';
                if (animate == -297) {
                    clearInterval(stopAnimation);
                    document.getElementById('captcha1').style.pointerEvents = 'none';
                    //animate=0;
                } else {
                    animate = animate - 27;
                }
            }, 50);
        }
</script>
<script src="<?php echo $path; ?>/js/jquery.validate.js" type="text/javascript"></script>
<!--<script src="<?php echo $path; ?>/js/additional-method.js" type="text/javascript"></script>-->
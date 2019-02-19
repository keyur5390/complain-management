$(function(){		
		
		// initialize popover
		$(document).ready(function(){applyPopover();});
				
		// validate form
		$('#frmLogin').validate({
			errorClass: "error",
			validClass: "text-success",
                        rule: {txtUsername:{required:true},txtPassword:{required:true}},
                        messages: {txtUsername:{required:"Please enter username"},txtPassword:{required:"Please enter password"}}
		});
		
		$('#frmPass').validate({
			errorClass: "error",
			validClass: "text-success",			
		});

		// handle form submit request
		$('#frmLogin').submit(function(event){		
			event.preventDefault();
			if($('#frmLogin').valid())
			{
				// initialize model
//				$('#loginModel').modal({backdrop:"static",keyboard:false})
				$.ajax({					
					url: loginPath,
					data: $(this).serialize(),
					async: false,
					type: 'post',				
					success : function( json ) {
						var jsonObj = jQuery.parseJSON(json);	
						if(jsonObj.result == "success")
							window.location.href = jsonObj.redirectLink;
						else
						{
							$("#alertMsg").html(jsonObj.reqMsg);
							$("#alertMsg").css("display","");							
						}
					},
					error : function( xhr, status ) {						
						$("#alertMsg").html("Sorry, there was a problem!. Please try again.");
						$("#alertMsg").css("display","");
					}					
				});				
				$('#loginModel').modal("hide");
			}			
		});
                
             $('#frmPass').submit(function(event){		
			event.preventDefault();
			if($('#frmPass').valid())
			{
				// initialize model
				$('#loginModel').modal({backdrop:"static",keyboard:false})
				$.ajax({					
					url: "index.php?m=mod_user&a=forgot_password",
					data: $(this).serialize(),
					async: false,
					type: 'post',				
					success : function( json ) {
						var jsonObj = jQuery.parseJSON(json);	
						if(jsonObj.result == "success")
						{
							
						   $("#alertMsg").html(jsonObj.reqMsg);
							$("#alertMsg").css("display","");
							//window.location.href = "index.php?m=mod_user&a=admin_login";	
						}
						else
						{
							$("#alertMsg").html(jsonObj.reqMsg);
							$("#alertMsg").css("display","");							
						}
					},
					error : function( xhr, status ) {						
						$("#alertMsg").html("Sorry, there was a problem!. Please try again.");
						$("#alertMsg").css("display","");
					}					
				});				
				$('#loginModel').modal("hide");
			}			
		});
});
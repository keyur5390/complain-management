<script type="text/javascript" src="<?php echo URI::getLiveTemplatePath() . "/js/jquery.paging.min.js" ?>"></script>
<script type="text/javascript" src="<?php echo URI::getLiveTemplatePath() . "/js/formJs.js" ?>"></script>
<script type="text/javascript" src="<?php echo URI::getLiveTemplatePath() . "/js/jquery-ui.custom.js" ?>"></script>
<?php /* ?><link rel="stylesheet" href="<?php echo URI::getLiveTemplatePath(); ?>/js/datepicker/jquery-ui.css" /><?php */ ?>
<link href="<?php echo URI::getLiveTemplatePath(); ?>/plugins/select/select2.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo URI::getLiveTemplatePath() . "/plugins/select/select2.js" ?>"></script>
<script type="text/javascript" src="<?php echo URI::getLiveTemplatePath() . "/plugins/tiny_mce/tiny_mce.js"; ?>"></script>
<script type="text/javascript" src="<?php echo URI::getLiveTemplatePath() . '/js/jquery.validate.js' ?>"></script>
<?php include CFG::$absPath . '/' . CFG::$helper . "/templates/js/tpl_region.php"; ?>

<script type="text/javascript">
       var selectedIds = [];
 
    $(document).ready(function() {
       
    
    
<?php echo Stringd::createJsObject("userData", $data); ?>
        
        console.log(userData);
  
         $("#txtDFrom").datepicker({ dateFormat: "dd-mm-yy",changeMonth: true,changeYear: true, buttonImage: "<?php echo URI::getLiveTemplatePath()."/images/calender2.png";?>",buttonImageOnly: true,showOn: "both",onClose: function( selectedDate ) {
				$( "#txtDTo" ).datepicker( "option", "minDate", selectedDate );
			}});
                    
            $("#txtDTo").datepicker({ dateFormat: "dd-mm-yy",changeMonth: true,changeYear: true, buttonImage: "<?php echo URI::getLiveTemplatePath()."/images/calender2.png";?>",buttonImageOnly: true,showOn: "both",onClose: function( selectedDate ) {
                    //$( "#txtDFrom" ).datepicker( "option", "maxDate", selectedDate );
            }});
        
        $("#txtSell").datepicker({ dateFormat: "dd-mm-yy",changeMonth: true,changeYear: true, buttonImage: "<?php echo URI::getLiveTemplatePath()."/images/calender2.png";?>",buttonImageOnly: true,showOn: "both",onClose: function( selectedDate ) {
                    //$( "#txtDFrom" ).datepicker( "option", "maxDate", selectedDate );
            }});
        
        $(document).ready(function() {
            
          
            
//            Region validation added, Sagar Jogi dt: 22/09/2017 start
            // define validation rules
            var rules = {
                ignore: ":hidden",
                product_model: {required: true, remote: {url: "<?php echo CFG::$livePath . '/page.php' ?>", type: "post",
                        data: {action: 'checkSrNo', 'current_id':<?php echo APP::$curId != '' ? APP::$curId : 0; ?>}}},
                product_name: {
                    required: true,
                },
            };

            // degine validation message
            var messages = {
                
               product_name: "Please enter product name",
               product_model: {
                    required: "Please enter product model",
                    remote: "Product model already exists"
                },
                
                
            };
            //            Region validation added, Sagar Jogi dt: 22/09/2017 end
            // initialize form validator
            validaeForm("frmUser", rules, messages);
            // load editor
            //  loadEditor("txaDescription");
            
            // initialize popover
            applyPopover();

            // initialize form validator
            validaeForm("frmUser");

            // call form fillup function
            fillForm();

            // display message
            <?php Core::displayMessage("actionResult", "Service Save"); ?>

            //apply tool tip
            applyTooltip();
            

        });
      
 

       $("#btnSave,#btnFooterSave").click(function(event) {
           
            event.preventDefault();
            submitForm(event, $(this));
        });

         // save and continue edit
        $("#btnEdit,#btnFooterEdit").click(function(event) {
            event.preventDefault();
            $("#hdnEdit").val("1");
            submitForm(event, $(this));
        });
         
        function submitForm(event, obj)
        {
            
            event.preventDefault();
			//alert("hi");
            
           
           // else
//            {
                //validTab();
//            }
           
            if ($('#frmUser').valid())
            {
                obj.prop("disabled", true);
                toggleFormLoad("show");
                
                $('#frmUser').submit();
//			   document.getElementById("frmUser").submit();
            }
        }
        
           

        // fillup form if record is set
        function fillForm()
        {
            console.log(userData);
             
            if (userData)
            {
                
                
                
                
              //  $('#role option[value="'+userData.roll_id+'"]').attr("selected", "selected");
                
                $("#product_model").val(userData.product_model);
                $("#product_name").val(userData.product_name);
               /* $("#region_id").val(userData.region_id);
                $("#txtDFrom").val(userData.warranty_start_date);
                $("#txtDTo").val(userData.warranty_end_date);
                $("#txtSell").val(userData.sell_date);
//                $("#qty").val(userData.qty);*/
               
                
                 
                
                
            }
            
        }
         
       
    });
    
    function remove_multiple_region_validation(flag)
    {
        
        var region_count=$("#count").val();

        for(var i=1;i<=region_count;i++)
        {
           
            $("#region"+i).rules('add', {
                required: flag,
                messages: {
                    required: "Please select region"
                }
         });
        }
    }
    function add_multiple_region_validation(total,flag)
    {
        
       
        $("#region"+total).rules('add', {
            
                required: flag,
                uniqRegion: flag,
                messages: {
                    required: "Please select region",
                    uniqRegion : "Please select unique region"
                }
         });
    }
    function add_extra_validation(flag)
    {
        
        /*$("#txtContactEmail").rules('add', {
                required: flag,
                email: true,
                messages: {
                    required: "Please enter email",
                    email: "Please enter valid email"
                }
         });*/
        
                
        $("#customer_type").rules('add', {
                required: flag,
                messages: {
                    required: "Please select type of customer"
                }
         });
         $("#txtDFrom").rules('add', {
                required: flag,
                messages: {
                    required: "Please select contract start date"
                }
         });
         $("#txtDTo").rules('add', {
                required: flag,
                messages: {
                    required: "Please select contract end date"
                }
         });
         $("#txtContactAddress").rules('add', {
                required: flag,
                messages: {
                    required: "Please enter address"
                }
         });
         /*$("#txtContactPhone").rules('add', {
                required: flag,
                minlength: 10,
                messages: {
                    required: "Please enter phone",
                    minlength: "Phone must be 10 digits long"
                }
         });*/
         $("#txtContactCity").rules('add', {
                required: flag,
                messages: {
                    required: "Please enter city"
                }
         });
         $("#txtContactState").rules('add', {
                required: flag,
                messages: {
                    required: "Please select state"
                }
         });
         $("#txtContactPostcode").rules('add', {
                required: flag,
                minlength: 6,
                messages: {
                    required: "Please enter postcode",
                    minlength: "Postcode must have at least 6 digits",
                }
         });
        
    }
    function add_helpdesk_validation(flag)
    {
        
        $("#helpdesk").rules('add', {
                required: flag,
                messages: {
                    required: "Please select help desk manager"
                }
        });
         
    }
    function add_region_validation(flag)
    {
         $("#parent_region").rules('add', {
                required: flag,
                messages: {
                    required: "Please select region"
                }
         });
    }
    $('#helpdesk').on('change', function() {
        
    
        var val=this.value;
        var role=$('#role').val();
        if(val!='')
        {
            $.ajax({
                url: "<?php echo URI::getURL(APP::$moduleName, 'check_region'); ?>",
                type: "post",
                data:"helpdesk_id="+ val+"&role_id="+ role,              
                "success": function(data) {
                    
                    if(data!='')
                    {
                        var selectedParentRegion="";
                        $("#parent_region").empty();
                        $("#parent_region").append('<option value="" disabled="disabled">Please Select Region</option>');
                        $.each(jQuery.parseJSON(data), function(index, value){
                            var disable="";
                            
                            
                            if(value.parent_region==0 && role!='5')
                            {
                                disable='disabled="true"';
                            }
                            
                            if(value.parent_region==0)
                            {
                                $("#parent_region").append('<option value="'+value.id+'" ' + disable + ' >'+value.name+'</option>');
                            }
                            else
                            {
                                $("#parent_region").append('<option value="'+value.id+'" ' + disable + ' >'+"&nbsp;&nbsp;"+value.name+'</option>');
                            }

                       });
                       $("#li_region").show();
                       if($("#role").val()=='5')
                       {
                          $("#region_star").removeClass("star"); 
                         add_region_validation(false);
                       }
                       else
                        {
                            $("#region_star").addClass("star");
                            add_region_validation(true);
                        }
                    }
                }
            });
        }
        else
        {
            if($("#role").val()=='5')
            {
               add_helpdesk_validation(false);
               $("#li_region").hide();
                $("#allRegLi").hide();
               add_region_validation(false);
            }
            else
            {
                $("#li_region").hide();
                 $("#allRegLi").hide();
                add_region_validation(false);
                add_helpdesk_validation(true);
            }
        }
    });
    
   
    $(".table").on('click','.remRG',function(){
   
        var check=true;
        if (confirm("Do you really want to delete this record(s) ?") == false)
        {
            check=false;
        }
       
        if(check==true)
        {
           var count=$("#count").val();
         
           if(count==1)
           {
                /*$('select[name^="region[]"]').each(function(){
                    $('select[name^="region[]"]').find('option:selected').each(function(){
                        $('select[name^="region[]')[0].selectedIndex = 0;
                    });
                });*/
                $('select[name^="region[]')[0].selectedIndex = 0;
                $('input[name^="parsonName[]').val('');
                $('input[name^="regionPhone[]').val('');
                $('input[name^="regionAddress[]').val('');
                
           }
           else
           {
                  var a = $(this).attr('id');
                 
                   selectedIds.splice($.inArray(a, selectedIds),1);
            
                  
               $(this).parent().parent().remove();
                var total=parseInt(count);
                $("#count").val(total);
                
                if($("#count").val() < $("#total_sub_region").val())
                {
                    $("#add_contact_region").show();
                }
           }
        }
        update_region(); 
            
        });
        
    $('.table').on('change', 'select[name^="region[]"]', function(){
        //$('select[name="region[]"] option').attr("disabled","false"); //enable everything
          
        //collect the values from selected;
       update_region(); 
       

    });
    
    function update_region()
    {
        /*var  arr = $.map
        (
           $('select[name="region[]"] option:selected'), function(n)
            {
                 return n.value;
             }
         );


       $('select[name="region[]"] option').filter(function()
       {

           return $.inArray($(this).val(),arr)>-1;
        }).attr("disabled","disabled");   
       $('select[name="region[]"] option').filter(function()
       {
           //alert($.inArray($(this).val(),arr));
           if($.inArray($(this).val(),arr))
               {
                  if($(this).val()==arr) 
                      {
                          $('select[name="region[]"] option').removeAttr("disabled");
                      }
            // alert($(this).val()+" abv "+arr);
           // alert($('select[name="region[]"] option').val());
               }
        });*/
        
        
        /* dt 12-5-2017
        // start by setting everything to enabled
        $('select[name^="region[]"]').each(function(){
           
            $('select[name^="region[]"]').find('option').each(function(){
                if($(this).attr('value')!='')
                {

                //$('select[name*="region[]"] option').attr('disabled',false);
                $(this).attr('disabled',false);
                }
            });
        });
        // loop each select and set the selected value to disabled in all other selects
        $('select[name^="region[]"]').each(function(){
            var $this = $(this);
            $('select[name^="region[]"]').not($this).find('option').each(function(){
               if($(this).attr('value') == $this.val())
                   $(this).attr('disabled',true);
            });
        });*/
        
        
        
    }
   function validTab()
   {
       if (!$('#frmUser').valid())
        {
            var lastp;
            var flag = true;
            $('.tabUl li').each(function() {
                $(this).trigger("click");
                if ($(".error").is(':visible')) {
                    if (flag)
                    {
                        lastp = $(this);
                        flag = false;
                    }
                    $(this).addClass("validTab");
                    //$(this).css("border", "1px solid red");
                }
                else
                {
                   // $(this).css("border", "none");
                    $(this).removeClass("validTab");
                }
            });
            lastp.trigger("click");
        }
   }
function capitalLetter(string)
{
    return string.charAt(0).toUpperCase()+string.slice(1);
}
/* function to add region in combobox when user select engineer as role Added By Sagar Jogi dt 08-06-2017 Started */
   function load_all_region() {
       
        $.ajax({
                url: "<?php echo URI::getURL(APP::$moduleName, 'check_region'); ?>",
                type: "post",
               
                "success": function(data) {
                     
                    if(data!='')
                    {
                        var selectedParentRegion="";
                        $("#parent_region").empty();
                        $("#parent_region").append('<option value="" disabled="disabled">Please Select Region</option>');
                        $.each(jQuery.parseJSON(data), function(index, value){
                            var disable="";
                            
                            
                            if(value.parent_region==0 && role!='5')
                            {
                                disable='disabled="true"';
                            }
                            
                            if(value.parent_region==0)
                            {
                                $("#parent_region").append('<option value="'+value.id+'" ' + disable + ' >'+value.name+'</option>');
                            }
                            else
                            {
                                $("#parent_region").append('<option value="'+value.id+'" ' + disable + ' >'+"&nbsp;&nbsp;"+value.name+'</option>');
                            }

                       });
                       $("#li_region").show();
                        
                       if($("#role").val()=='5')
                       {
                          $("#region_star").removeClass("star"); 
                         add_region_validation(false);
                       }
                       else
                        {
                            $("#region_star").addClass("star");
                            add_region_validation(true);
                        }
                    }
                }
            });
    }
 
   </script> 
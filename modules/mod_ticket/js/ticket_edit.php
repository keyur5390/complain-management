<script type="text/javascript" src="<?php echo URI::getLiveTemplatePath() . '/js/jquery.validate.js' ?>"></script>
<script src="<?php echo URI::getLiveTemplatePath();?>/js/lightgallery.js" type="text/javascript"></script>
<link href="<?php echo URI::getLiveTemplatePath(); ?>/plugins/select/select2.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo URI::getLiveTemplatePath() . "/plugins/select/select2.js" ?>"></script>
<?php $path = URI::getLiveTemplatePath(); ?>
<?php echo UTIL::loadFileUploadJs(); ?>
<?php echo UTIL::loadEditor(); ?>
<script type="text/javascript">


<?php echo Stringd::createJsObject("pageData", $data); ?>

    $(document).ready(function() {
        $('.img_upMain').lightGallery({
        selector: '.zoomImg2'
   });
        $(document).ready(function() {
            
            var rules = {
                txtSubject: {required: true},
                customer: {required: true},
                ticket_problem: {required: true}
            }
               
           
              //hdnImg: {required: true}
           
            var messages = {
                txtSubject: "Please enter ticket subject",
                customer: "Please select customer",
                ticket_problem: "Please select type of problem"
                //lImage: "Please select ticket image"
          
                //hdnImg: "Please select slider image"
            };

            // initialize form validator
            validaeForm("frmTicket", rules, messages);
            // load editor
            //  loadEditor("txaDescription");

            // initialize popover
            applyPopover();

            // initialize form validator
            validaeForm("frmTicket");

            // call form fillup function
            fillForm();
           /* $('#serial_no').select2().on('select2:open', function() {$(".select2-results:not(:has(a))").append('<div class="select2-link"><a>Other</a></div>').on('click', function (b) {
                          $('#otherDiv').show();
             $( "#other_serial_no" ).rules( "add", {
                required: true,
                messages: {
                  required: "Please enter other product sr. no",
                }
              });
              $('#dateLbl').hide();
              $('#dateLbl').html('');
              
              $("#serial_no").append('<option value="other">Other</option>');
               $('#serial_no').val('other').trigger('change');
                            // add your code
                       });;});*/
        $("#serial_no").select2({
                tags: true
        });
     
   
        
                    
                    
/*$('#serial_no').select2({  
    allowClear:true
 });*/
            // display message
<?php Core::displayMessage("actionResult", "Ticket"); ?>

            //apply tool tip
            applyTooltip();

        });
        // save
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
            
            var fileName = $("input[name=flImage_hdn]").val();
            $('#hdnImg').val(fileName);   
             var fileName1 = $("input[name=flImage1_hdn]").val();
            $('#hdnImg1').val(fileName1);   
            event.preventDefault();
            add_region_validation(true);
            <?php if(isset($_SESSION['user_login']) && $_SESSION['user_login']['roll_id']!='7' && $_SESSION['user_login']['roll_id']!='6'){?>
           
                 add_engineer_validation(true);
            <?php }?>
           
            if ($('#frmTicket').valid())
            {
                 var current_status=$("#ticket_status").val();
                 var check=true;
               
                 if( pageData['ticketData'] && current_status!=pageData['ticketData'].ticket_status)
                 {
                    if (confirm("Do you really want to change status for this record(s) ?") == false)
                    {
                        check=false;
                    }
                 }
                 if(check==true)
                 {
                    $('#customer').prop('disabled', false);
                    $('#ticket_problem').prop('disabled', false);

                   obj.prop("disabled", true);
                   toggleFormLoad("show");
                   $('#frmTicket').submit();
                 }
            }
        }
        var selectedCustomer="";
        $("#customer").empty();
        $("#customer").append('<option value="">Select Customer</option>');
        $.each(pageData['customerData'], function(Key1,Value1) {
             
            if( pageData['ticketData'] && pageData['ticketData'].user_id==Value1.id)
            {
                selectedCustomer="Selected";
            }
            else
            {
                selectedCustomer=""; 
            }
          
            $("#customer").append('<option value="'+Value1.id+'" ' + selectedCustomer + ' >'+Value1.name+'</option>');
        });
        
        if(pageData['customerRegion'])
        {
           $("#li_region").show();

            var regionFlag=false;
            var selectedParentRegion="";
            $("#parent_region").empty();
            if(pageData['customerRegion'].length > 1)
            {
                $("#parent_region").append('<option value="">Please select region</option>');
            }
           //var region=pageData['ticketData'].region.split(",");
           
            $.each(pageData['customerRegion'], function(parentRegionKey,parentRegionValue) {

                    if( pageData['ticketData'] && pageData['ticketData'].region_id==parentRegionValue.id)
                    {
                        selectedParentRegion="Selected";
                    }
                    else
                    {
                        selectedParentRegion=""; 
                    }
                   
                $("#parent_region").append('<option value="'+parentRegionValue.id+'" ' + selectedParentRegion + ' >'+parentRegionValue.name+'</option>');
            });
        }
        
    });

    // fillup form if record is set
    function fillForm()
    {
       
       createUploader("flImage", "fileProgress", "files", displayUploadResult, "<?php echo URI::getURL("mod_admin", "upload_image") ?>", ["JPG","jpg","JPEG","jpeg", "gif","GIF", "png","PNG"], "<?php echo CFG::$ticketDir; ?>", "<?php echo URI::getURL("mod_ticket", "ticket_delete_file") ?>", (pageData['ticketData'] ? [{"name": pageData['ticketData'].image_name, "title": pageData['ticketData'].image_title, "alt": pageData['ticketData'].image_alt}] : ""), ((pageData['ticketData']) ? pageData['ticketData'].id : ""));

     
       createUploader("flImage1", "fileProgress1", "files1", displayUploadResult, "<?php echo URI::getURL("mod_admin", "upload_image") ?>", ["JPG","jpg","JPEG","jpeg", "gif","GIF", "png","PNG", "doc","DOC", "pdf","PDF", "docx","DOC"], "<?php echo CFG::$ticketDir; ?>", "<?php echo URI::getURL("mod_ticket", "ticket_delete_report") ?>", (pageData['ticketData'] ? [{"name": pageData['ticketData'].attach_report, "title": pageData['ticketData'].image_title, "alt": pageData['ticketData'].image_alt}] : ""), ((pageData['ticketData']) ? pageData['ticketData'].id : ""));
      
    
      
        if (pageData['ticketData'])    // fill form data if passed
        {
           
            $("#txtSubject").val(pageData['ticketData'].subject);
            
            getSerialNo(pageData['ticketData'].user_id);
            $(document).ajaxStop(function() {
   if(pageData['ticketData'].serial_no){
                $("#serial_no").val(pageData['ticketData'].serial_no).trigger('change');
            } else {
                $("#serial_no").append('<option value="'+pageData['ticketData'].other_serial_no+'">'+pageData['ticketData'].other_serial_no+'</option>');
                $("#serial_no").val(pageData['ticketData'].other_serial_no).trigger('change');
                $("#other_serial_no").val(pageData['ticketData'].other_serial_no);
            }
});
           
            // check tinyMCE is initialized or not
            if (tinyMCE.activeEditor == null)
            {
                
                var desc=pageData['ticketData'].description;
                if(desc!='')
                    $("#ticket_desc").html(desc);
                else
                    $("#li_desc").css("display","none");
               // $("#txaDescription").val().replace("/\r\n|\r|\n/g","<br />");
                
            }
            else
                tinyMCE.get("txaDescription").setContent(pageData['ticketData'].description);
            
            //$("#sortOrder").val(pageData['ticketData'].sort_order);
           
            $("#li_ticket").show();
            
            $('#ticket_problem option[value="'+pageData['ticketData'].problem_type+'"]').attr("selected", "selected");
            if (pageData['ticketData'].ticket_status!='')
            {
                $('#ticket_status option[value="'+pageData['ticketData'].ticket_status+'"]').attr("selected", "selected");
            }
            if (pageData['ticketData'].status == 1)
            {
                $("#chkStatus").attr("checked", "checked");
                $("#checkAct").html("Active");
            }
            else if (pageData['ticketData'].status == 0)
            {
                $("#chkStatus").removeAttr("checked");
                $("#checkAct").html("Inactive");
            }
            
            if(pageData['ticketData'].region_id!='' && pageData['ticketData'].region_id!=null)
            {
                    $("#li_region").show();
                    add_region_validation(true);
                    var regionFlag=false;
                    var selectedParentRegion="";
                    $("#parent_region").empty();
                    <?php if(isset($_SESSION['user_login']) && $_SESSION['user_login']['roll_id']!='6' ){?>
                    $("#parent_region").append('<option value="">Please select region</option>');
                    <?php }?>
                   //var region=pageData['ticketData'].region.split(",");

                    $.each(pageData['parentRegionData'], function(parentRegionKey,parentRegionValue) {

                            if(pageData['ticketData'].region_id==parentRegionValue.id)
                            {
                                selectedParentRegion="Selected";
                            }
                            else
                            {
                                selectedParentRegion=""; 
                            }
                             <?php if(isset($_SESSION['user_login']) && $_SESSION['user_login']['roll_id']=='6' ){?>
                                     if(selectedParentRegion!='')
                                     {
                                        $("#parent_region").append('<option value="'+parentRegionValue.id+'" ' + selectedParentRegion + ' >'+parentRegionValue.name+'</option>');
                                     }
                             <?php }else
                             {?>
                                     $("#parent_region").append('<option value="'+parentRegionValue.id+'" ' + selectedParentRegion + ' >'+parentRegionValue.name+'</option>');
                             <?php
                             }?>
                    });
                    
            }
            
            if(pageData['ticketData'].engineer_id!='' && pageData['ticketData'].engineer_id!=null)
            {
                    $("#li_engineer").show();

                    var regionFlag=false;
                    var selectedParentRegion="";
                    $("#engineer").empty();
                     <?php if(isset($_SESSION['user_login']) && $_SESSION['user_login']['roll_id']!='6' ){?>
                    $("#engineer").append('<option value="">Please select engineer</option>');
                     <?php }?>
                   //var region=pageData['ticketData'].region.split(",");

                    $.each(pageData['ticketEngineerData'], function(parentRegionKey,parentRegionValue) {

                            if(pageData['ticketData'].engineer_id==parentRegionValue.id)
                            {
                                selectedParentRegion="Selected";
                            }
                            else
                            {
                                selectedParentRegion=""; 
                            }
                       <?php if(isset($_SESSION['user_login']) && $_SESSION['user_login']['roll_id']=='6' ){?>
                                var engineer_id="<?php echo $_SESSION['user_login']['id'];?>";
                                if(engineer_id==parentRegionValue.id)
                                {
                                    $("#engineer").append('<option value="'+parentRegionValue.id+'" ' + selectedParentRegion + ' >'+parentRegionValue.name+'</option>');
                                 }
                       <?php }
                       else{?>
                           $("#engineer").append('<option value="'+parentRegionValue.id+'" ' + selectedParentRegion + ' >'+parentRegionValue.name+'</option>');
                       <?php }
                       ?>
                    });
            }
            

        }

        toggleFormLoad("hide"); // hide form load div
    }
    $('#customer').on('change', function() {
        
       
        var val=this.value;
        if(val!='')
        {
             $('.qLoverlay-new').addClass('showProcess');
            $.ajax({
                url: "<?php echo URI::getURL(APP::$moduleName, 'customer_region'); ?>",
                type: "post",
                data:"customer_id="+ val,              
                "success": function(data) {
//                    alert(data);
                    console.log(data);
                    if(data!='')
                    {
                        var selectedParentRegion="";
                        $("#parent_region").empty();
                        $("#parent_region").append('<option value="">Please select region</option>');
                        $.each(jQuery.parseJSON(data), function(index, value){
                            var disable="";
                            
                            if(value.parent_region==0)
                            {
                                disable='disabled="true"';
                            }
                            $("#parent_region").append('<option value="'+value.id+'" ' + disable + ' >'+value.name+'</option>');


                       });
                       $("#li_region").show();
                       add_region_validation(true);
                    }
                }
            });
            getSerialNo(val);
//             $('.qLoverlay-new').removeClass('showProcess');
        }
        else
        {
            $("#li_region").hide();
            add_region_validation(false);
        }
       
    });
    $('#parent_region').on('change', function() {
        
  
        var val=this.value;
      
        if(val!='')
        {
            $.ajax({
                url: "<?php echo URI::getURL(APP::$moduleName, 'customer_region'); ?>",
                type: "post",
                data:"region_id="+ val,              
                "success": function(data) {
                    
                    if(data!='')
                    {
                        var selectedParentEngineer="";
                        $("#engineer").empty();
                        $("#engineer").append('<option value="">Please select engineer</option>');
                        $.each(jQuery.parseJSON(data), function(index, value){
                            
                            $("#engineer").append('<option value="'+value.id+'" >'+value.name+'</option>');


                       });
                       $("#li_engineer").show();
                       $("#li_engineer").addClass("required");
                       add_engineer_validation(true);
                    }
                    
                }
            });
        }
        else
        {
            $("#li_engineer").hide();
            $("#li_engineer").removeClass("required");
            add_engineer_validation(false);
            add_region_validation(true);
        }
    });
    $('#ticket_status').on('change', function() {
        
  
        var val=this.value;
       
        if(val!='')
        {
            if(val=='closed')
            {
                $("#li_comment").show();
                $("#li_attach_report").show();
                $("#flImage1").addClass("required");
                $("#comment").addClass("required");
                add_comment_validation(true);
            }
            else
            {
                $("#li_attach_report").hide();
                $("#flImage1").removeClass("required");
                $("#li_comment").show();
                $("#comment").addClass("required");
                add_comment_validation(true);
            }
                    
        }
        else
        {
           $("#li_comment").hide();
           $("#li_attach_report").hide();
           $("#flImage1").removeClass("required");
           $("#comment").removeClass("required");
           add_status_validation(true);
        }
    });
     $('#serial_no').on('change', function() {
         /*if($(this).val()!='' && $(this).val()=='other'){
//             $('#otherDiv').show();
             $( "#other_serial_no" ).rules( "add", {
                required: true,
                messages: {
                  required: "Please enter other product sr. no",
                }
              });
              $('#dateLbl').hide();
              $('#dateLbl').html('');
         } else {*/
             
             if($(this).val()!='' && $('#serial_no :selected').attr('data-sd')!=undefined){
                $('#dateLbl').show();
              $('#dateLbl').html('<div class="wraProMain"><div class="wrrantyPrductModel1"><label class="datelbl">Warranty : </label><span> <strong>Start Date: </strong>'+$('#serial_no :selected').attr('data-sd')+' </span><span><strong>End Date: </strong>'+$('#serial_no :selected').attr('data-ed')+'</span></div><div class="wrrantyPrductModel2"><label class="datelbl">Model No : </label><span> '+$('#serial_no :selected').attr('data-model')+' </span></div></div>');
              
             $('#product_model').val($('#serial_no :selected').attr('data-model')); 
             $('#product_name').val($('#serial_no :selected').attr('data-productname')); 
              // $('#productModelLbl').html('<label class="datelbl">Product Model: </label><span> '+$('#serial_no :selected').attr('data-model')+' </span>');
//               $('#otherDiv').hide();
//             $( "#other_serial_no" ).rules( "remove" );
 $( "#other_serial_no" ).val('');
             } else {
                 
//             $('#otherDiv').hide();
//             $( "#other_serial_no" ).rules( "remove" );
//alert($(this).val());
             $( "#other_serial_no" ).val($('#serial_no :selected').val());
             $('#dateLbl').hide();
              $('#dateLbl').html('');
             }
         /*}*/
    });
    function add_region_validation(flag)
    {
        
         $("#parent_region").rules('add', {
                required: flag,
                messages: {
                    required: "Please select region"
                }
         });
    }
    
    function add_comment_validation(flag)
    {
        
         $("#comment").rules('add', {
                required: flag,
                messages: {
                    required: "Please enter comment"
                }
         });
    }
    function add_status_validation(flag)
    {
        
         $("#ticket_status").rules('add', {
                required: flag,
                messages: {
                    required: "Please select region"
                }
         });
    }
    function add_engineer_validation(flag)
    {
        
        $("#engineer").rules('add', {
                required: flag,
                messages: {
                    required: "Please select engineer"
                }
         });
    }
    $('#files,.imgMain').click(function(e){ 
      
        if(e.target.id=='files' || $(e.target).attr('class')=='imgMain')
        {
            $('#flImage').trigger('click'); 
        }
        
    });
   $('#files1,.imgMain').click(function(e){ 
       
        if(e.target.id=='files1' || $(e.target).attr('class')=='imgMain')
        {
            $('#flImage1').trigger('click'); 
        }
    });
//$(document).ready(function() {
//        $('.img_upMain').lightGallery({
//        selector: '.zoomImg'
//   });
//   $('.img_upMain1').lightGallery({
//        selector: '.zoomImg1'
//   });
//});
       function br2nl(str) {
        //return str.replace(/<br *\/?>/gi,"\n");
        return str.replace(/<br *\/?>/gi,"");
        
}
function getSerialNo(cid){
    $.ajax({
                url: "<?php echo URI::getURL(APP::$moduleName, 'ticket_edit'); ?>",
                type: "post",
                data:"customer_id="+ cid,              
                "success": function(data) {
//                    alert(data);
//                    console.log(data);
                    $("#serial_no").html('<option value="">Serial No</option>');
                    $("#serial_no").append(data);
                    $('.qLoverlay-new').removeClass('showProcess');
                    
                   
                }
            });
}
</script>
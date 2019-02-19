<script type="text/javascript" src="<?php echo URI::getLiveTemplatePath() . '/js/jquery.validate.js' ?>"></script>
<script src="<?php echo URI::getLiveTemplatePath();?>/js/lightgallery.js" type="text/javascript"></script>
<?php $path = URI::getLiveTemplatePath(); ?>
<?php echo UTIL::loadFileUploadJs(); ?>
<?php echo UTIL::loadEditor(); ?>
<script type="text/javascript">


<?php echo Stringd::createJsObject("pageData", $data); ?>

    $(document).ready(function() {
        $('.rightData, .leftData').lightGallery({
        selector: '.zoomImg'
   });
   $('.commentImageZoom').lightGallery({
        selector: '.zoomImg1'
   });
        $(document).ready(function() {
            
            var rules = {
                comment: {required: true}

               
           
              //hdnImg: {required: true}
            };
            var messages = {
                comment: "Please enter comment"
          
                //hdnImg: "Please select slider image"
            };

            // initialize form validator
            validaeForm("frmComment", rules, messages);
            validaeForm("frmComment1", rules, messages);
            // load editor
            //  loadEditor("txaDescription");

            // initialize popover
            applyPopover();

            // initialize form validator
            validaeForm("frmComment");
            validaeForm("frmComment1");

            // call form fillup function
            fillForm();

            // display message
<?php Core::displayMessage("actionResult", "Ticket Comment Save"); ?>

            //apply tool tip
            applyTooltip();

        });
        // save
        $("#btnSubmit").click(function(event) {
            
            event.preventDefault();
            submitForm(event, $(this));
        });

        $("#btnOtherSubmit").click(function(event) {
            
            event.preventDefault();
            submitForm1(event, $(this));
        });

        function submitForm(event, obj)
        {
            
           <?php
           /* if(isset($_SESSION['user_login']) && $_SESSION['user_login']['roll_id']!='7' )
            {
            ?>
           $("#ticket_status").rules('add', {
                required: true,
                messages: {
                    required: "Please select status"
                }
            });
            <?php }*/?>
            event.preventDefault();
            if ($('#frmComment').valid())
            {
                obj.prop("disabled", true);
                toggleFormLoad("show");
                $('#frmComment').submit();
            }
            
        }
        function submitForm1(event, obj)
        {
     
            event.preventDefault();
            
            if ($('#frmComment1').valid())
            {
                obj.prop("disabled", true);
                toggleFormLoad("show");
                $('#frmComment1').submit();
            }
        }
       
        
       
    });
 
 
$(function(){  
 /*$("a.reply").click(function() {  
  var id = $(this).attr("id");  
  $("#parent_id").attr("value", id);  
 });  */
});  

    // fillup form if record is set
    function fillForm()
    {
       
       
        if (pageData['ticketData'])    // fill form data if passed
        {
           
            $("#txtSubject").val(pageData['ticketData'].subject);
            
            // check tinyMCE is initialized or not
            if (tinyMCE.activeEditor == null)
                $("#txaDescription").val(pageData['ticketData'].description);
            else
                tinyMCE.get("txaDescription").setContent(pageData['ticketData'].description);
            
            $("#sortOrder").val(pageData['ticketData'].sort_order);
           
            $("#li_ticket").show();
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

                    var regionFlag=false;
                    var selectedParentRegion="";
                    $("#parent_region").empty();
                    $("#parent_region").append('<option value="">Please select region</option>');

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
                        $("#parent_region").append('<option value="'+parentRegionValue.id+'" ' + selectedParentRegion + ' >'+parentRegionValue.name+'</option>');
                    });
            }
            
            if(pageData['ticketData'].engineer_id!='' && pageData['ticketData'].engineer_id!=null)
            {
                    $("#li_engineer").show();

                    var regionFlag=false;
                    var selectedParentRegion="";
                    $("#engineer").empty();
                    $("#engineer").append('<option value="">Please select region</option>');

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
                        $("#engineer").append('<option value="'+parentRegionValue.id+'" ' + selectedParentRegion + ' >'+parentRegionValue.name+'</option>');
                    });
            }
            

        }

        toggleFormLoad("hide"); // hide form load div
    }
    $(document).ready(function() {  
    
        $("a.reply").click(function() {  
            
           var html = $('#replymsgbox').html();
          // alert(html);
           var id=$(this).attr("id");
           var remove="<a href='#comment_form' class='abc'  onclick='return removePost("+id+");'>Remove</a>";
           $.ajax({
                url: "<?php echo URI::getURL(APP::$moduleName, 'edit_comment'); ?>",
                type: "post",
                data:"comment_id="+ id,              
                "success": function(data) {
                    //alert(data);
                    if(data!='')
                    {
                       var content=data+remove;
                       $("#main_comment").hide();
                       $("#reply_body"+id).html(content);
                    }
                }
            });
           
           /*var content=html+remove;
           $("#main_comment").hide();
           $("#reply_body"+id).html(content);
           
           $(".parent_class").val(id);*/
           
        }); 
        
      
});  
function removePost(id)
{
    if(id!='' && id!=null)
    {
        $("#reply_body"+id).html('');
        $("#main_comment").show();
        return true;
    }
    else
    {
        return false
    }
}
function submitPost(id)
{
   
    var rules = {
      comment: {required: true}

      };
    var messages = {
        comment: "Please enter comment"

        //hdnImg: "Please select slider image"
    };
     validaeForm("frmReply"+id, rules, messages);    
           
    if ($('#frmReply'+id).valid())
    {
       return true;
    }
     return false;
}
function deleteComment(url)
{
           
    if (url != "") {
        if (confirm("Do you really want to delete this comment(s) ?") == false)
        {
            return false;
        }
        else
        {
            window.location.href=url;
        }
    } else 
    {
        return false;
    }
}
</script>
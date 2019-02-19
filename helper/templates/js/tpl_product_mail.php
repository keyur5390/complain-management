<link rel="stylesheet" href="<?php echo URI::getLiveTemplatePath(); ?>/plugins/multiselect/jquery.multiselect.css" />    
<script src = "<?php echo URI::getLiveTemplatePath(); ?>/plugins/multiselect/jquery.multiselect.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#selSendTo').change(function(e) {
            if($(this).val()!=null){
            var to = $(this).val().toString();
            $('#other_emails').hide();
            if (to.toLowerCase() == "other")
                $('#other_emails').show();
            }
        });
        $('#selSendCC').change(function(e) {
            var to = $(this).val();
            $('#other_emails_cc').hide();
            if (to.toLowerCase() == "other")
                $('#other_emails_cc').show();
        });
        
        $('#send_to_all').change(function(){
          if($(this).prop("checked") == true){
            $("#selSendTo").empty();
            $("#selSendTo").prop("disabled", true);
            $("#hascustomer").val("");
          }
          else
          {
            $("#selSendTo").prop("disabled", false);
          }
          
          
        });
        $.validator.addMethod("multiemail", function (value, element) {
            if (this.optional(element)) {
            return true;
            }

            var emails = value.split(','),
            valid = true;

            for (var i = 0, limit = emails.length; i < limit; i++) {
            value = emails[i];
            valid = valid && jQuery.validator.methods.email.call(this, value, element);
            }

            return valid;
            }, "Invalid email format: please use a comma to separate multiple email addresses.");
            
            
            
    });

    function open_dialog() {
        div = $(".mail_dialog");
        var table_data = "";

        div.html();
        div.dialog({
            autoOpen: true,
            modal: true,
            title: "Send Email",
            draggable: true,
            resizable: false,
            width: "800",
            height: "690",
            dialogClass: 'dialog',
            closeOnEscape: false,
            position: ['center', 50],
            open: function() {
                $("#txtOtherCC, #selSendCC").val("");
                
                $.each($('#tblImg li'), function(k, v) {
                    if ($(v).attr('id') != "") {
                        $(this).remove();
                    }
                })
                load_customer_select();
                getCustomerEmailDropDowm();
                
                $('#mail_subject').val('Ticket Report');
                
                var rules = {
                    'selSendTo[]': {required:true},
                    subject: {required:true},
                    comment:{required:true},
                   
                };
                var messages = {
                    'selSendTo[]': {required: "Please select email"},
                    subject: {required:"Please enter email subject"},
                    comment:{required:"Please enter comments"},
                };

                // initialize form validator
                validaeForm("frmMail", rules, messages);
                validaeForm("frmMail");

                

                $("#cancel").off("click");
                $("#cancel").on("click", function() {
                    div.find("input").val("");
                    div.dialog("close");
                });
                $(".ui-dialog-buttonset").find("button:first").html("Send").addClass("applyTooptip").attr("data-title", "send");
                $(".ui-dialog-buttonset").find("button:last").html("Cancel").addClass("applyTooptip").attr("data-title", "cancel");
                $(".ui-dialog-buttonset").find("button").addClass("btn btn-primary");
                applyTooltip();
               
                div.find("label.text-error").remove();
                $(".mceEditor").remove();
                $("#txtAdjustComment").val(window.user_signature);
                $('#mail_subject').val('Ticket Report');
                $("#txtAdjustComment").val('');
                var livePath = '<?php echo CFG::$livePath; ?>';
                $("#txtAdjustComment").val();
                loadEditor("txtAdjustComment");
                $(".mceEditor").show();
                
                obj = "";
                last = "";

               // var multiDeleteUrl = "index.php?m=mod_admin&a=delete_images&upload=multi-image";
              //  createUploader("location_image", "tblImg", "location_image", "index.php?m=mod_admin&a=upload_multi_image", "attachment", "Upload Document", "hdnImg", multiDeleteUrl, obj, last, "", "location_images", "images", "id", "", "<?php //echo base64_encode(CFG::$absPath . "/media"); ?>");
                
                 createUploader("flImage3", "fileProgress", "files", displayUploadResult, "<?php echo URI::getURL("mod_admin", "upload_image") ?>", ["jpg", "gif", "png","jpeg", "JPG", "PNG", "GIF" ,"JPEG"], "<?php echo CFG::$ticketDir; ?>", "<?php echo URI::getURL("mod_ticket", "ticket_delete_file") ?>", '', '');
                
            },
            buttons: {
                "send_email": function(e) {
                    
                        $("#txtAdjustComment").val(tinyMCE.activeEditor.getContent());
						
                        var mail_url = "";
                        
                        mail_url = '<?php echo URI::getURL(APP::$moduleName, "send_email", "", "send_mail=true"); ?>';
                        
                        if($('#frmMail').valid())
                        {
                            send_email(mail_url);
                        }
                        $("#txtAdjustComment").val("");
                },
                "close": function() {
                    dropDownCloseAction();
                    $(".tooltip").remove();
                    $(".mceEditor").remove();
                    $.ajax({
            url: '<?php echo URI::getURL(APP::$moduleName,"export_report");?>',
            data: "filenamedata="+$("#attachementD").val()+"&ajax=deletefile",
            type: "post",
            success: function(data) {
    //                displayMessage("success", "Ticket report", "Ticket report email sent successfully");
    //                div.dialog("close");
            $('#attachementD').val(data);
                }
            });
                }
            },
            close: function() {
                dropDownCloseAction();
                $(".tooltip").remove();
                $(".mceEditor").remove();
                
                div.dialog("destroy");
            },
        })
    }

    function send_email(mailUrl) {
        $(".ui-dialog-buttonset").find(":button:last").remove();
        $(".tooltip").remove();
        $(".ui-dialog-buttonset").find(":button:first").prop("disabled", "disabled").html("Sending...");
        var mail_url = mailUrl;
        $.ajax({
            url: mail_url,
            data: $("#frmMail").serialize(),
            type: "post",
            success: function() {
                displayMessage("success", "Ticket report", "Ticket report email sent successfully");
                div.dialog("close");
            }
        })
    }

    function getCustomerEmailDropDowm() {
        
        var livePath = '<?php echo CFG::$livePath; ?>';
        $.ajax({
            type: "post",
            dataType: "json",
            data: "all_customer_email=true",
            url: livePath + "/page.php", // url of php page where you are writing the query
            success: function(response)
            {
                $('#selSendTo').html('');
                $('#selSendTo').html('<option value="">Please select email</option>');
                $('#selSendCC').html('');
                $('#selSendCC').html('<option value="">Please select email</option>');

                if (response != null && response != "") {
                    var data1 = new Array();
                    $.each(response, function(k, response) {
                        
                        str = "";
                        if (response.name != "")
                        {   
                            var str = "(";
                            str += response.name; 
                        }
                        if (typeof response.mainEmail != 'undefined' && response.mainEmail == 1 && response.name != "")
                        {
                            str += " - Main Contact ";
                        }
                        if (response.name != "")
                        {
                            str += ")";
                        }
                        data1.push({id: response.email, text: response.email , names: str });
                    })
                    $('#selSendTo').select2({
                        "data": data1,
                        "placeholder": "Select email address",
                        templateResult: setCurrency,
                        templateSelection: setCurrency
                    })
                    $('#selSendCC').select2({
                        "data": data1,
                        "placeholder": "Select CC email address",
                        templateResult: setCurrency,
                        templateSelection: setCurrency
                    })
                   
                    
                }
                function setCurrency (currency) {
                    if (!currency.id) { return currency.text; }
                    var $currency = $('<span class="glyphicon glyphicon">' + currency.text +'  <b>'+ currency.names+'</b></span>');
                    return $currency;
                };


            }
        });
        
//        $.ajax({
//            type: "post",
//            dataType: "json",
//            data: "action=get_mailsubject&mail_quote_id=" + quoteId,
//            url: livePath + "/page.php", // url of php page where you are writing the query
//            success: function(response)
//            {
//                $('#mail_subject').val(response.mail_subject);
//                $("#txtAdjustComment").val(response.mail_body);
//                loadEditor("txtAdjustComment");
//            }
//        });
    }

    function dropDownCloseAction() {
        $('#other_emails').hide();
        $('#txtOther').val("");
        $('#send_to_all').prop("checked",false);
        $("#selSendTo").prop("disabled", false);
        $('#hascustomer').val("");
        $("#selSendTo").empty();
        $('#other_emails_cc').hide();
        $('#txtOtherCC').val("");
        $("#selSendCC").empty();
        
        div.dialog("close");
    }

   function restoreSaveEmailCheckbox() {
    $.uniform.restore("#save_to_email,#save_cc_email")
    $("#save_to_email,#save_cc_email").removeAttr("checked");
    $("#save_to_email,#save_cc_email").uniform();
}
</script>



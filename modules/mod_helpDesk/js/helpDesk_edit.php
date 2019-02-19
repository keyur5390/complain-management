<script type="text/javascript" src="<?php echo URI::getLiveTemplatePath() . '/js/jquery.validate.js' ?>"></script>

<script type="text/javascript" src="<?php echo URI::getLiveTemplatePath(); ?>/plugins/select/select2.full.js"></script>  <!-- select2.full.css -->
<link href="<?php echo URI::getLiveTemplatePath(); ?>/plugins/select/select2.min.css" type="text/css" rel="stylesheet"/> <!-- select2.min.css -->

<script type="text/javascript">
<?php echo Stringd::createJsObject("pageData", $data); ?>

    $(document).ready(function() {
        
        var user_id = '';
        if (pageData['helpDeskData'])    // fill form data if passed
        {
            user_id = pageData['helpDeskData'].id;
        }

        $(document).ready(function() {
            
            var rules = {
                name: {required: true},
                code: {
                    required: false,
                    minlength: 3,
//                    usernameValue: true,
                    whitespaceValue: true,
                    remote: {
                        url: "<?php echo URI::getURL(APP::$moduleName, APP::$actionName) ?>&ajaxCall=yes",
                        type: "post",
                        data: 
                        {
                            code: function() 
                            {
                                return $("#code").val();
                            },
                            id: user_id 
                        }
                    }
                },
                "manager[]": {required: true}
            };
            var messages = {
                name: "Please enter help desk name",
                code: 
                {
                    required: "Please enter help desk code",
                    minlength: "Help desk code must have at least 3 characters",
//                    usernameValue: "Username should not start with underscore (_)",
                    whitespaceValue: "White space not allowed in help desk code",
                    remote: "Help desk code already exist with this help desk code"
                },
                "manager[]":"Please select help desk"
            };

            // initialize form validator
            validaeForm("frmHelpDesk", rules, messages);
            
            // initialize popover
            applyPopover();

            // call form fillup function
            fillForm();

            // display message
<?php Core::displayMessage("actionResult", "Help Desk Save"); ?>

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
            event.preventDefault();
            if ($('#frmHelpDesk').valid())
            {
                obj.prop("disabled", true);
                toggleFormLoad("show");
                $('#frmHelpDesk').submit();
            }
        }
        
        $(".progControlSelect2").select2({
                placeholder: "Enter Help Desk"//Placeholder
        });
        
        $(".progControlSelect2_1").select2({
                placeholder: "Enter Parent Region",//Placeholder
        });
        
    });


        var selectedRegion="";
        var SaveRegion=[];
        if(pageData['helpDeskData'])
        {
            SaveRegion=pageData['helpDeskData'].parent_region;
        }
        
        
        
//        var SaveRegion=pageData['helpDeskData'].region;
        var save_region = [];
        (SaveRegion.length > 0) ? save_region = SaveRegion.split(",") : save_region = SaveRegion;
//        console.log(SaveRegion);
        $("#region").empty();
//        $("#region").append('<option value="">Select Region</option>');
        $.each(pageData['allRegionData'], function(RegionKey,RegionValue) {
            if(pageData['helpDeskData'])
            {
                if(save_region.length > 0){
                    if(jQuery.inArray( RegionValue.id, save_region ) >= 0)
                    {
                        
                        (jQuery.inArray( RegionValue.id, save_region ) >= 0) ? selectedRegion="selected" : selectedRegion="";
                        $("#region").append('<option  value="'+RegionValue.id+'" ' + selectedRegion + ' >'+RegionValue.name+'</option>');
                    }
                }
                selectedRegion="";
                
                
            }
            if(pageData['remainRegionData'])
            {
                $.each(pageData['remainRegionData'], function(remainKey,remainValue) {
                    
                    if(RegionValue.id==remainValue.id)
                    {
                     $("#region").append('<option  value="'+RegionValue.id+'"  >'+RegionValue.name+'</option>');
                    }
                });
               
                
            }
            
        });
        
        
        var selectedHelpDeskManager="";
        var SaveHelpDeskManager=[];
        if(pageData['helpDeskData'])
        {
            SaveHelpDeskManager=pageData['helpDeskData'].manager;
        }
//        var SaveHelpDeskManager=pageData['helpDeskData'].manager;
        var save_helpDesk_manager = [];
        (SaveHelpDeskManager.length > 0) ? save_helpDesk_manager = SaveHelpDeskManager.split(",") : save_helpDesk_manager = SaveHelpDeskManager;
        
        
        $("#manager").empty();
//        $("#manager").append('<option value="">Select Help Desk Manager</option>');
        $.each(pageData['helpDeskManagersData'], function(Key,Value) {
            if(pageData['helpDeskData'])
            {

//                if(pageData['helpDeskData'].helpDesk==Value.id)
//                {
//                    selectedHelpDeskManager="Selected"; 
//                }
//                else
//                {
//                    selectedHelpDeskManager=""; 
//                }
                    
                    if(save_helpDesk_manager.length > 0){
                        if(jQuery.inArray( Value.id, save_helpDesk_manager ) >= 0)
                        {
                            (jQuery.inArray( Value.id, save_helpDesk_manager ) >= 0) ? selectedHelpDeskManager="selected" : selectedHelpDeskManager="";
                            $("#manager").append('<option  value="'+Value.id+'" ' + selectedHelpDeskManager + ' >'+Value.name+'</option>');
                        }
                    }
                    selectedHelpDeskManager=""; 
                    
            }
            if(pageData['remainingManagerData'])
            {
                $.each(pageData['remainingManagerData'], function(remainManagerKey,remainManagerValue) {
                
                    if(Value.id==remainManagerValue.id)
                    {
                     $("#manager").append('<option  value="'+remainManagerValue.id+'"  >'+remainManagerValue.name+'</option>');
                    }
                });
               
                
            }
            
        });
        
    // fillup form if record is set
    function fillForm()
    {
        if (pageData['helpDeskData'])    // fill form data if passed
        {  
            $("#name").val(pageData['helpDeskData'].name);
            $("#code").val(pageData['helpDeskData'].code);
//            $("#region").val(pageData['helpDeskData'].region);
//            $("#manager").val(pageData['helpDeskData'].manager);
            //$("#sortOrder").val(pageData['helpDeskData'].sort_order);
            
            if (pageData['helpDeskData'].status == 1)
            {
                $("#chkStatus").attr("checked", "checked");
                $("#checkAct").html("Active");
            }
            else if (pageData['helpDeskData'].status == 0)
            {
                $("#chkStatus").removeAttr("checked");
                $("#checkAct").html("Inactive");
            }
        }
        toggleFormLoad("hide"); // hide form load div
    }
    
</script>

<?php // include CFG::$absPath . '/' . CFG::$helper . "/templates/js/add_new_parent_region.php"; ?>
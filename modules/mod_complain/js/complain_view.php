<script type="text/javascript" src="<?php echo URI::getLiveTemplatePath() . '/js/jquery.validate.js' ?>"></script>

<script type="text/javascript" src="<?php echo URI::getLiveTemplatePath(); ?>/plugins/select/select2.full.js"></script>  <!-- select2.full.css -->
<link href="<?php echo URI::getLiveTemplatePath(); ?>/plugins/select/select2.min.css" type="text/css" rel="stylesheet"/> <!-- select2.min.css -->
<?php $path = URI::getLiveTemplatePath(); ?>
<?php echo UTIL::loadFileUploadJs(); ?>
<?php echo UTIL::loadEditor(); ?>

<script type="text/javascript">
<?php echo Stringd::createJsObject("pageData", $data); ?>

    $(document).ready(function() {

        var user_id = '';
        if (pageData['complainData'])    // fill form data if passed
        {
            user_id = pageData['complainData'].id;
        }

        $('input[type=radio][name=txtrelaed]').change(function() {
            if (this.value == '1') {
                $('#pesrond').show();
                $('#stationd').hide();
                $('#groupd').hide();
            }
            else if (this.value == '2') {
                $('#pesrond').hide();
                $('#stationd').show();
                $('#groupd').hide();
            }
            else if (this.value == '3') {
                $('#pesrond').hide();
                $('#stationd').hide();
                $('#groupd').show();
            }
        });
        
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
                helpDesk: {required: true},
//                engineer: {required: true}
            };
            var messages = {
                name: "Please enter complain name",
                code: 
                {
                    required: "Please enter complain code",
                    minlength: "complain code must have at least 3 characters",
//                    usernameValue: "Username should not start with underscore (_)",
                    whitespaceValue: "White space not allowed in complain code",
                    remote: "complain code already exist with this complain code"
                },
                helpDesk:"Please select help desk",
//                  engineer:"Please select engineer"
            };

            // initialize form validator
            //validaeForm("frmcomplain", rules, messages);
            
//            loadEditor("description");
            /*
            * Form validate function For ignore hidden required validation
            * 
            * author Mayur Patel<mayur.datatech@gmail.com>
            * Date : 02-03-2017
            */
            $('#frmcomplain').validate({
                ignore: ':hidden',
                onkeyup: false,
//                errorClass: "text-error",
//                validClass: "text-success",
                rules: rules,
                messages: messages
            });
            
            // initialize popover
            applyPopover();

            // initialize form validator
            validaeForm("frmcomplain");

            // call form fillup function
            fillForm();

            // display message
<?php Core::displayMessage("actionResult", "complain Save"); ?>

            //apply tool tip
            applyTooltip();

            $(".progControlSelect2").select2({
                placeholder: "Enter Parent complain"//Placeholder
            });

            $(".progControlSelect2_1").select2({
                    placeholder: "Enter Help Desk",//Placeholder
            });

            $(".progControlSelect2_2").select2({
                    placeholder: "Enter Engineer",//Placeholder
            });


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
            if ($('#frmcomplain').valid())
            {
                obj.prop("disabled", true);
                toggleFormLoad("show");
                $('#frmcomplain').submit();
            }
        }
        
        
        
    });

        
       

        
    // fillup form if record is set
    function fillForm()
    {
        if (pageData['complainData'])    // fill form data if passed
        {  
           console.log(pageData['complainData']);
            //$("#name").val(pageData['complainData'].name);
            //$("#code").val(pageData['complainData'].code);
//            $("#description").val(pageData['complainData'].description);
            $("#complain_type").val((pageData['complainData'].complain_type!=null)?pageData['complainData'].complain_type:"0");
            if(pageData['complainData'].company_dealer!=''){
                $("#dealer").val(pageData['complainData'].company_dealer);
                $("#dealer").change();
            }
            if(pageData['complainData'].asset_extra!=''){
                 $("#asset_extra").val(pageData['complainData'].asset_extra);
            }
            if(pageData['complainData'].department!=''){
                 $("#department").val(pageData['complainData'].department);
            }
            if(pageData['complainData'].complain_priority!=''){
                 $("#priority").val(pageData['complainData'].complain_priority);
            }
            if(pageData['complainData'].recived_time!=''){
                 $("#received_time").val(pageData['complainData'].recived_time);
            }
            if(pageData['complainData'].sms_enable=='1'){
                 $("#sms_type1").attr('checked',true);
            }
            if(pageData['complainData'].sap_enable=='1'){
                 $("#sms_type2").attr('checked',true);
            }
            if(pageData['complainData'].remark!=''){
                 $("#remark").val(pageData['complainData'].remark);
            }
            
//            
//             	pageData['complainData'].complain_type;
//                pageData['complainData'].company_dealer
//                pageData['complainData'].station_id 
//                pageData['complainData'].equipment_id  	
//                pageData['complainData'].assets_id 	
//                pageData['complainData'].asset_extra 
//                pageData['complainData'].department 
//                pageData['complainData'].complain_priority 
//                pageData['complainData'].recived_time 
//                pageData['complainData'].sms_enable 
//                pageData['complainData'].sap_enable 
//                pageData['complainData'].remark 
//            if(pageData['assetData'].station_id!=''){
//            $("#station").change();
//            }
//            $("#description").val(pageData['complainData'].description);
//            $("#parent_complain").val(pageData['complainData'].parent_complain);
//            $("#helpDesk").val(pageData['complainData'].helpDesk);
//            $("#engineer").val(pageData['complainData'].engineer);
//            $("input[name=txtrelaed][value='"+pageData['complainData'].related+"']").prop("checked",true);
//
//            
//            if (pageData['complainData'].related == '1') {
//                $('#pesrond').show();
//                $("#person_id").val(pageData['complainData'].related_id);
//                $('#stationd').hide();
//                $('#groupd').hide();
//            }
//            else if (pageData['complainData'].related== '2') {
//                $('#pesrond').hide();
//                $('#stationd').show();
//                $("#station_id").val(pageData['complainData'].related_id);
//                $('#groupd').hide();
//            }
//            else if (pageData['complainData'].related== '3') {
//                $('#pesrond').hide();
//                $('#stationd').hide();
//                $('#groupd').show();
//                $("#group_id").val(pageData['complainData'].related_id);
//            }
            
            //$("#sortOrder").val(pageDa11ta['complainData'].sort_order);
            
//            txtHelpDesk
//            txtEngineer
            
            if (pageData['complainData'].status == 1)
            {
                $("#chkStatus").attr("checked", "checked");
                $("#checkAct").html("Active");
            }
            else if (pageData['complainData'].status == 0)
            {
                $("#chkStatus").removeAttr("checked");
                $("#checkAct").html("Inactive");
            }
        }
        else
        {
            $('.helpDesk').show();
        }
        toggleFormLoad("hide"); // hide form load div
    }
    
    
    function SelectedFunctionality(Parentcomplain)
    {   
        if($("#parent_complain").val()=="0")
        {
            $('.helpDesk').show();
            $('.engineer').hide();
            $('#engineer').val('');
            
            $(".progControlSelect2_1").select2({
                placeholder: "Enter Help Desk",//Placeholder
            });
        }
        else
        {
            $('.helpDesk').hide();
            $('#helpDesk').val('');
            $('.engineer').show();
            $(".progControlSelect2_2").select2({
                    placeholder: "Enter Engineer",//Placeholder
            });
        }
    }
    
    
    
    /*
     * Help to add required validation
     * @param {type} flag
     * @param {type} option
     * @returns {undefined}
     */
    function add_extra_validation(flag,option)
    {
        if(option="helpDesk")
        {
            $("#helpDesk").rules('add', {
                required: flag,
                messages: {
                    required: "Please select help desk"
                }
            });
        }
        else if(option="engineer")
        {
            $("#engineer").rules('add', {
                required: flag,
                messages: {
                    required: "Please select engineer"
                }
            });
        }
    }
        
    /*
      $("#code").focusout(function(){
          var url = '<?php // echo URI::getURL(APP::$moduleName, APP::$actionName) ?>';
//          alert($("#code").val());
          if($("#code").val()!="" && $("#code").val()!=0)
          {
              $.ajax({
                    "url": url + "&ajaxCall=yes&code="+$("#code").val(), 
                    async: true, 
                    "success": function (data){
                        console.log(data);
//                        alert(data);
                        if (data=="true")
                        {
                            $("#code_check_status").html("<font color='green'>valid code</font>");
                            //$('.loaderImg').hide();
                        }
                        else
                        {
                            $("#code_check_status").html("<font color='red'>code already exist</font>");
                        }
                    }
                });
          }
                
        });
        */
       
       $('#dealer').on('change', function() {
        var val=this.value;
        if(val!='')
        {//alert(pageData['assetData'].equipment);
            $.ajax({
                url: "<?php echo CFG::$livePath."/page.php"; ?>",
                type: "post",
                data:"dealer="+ val,              
                "success": function(data) {
                    if(data!='')
                    {
                        $("#station").empty();
                        $("#station").append('<option value="">Please Select Station</option>');
                        $.each(jQuery.parseJSON(data), function(index, value){
                            $("#station").append('<option value="'+value.id+'"  >'+value.name+'</option>');
                       });
//                        if(pageData['assetData'].equipment!=''){ $("#equipment_type").val(pageData['assetData'].equipment_id);}
                       //if(pageData['assetData'].equipment!=''){ $("#equipment").val(pageData['assetData'].equipment);}
                       if(pageData['complainData'].station_id!=''){$("#station").val(pageData['complainData'].station_id);$("#station").change();}
                
                
                    }
                }
            });
        }
    });
       $('#station').on('change', function() {
        var val=this.value;
        if(val!='')
        {//alert(pageData['assetData'].equipment);
            $.ajax({
                url: "<?php echo CFG::$livePath."/page.php"; ?>",
                type: "post",
                data:"station_id="+ val,              
                "success": function(data) {
                    if(data!='')
                    {
                        $("#equipment_type").empty();
                        $("#equipment_type").append('<option value="">Please Select Equipment</option>');
                        $.each(jQuery.parseJSON(data), function(index, value){
                            $("#equipment_type").append('<option value="'+value.id+'"  >'+value.name+'</option>');
                       });
                       // if(pageData['assetData'].equipment!=''){ $("#equipment_type").val(pageData['assetData'].equipment_id);}
                       //if(pageData['assetData'].equipment!=''){ $("#equipment").val(pageData['assetData'].equipment);}
                       if(pageData['complainData'].equipment_id!=''){$("#equipment_type").val(pageData['complainData'].equipment_id);$("#equipment_type").change();}
                    }
                }
            });
        }
    });
       $('#equipment_type').on('change', function() {
        var val=this.value;
        if(val!='')
        {//alert(pageData['assetData'].equipment);
            $.ajax({
                url: "<?php echo CFG::$livePath."/page.php"; ?>",
                type: "post",
                data:"equipment_type="+ val+"&action=getComplainname",              
                "success": function(data) {
                    if(data!='')
                    {
                        $("#complain_name").empty();
                        $("#complain_name").append('<option value="">Please Select Complain Name</option>');
                        $.each(jQuery.parseJSON(data), function(index, value){
                            $("#complain_name").append('<option value="'+value.id+'"  >'+value.name+'</option>');
                       });
                       // if(pageData['assetData'].equipment!=''){ $("#equipment_type").val(pageData['assetData'].equipment_id);}
                       //if(pageData['assetData'].equipment!=''){ $("#equipment").val(pageData['assetData'].equipment);}
                       if(pageData['complainData'].equipment_id!=''){$("#complain_name").val(pageData['complainData'].name);$("#complain_name").change();}
                    }
                }
            });
       
            $.ajax({
                url: "<?php echo CFG::$livePath."/page.php"; ?>",
                type: "post",
                data:"equipment_type="+ val+"&dealer="+$('#dealer').val()+"&station="+$('#station').val()+"&action=getAssets",              
                "success": function(data) {
                    if(data!='')
                    {
                        $("#asset").empty();
                        $("#asset").append('<option value="">Please Select Asset</option>');
                        $.each(jQuery.parseJSON(data), function(index, value){
                            $("#asset").append('<option value="'+value.id+'"  >'+value.name+'</option>');
                       });
                       // if(pageData['assetData'].equipment!=''){ $("#equipment_type").val(pageData['assetData'].equipment_id);}
                       //if(pageData['assetData'].equipment!=''){ $("#equipment").val(pageData['assetData'].equipment);}
                        if(pageData['complainData'].assets_id!=''){$("#asset").val(pageData['complainData'].assets_id);$("#asset").change();}
                    }
                }
            });
        }
    });
    $('#complain_name').on('change', function() {
        var val=this.value;
        if(val!='')
        {//alert(pageData['assetData'].equipment);
            $.ajax({
                url: "<?php echo CFG::$livePath."/page.php"; ?>",
                type: "post",
                data:"complain_name="+ val+"&action=getComplainDesc",              
                "success": function(data) {
                    if(data!='')
                    {
                        $("#complain_description").empty();
                        $("#complain_description").append('<option value="">Please Select Complain Description</option>');
                        $.each(jQuery.parseJSON(data), function(index, value){
                            $("#complain_description").append('<option value="'+value.id+'"  >'+value.description+'</option>');
                       });
                       // if(pageData['assetData'].equipment!=''){ $("#equipment_type").val(pageData['assetData'].equipment_id);}
                       //if(pageData['assetData'].equipment!=''){ $("#equipment").val(pageData['assetData'].equipment);}
                       if(pageData['complainData'].name!=''){$("#complain_description").val(pageData['complainData'].description);$("#complain_description").change();}
                    }
                }
            });
    }
    });
</script>

<?php // include CFG::$absPath . '/' . CFG::$helper . "/templates/js/add_new_parent_complain.php"; ?>
<script type="text/javascript" src="<?php echo URI::getLiveTemplatePath() . '/js/jquery.validate.js' ?>"></script>

<script type="text/javascript" src="<?php echo URI::getLiveTemplatePath(); ?>/plugins/select/select2.full.js"></script>  <!-- select2.full.css -->
<link href="<?php echo URI::getLiveTemplatePath(); ?>/plugins/select/select2.min.css" type="text/css" rel="stylesheet"/> <!-- select2.min.css -->

<script type="text/javascript">
<?php echo Stringd::createJsObject("pageData", $data); ?>


    



    $(document).ready(function() {

        var user_id = '';
        if (pageData['employeeData'])    // fill form data if passed
        {
            user_id = pageData['employeeData'].id;
        }

        $(document).ready(function() {
            
            var rules = {
                name: {required: true},
                email: {required: true}
//                engineer: {required: true}
            };
            var messages = {
                name: "Please enter employee name",
                email: "Please enter email"
//                  engineer:"Please select engineer"
            };

            // initialize form validator
            //validaeForm("frmemployee", rules, messages);
            
            
            /*
            * Form validate function For ignore hidden required validation
            * 
            * author Mayur Patel<mayur.datatech@gmail.com>
            * Date : 02-03-2017
            */
            $('#frmemployee').validate({
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
            validaeForm("frmemployee");

            // call form fillup function
            fillForm();

            // display message
<?php Core::displayMessage("actionResult", "Employee Save"); ?>

            //apply tool tip
            applyTooltip();

            $(".progControlSelect2").select2({
                placeholder: "Enter Parent Employee"//Placeholder
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
            if ($('#frmemployee').valid())
            {
                obj.prop("disabled", true);
                toggleFormLoad("show");
                $('#frmemployee').submit();
            }
        }
        
        
        
    });

        
       

        
    // fillup form if record is set
    function fillForm()
    {
        if (pageData['employeeData'])    // fill form data if passed
        {  
           console.log(pageData['employeeData']);
            $("#name").val(pageData['employeeData'].name);
            $("#code").val(pageData['employeeData'].code);
            $("#mobile").val(pageData['employeeData'].mobile_no);
            $("#email").val(pageData['employeeData'].email);
            $("#type").val(pageData['employeeData'].type);
            $("#station").val(pageData['employeeData'].station_id);
            $("#asset").val(pageData['employeeData'].assets_id);
            //var equipmentdb = pageData['employeeData'].equipment.split(',');
            if(pageData['employeeData'].station_id!=''){
            $("#station").change();
            }
            
//            $("#equipment").val(pageData['employeeData'].equipment);
            $("#dealer").val((pageData['employeeData'].dealer!=null)?pageData['employeeData'].dealer:"0");
//            $("#description").val(pageData['employeeData'].description);
//            $("#parent_employee").val(pageData['employeeData'].parent_employee);
//            $("#helpDesk").val(pageData['employeeData'].helpDesk);
//            $("#engineer").val(pageData['employeeData'].engineer);
            
            
            
            //$("#sortOrder").val(pageData['employeeData'].sort_order);
            
//            txtHelpDesk
//            txtEngineer
            
            if (pageData['employeeData'].status == 1)
            {
                $("#chkStatus").attr("checked", "checked");
                $("#checkAct").html("Active");
            }
            else if (pageData['employeeData'].status == 0)
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
    
    
    function SelectedFunctionality(Parentemployee)
    {   
        if($("#parent_employee").val()=="0")
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
//                        var selectedParentasset="";
                        $("#equipment_type").empty();
                        $("#equipment_type").append('<option value="">Please Select Equipment</option>');
                        $.each(jQuery.parseJSON(data), function(index, value){
                            
                            $("#equipment_type").append('<option value="'+value.id+'"  >'+value.name+'</option>');

                            
                       });
                        if(pageData['employeeData'].equipment!=''){ $("#equipment_type").val(pageData['employeeData'].equipment);}
                       //if(pageData['assetData'].equipment!=''){ $("#equipment").val(pageData['assetData'].equipment);}
                    }
                }
            });
        }
        
    });
    
</script>

<?php // include CFG::$absPath . '/' . CFG::$helper . "/templates/js/add_new_parent_employee.php"; ?>
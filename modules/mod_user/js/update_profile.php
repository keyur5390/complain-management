<script type="text/javascript" src="<?php echo URI::getLiveTemplatePath() . "/js/jquery.alphanum.js" ?>"></script>
<script type="text/javascript" src="<?php echo URI::getLiveTemplatePath() . "/js/jquery.maskedinput.min-1.4.js" ?>"></script>
<script type="text/javascript" src="<?php echo URI::getLiveTemplatePath().'/js/jquery.validate.js' ?>"></script>
<script type="text/javascript">
    $(document).ready(function() {

<?php echo Stringd::createJsObject("userData", $data); ?>

        $(document).ready(function() {

            // initialize popover
            applyPopover();

            // define validation rules
            var rules = {
                name: "required",
                email: {
                    required: true,
                    email: true
                },
                username: {
                    required: true,
                    minlength: 6,
                    usernameValue: true,
                    whitespaceValue: true
                },
                password: {
                    minlength: 7,
                    passwordValue: true,
                    whitespaceValue: true
                },
                confirm_password: {
                    equalTo: "#txtPassword"
                },
                postcode: {
                    minlength: 4
                },
                phone: {
                    minlength: 10
                },
                mobile: {
                    minlength: 10
                },
                fax: {
                    minlength: 10
                }

            };

            // degine validation message
            var messages = {
                name: "Please enter name",
                email: {
                    required: "Please enter email",
                    email: "Please enter valid email"
                },
                username: {
                    required: "Please enter username",
                    minlength: "Username must have at least 6 characters",
                    usernameValue: "Username should not start with underscore (_)",
                    whitespaceValue: "White space not allowed in username"
                },
                password: {
                    minlength: "Password must have at least 7 characters",
                    passwordValue: "Password must have at least one uppercase letter, one digits and one special character",
                    whitespaceValue: "whitespace not allowed in password"
                },
                confirm_password: {
                    equalTo: "Confirm password must be same as password"
                },
                postcode: {
                    minlength: "Pincode must be 4 digits long",
                },
                phone: {
                    minlength: "Phone must be 10 digits long"
                },
                mobile: {
                    minlength: "Mobile must be 10 digits long"
                },
                fax: {
                    minlength: "Fax must be 10 digits long"
                }
            };

            // initialize form validator
            validaeForm("frmProfile", rules, messages);

            // call form fillup function
            fillForm();

            // display message
            <?php Core::displayMessage("actionResult", "Profile Updated"); ?>

            //apply tool tip
            applyTooltip();
            

            // restrict username filed to take only alphabates, digits and underscore
            $("#txtUsername").alphanum({allow: '_'});

            // set pattern input in phone field
//            $("#txtPhone").mask("(99) 9999 9999");
//
//            // set pattern input in mobile field
//            $("#txtMobile").mask("9999 999 999");
//
//            $("#txtFax").mask("9999 999 999");
             
            bindCountry(userData.country, (userData.country_id ? userData.country_id : 0));
        });

        // save
        $("#btnSave,#btnFooterSave").click(function(event) {
            submitForm(event,$(this));
        });

        // submit form
        function submitForm(event,obj)
        {
            obj.prop("disabled",true);
            event.preventDefault();
            toggleFormLoad("show");
            if ($('#frmProfile').valid())
                $('#frmProfile').submit();
        }

        // fillup form if record is set
        function fillForm()
        { 
            if (userData)
            { 
                $("#txtName").val(userData.name);
                $("#txtEmail").val(userData.email);
                $("#txtUsername").val(userData.username);
                $("#txtPhone").val(userData.phone);
                $("#txtMobile").val(userData.mobile);
                $("#txtFax").val(userData.fax);
                $("#txtAddress").val(userData.address);
                $("#txtSuburb").val(userData.suburb);
                $("#txtState").val(userData.state);
                $("#txtPostcode").val(userData.postcode);
            }
            toggleFormLoad("hide");
        }

    });

    function bindCountry(json, storeID) {
        if (storeID) {
            for (r = 0; r < json.length; r++) {

                if (json[r].id == storeID) {
                    $("#txtCountry").append("<option value='" + json[r].id + "' selected='selected'>" + json[r].country_name + "</option>");
                } else {
                    $("#txtCountry").append("<option value='" + json[r].id + "'>" + json[r].country_name + "</option>");
                }
            }
        } else {
            for (r = 0; r < json.length; r++) {
                $("#txtCountry").append("<option value='" + json[r].id + "'>" + json[r].country_name + "</option>");
            }
        }
    }
</script>
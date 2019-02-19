<script type="text/javascript" src="<?php echo URI::getLiveTemplatePath() . '/js/jquery.validate.js' ?>"></script>
<!--<script type="text/javascript" src="<?php //echo URI::getLiveTemplatePath() . "/plugins/tiny_mce/tiny_mce.js" ?>"></script>-->
<?php echo UTIL::loadFileUploadJs(); ?>
<?php echo UTIL::loadEditor(); ?>
<script type="text/javascript">

var password_length = 8;

<?php echo Stringd::createJsObject("pageData", $data); ?>

    $(document).ready(function() {
        $(document).ready(function() {
            var user_id = '';
            if (pageData)    // fill form data if passed
            {
                user_id = pageData.id;
            }

            var rules = {
                name: "required",
                role: {
                    required: true
                },
                email: {
                    required: true,
                    email: true,
                },
                username: {
                    required: true,
                    minlength: 6,
                    usernameValue: true,
                    whitespaceValue: true,
                },
                password: {
                    minlength: password_length,
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
                    required: true,
                    minlength: 10
                },
                mobile: {
                    minlength: 10
                },
                fax: {
                    minlength: 10
                },
                store: {
                    required: true,
                }
            };

            // degine validation message
            var messages = {
                name: "Please enter name",
                role: "Please select role",
                email: {
                    required: "Please enter email",
                    email: "Please enter valid email",
                    remote: "User already exist with this email"
                },
                username: {
                    required: "Please enter username",
                    minlength: "Username must have at least 6 characters",
                    usernameValue: "Username should not start with underscore (_)",
                    whitespaceValue: "White space not allowed in username",
                    remote: "User already exist with this username"
                },
                password: {
                    minlength: "Password must have at least " + password_length + " characters",
                    passwordValue: "Password must have at least one uppercase letter, one digits and one special character",
                    whitespaceValue: "whitespace not allowed in password"
                },
                confirm_password: {
                    equalTo: "Confirm password must be same as password"
                },
                postcode: {
                    minlength: "Postcode/Zipcode must be 4 digits long",
                },
                phone: {
                    required: "Please enter phone",
                    minlength: "Phone must be 10 digits long"
                },
                mobile: {
                    minlength: "Mobile must be 10 digits long"
                },
                fax: {
                    minlength: "Fax must be 10 digits long"
                },
                store: {
                    required: "Please select store",
                }
            };

            // initialize form validator
            validaeForm("frmUser", rules, messages);

            // load editor
            //  loadEditor("txaDescription");

            // initialize popover
            applyPopover();

            // initialize form validator
            //validaeForm("frmUser");

            // call form fillup function
            fillForm();

            // display message
<?php Core::displayMessage("actionResult", "User Save"); ?>

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
<?php if (isset(APP::$curId) && !empty(APP::$curId)) { ?>
                $("#hdnEdit").val("1");
<?php } else { ?>
                $("#hdnAdd").val("1");
<?php } ?>
            submitForm(event, $(this));
        });


        function submitForm(event, obj)
        {

            event.preventDefault();
            if ($('#frmUser').valid())
            {
                obj.prop("disabled", true);
                toggleFormLoad("show");
                $('#frmUser').submit();
            }
        }

    });

    // fillup form if record is set
    function fillForm()
    {

        if (pageData)    // fill form data if passed
        {
            $("#txtRole").val(pageData.roll_id);
            $("#txtStore").val(pageData.store_id);
            $("#txtName").val(pageData.name);
            $("#txtEmail").val(pageData.email);
            $("#txtUsername").val(pageData.username);
            $("#txtPhone").val(pageData.phone);
            $("#txtMobile").val(pageData.mobile);
            $("#txtFax").val(pageData.fax);
            $("#txtAddress").val(pageData.address);
            $("#txtSuburb").val(pageData.suburb);
            $("#txtState").val(pageData.state);
            //$("#txtCountry").val(pageData.country);
            $("#txtPostcode").val(pageData.postcode);
            $("#station").val(pageData.station_id);
            $("#group").val(pageData.group_id);
            $("#hdnLastUpdate").val(pageData.updated_date);

//            if (tinyMCE.activeEditor == null)
//                $("#txaDescription").val(pageData.email_signature);
//            else
//                tinyMCE.get("txaDescription").setContent(pageData.email_signature);

            if (pageData.active == 1)
            {
                $("#chkStatus").attr("checked", "checked");
            }
            else if (pageData.active == 0)
            {
                $("#chkStatus").removeAttr("checked");
            }
        } else {
            $("#frmUser").validate();
            $("input[name=password]").rules("add", {
                required: true,
                messages: {
                    required: "Please enter password",
                }
            });
            $("input[name=confirm_password]").rules("add", {
                required: true,
                messages: {
                    required: "Please enter confirm password",
                }
            });
        }

        toggleFormLoad("hide"); // hide form load div
    }
</script>
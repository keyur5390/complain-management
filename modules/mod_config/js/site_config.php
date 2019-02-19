<script type="text/javascript" src="<?php echo URI::getLiveTemplatePath() . '/js/jquery.validate.js' ?>"></script>
<script type="text/javascript" src="<?php echo URI::getLiveTemplatePath() . "/js/jquery.maskedinput.min-1.4.js" ?>"></script>
<script type="text/javascript" src="<?php echo URI::getLiveTemplatePath() . "/js/additional-method.js" ?>"></script>
<?php echo UTIL::loadFileUploadJs(); ?>
<script type="text/javascript">
    $(document).ready(function() {

<?php echo Stringd::createJsObject("configData", $data); ?>

        $(document).ready(function() {

            // initialize popover
            applyPopover();

            var rules = {
                site_name: "required",
                site_email: {
                    required: true,
                    email: true
                },
                enquiry_emails: {
                    required: true,
                    multipleEmails: true
                },
                google_analytic_code:{pattern:/^ua-\d{4,9}-\d{1,4}$/i}
            };
            var messages = {
                site_name: "Please enter site name",
                site_email: {
                    required: "Please enter site email",
                    email: "Please enter valid email"
                },
                enquiry_emails: {
                    required: "Please enter enquiry email",
                    multipleEmails: "Please enter valid email"
                },
                google_analytic_code:{pattern:'Please enter valid google analytic code'}
            };

            // initialize form validator
            validaeForm("frmConfig", rules, messages);

            // call form fillup function
            fillForm();

            // display message
<?php Core::displayMessage("actionResult", "Config settings saved"); ?>

            //apply tool tip
            applyTooltip();

            //$('#txtSitePhone').mask("99 9999 9999", {placeholder: ""});

            jQuery(window).bind('scroll', function() {
                if (jQuery(window).scrollTop() > 32) {
                    jQuery('#menu').addClass('scrollsticky');
                }
                else {
                    jQuery('#menu').removeClass('scrollsticky');
                }
            });

        });

        // save
        $("#btnEdit,#btnFooterEdit").click(function(event) {
            submitForm(event, $(this));
        });

        // submit form
        function submitForm(event, obj)
        {
            obj.prop("disabled", true);
            event.preventDefault();
            toggleFormLoad("show");
            if ($('#frmConfig').valid())
                $('#frmConfig').submit();
        }

        // fillup form if record is set
        function fillForm()
        {


            if (configData)
            {
                for (i = 0; i < configData.length; i++) {
                    if (configData[i].config_key == 'flImage_hdn') {
                        // Create main image uploader
                        createUploader("flImage", "fileProgress", "files", displayUploadResult, "<?php echo URI::getURL("mod_admin", "upload_image") ?>", ["jpg", "gif", "png", "JPG", "GIF", "PNG"], "<?php echo CFG::$sliderDir; ?>", "<?php echo URI::getURL("mod_slider", "delete_file") ?>", (configData[i].config_value?[{"name": configData[i].config_value,"title":configData[i].config_value,"alt": configData[i].config_value}]:""),((configData[i].config_value)?configData[i].id:""));
                    } else {
                        $('[name="' + configData[i].config_key + '"]').val(configData[i].config_value);
                    }
                }
            }
            toggleFormLoad("hide");
        }
        
        function isNumberic(evt)
    {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 46 && charCode != 8)
            return false;
        if (charCode == 46)
            return false;
        return true;
    }

    });
</script>
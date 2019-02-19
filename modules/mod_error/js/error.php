<?php
//restrict direct access to the page
defined('DMCCMS') or die('Unauthorized access');
?>
<script type="text/javascript" src="<?php echo URI::getLiveTemplatePath() . '/js/jquery.validate.js' ?>"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var rules = {
            cmbFile: {required: true}

        };
        var messages = {
            cmbFile: {required: "Please select file from list"}

        };
        validaeForm("frmSCSS", rules, messages);
        $("#btnCompile").click(function (event) {
            event.preventDefault();
            submitForm(event, $(this));
        });
        function submitForm(event, obj)
        {

            event.preventDefault();
            if ($('#frmSCSS').valid())
            {

                $('#frmSCSS').submit();
            }
        }

    });
</script>
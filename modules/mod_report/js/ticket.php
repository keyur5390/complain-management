<script type="text/javascript" src="<?php echo URI::getLiveTemplatePath() . "/js/jquery.paging.min.js" ?>"></script>
<script type="text/javascript" src="<?php echo URI::getLiveTemplatePath() . "/js/formJs.js" ?>"></script>
<script type="text/javascript" src="<?php echo URI::getLiveTemplatePath() . "/js/jquery-ui.custom.js" ?>"></script>
<?php /* ?><link rel="stylesheet" href="<?php echo URI::getLiveTemplatePath(); ?>/js/datepicker/jquery-ui.css" /><?php */ ?>
<link href="<?php echo URI::getLiveTemplatePath(); ?>/plugins/select/select2.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo URI::getLiveTemplatePath() . "/plugins/select/select2.js" ?>"></script>
<script type="text/javascript" src="<?php echo URI::getLiveTemplatePath() . "/plugins/tiny_mce/tiny_mce.js"; ?>"></script>
<script type="text/javascript" src="<?php echo URI::getLiveTemplatePath() . '/js/jquery.validate.js' ?>"></script>
<?php echo UTIL::loadFileUploadJs(); ?>

<script type="text/javascript">
    $(document).ready(function() {
        var pausecontent = <?php echo json_encode(CFG::$ticketStatusArray); ?>;
        $("#txtDFrom").datepicker({dateFormat: "dd-mm-yy", changeMonth: true, changeYear: true, buttonImage: "<?php echo URI::getLiveTemplatePath() . "/images/calender2.png"; ?>", buttonImageOnly: true, showOn: "both", maxDate: '0', onClose: function(selectedDate) {
                $("#txtDTo").datepicker("option", "minDate", selectedDate);
            }});

        $("#txtDTo").datepicker({dateFormat: "dd-mm-yy", changeMonth: true, changeYear: true, buttonImage: "<?php echo URI::getLiveTemplatePath() . "/images/calender2.png"; ?>", buttonImageOnly: true, showOn: "both", maxDate: '0', onClose: function(selectedDate) {
                //$( "#txtDFrom" ).datepicker( "option", "maxDate", selectedDate );
            }});
        var displayPages = function(data, startIndex) {

            var list = "";
            var dt = "";
            for (i = 0; i < data.records.length; i++)
            {
                var odd = (i % 2 == 0) ? "" : " class='odd' ";
                list = list + '<li ' + odd + '>';

                list = list + '<div class="hashBox">' + data.records[i].id + '</div>';
                list = list + '<div class="pageName">';

                list = list + capitalLetter(data.records[i].subject);
                list = list + '<ul class="optUl"><li><a href="index.php?m=mod_ticket&a=ticket_view&id=' + data.records[i].id + '"  title="View" target="_blank">View</a></li><li><a href="index.php?m=mod_ticket&a=ticket_edit&id=' + data.records[i].id + '"  title="Edit" target="_blank">Edit</a></li></ul>';

                list = list + '<a class="toggleLink" href="javascript:;"></a></div>';
                list = list + '<div class="statusBox alignLeft" data-title="Customer:"><span class="conSpan">' + capitalLetter(data.records[i].name) + '</span></div>';
                list = list + '<div class="statusBox alignLeft" data-title="Ticket Engineer:"><span class="conSpan">' + capitalLetter(check_empty(data.records[i].engineer_name)) + '</span></div>';
                var cur_status = data.records[i].ticket_status;
                list = list + '<div class="statusBox alignLeft" data-title="Ticket Status:"><span class="conSpan">' + pausecontent[cur_status] + '</span></div>';
                list = list + '<div class="statusBox alignLeft" data-title="Region:"><span class="conSpan">' + capitalLetter(data.records[i].region_name) + '</span></div>';

                list = list + '<div class="statusBox alignLeft" data-title="HelpDesk:"><span class="conSpan">' + capitalLetter(data.records[i].helpdesk_name) + '</span></div>';
                    if(data.records[i].close_date=='0000-00-00') {
                        dt='-';
                    } else {
                        dt=displayFormatedDate(data.records[i].close_date);
                    }
                 list = list + '<div class="statusBox alignLeft" data-title="CloseDate:"><span class="conSpan">' + dt  + '</span></div>';

                /*list = list + '<div class="sortOrder" data-title="Sort Order:">\n\
                 <input class="sortTxt text-center inner-page-checkbox" type="text" maxlength="3" id="sort_order'+data.records[i].sort_order+'" name="sort_order['+data.records[i].id+']" value="'+data.records[i].sort_order+'" \n\\n\
<?php if (Core::hasAccess(APP::$moduleName, "save_sortorder")) { ?> \n\
                     onblur="if(this.value!='+data.records[i].sort_order+'){changeSortOrder(\'index.php?m=mod_ticket&a=save_sortorder\',this.value,'+data.records[i].id+');}if(this.value.length==0){this.value='+data.records[i].sort_order+';}" \n\
    <?php
} else {
    ?> disabled="true" <?php }
?> onkeypress=\'return isNumberic(event);\' /></div>';
                 list = list + '<div class="statusBox" data-title="Status:"><span class="conSpan">' + displayStatus(data.records[i].status) + '</span></div>';*/
                list = list + '</li>';
                startIndex = startIndex + 1;
            }
            $(".table").find("li:not(.topLi)").remove();
            $(".table").append(list);
            bindListingClick();
        }

        pageData.url = '<?php echo URI::getURL(APP::$moduleName, APP::$actionName) ?>';
        pageData.noOfRecords = totalPages;
        pageData.pagingBlock = '#pagingNo';
        pageData.callbackFun = displayPages;
        pageData.perPage = $('.numOfRecord').val();
        if (oldPageState && oldPageState.searchData != undefined && oldPageState.searchData.searchForm.numOfRecord != undefined)
        {
            //alert(JSON.stringify(oldPageState));
            pageData.perPage = oldPageState.searchData.searchForm.numOfRecord;
        }

        // do paging	
        createDataGrid();

        // initialize sorting
        sortData();

        // create function for validating search form
        validateSearchForm = function() {


            if ($.trim($("#ticket_subject").val()) == "" && $('#ticket_subject').length > 0)
            {

                if (($.trim($("#txtDFrom").val()) == "" && $.trim($("#txtDTo").val()) == "") && ($.trim($("#customer").val()) == "") && ($.trim($("#searchByEngineer").val()) == "") && ($.trim($("#searchByHelpDesk").val()) == "") && ($.trim($("#searchByRegion").val()) == "")&& ($.trim($("#searchByStatusReport").val()) == ""))
                {
                    alert("Please select customer, engineer, helpdesk, region or enter ticket subject or ticket no for search");
                    return false;
                }
            }
            //$("#searchByEngineer").val("");
            // $("#searchByStatusReport").val("");
            return true;
        }

        pageData.validateSearch = validateSearchForm;

        resetForm = function()
        {
            $("#customer").val(null).trigger('change');
            $("#select2-customer-container").attr('title','Please Select Customer');
            //$('#customer').select2('val', '').trigger('change');
            $("#ticket_subject").val("");
            //$("#searchByEngineer").val("");
            $("#searchByEngineer").val("").trigger('change');
            $("#select2-searchByEngineer-container").attr('title','Please select engineer');
            $("#searchByStatusReport").val("");
            $("#searchByHelpDesk").val("").trigger('change');
            $("#select2-searchByHelpDesk-container").attr('title','Select Help Desk');
            $("#searchByRegion").val("").trigger('change');
            $("#select2-searchByRegion-container").attr('title','Select Region');
            console.log(pageData)
            pageData.searchField = "";
            pageData.noOfRecords = totalPages;
            doPaging();
        }

        // display message			
<?php Core::displayMessage("actionResult", "Ticket Save"); ?>

        // initialize tooltip	
        applyTooltip();

        // initialize popover
        applyPopover();
        //  createUploader("flImage", "fileProgress", "files", displayUploadResult, "<?php //echo URI::getURL("mod_admin", "upload_image")   ?>", ["JPG","jpg","JPEG","jpeg", "gif","GIF", "png","PNG"], "<?php //echo CFG::$ticketDir;   ?>", "<?php //echo URI::getURL("mod_ticket", "ticket_delete_file")   ?>", '', '');

        // restore value of search form
        function restoreSearchForm()
        {
            if (oldPageState && oldPageState.searchData)
            {
                $("#ticket_subject").val(oldPageState.searchData.searchForm.ticket_subject);
                $("#txtDFrom").val(oldPageState.searchData.searchForm.dateFrom);
                $("#txtDTo").val(oldPageState.searchData.searchForm.dateTo);
                $('#customer').val(oldPageState.searchData.searchForm.customer);
                $(".numOfRecord").val(oldPageState.searchData.searchForm.numOfRecord);
            }
        }
        restoreSearchForm();
        $(".progControlSelect2").select({
            placeholder: "Enter Customer"//Placeholder
        });
    });
    function capitalLetter(string)
    {

        if (string != '' && string != '-')
        {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }
        else {
            return string;
        }

    }
    function check_empty(string)
    {
        if (string == "" || string == null)
        {
            return "-";
        }
        else
        {
            return string;
        }

    }
    function send_mail() {
        $.ajax({
            url: '<?php echo URI::getURL(APP::$moduleName, "export_report"); ?>',
            data: $("#searchForm").serialize() + "&ajax=true",
            type: "post",
            success: function(data) {
//                displayMessage("success", "Ticket report", "Ticket report email sent successfully");
//                div.dialog("close");
                $('#attachementD').val(data);
                $("#exportDs").attr("href", "<?php echo CFG::$livePath . "/" . CFG::$mediaDir . '/' . CFG::$ticketDir . '/'; ?>" + data);
            }
        })
        open_dialog();
        return;
    }
 function export_data() {
     $.ajax({
            url: '<?php echo URI::getURL(APP::$moduleName, "export_report"); ?>',
            data: $("#searchForm").serialize() + "&ajax=true",
            type: "post",
            success: function(data) {
        document.location.href = "<?php echo CFG::$livePath . "/" . CFG::$mediaDir . '/' . CFG::$ticketDir . '/'; ?>" + data;
//                displayMessage("success", "Ticket report", "Ticket report email sent successfully");
//                div.dialog("close");
            //window.open();
            }
        });
        
        return;
    }
</script>
<?php include CFG::$absPath . '/' . CFG::$helper . "/templates/js/tpl_product_mail.php"; ?>

<script type="text/javascript">
    load_customer_search_select();
    load_Engineer_search_select();
    load_Helpdesk_search_select();
    load_Region_search_select();
    
    function load_customer_search_select() {
        var selected_cust_ids = '';
        var selectors = $("#customer");
        var get_url = "<?php echo CFG::$livePath; ?>/page.php";

        selectors.select2({
            minimumInputLength: 1,
            width: "100%",
            placeholder: "Please Select Customer",
            ajax: {
                url: get_url,
                dataType: 'json',
                data: function(params) {
                    return {
                        code: params.term,
                        notid: selected_cust_ids,
                        action: 'all_customer_name'// search term
                    };
                },
                processResults: function(data, params) {

                    params.page = params.page || 1;

                    return {
                        results: data.items,
                    };
                },
                cache: false
            },
        });
    }
    function load_Engineer_search_select() {
        var selected_cust_ids = '';
        var selectors = $("#searchByEngineer");
        var get_url = "<?php echo CFG::$livePath; ?>/page.php";

        selectors.select2({
            minimumInputLength: 1,
            width: "100%",
            placeholder: "Select Engineer",
            ajax: {
                url: get_url,
                dataType: 'json',
                data: function(params) {
                    return {
                        code: params.term,
                        notid: selected_cust_ids,
                        action: 'all_engineer_name'// search term
                    };
                },
                processResults: function(data, params) {

                    params.page = params.page || 1;

                    return {
                        results: data.items,
                    };
                },
                cache: false
            },
        });
    }
    function load_Helpdesk_search_select() {
        var selected_cust_ids = '';
        var selectors = $("#searchByHelpDesk");
        var get_url = "<?php echo CFG::$livePath; ?>/page.php";

        selectors.select2({
            minimumInputLength: 1,
            width: "100%",
            placeholder: "Select Help Desk",
            ajax: {
                url: get_url,
                dataType: 'json',
                data: function(params) {
                    return {
                        code: params.term,
                        notid: selected_cust_ids,
                        action: 'all_help_desk'// search term
                    };
                },
                processResults: function(data, params) {

                    params.page = params.page || 1;

                    return {
                        results: data.items,
                    };
                },
                cache: false
            },
        });
    }
    function load_Region_search_select() {
        var selected_cust_ids = '';
        var selectors = $("#searchByRegion");
        var get_url = "<?php echo CFG::$livePath; ?>/page.php";

        selectors.select2({
            minimumInputLength: 1,
            width: "100%",
            placeholder: "Select Region",
            ajax: {
                url: get_url,
                dataType: 'json',
                data: function(params) {
                    return {
                        code: params.term,
                        notid: selected_cust_ids,
                        action: 'all_region'// search term
                    };
                },
                processResults: function(data, params) {

                    params.page = params.page || 1;

                    return {
                        results: data.items,
                    };
                },
                cache: false
            },
        });
    }
    function displayFormatedDate(val)
{
    var dateString = val.split("-");
   //alert(dateString);
    return dateString[2] + "/" + dateString[1] + "/" + dateString[0];
}
</script>
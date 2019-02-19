<script type="text/javascript" src="<?php echo URI::getLiveTemplatePath() . "/js/jquery.paging.min.js" ?>"></script>
<script type="text/javascript">

<?php echo Stringd::createJsObject("roleData", $data); ?>;

    $(document).ready(function() {

        $("#selRole").empty();
        $("#selRole").append('<option value="">Select Role</option>');

        for (r = 0; r < roleData.role.length; r++) {
            $("#selRole").append("<option value='" + roleData.role[r].id + "'>" + roleData.role[r].name + "</option>");
        }
        var user = new Array();
        var role = new Array();

        for (r = 0; r < roleData.role.length; r++) {
            role[roleData.role[r].id] = roleData.role[r].name;
        }

        var displayPages = function(data, startIndex) {

            // console.log(data);
            var list = "";
            var sta = "";
            for (i = 0; i < data.records.length; i++)
            {
                var odd = (i % 2 == 0) ? "" : " class='odd' ";
                list = list + '<li ' + odd + '>';
                list = list + '<div class="chekMain"><div class="chkInn"><label><input type="checkbox" id="status' + data.records[i].id + '" name="status[' + data.records[i].id + ']" value="' + data.records[i].active + '" class="checkbox" data-update="' + data.records[i].updated_date + '" data-id="' + data.records[i].id + '" /><span></span></label></div></div>';
                list = list + '<div class="hashBox">' + startIndex + '</div>';
                list = list + '<div class="pageName">';
                list = list + '<a href="index.php?m=mod_user&a=user_edit&id=' + data.records[i].id + '"  title="' + data.records[i].name + '">' + data.records[i].name + '</a>';
//                list = list + data.records[i].name;

                list = list + '<ul class="optUl">';

                list = list + '<li><a href="index.php?m=mod_user&a=user_edit&id=' + data.records[i].id + '" title="Edit">Edit</a></li>';
                list = list + '<li><a href="javascript:;" onclick="return changeStatus(\'index.php?m=mod_user&a=change_status\',' + data.records[i].id + ',\'\')" title="Change Status">Change Status</a></li>';
               // list = list + '<li><a href="javascript:;" onclick="return sendMail(\'index.php?m=mod_user&a=send_mail\',' + data.records[i].id + ',\'\')" title="Send Mail">Send Mail</a></li>';
                list = list + '<li class="delLi"><a href="javascript:;" onclick="deleteRecord(\'index.php?m=mod_user&a=delete_user\',' + data.records[i].id + ',\'' + data.records[i].updated_date + '\')" title="Delete">Delete</a></li>';

                list = list + '</ul><a class="toggleLink" href="javascript:;"></a></div>';
                list = list + '<div class="alignLeft" data-title="Username:">' + data.records[i].username + '</div>';
                list = list + '<div class="alignLeft" data-title="Role:">' + role[data.records[i].roll_id] + '</div>';
                list = list + '<div class="alignLeft" data-title="Email:">' + data.records[i].email + '</div>';

                list = list + '<div class="customerName" data-title="Phone:">' + data.records[i].phone + '</div>';

//                list = list + '<div class="customerName" data-title="Created By:">' + user[data.records[i].created_by] + '</div>';
//
//                list = list + '<div class="customerName" data-title="Updated By:">' + (user[data.records[i].updated_by]?user[data.records[i].updated_by]:"") + '</div>';

                list = list + '<div class="statusBox"  data-title="Status:"><span class="conSpan">' + displayStatus(data.records[i].active) + '</span></div>';
                list = list + '</li>';
                startIndex = startIndex + 1;
            }
            $(".table").find("li:not(.topLi)").remove();
            $(".table").append(list);
            bindListingClick();
        }

        pageData.url = '<?php echo URI::getURL(APP::$moduleName, APP::$actionName) ?>';
        //alert(pageData.url);
        pageData.noOfRecords = totalUsers;
        pageData.pagingBlock = '#pagingNo';
        pageData.callbackFun = displayPages;
        pageData.perPage = $('.numOfRecord').val();
        if (oldPageState && oldPageState.searchData != undefined && oldPageState.searchData.searchForm.numOfRecord != undefined)
        {
            pageData.perPage = oldPageState.searchData.searchForm.numOfRecord;
        }

        // do paging	
        createDataGrid();

        // initialize sorting
        sortData();

        validateSearchForm = function() {


            if ($("#user_name").val() == "")
            {
                if ($("#selRole").attr('data-source') == "0") {
                    alert("Please enter name, username or email for search");
                    return false;
                } else {
                    if ($("#selRole").val() == '') {
                        $("#selRole").attr("data-source", "0");
                    }
                }
            }
            return true;
        }

        pageData.validateSearch = validateSearchForm;

        resetForm = function()
        {
            $("#user_name").val("");
            $("#selRole").val("");

            pageData.searchField = "";
            pageData.noOfRecords = totalUsers;
            doPaging();
        }

        // display message			
<?php Core::displayMessage("actionResult", "User Save"); ?>

        // initialize tooltip	
        applyTooltip();

        // initialize popover
        applyPopover();

        // restore value of search form
        function restoreSearchForm()
        {
            if (oldPageState && oldPageState.searchData)
            {
                $("#user_name").val(oldPageState.searchData.searchForm.user_name);
                $("#selRole").val(oldPageState.searchData.searchForm.role);
                $(".numOfRecord").val(oldPageState.searchData.searchForm.numOfRecord);
            }
        }
        restoreSearchForm();

    });

</script>
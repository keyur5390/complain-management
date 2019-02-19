<script type="text/javascript" src="<?php echo URI::getLiveTemplatePath() . "/js/jquery.paging.min.js" ?>"></script>
<!--<script type="text/javascript" src="<?php // echo URI::getLiveTemplatePath() . "/js/jquery-ui.custom.js" ?>"></script>-->
<script type="text/javascript">

<?php echo Stringd::createJsObject("pagaData", $data); ?>;

    $("#helpDesk").empty();
    $("#helpDesk").append('<option value="">Select Help Desk</option>');
    
    for (r = 0; r < pagaData.helpDeskData.length; r++) {
        $("#helpDesk").append("<option value='" + pagaData.helpDeskData[r].id + "'>" + pagaData.helpDeskData[r].name + "</option>");
    }
    
    
    
    $(document).ready(function() {
        
        
        var displayPages = function(data, startIndex) {

            //console.log(data);
            var list = "";
            var sta = "";
            
            for (var i = 0; i < data.records.length; i++)
            {
                var odd = (i % 2 == 0) ? "" : " class='odd' ";
                list = list + '<tr class=" ' + odd + '">';
                <?php if(Core::hasAccess(APP::$moduleName, "delete_station")) { ?>
                list = list + '<td align="center"><div class="chkInn"><label><input type="checkbox" id="status' + data.records[i].id + '" name="status[' + data.records[i].id + ']" value="' + data.records[i].status + '" class="checkbox" data-update="' + data.records[i].updated_date + '" data-id="' + data.records[i].id + '" /><span></span></label></div></td>';
                <?php } ?>
                list = list + '<td align="center">' + startIndex + '</td>';
                
                list = list + '<td><div class="pageName alignLeft">';
                
                <?php if(Core::hasAccess(APP::$moduleName, "station_edit")) { ?>
                list = list + '<a href="index.php?m=mod_station&a=station_edit&id=' + data.records[i].id + '"  title="">'+data.records[i].name+'</a>';              
                <?php } else { ?>
                        list = list + data.records[i].name;
                <?php } ?>
                list = list + '<ul class="optUl">';                  
                <?php if(Core::hasAccess(APP::$moduleName, "station_edit")) { ?>
				list = list + '<li><a href="index.php?m=mod_station&a=station_edit&id=' + data.records[i].id + '" title="Edit">Edit</a></li>';
                <?php } ?>
                    
                <?php if(Core::hasAccess(APP::$moduleName, "change_status")) { ?>
                    list = list + '<li><a href="javascript:;" onclick="return changeStatus(\'index.php?m=mod_station&a=change_status\',' + data.records[i].id + ',\'\')" title="Change Status">Change Status</a></li>';
                <?php } ?> 
                    
                <?php if(Core::hasAccess(APP::$moduleName, "delete_station")) { ?>
				list = list + '<li class="delLi"><a href="#" onclick="deleteRecord(\'index.php?m=mod_station&a=delete_station\',' + data.records[i].id + ',\'\')" title="Delete">Delete</a></li>';
                <?php } ?>
                    
                list = list + '</ul><a class="toggleLink" href="javascript:;"></a></div></td>';
                
                
                var parentstation=(data.records[i].parent_station == null && data.records[i].parent_station != "" && data.records[i].parent_station != "0" ) ? "-" : data.records[i].parent_station;
                list = list + '<td class="customerName" align="center" data-title="Parent station:">' + parentstation + '</td>';
                
                var helpDeskName=(data.records[i].helpDeskName == null && data.records[i].helpDeskName != "" && data.records[i].helpDeskName != "0" ) ? "-" : data.records[i].helpDeskName;
                list = list + '<td class="customerName" align="center" data-title="Help Desk:">' + helpDeskName + '</td>';
                
                
                list = list + '<td class="customerName alignLeft" data-title="Help Desk:"><input class="sortTxt text-center inner-page-checkbox" type="text" maxlength="3" id="sort_order'+data.records[i].sort_order+'" name="sort_order['+data.records[i].id+']" value="'+data.records[i].sort_order+'" onblur="if(this.value!='+data.records[i].sort_order+'){changeSortOrder(\'index.php?m=mod_station&a=save_sortorder\',this.value,'+data.records[i].id+');}if(this.value.length==0){this.value='+data.records[i].sort_order+';}" onkeypress=\'return isNumberic(event);\' /></td>';
                
                
//                var departmentName="";
//                (data.records[i].department_name != "" && data.records[i].department_name != null  ) ? departmentName=data.records[i].department_name : departmentName="N/A" ;
//                list = list + '<td class="customerName alignLeft" data-title="Task:">' + departmentName + '</td>';
                
                
                list = list + '<td align="center" data-title="Status:"><span class="conSpan">' + displayStatus(data.records[i].status) + '</span></td>';
                
                list = list + '</tr>';
                list = list + '<tr id="append-'+data.records[i].id+'" style="display:none" class="appendDiv"></tr>';
                startIndex = startIndex + 1;
            }
            $(".custom-table tbody").find("tr").remove();
            $(".custom-table tbody").append(list);
            bindListingClick();
        }

        pageData.url = '<?php echo URI::getURL(APP::$moduleName, APP::$actionName) ?>';
        pageData.noOfRecords = totalPages;
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
            if ($("#name").val() == "")
            {
                if ($("#helpDesk").attr('data-source') == "0") 
                {
                    alert("Please enter station name for search");
                    return false;
                } 
                else 
                {
                    $("#helpDesk").attr("data-source", "0");
                    //$("#selTeam").attr("data-source", "0");
                }
            }
            return true;
        }

        pageData.validateSearch = validateSearchForm;

        resetForm = function()
        {
            $("#name").val("");
            $("#helpDesk").val("");
            
            pageData.searchField = "";
            pageData.noOfRecords = totalPages;
            doPaging();
        }

        // display message			
        <?php Core::displayMessage("actionResult", "station Save"); ?>

        // initialize tooltip	
        applyTooltip();

        // initialize popover
        applyPopover();

        // restore value of search form
        function restoreSearchForm()
        {
            if (oldPageState && oldPageState.searchData)
            {
                $("#name").val(oldPageState.searchData.searchForm.name);
                $("#helpDesk").val(oldPageState.searchData.searchForm.helpDesk);
                $(".numOfRecord").val(oldPageState.searchData.searchForm.numOfRecord);
            }
        }
        restoreSearchForm();

    });

</script>
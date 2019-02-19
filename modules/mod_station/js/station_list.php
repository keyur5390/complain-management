
<script type="text/javascript" src="<?php echo URI::getLiveTemplatePath() . "/js/jquery.paging.min.js" ?>"></script>
<script type="text/javascript">
    
    <?php // echo Stringd::createJsObject("pageData", $data); ?>
    
//    console.log(pageData);
//    $("#parent_station").empty();
//    $("#parent_station").append('<option value="0">Root</option>');
//    var selectedParentstation="";
//    $.each(pageData['parentstationData'], function(parentstationKey,parentstationValue) {
////        alert(parentstationValue.name);
//        $("#parent_station").append('<option value="'+parentstationValue.id+'" ' + selectedParentstation + ' >'+parentstationValue.name+'</option>');
//    });
    
//    helpDeskData

    
    
    $(document).ready(function() {
        
        
//        $("#helpDesk").empty();
//        $("#helpDesk").append('<option value="">Select Help Desk</option>');
//        var selectedHelpDesk="";
//        $.each(pageData['helpDeskData'], function(helpDeskKey,helpDeskValue) {
//            $("#helpDesk").append('<option value="'+helpDeskValue.id+'" ' + selectedHelpDesk + ' >'+helpDeskValue.name+'</option>');
//        });
    
    
        var displayPages = function(data, startIndex) {
			
            var list = "";
            for (i = 0; i < data.records.length; i++)
            {
                var odd = (i % 2 == 0) ? "" : " class='odd' ";
                list = list + '<li ' + odd + '>';
                 <?php 
                            if(isset($_SESSION['user_login']) && $_SESSION['user_login']['roll_id']=='1'){?>
                list = list + '<div class="chekMain"><div class="chkInn"><label><input type="checkbox" id="status' + data.records[i].id + '" name="status[' + data.records[i].id + ']" value="' + data.records[i].status + '" class="checkbox" /><span></span></label></div></div>';
                            <?php }?>
                list = list + '<div class="hashBox">' + startIndex + '</div>';
                list = list + '<div class="pageName">';
                 <?php if(Core::hasAccess(APP::$moduleName, "helpDesk_edit")) { ?>
                        list = list + '<a href="index.php?m=mod_station&a=station_edit&id=' + data.records[i].id + '"  title="' + data.records[i].name + '">' + data.records[i].name + '</a>';
                <?php } else { ?>
                        list = list + data.records[i].name;
                <?php } ?>
                list = list + '<ul class="optUl">';
                <?php if(Core::hasAccess(APP::$moduleName, "station_edit")) { ?>
                list = list + '<li><a href="index.php?m=mod_station&a=station_edit&id=' + data.records[i].id + '" title="Edit">Edit</a></li>';
                <?php } ?>

                <?php if(Core::hasAccess(APP::$moduleName, "change_status")) { ?>
                list = list + '<li><a href="#" onclick="return changeStatus(\'index.php?m=mod_station&a=change_status\',' + data.records[i].id + ',\'\')" title="Change Status">Change Status</a></li>';
                <?php } ?>

                <?php //if(Core::hasAccess(APP::$moduleName, "delete_station")) { ?>
                list = list + '<li class=""><a href="#" onclick="deleteRecord(\'index.php?m=mod_station&a=delete_station\',' + data.records[i].id + ')" title="Delete">Delete</a></li>';
                <?php //} ?>    
                list=list+'</ul>';
                list = list + '<a class="toggleLink" href="javascript:;"></a>';
                 list = list + '</div>';
               /* list = list + '<div class="sortOrder" data-title="Sort Order:"><input class="sortTxt text-center inner-page-checkbox" type="text" maxlength="3" id="sort_order'+data.records[i].sort_order+'" name="sort_order['+data.records[i].id+']" value="'+data.records[i].sort_order+'" onblur="if(this.value!='+data.records[i].sort_order+'){changeSortOrder(\'index.php?m=mod_station&a=save_sortorder\',this.value,'+data.records[i].id+');}if(this.value.length==0){this.value='+data.records[i].sort_order+';}" onkeypress=\'return isNumberic(event);\' /></div>';*/
                list = list + '<div class="statusBox" data-title="Status:"><span class="conSpan">' + displayStatus(data.records[i].status) + '</span></div>';
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
            pageData.perPage = oldPageState.searchData.searchForm.numOfRecord;
        }

        // do paging	
        createDataGrid();

        // initialize sorting
        sortData();

        validateSearchForm = function() {
//            if ($("#name").val() == "")
//            {
//                /*if ($("#helpDesk").attr('data-source') == "0") 
//                {
//                    alert("Please enter station name for search");
//                    return false;
//                } 
//                else 
//                {
//                    $("#helpDesk").attr("data-source", "0");
//                }*/
//                if($.trim($("#helpDesk").val()) == "" )
//                {							
//                   alert("Please enter station name or select hepl desk or parent station for search");
//                   return false;
//                }
//            }
            
            return true;
        }

        pageData.validateSearch = validateSearchForm;

        resetForm = function()
        {
            $("#name").val("");
            $("#helpDesk").val("");
            $("#parentstation").val("");
            pageData.searchField = "";
            pageData.noOfRecords = totalPages;
            doPaging();
        }

        // display message			
        <?php Core::displayMessage("actionResult", "Station Save"); ?>

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
                $("#parentstation").val(oldPageState.searchData.searchForm.parentstation);
                $(".numOfRecord").val(oldPageState.searchData.searchForm.numOfRecord);
            }
        }
        restoreSearchForm();

    });

</script>
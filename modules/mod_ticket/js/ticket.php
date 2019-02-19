
<script type="text/javascript" src="<?php echo URI::getLiveTemplatePath() . "/js/jquery.paging.min.js" ?>"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var pausecontent = <?php echo json_encode(CFG::$ticketStatusArray); ?>;
       
       
        $("#txtDFrom").datepicker({ dateFormat: "dd-mm-yy",changeMonth: true,changeYear: true, buttonImage: "<?php echo URI::getLiveTemplatePath()."/images/calender2.png";?>",buttonImageOnly: true,showOn: "both",maxDate:'0',onClose: function( selectedDate ) {
				$( "#txtDTo" ).datepicker( "option", "minDate", selectedDate );
			}});
                    
                        $("#txtDTo").datepicker({ dateFormat: "dd-mm-yy",changeMonth: true,changeYear: true, buttonImage: "<?php echo URI::getLiveTemplatePath()."/images/calender2.png";?>",buttonImageOnly: true,showOn: "both",maxDate:'0',onClose: function( selectedDate ) {
				//$( "#txtDFrom" ).datepicker( "option", "maxDate", selectedDate );
			}});
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
                list = list + '<div class="hashBox">' + data.records[i].id + '</div>';
                list = list + '<div class="pageName">';
                <?php if(Core::hasAccess(APP::$moduleName, "ticket_edit") && isset($_SESSION['user_login']) && $_SESSION['user_login']['roll_id']!='7') { ?>
                      list = list + '<a href="index.php?m=mod_ticket&a=ticket_edit&id=' + data.records[i].id + '"  title="' + data.records[i].name + '">' + capitalLetter(data.records[i].name) + '</a>';
                       
               <?php } else { ?>
                       list = list  + capitalLetter(data.records[i].subject);
               <?php } ?>
                list = list + '<ul class="optUl">';
                <?php if(Core::hasAccess(APP::$moduleName, "ticket_view")) { ?>
                list = list + '<li><a href="index.php?m=mod_ticket&a=ticket_view&id=' + data.records[i].id + '" title="View">View</a></li>';
                <?php } ?>
                <?php if(Core::hasAccess(APP::$moduleName, "ticket_edit") && $_SESSION['user_login']['roll_id']!='7') { ?>
                    if(data.records[i].ticket_status!='completed'){
                        list = list + '<li><a href="index.php?m=mod_ticket&a=ticket_edit&id=' + data.records[i].id + '" title="Edit">Edit</a></li>';
                    }
                <?php } ?>
                <?php /*if(Core::hasAccess(APP::$moduleName, "change_status")) { ?>
                    list = list + '<li><a href="#" onclick="return changeStatus(\'index.php?m=mod_ticket&a=change_status\',' + data.records[i].id + ',\'\')" title="Change Status">Change Status</a></li>';
                <?php } */?>
                 <?php
                    if (Core::hasAccess(APP::$moduleName, "delete_ticket")) {
                    ?>
                    list = list +'<li class="delLi hideDeleteOption"><a href="#" onclick="deleteRecord(\'index.php?m=mod_ticket&a=delete_ticket\',' + data.records[i].id + ')" title="Delete">Delete</a></li>';
                    <?php }?>
                list=list+'</ul>';
                
                list = list +'<a class="toggleLink" href="javascript:;"></a></div>';
                 <?php if(Core::hasAccess(APP::$moduleName, "ticket_edit") && isset($_SESSION['user_login']) && $_SESSION['user_login']['roll_id']!='7') { ?>
                     list = list + '<div class="statusBox alignLeft" data-title="Ticket Subject:"><span class="conSpan">' + capitalLetter(data.records[i].subject) + '</span></div>';
                 <?php }?>
                     var cur_status=data.records[i].ticket_status;
                    
                list = list + '<div class="statusBox alignLeft" data-title="Ticket Status:"><span class="conSpan">' + pausecontent[cur_status]+ '</span></div>';
                list = list + '<div class="statusBox alignLeft" data-title="Region:"><span class="conSpan">' + capitalLetter(data.records[i].region_name) + '</span></div>';
                
                list = list + '<div class="statusBox alignLeft" data-title="HelpDesk:"><span class="conSpan">' + capitalLetter(data.records[i].helpdesk_name) + '</span></div>';
                 list = list + '<div class="statusBox alignLeft" data-title="Created Date:"><span class="conSpan">' + displayFormatedDate(data.records[i].created_date) + '</span></div>';
                
                /*list = list + '<div class="sortOrder" data-title="Sort Order:">\n\
                                <input class="sortTxt text-center inner-page-checkbox" type="text" maxlength="3" id="sort_order'+data.records[i].sort_order+'" name="sort_order['+data.records[i].id+']" value="'+data.records[i].sort_order+'" \n\\n\
                                <?php if(Core::hasAccess(APP::$moduleName, "save_sortorder")) { ?> \n\
                                onblur="if(this.value!='+data.records[i].sort_order+'){changeSortOrder(\'index.php?m=mod_ticket&a=save_sortorder\',this.value,'+data.records[i].id+');}if(this.value.length==0){this.value='+data.records[i].sort_order+';}" \n\
                                <?php 
                                }else{ 
                                    ?> disabled="true" <?php 
                                } ?> onkeypress=\'return isNumberic(event);\' /></div>';
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
           
            if ($.trim($("#customer_name").val()) == "" && $('#customer_name').length > 0)
            {
                
                if(($.trim($("#txtDFrom").val()) == "" &&  $.trim($("#txtDTo").val()) == "") && $.trim($("#searchByRegion").val()) == "" && $.trim($("#searchByHelpDesk").val()) == "" && $.trim($("#searchByStatus").val()) == "")
                {					
                   alert("Please enter customer, ticket subject or ticket no in search text");
                   return false;
                }
            }
            else if ($.trim($("#ticket_subject").val()) == "" && $('#ticket_subject').length > 0)
            {
                if($.trim($("#txtDFrom").val()) == "" &&  $.trim($("#txtDTo").val()) == "" && $.trim($("#searchByRegion").val()) == "" && $.trim($("#searchByHelpDesk").val()) == "" && $.trim($("#searchByStatus").val()) == "")
                {							
                   alert("Please enter ticket subject or ticket no to search in search text");
                   return false; 
                }
            }
            //$("#searchByRegion").val("");
            //$("#searchByStatus").val("");
            //$("#searchByHelpDesk").val("");
            return true;
        }

        pageData.validateSearch = validateSearchForm;

        resetForm = function()
        {
            
            $("#searchByRegion").val("");
            $("#searchByStatus").val("");
            $("#searchByHelpDesk").val("");
            $("#customer_name").val("");
            $("#ticket_subject").val("");
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

        // restore value of search form
        function restoreSearchForm()
        {
            if (oldPageState && oldPageState.searchData)
            {
                $("#ticket_subject").val(oldPageState.searchData.searchForm.ticket_subject);
                $("#customer_name").val(oldPageState.searchData.searchForm.customer_name);
                $('#searchByStatus').val(oldPageState.searchData.searchForm.status);
                $('#searchByRegion').val(oldPageState.searchData.searchForm.region);
                $('#searchByHelpDesk').val(oldPageState.searchData.searchForm.helpdesk);
                $("#txtDFrom").val(oldPageState.searchData.searchForm.dateFrom);
                $("#txtDTo").val(oldPageState.searchData.searchForm.dateTo);
                $(".numOfRecord").val(oldPageState.searchData.searchForm.numOfRecord);
            }
        }
        restoreSearchForm();

    });
function capitalLetter(string)
{
    return string.charAt(0).toUpperCase()+string.slice(1);
}
function displayFormatedDate(val)
{
    var dateString = val.split("-");
   //alert(dateString);
    return dateString[2] + "/" + dateString[1] + "/" + dateString[0];
}
</script>
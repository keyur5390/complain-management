
<script type="text/javascript" src="<?php echo URI::getLiveTemplatePath() . "/js/jquery.paging.min.js" ?>"></script>
<script type="text/javascript">
    $(document).ready(function() {
        
        $("#txtDFrom").datepicker({ dateFormat: "dd-mm-yy",changeMonth: true,changeYear: true, buttonImage: "<?php echo URI::getLiveTemplatePath()."/images/calender2.png";?>",buttonImageOnly: true,showOn: "both",onClose: function( selectedDate ) {
				$( "#txtDTo" ).datepicker( "option", "minDate", selectedDate );
			}});
                    
                        $("#txtDTo").datepicker({ dateFormat: "dd-mm-yy",changeMonth: true,changeYear: true, buttonImage: "<?php echo URI::getLiveTemplatePath()."/images/calender2.png";?>",buttonImageOnly: true,showOn: "both",onClose: function( selectedDate ) {
				//$( "#txtDFrom" ).datepicker( "option", "maxDate", selectedDate );
			}});
        var displayPages = function(data, startIndex) {
			
            var list = "";
            for (i = 0; i < data.records.length; i++)
            {
                
                
                
                var odd = (i % 2 == 0) ? "" : "odd";
                list = list + '<tr class=" ' + odd + '">';
                
                list = list + '<td align="center"  class="hide-mobile visibleNumber">' + startIndex + '</td>';
                //list = list + '<div class="hashBox">' + startIndex + '</div>';
               
                
                list = list + '<td class="pageName customerName alignLeft" data-title="Customer Name:">' + data.records[i].name+ '  <a class="toggleLink" href="javascript:;"></a></td>';
                list = list + '<td class="customerName alignCenter" data-title="Region:">' + data.records[i].region_name + '</td>';
                list = list + '<td class="customerName alignCenter" data-title="Helpdesk:">' + data.records[i].helpdesk_name + '</td>';
                
                
              
                /*list = list + '<div class="sortOrder" data-title="Sort Order:">\n\
                                <input class="sortTxt text-center inner-page-checkbox" type="text" maxlength="3" id="sort_order'+data.records[i].sort_order+'" name="sort_order['+data.records[i].id+']" value="'+data.records[i].sort_order+'" \n\\n\
                                <?php if(Core::hasAccess(APP::$moduleName, "save_sortorder")) { ?> \n\
                                onblur="if(this.value!='+data.records[i].sort_order+'){changeSortOrder(\'index.php?m=mod_ticket&a=save_sortorder\',this.value,'+data.records[i].id+');}if(this.value.length==0){this.value='+data.records[i].sort_order+';}" \n\
                                <?php 
                                }else{ 
                                    ?> disabled="true" <?php 
                                } ?> onkeypress=\'return isNumberic(event);\' /></div>';
                list = list + '<div class="statusBox" data-title="Status:"><span class="conSpan">' + displayStatus(data.records[i].status) + '</span></div>';*/
                list = list + '<td title="View Details" class="toggle-details DetailProBtn" id="viewPrdDet' + data.records[i].user_id + '" onclick="viewPrd(\'' + data.records[i].user_id +'\')" data-order="1"><span id="toggleId'+data.records[i].user_id+'" class="removeToggle" >&nbsp;</span></td>';
                list = list + '</tr>';
                 list = list + '<tr id="append-'+data.records[i].user_id+'" style="display:none" class="appendDiv"></li>';
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

        // create function for validating search form
        validateSearchForm = function() {
           
            if ($.trim($("#customer_name").val()) == "" && $('#customer_name').length > 0)
            {
                if($.trim($("#txtDFrom").val()) == "" &&  $.trim($("#txtDTo").val()) == "")
                {							
                   alert("Please enter customer");
                   return false;
                }
            }
            else if ($.trim($("#ticket_subject").val()) == "" && $('#ticket_subject').length > 0)
            {
                if($.trim($("#txtDFrom").val()) == "" &&  $.trim($("#txtDTo").val()) == "")
                {							
                   alert("Please enter ticket subject");
                   return false;
                }
            }
            return true;
        }

        pageData.validateSearch = validateSearchForm;

        resetForm = function()
        {
            $("#customer_name").val("");
            $("#searchByRegion").val("");
            $("#searchByHelpDesk").val("");
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
                $(".numOfRecord").val(oldPageState.searchData.searchForm.numOfRecord);
            }
        }
        restoreSearchForm();

    });
    function viewPrd(id)
    {
       
        var livePath = '<?php echo URI::getURL(APP::$moduleName, APP::$actionName) ?>';
        if ($("#append-" + id).is(":visible")) {
            $('#append-' + id).hide(200);
            $("#toggleId"+ id).removeClass("spanMinus");
        } else {
            $.ajax({
                type: "post",
                dataType: "text",
                data: "user_id=" + id + "&action=getTicketDetails",
                url: livePath, // url of php page where you are writing the query
                beforeSend: function() {
                    showGridProgress();
                },
                success: function(response)
                {
                    //alert(response);
                    $('.appendDiv').empty();
                     $('.appendDiv').hide();
                    $(".removeToggle").removeClass("spanMinus");
                    $("#append-" + id).append(response).show(200);
                    hideGridProgress();
                      
                    $("#toggleId"+ id).addClass("spanMinus");
                      
                    return false;
                }
            });
        }

    }

</script>
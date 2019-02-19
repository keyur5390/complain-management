<script type="text/javascript" src="<?php echo URI::getLiveTemplatePath()."/js/jquery.paging.min.js"?>"></script>
<script type="text/javascript">	
	$(document).ready(function(){	

        var displayPages = function(data, startIndex) {
            var list = "";
            for (i = 0; i < data.records.length; i++)
            {
                var odd = (i % 2 == 0) ? "" : " class='odd' ";
                list = list + '<li ' + odd + '>';
                list = list + '<div class="chekMain"><div class="chkInn"><label><input type="checkbox" id="status' + data.records[i].id + '" name="status[' + data.records[i].id + ']" value="' + data.records[i].status + '" class="checkbox" /><span></span></label></div></div>';
                list = list + '<div class="hashBox">' + startIndex + '</div>';
                list = list + '<div class="pageName"><a href="index.php?m=mod_user&a=access_edit&id=' + data.records[i].id + '"  title="' + data.records[i].name + '">' + data.records[i].name + '</a><ul class="optUl"><li><a href="index.php?m=mod_user&a=access_edit&id=' + data.records[i].id + '" title="Edit">Edit</a></li><li class="delLi"><a href="#" onclick="deleteRecord(\'index.php?m=mod_user&a=access_delete\',' + data.records[i].id + ')" title="Delete">Delete</a></li></ul></div>';
                list = list + '</li>';
                startIndex = startIndex + 1;
            }
            $(".table").find("li:not(.topLi)").remove()
            $(".table").append(list);
            bindListingClick();
        }


        pageData.url = '<?php echo URI::getURL(APP::$moduleName,APP::$actionName)?>';
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
	validateSearchForm = function(){
							if($.trim($("#name").val()) == "")
							{
								alert("Please enter name.");
								return false;
							}
							return true;
						 }
						 
	pageData.validateSearch = validateSearchForm;
	
	resetForm = function()
				{
					$("#name").val("");
					pageData.searchField = "";
					pageData.noOfRecords = totalPages;
					doPaging();
				}
	
	// display message			
	<?php Core::displayMessage("actionResult","User Save");?>
	
	// initialize tooltip	
	applyTooltip();
	
	// initialize popover
	applyPopover();	
	
	// restore value of search form
	function restoreSearchForm()
	{
		if(oldPageState && oldPageState.searchData)
		{
			$("#name").val(oldPageState.searchData.searchForm.name);
                        $(".numOfRecord").val(oldPageState.searchData.searchForm.numOfRecord);
		}
	}
	restoreSearchForm();
        
});
	
</script>
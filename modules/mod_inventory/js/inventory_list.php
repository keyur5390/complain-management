<link href="<?php echo URI::getLiveTemplatePath();?>/plugins/pnotify/jquery.pnotify.default.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo URI::getLiveTemplatePath()."/plugins/pnotify/jquery.pnotify.min.js"?>"></script>
<script type="text/javascript" src="<?php echo URI::getLiveTemplatePath()."/js/jquery.paging.min.js"?>"></script>
<script type="text/javascript" src="<?php echo URI::getLiveTemplatePath()."/js/datepicker.js"?>"></script>
<script type="text/javascript" src="<?php echo URI::getLiveTemplatePath() . "/js/jquery-ui.custom.js" ?>"></script>
 
<script type="text/javascript">	
 <?php 
 
 echo Stringd::createJsObject("roleData",$data);
 
 ?>
  
	$(document).ready(function(){
 $("#txtDFrom").datepicker({ dateFormat: "dd-mm-yy",changeMonth: true,changeYear: true, buttonImage: "<?php echo URI::getLiveTemplatePath()."/images/calender2.png";?>",buttonImageOnly: true,showOn: "both",onClose: function( selectedDate ) {
				$( "#txtDTo" ).datepicker( "option", "minDate", selectedDate );
			}});
                    
                        $("#txtDTo").datepicker({ dateFormat: "dd-mm-yy",changeMonth: true,changeYear: true, buttonImage: "<?php echo URI::getLiveTemplatePath()."/images/calender2.png";?>",buttonImageOnly: true,showOn: "both",onClose: function( selectedDate ) {
				//$( "#txtDFrom" ).datepicker( "option", "maxDate", selectedDate );
			}});
                    $("#txtSellDate").datepicker({ dateFormat: "dd-mm-yy",changeMonth: true,changeYear: true, buttonImage: "<?php echo URI::getLiveTemplatePath()."/images/calender2.png";?>",buttonImageOnly: true,showOn: "both"});
      
            var displayUsers = function(data,startIndex){ 
             
                var list = ""; 
                var roll='<?php echo CORE::getUserData('roll_id'); ?>';
                var uid='<?php echo CORE::getUserData('id'); ?>';
        for(i=0;i<data.records.length;i++)
                {	var region="";
                        if(data.records[i].helpdesk_region && data.records[i].helpdesk_region!=""){
                            region=data.records[i].helpdesk_region;
                        }
                        var odd = (i % 2 == 0) ? "" : " class='odd' ";
                        list = list + '<li ' + odd + '>';
                          
                        list = list + '<div class="hashBox">' + startIndex + '</div>';
                        list = list + '<div class="pageName">';
                        if(roll == '1' || (roll == '5' && data.records[i].created_by == uid)) {
                               list = list + '<a href="index.php?m=mod_inventory&a=inventory_edit&id=' + data.records[i].id + '"  title="' + data.records[i].product_sr_no + '">' + data.records[i].product_sr_no + '</a>';
                        } else {
                               list = list + data.records[i].product_sr_no;
                        }
                           if(roll == '1' || (roll == '5' && data.records[i].created_by == uid)) {
                        list = list + '<ul class="optUl">';
                        list = list + '<li><a href="index.php?m=mod_inventory&a=inventory_edit&userid='+ data.records[i].user_id +'&id=' + data.records[i].id + '" title="Add Inventory">Edit</a></li>';
                        //list = list + '<li><a href="index.php?m=mod_inventory&a=delete_inventory&id=' + data.records[i].id + '" title="View Inventory">Delete</a></li>';
                        list  = list + '<li><a href="javascript:;" onclick="deleteRecord(\'index.php?m=mod_inventory&a=delete_inventory\',' +  data.records[i].id + ')" title="Delete" rel="nofollow" title="Delete" class="trans actionLink delLink">Delete</a></li>';
                        list=list+'</ul>';
                           }
                        list = list +'<a class="toggleLink" href="javascript:;"></a></div>';

                        list = list + '<div class="slugName  alignLeft" data-title="User Name:"><span class="conSpan">' + data.records[i].product_name + '</span></div>';
                        list = list + '<div class="slugName  alignLeft" data-title="User Name:"><span class="conSpan">' + data.records[i].product_model + '</span></div>';
                        list = list + '<div class="slugName" data-title="Email:"><span class="conSpan">' + displayFormatedDate(data.records[i].warranty_start_date)  + '</span></div>';
                        list = list + '<div class="slugName" data-title="Phone:"><span class="conSpan">' + displayFormatedDate(data.records[i].warranty_end_date) + '</span></div>';
                        list = list + '<div class="slugName" data-title="Phone:"><span class="conSpan">' + displayFormatedDate(data.records[i].sell_date) + '</span></div>';
                        list = list + '<div class="slugName alignLeft" data-title="Phone:"><span class="conSpan">' + data.records[i].region_name + '</span></div>';

                         

                        list = list + '</li>';
                        startIndex = startIndex + 1;
                }
                $(".table").find("li:not(.topLi)").remove();
                $(".table").append(list);
                  bindListingClick();
                //$("input").uniform();
                applyTooltip();										
           }

            pageData.url = '<?php echo URI::getURL(APP::$moduleName,APP::$actionName)?>';
            pageData.noOfRecords = totalUsers;
            pageData.pagingBlock = '#pagingNo';
            pageData.callbackFun = displayUsers;
            pageData.perPage = <?php echo CFG::$pageSize;?>;

            // do paging	
            createDataGrid();

            // initialize sorting
            sortData();	

            // create function for validating search form
            validateSearchForm = function()
            {
                if ($("#user_name").val() == "" && $("#searchByRegion").val() == "" && $("#txtDFrom").val() == "" && $("#txtDTo").val() == "" && $("#txtSellDate").val() == "")
                {
                    
                        alert("Please select or enter at least one parameter");
                        return false;
                } 
                /*
                if($.trim($("#user_name").val()) == "")
                {
                    alert("Please enter name,username or email into the serach");
                    return false;
                }
                $("#searchByRole").val('');	 
                */
                return true;
            }

            pageData.validateSearch = validateSearchForm;

            resetForm = function()
            {
                $("#searchByRegion").val('');
                $("#user_name").val("");
                $("#txtDFrom").val("");
                $("#txtDTo").val("");
                $("#txtSellDate").val("");
                //$.uniform.update($("#drpRole").prop("selectedIndex",0));
                pageData.searchField = "";
                pageData.noOfRecords = totalUsers;
                doPaging();
            }

            // display message			
            <?php Core::displayMessage("actionResult","Inventory Save");?>

            // initialize tooltip	
            applyTooltip();

            // initialize popover
            applyPopover();	

            // restore value of search form
            function restoreSearchForm()
            {
                if(oldPageState && oldPageState.searchData)
                {
                    $("#user_name").val(oldPageState.searchData.searchForm.user_name);
                    $("#txtDFrom").val(oldPageState.searchData.searchForm.dateFrom);
                    $("#txtDTo").val(oldPageState.searchData.searchForm.dateTo);
                    $("#txtSellDate").val(oldPageState.searchData.searchForm.sellDate);
                    $("#searchByRegion").val(oldPageState.searchData.searchForm.region);
                    $('#searchByRole').val(oldPageState.searchData.searchForm.role);
                    $("#drpRole").prop("selectedIndex",oldPageState.searchData.searchForm.role);
                }
            }
            restoreSearchForm();
			
	});
        
//        $("#drpRole").change(function(e){
//             pageData.validateSearch="";
//            $("#searchForm").submit();
//             pageData.validateSearch=validateSearchForm;  
//        });
function send_mail(url, id)
{
   
    
    // display proccess div over grid
    showGridProgress();

    $.ajax({
        "type": "post",
        "url": url,
        //"data": $("#frmGrid").serialize(),
        "data": "id="+id,
        "success": function(data) {
                    
           
                    var objData = jQuery.parseJSON(data);
                    
                    

                    // hide proccess div over grid
                    hideGridProgress();

                    // display message
                    //if(objDataDelete.result && objDataDelete.result == "error")
                    displayMessage(objData.result, objData.title, objData.message);
                    
                }
            });
        
   
}

function displayFormatedDate(val)
{
    var dateString = val.split("-");
   //alert(dateString);
    return dateString[2] + "/" + dateString[1] + "/" + dateString[0];
}

function csvImport(userid) {
<?php $_SESSION['csvUrl'] = URI:: getURL("mod_inventory", "import_csv"); ?>
       window.open("<?php echo CFG::$livePath; ?>/feed/importInventoryCSV.php?userid="+userid, "_blank", "width=600px,height=400px,toolbar=no,menubar=no,scrollbars=1");
   }
</script>
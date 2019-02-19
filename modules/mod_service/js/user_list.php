<link href="<?php echo URI::getLiveTemplatePath();?>/plugins/pnotify/jquery.pnotify.default.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo URI::getLiveTemplatePath()."/plugins/pnotify/jquery.pnotify.min.js"?>"></script>
<script type="text/javascript" src="<?php echo URI::getLiveTemplatePath()."/js/jquery.paging.min.js"?>"></script>
 
<script type="text/javascript">	
 <?php echo Stringd::createJsObject("roleData",$data);?>
            
//           $("#drpRole").empty(); 
//           $("#drpRole").append('<option value="">Select Role<?php // echo " - ".Select_role; ?></option>');
//    
//           for(r=0;r<roleData.role.length;r++) {
//                   
//                $("#drpRole").append("<option value='"+roleData.role[r].id+"'>"+roleData.role[r].name+"</option>");
//                
//           }
	$(document).ready(function(){
//           alert(roleData.allRegion);
      
            var displayUsers = function(data,startIndex){ 
             
                var list = ""; 

    //            var user = new Array();
    //            var role = new Array();
    //            
    //             for(r=0;r<roleData.role.length;r++) {
    //               role[roleData.role[r].id]=roleData.role[r].name; 
    //           }
    //      
    //            for(u=0;u<roleData.admin.length;u++){
    //                user[roleData.admin[u].id]=roleData.admin[u].name;
    //            }
                console.log(data.records.length);
                for(i=0;i<data.records.length;i++)
                {	var region="";
                        if(data.records[i].helpdesk_region && data.records[i].helpdesk_region!=""){
                            region=data.records[i].helpdesk_region;
                        }
                        var odd = (i % 2 == 0) ? "" : " class='odd' ";
                        list = list + '<li ' + odd + '>';
                          
                        list = list + '<div class="hashBox">' + startIndex + '</div>';
                        list = list + '<div class="pageName">';
                        <?php if(Core::hasAccess(APP::$moduleName, "user_edit")) { ?>
                               list = list + '<a href="index.php?m=mod_user&a=user_edit&id=' + data.records[i].id + '"  title="' + data.records[i].name + '">' + data.records[i].name + '</a>';
                       <?php } else { ?>
                               list = list + data.records[i].name;
                       <?php } ?>
                        list = list + '<ul class="optUl">';
                        <?php if(Core::hasAccess(APP::$moduleName, "inventory_edit")) { ?>
                        list = list + '<li><a href="index.php?m=mod_inventory&a=inventory_edit&userid=' + data.records[i].id + '" title="Add Inventory">Add Inventory</a></li>';
                        <?php } ?>
                        <?php if(Core::hasAccess(APP::$moduleName, "inventory_view")) { ?>
                        list = list + '<li><a href="index.php?m=mod_inventory&a=inventory_list&userid=' + data.records[i].id + '" title="View Inventory">View Inventory</a></li>';
                        <?php } ?>
                          
                            
                        list=list+'</ul>';
                        list = list +'<a class="toggleLink" href="javascript:;"></a></div>';

                        list = list + '<div class="slugName  alignLeft" data-title="User Name:"><span class="conSpan">' + data.records[i].username + '</span></div>';
                         
                        if(data.records[i].roll_id=="6" && data.records[i].all_region=='1') {
                             list = list + '<div class="slugName  alignLeft" data-title="Region:"><span class="conSpan">All Region</span></div>';
                        } else {
                        list = list + '<div class="slugName  alignLeft" data-title="Region:"><span class="conSpan">' + (data.records[i].roll_id=="5"?region:data.records[i].sub_region) + '</span></div>';
                        }

                        list = list + '<div class="slugName  alignLeft" data-title="Email:"><span class="conSpan">' + data.records[i].email + '</span></div>';

                        list = list + '<div class="slugName alignLeft" data-title="Phone:"><span class="conSpan">' + data.records[i].phone + '</span></div>';

                         

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
                if ($("#user_name").val() == "")
                {
                    if ($("#searchByRole").val() == "") 
                    {
                        alert("Please enter name, username, email or phone for search");
                        return false;
                    } 
                    else 
                    {
                        $("#searchByRole").attr("data-source", "0");
                    }
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
                $("#searchByRole").val('');
                $("#user_name").val("");
                //$.uniform.update($("#drpRole").prop("selectedIndex",0));
                pageData.searchField = "";
                pageData.noOfRecords = totalUsers;
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
                    $("#user_name").val(oldPageState.searchData.searchForm.user_name);
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
function csvImport(treat) {
<?php $_SESSION['csvUrl'] = URI:: getURL("mod_inventory", "import_csv"); ?>
       window.open("<?php echo CFG::$livePath; ?>/feed/importInventoryCSV.php", "_blank", "width=600px,height=400px,toolbar=no,menubar=no,scrollbars=1");
   }
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
</script>
<script type="text/javascript" src="<?php echo URI::getLiveTemplatePath() . '/js/jquery.validate.js' ?>"></script>
<script type="text/javascript" src="<?php echo URI::getLiveTemplatePath() . "/js/jquery.paging.min.js" ?>"></script>
<link href="<?php echo URI::getLiveTemplatePath(); ?>/css/jquery.simple-dtpicker.css" type="text/css" rel="stylesheet"/> 
<link href="<?php echo URI::getLiveTemplatePath(); ?>/css/jquery-ui.css" type="text/css" rel="stylesheet"/> 
<script type="text/javascript" src="<?php echo URI::getLiveTemplatePath() . '/js/jquery.simple-dtpicker.js' ?>"></script>
<script type="text/javascript">
    
    <?php  echo Stringd::createJsObject("priorityData", CFG::$priorityArray); ?>
    
//    console.log(priorityData);
//    $("#parent_complain").empty();
//    $("#parent_complain").append('<option value="0">Root</option>');
//    var selectedParentcomplain="";
//    $.each(pageData['parentcomplainData'], function(parentcomplainKey,parentcomplainValue) {
////        alert(parentcomplainValue.name);
//        $("#parent_complain").append('<option value="'+parentcomplainValue.id+'" ' + selectedParentcomplain + ' >'+parentcomplainValue.name+'</option>');
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
			console.log(data);
            var list = "";
            for (i = 0; i < data.records.length; i++)
            {
                var odd = (i % 2 == 0) ? "" : " class='odd' ";
                list = list + '<li ' + odd + '>';
                 <?php 
                            if(isset($_SESSION['user_login']) && $_SESSION['user_login']['roll_id']=='1'){?>
                                            <?php if(!isset($_REQUEST['type']) && $_REQUEST['type']==''){?>
                list = list + '<div class="chekMain"><div class="chkInn"><label><input type="checkbox" id="status' + data.records[i].id + '" name="status[' + data.records[i].id + ']" value="' + data.records[i].status + '" class="checkbox" /><span></span></label></div></div>';
                            <?php }?>
                            <?php }?>
                                var bgColor = "";
                                if(data.records[i].status==0){
                                    bgColor ="red";
                                }else if(data.records[i].status==1){
                                    bgColor ="green";
                                }
                             var forwareded =   (data.records[i].forward!=null?"_"+data.records[i].forward:"");
               // list = list + '<div class="hashBox">' + startIndex + '</div>';
                list = list + '<div class="hashBox" style="background-color:'+bgColor+'">' + data.records[i].comid+forwareded+ '</div>';
                list = list + '<div class="">' + displayDate(data.records[i].created_date) + '</div>';
                list = list + '<div class="pageName">';
                 <?php if(Core::hasAccess(APP::$moduleName, "helpDesk_edit")) { ?>
                        list = list + '' + data.records[i].compname + '';
                <?php } else { ?>
                        list = list + data.records[i].compname;
                <?php } ?>
                list = list + '<ul class="optUl">';
                <?php if(!isset($_REQUEST['type']) && $_REQUEST['type']==''){?>
                <?php /*if(Core::hasAccess(APP::$moduleName, "complain_edit")) { ?>
                list = list + '<li><a href="index.php?m=mod_complain&a=complain_edit&id=' + data.records[i].comid + '" title="Edit">Edit</a></li>';
                <?php }*/ ?>

                <?php /*if(Core::hasAccess(APP::$moduleName, "change_status")) { ?>
                list = list + '<li><a href="#" onclick="return changeStatus(\'index.php?m=mod_complain&a=change_status\',' + data.records[i].id + ',\'\')" title="Change Status">Change Status</a></li>';
                <?php }*/ ?>

                <?php //if(Core::hasAccess(APP::$moduleName, "delete_complain")) { ?>
                list = list + '<li class=""><a href="#" onclick="deleteRecord(\'index.php?m=mod_complain&a=delete_complain\',' + data.records[i].id + ')" title="Delete">Delete</a></li>';
                <?php //} ?>    
                <?php }else{?> 
                list = list + '<li><a href="index.php?m=mod_complain&a=complain_view&id=' + data.records[i].comid + '&type=view" title="View">View</a></li>';
                    <?php }?>
                list=list+'</ul>';
                list = list + '<a class="toggleLink" href="javascript:;"></a>';
                 list = list + '</div>';
                 list = list + '<div class="hashBox">' + data.records[i].company_dealer + '</div>';
                 list = list + '<div class="hashBox">' + data.records[i].complaintype + '</div>';
                 list = list + '<div class="hashBox">' + data.records[i].stationname + '</div>';
                 list = list + '<div class="hashBox">' + data.records[i].euiname + '</div>';
                 list = list + '<div class="hashBox">' + data.records[i].assetname + '</div>';
                 list = list + '<div class="hashBox">' + data.records[i].asset_extra + '</div>';
               /* list = list + '<div class="sortOrder" data-title="Sort Order:"><input class="sortTxt text-center inner-page-checkbox" type="text" maxlength="3" id="sort_order'+data.records[i].sort_order+'" name="sort_order['+data.records[i].id+']" value="'+data.records[i].sort_order+'" onblur="if(this.value!='+data.records[i].sort_order+'){changeSortOrder(\'index.php?m=mod_complain&a=save_sortorder\',this.value,'+data.records[i].id+');}if(this.value.length==0){this.value='+data.records[i].sort_order+';}" onkeypress=\'return isNumberic(event);\' /></div>';*/
                list = list + '<div class="statusBox" data-title="Status:"><span class="conSpan">' + priorityData[data.records[i].complain_priority] + '</span></div>';
                list = list + '<div class="">' + data.records[i].recived_time + '</div></li>';
                   list = list + '<li ' + odd + '><div></div><div></div>';
                  // alert(data.records[i].reach_time);
                list = list + '<div class="hashBox" style="width:500px;"><span class="topLi star " style="padding-top: 8px; PADDING-BOTTOM: 8px;margin-bottom: 8px;  float: left;  text-align: center;width: 100%; ">Reach Time</span><input type="text" name="reach_time" id="reach_time_'+data.records[i].comid+'" maxlength="100" class="txt required reach_time" title="Complain Reach Time"  value="'+(data.records[i].reach_time) +'" ></div>';
                list = list + '<div class="hashBox" style="width:500px;"><span class="topLi star" style="padding-top: 8px; PADDING-BOTTOM: 8px;margin-bottom: 8px;  float: left;  text-align: center;width: 100%; ">Close Time</span><input type="text" name="close_time" id="close_time_'+data.records[i].comid+'" maxlength="100" class="txt required close_time" title="Complain Reach Time"  value="'+(data.records[i].close_time) +'" ></div>';
                var opn = (data.records[i].status  == 0) ? "selected='selected'" : " ";
                var cls = (data.records[i].status  == 1) ? "selected='selected'" : " ";
                list = list + '<div class="hashBox" style="width:200px;"><span class="topLi star" style="padding-top: 8px; PADDING-BOTTOM: 8px;margin-bottom: 8px;  float: left;  text-align: center;width: 100%; ">Status</span><br/><select id="chkStatus_'+data.records[i].comid+'" name="status"><option '+opn+' value="0">Open</option><option '+cls+' value="1">Close</option></select></div>';
                 list = list + '<div class="hashBox" style="width:200px;"><span class="topLi " style="padding-top: 8px; PADDING-BOTTOM: 8px;margin-bottom: 8px;  float: left;  text-align: center;width: 100px; ">Department Name</span><br/>'+data.records[i].departmentname+'</div>';
                list = list + '<div class="hashBox" style="width:200px;"><span class="topLi " style="padding-top: 8px; PADDING-BOTTOM: 8px;margin-bottom: 8px;  float: left;  text-align: center;width: 100%; ">Remark</span><br/>'+data.records[i].remark+'</div>';
                list = list + '<div class="hashBox" style="width:200px;"><span class="topLi " style="padding-top: 8px; PADDING-BOTTOM: 8px;margin-bottom: 8px;  float: left;  text-align: center;width: 100%; ">logged By</span><br/>'+data.records[i].updatedBy+'</div>';
                var clsby = (data.records[i].close_by!=null && data.records[i].status  == 1)?data.records[i].close_by:"N/A";
                list = list + '<div class="hashBox" style="width:200px;"><span class="topLi " style="padding-top: 8px; PADDING-BOTTOM: 8px;margin-bottom: 8px;  float: left;  text-align: center;width: 100%; ">Close By</span><br/>'+clsby+'</div>';
                list = list + '<div class="hashBox" style="width:200px;"><a href="index.php?m=mod_complain&a=complain_edit&type=forward&id=' + data.records[i].comid + '" id="btnForward" class="trans comBtn" title="Forward">Forward</a><br/></div>'; //onclick="forwardCom('+data.records[i].comid+')" 
                list = list + '<div class="hashBox" style="width:200px;"><a href="#" id="btnUpdate" class="trans comBtn" onclick="updateCom('+data.records[i].comid+')" title="Update">Update</a><br/></div>';
                list = list + '</li>';
                startIndex = startIndex + 1;
            }
            $(".table").find("li:not(.topLi)").remove();
            $(".table").append(list);
            bindListingClick();
        }
setTimeout(function(){
$('.reach_time').appendDtpicker({
	"closeOnSelected": true,
       // "futureOnly": true,
        "minuteInterval": 5
	});    
$('.close_time').appendDtpicker({
	"closeOnSelected": true,
       // "futureOnly": true,
        "minuteInterval": 5
	});    
},3000);
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
//                    alert("Please enter complain name for search");
//                    return false;
//                } 
//                else 
//                {
//                    $("#helpDesk").attr("data-source", "0");
//                }*/
//                if($.trim($("#helpDesk").val()) == "" )
//                {							
//                   alert("Please enter complain name or select hepl desk or parent complain for search");
//                   return false;
//                }
//            }
            if($.trim($("#parentcomplain").val()) == "" && $.trim($("#helpDesk").val()) == "" && $("#name").val() == "")
                {							
                   alert("Please enter complain name or select hepl desk or parent complain for search");
                   return false;
                }
            return true;
        }

        pageData.validateSearch = validateSearchForm;

        resetForm = function()
        {
            $("#name").val("");
            $("#helpDesk").val("");
            $("#parentcomplain").val("");
            pageData.searchField = "";
            pageData.noOfRecords = totalPages;
            doPaging();
        }

        // display message			
        <?php Core::displayMessage("actionResult", "complain Save"); ?>

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
                $("#parentcomplain").val(oldPageState.searchData.searchForm.parentcomplain);
                $(".numOfRecord").val(oldPageState.searchData.searchForm.numOfRecord);
            }
        }
        restoreSearchForm();

    });
    function forwardCom(comid)
    {showGridProgress();
        $.ajax({
                url: "<?php echo CFG::$livePath."/page.php"; ?>",
                type: "post",
               // data:"comid="+ comid+"&action=forwardcom&reach_time=reach_time_"+comid+"&close_time=close_time_"+comid+"&status=chkStatus_"+comid+"",                   
     data:"comid="+ comid+"&action=forwardcom&reach_time="+$('#reach_time_'+comid).val()+"&close_time="+$('#close_time_'+comid).val()+"&status="+$('#chkStatus_'+comid).val()+"",      
                "success": function(data) {
                    if(data!='')
                    {hideGridProgress();
                         createDataGrid();
                         displayMessage("success","Forward Successfully","The complain is forwarded successfully");
                    }
                }
            });
    }
    function updateCom(comid)
    {showGridProgress();
        $.ajax({
                url: "<?php echo CFG::$livePath."/page.php"; ?>",
                type: "post",
                data:"comid="+ comid+"&action=updatecom&reach_time="+$('#reach_time_'+comid).val()+"&close_time="+$('#close_time_'+comid).val()+"&status="+$('#chkStatus_'+comid).val()+"",              
                "success": function(data) {
                    if(data!='')
                    {hideGridProgress();
                         createDataGrid();
                         displayMessage("success","Update Successfully","The complain is updated successfully");
                    }
                }
            });
    }

</script>
<link href="<?php echo URI::getLiveTemplatePath();?>/plugins/pnotify/jquery.pnotify.default.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo URI::getLiveTemplatePath()."/plugins/pnotify/jquery.pnotify.min.js"?>"></script> 
<script type="text/javascript" src="<?php echo URI::getLiveTemplatePath()."/js/jquery.paging.min.js"?>"></script>
 <script language="javascript">
  
 $(document).ready(function(){
     var displayNotifications = function(data,startIndex){ 
            var list = ""; 
       
            for(i=0;i<data.records.length;i++){	
						list = list + "<tr>";
                                                //list = list + '<td>' + startIndex + '</td><td class="chChildren"><input type="checkbox" id="status' + data.records[i].id + '" name="status[' + data.records[i].id + ']" value="' + data.records[i].status + '" class="styled" /></td><td>' + data.records[i].id + '</td><td style="text-align:left;cursor:pointer" onclick="location.href=\'index.php?m=mod_po&a=po_products_preview&id=' + data.records[i].po_id + '&unread='+data.records[i].id+'\'">' +(data.records[i].status=='0'?'<strong>'+data.records[i].notification+'</strong>':data.records[i].notification)+ '</td>';
                                                list = list + '<td>' + startIndex + '</td><td>' + data.records[i].id + '</td><td style="text-align:left;cursor:pointer" onclick="location.href=\'index.php?m=mod_po&a=po_products_preview&id=' + data.records[i].po_id + '&unread='+data.records[i].id+'\'">' +(data.records[i].status=='0'?'<strong>'+data.records[i].notification+'</strong>':data.records[i].notification)+ '</td>';
                                           
                                                                                        
                                                                  
                                                                           //  list+='<a href="#" title="Change Status<?php //echo " - ".Change_Status;?>" data-title="Change Status" class="" onclick="return changeStatus(\'index.php?m=mod_admin&a=notification_list\',' + data.records[i].id + ',\'\',\'Notification Status - <?php //echo Notification_Status;?>\',\'Notification(s) status have been changed successfully - \');"><span class="icon14 icomoon-icon-tab-2 greenColor"></span></a></div></td>';
                                                                        //list+='<a href="#" title="Delete User<?php echo " - ".Delete_User;?>" data-title="Delete User" class="" onclick="deleteRecord(\'index.php?m=mod_user&a=delete_user\',' + data.records[i].id + ',\'Delete User - <?php echo Delete_User;?>\',\'User(s) have been deleted successfully - <?php echo User_have_been_deleted_successfully;?>\')"><span class="icon14 icomoon-icon-remove-5 redColor"></span></a>';
                                                                       
										list = list + "</tr>";
										startIndex = startIndex + 1;
									}
									$("#notificationData").html(list);
									$("input").uniform();
									applyTooltip();										
				   }
				   
	pageData.url = '<?php echo URI::getURL(APP::$moduleName,APP::$actionName)?>';
	pageData.noOfRecords = totalNotifications;
	pageData.pagingBlock = '#pagingNo';
	pageData.callbackFun = displayNotifications;
	pageData.perPage = <?php echo CFG::$pageSize;?>;
	
       
        
	// do paging	
	createDataGrid();
	
	// initialize sorting
	sortData();
        
         
      
 });

        
   </script>
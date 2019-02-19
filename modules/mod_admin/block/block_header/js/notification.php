
<script language="javascript">
    
  $(document).ready(function(){
      
       $(".notifyIcon").click(function(){
            var nData=$(this).attr("id").split("-");
            changeNotificationStatus(parseInt(nData[0]),parseInt(nData[1]));  
            $(this).removeAttr('style');
       });
       
       //Dynamic height to the notification dropdown
       var ullngth = $(".scrollbar-nav li").length;
       if(ullngth <= 4)
       {
           $(".scrollbar-nav").css("height", 50);
       }
       else
       {
           $(".scrollbar-nav").css("height", 150);
       }
       
  }); 

	
      function changeNotificationStatus(no,po){
         
           $.ajax({
               url:"index.php?m=mod_admin&a=notification_list",
               data:{id:no},
               type:"POST",
               success:function(data){
                   
                    var cntNo=parseInt($(".notification").html()); 
                    if(cntNo==0){
                        $(".notification").hide();
                    } else {
                        $(".notification").html(cntNo);
                    }
                    cntNo--;
                    // $(this).attr("href","index.php?m=mod_po&a=po_products_preview&id="+po);
                    location.href="index.php?m=mod_po&a=po_products_preview&id="+po;
               }
           }); 
         }
    
</script>
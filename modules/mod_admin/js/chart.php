<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="<?php echo URI::getLiveTemplatePath(); ?>/plugins/flot/excanvas.min.js"></script><![endif]-->
<?php /*?><link href="<?php echo URI::getLiveTemplatePath()."/css/datepicker.css"?>" rel="stylesheet" type="text/css" /><?php */?>
<script language="javascript" type="text/javascript" src="<?php echo URI::getLiveTemplatePath(); ?>/plugins/flot/jquery.flot.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo URI::getLiveTemplatePath(); ?>/plugins/flot/jquery.flot.pie.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo URI::getLiveTemplatePath(); ?>/plugins/flot/jquery.flot.tooltip_0.4.4.js"></script>


<script id="source" type="text/javascript">
    $(document).ready(function() {
        //chartFunction();
	$('.titleDiv').click(function() {
            if ($(this).next('.rowBtm').is(":visible")) {
                $(this).next().slideUp('slow');
               $(this).addClass("active");
            } else {
                $(this).next().slideUp('slow');
                $(this).addClass("active");
                $(this).toggleClass("active");
                $(this).siblings('.rowBtm').slideToggle('slow');
            }
            //	$(this).next().slideDown();
            setTimeout(function() {
                    $("html,body").animate({
                            scrollTop: $('.titleDiv').offset().top
                    }, "slow");
            }, 500);
        });
	
        var  d = [];
        
        function displayGraph(graphStatus)
        {
//            alert(graphStatus);
            $("#displayProcess").css("display", "");
            $.ajax({
                "url": "index.php?m=mod_admin&a=dashboard&status=" + graphStatus,
                "success": function(data) {
//                    console.log(data);
                
                    var arrDates = jQuery.parseJSON(data);
                    //alert(arrDates);
                    for (i = 0; i < arrDates.length; i++){
                        var startTime = new Date(arrDates[i].enqDate).getTime();
                         var temp = {day: startTime,value:arrDates[i].cntTicket};
                        d.push(temp);
                   }
                    morris.setData(d);
                    $("#graphTitle").html(graphStatus + " ");
                    $("#displayProcess").css("display", "none");
                }
            });
        }
   


        $("#showGraphdata").change(function() {
            // displayGraph($(this).attr("data-graph"));
            d = [];
            displayGraph($(this).val());
        });

        displayGraph("All Ticket");
        
        var morris =  Morris.Line({
                // ID of the element in which to draw the chart.

                element: 'allTicketchart',
                // Chart data records -- each entry in this array corresponds to a point on
                // the chart.
                data: d,
                // The name of the data record attribute that contains x-values.
                xkey: 'day',
                xLabelFormat: function (x) { 
                    var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun","Jul", "Aug", "Sept", "Octr", "Nov", "Dec"];
                    var date = new Date(x).getDate();
      //              console.log(date);

                    var month = new Date(x).getMonth();
                  return monthNames[month] + " " + date; },
                // A list of names of data record attributes that contain y-values.
                ykeys: ['value'],
                // Labels for the ykeys -- will be displayed when you hover over the
                // chart.

                hoverCallback: function (index, options, content, row) {

                var getdate = new Date(row.day);
                var strdate = getdate.toLocaleDateString("en-US"); 
        return " Date: " + getdate.getDate() + '/' + (getdate.getMonth() + 1) + '/' +  getdate.getFullYear() +  "<br/>No. of Ticket: " + row.value;
      },
                labels: '',

               resize: true
          });
          

        // initialize tooltip	
        applyTooltip();
       
        
       
/////////////////////////////////// unread ticket data ///////////////////////////////////////////////


        <?php echo Stringd::createJsObject("unreadData",$data);?>	     
        
//        console.log("unreadData : "+unreadData.ddData[0]);
    
        var htmlli='';
        
//        console.log(unreadData.ddData[0].type);
        
        //for(j=0;j<unreadData.ddData.length;j++)
//        for(j=0;j<unreadData.ddData[0].type.length;j++)
//        {
//            //alert(unreadData.ddData[j].type);
//           // htmlli+='<li><a href="#"  class="showUnreadData applyTooptip" data-placement="left" data-title="'+unreadData[j].type+' Enquiry" data-graph="'+unreadData[j].type+'" ><span class="icomoon-icon-graph greenColor"></span>'+unreadData[j].type+' Enquiry</a></li>';
//            htmlli += '<option value="'+unreadData.ddData[0].typet[j]+'">'+unreadData.ddData[0].type[j]+'</option>';
//            //htmlli += '<option value="'+unreadData.ddData[j].ypet+'">'+unreadData.ddData[j].type+'</option>';
//            
//        }
        
        $.each(unreadData.ddData[0].type, function(key,value) {
            htmlli += '<option value="'+key+'">'+value+'</option>';
        });
//        console.log(htmlli);
        $('#unreadUlData').append(htmlli);
        //$('#recentUlData').append(htmlli);
    function displayUnreadData(graphStatus)
    { 
        $.ajax({
            "url": "index.php?m=mod_admin&a=dashboard&unreadtype=" + graphStatus,
            "success": function(data) {               ///alert(data);
//                console.log(data);
                var recentDataArr = jQuery.parseJSON(data);
//                console.log(recentDataArr);
                var listrecent = "";
                
                if (recentDataArr.length > 0)
                {
//                    alert("data");
                    var startIndex=1;
                    var linkUnreadType='';
//                         alert("data1");
                    for(i=0;i<recentDataArr.length;i++)
                    {
//                        alert("data--");
                        
                        var odd = (i % 2 == 0) ? "" : " class='odd' ";
                        
                        listrecent = listrecent + '<li ' + odd + '>';
//                        alert(recentDataArr[i].datatype);
                        if( recentDataArr[i].datatype != null ){ linkUnreadType='index.php?m=mod_ticket&a=ticket_view&id=' + recentDataArr[i].id; }
                        else {linkUnreadType='#';}
                        
                        listrecent = listrecent + '<div class="hashBox">' + startIndex + '</div>';
                        
                        listrecent = listrecent + '<div><a href="'+linkUnreadType+'"  title="' + recentDataArr[i].user_name + '">' + recentDataArr[i].user_name + '</a></div>';
                        listrecent = listrecent + '<div><a href="'+linkUnreadType+'"  title="' + recentDataArr[i].subject + '">' + recentDataArr[i].subject + '</a></div>';
                        listrecent = listrecent + '<div><a href="'+linkUnreadType+'"  title="' + recentDataArr[i].engeneer_name + '">' + recentDataArr[i].engeneer_name + '</a></div>';
                        listrecent = listrecent + '<div><a href="'+linkUnreadType+'"  title="' + recentDataArr[i].region_name + '">' + recentDataArr[i].region_name + '</a></div>';
                        listrecent = listrecent + '<div><a href="'+linkUnreadType+'"  title="' + recentDataArr[i].helpdesk_name + '">' + recentDataArr[i].helpdesk_name + '</a></div>';
                        
                        //alert(recentDataArr[i].created_date);
//                        listrecent = listrecent + '<div>' + displayDate(recentDataArr[i].created_date) + '</div>';
                        listrecent = listrecent + '<div>' + recentDataArr[i].created_date + '</div>';
                    
                    
                        listrecent = listrecent + '</li>';
                        startIndex = startIndex + 1;
                    }						
                }
                else
                {
                    listrecent = listrecent + "<li class='odd' align='center'>" + graphStatus + " ticket records not found</li>";
                }
                $(".tableu").find("li:not(.topLi)").remove();
                $(".tableu").append(listrecent);
                bindListingClick();
            }
        });
    }
    displayUnreadData('All');
    

    $("#unreadUlData").change(function() {
        displayUnreadData($(this).val());
    });
    
/////////////////////////////////// unread ticket data ///////////////////////////////////////////////   
        
        
/////////////////////////////////// recent ticket data ///////////////////////////////////////////////
        <?php echo Stringd::createJsObject("recentData",$data);?>	     
        var htmlrecentli='';

    function displayRecentData()
    { 
        $.ajax({
            //"url": "index.php?m=mod_admin&a=dashboard&recentTicket=All",
            "url": "index.php?m=mod_admin&a=dashboard&recentTicket=open",
            "success": function(data) { 
                var recentDataArr = jQuery.parseJSON(data);
//                console.log(recentDataArr);
                var listrecent = "";
                if (recentDataArr.length > 0)
                {
                    var startIndexrecent=1;
                    var linkRecentType='';
                    for(i=0;i<recentDataArr.length;i++)
                    {
                        var odd = (i % 2 == 0) ? "" : " class='odd' ";

                        listrecent = listrecent + '<li ' + odd + '>';
                        if( recentDataArr[i].datatype != null ){ linkRecentType='index.php?m=mod_ticket&a=ticket_view&id=' + recentDataArr[i].id; }
                        else {linkRecentType='#';}

                        listrecent = listrecent + '<div class="hashBox">' + startIndexrecent + '</div>';

//                        listrecent = listrecent + '<div class="hashBox">' + startIndex + '</div>';

                        listrecent = listrecent + '<div><a href="'+linkRecentType+'"  title="' + recentDataArr[i].user_name + '">' + recentDataArr[i].user_name + '</a></div>';
                        listrecent = listrecent + '<div><a href="'+linkRecentType+'"  title="' + recentDataArr[i].subject + '">' + recentDataArr[i].subject + '</a></div>';
                        listrecent = listrecent + '<div><a href="'+linkRecentType+'"  title="' + recentDataArr[i].engeneer_name + '">' + recentDataArr[i].engeneer_name + '</a></div>';
                        listrecent = listrecent + '<div><a href="'+linkRecentType+'"  title="' + recentDataArr[i].region_name + '">' + recentDataArr[i].region_name + '</a></div>';
                        listrecent = listrecent + '<div><a href="'+linkRecentType+'"  title="' + recentDataArr[i].helpdesk_name + '">' + recentDataArr[i].helpdesk_name + '</a></div>';

                        //alert(recentDataArr[i].created_date);
                        //listrecent = listrecent + '<div>' + displayDate(recentDataArr[i].created_date) + '</div>';
//                        listrecent = listrecent + '<div>' + displayDateSlash(recentDataArr[i].created_date) + '</div>';
                        
                        listrecent = listrecent + '<div>' + recentDataArr[i].created_date + '</div>';


                        listrecent = listrecent + '</li>';
                        startIndexrecent = startIndexrecent + 1;
                    }					
                }
                else
                {
                    listrecent = listrecent + "<li class='odd' >Recent ticket records not found</li>";
                }
                $(".tabler").find("li:not(.topLi)").remove();
                $(".tabler").append(listrecent);
                bindListingClick();
            }
        });
    }      
    displayRecentData();
//    $("#recentUlData").change(function() {
//        displayRecentData($(this).val());
//    });

/////////////////////////////////// unread ticket data ///////////////////////////////////////////////                
        
        
    });
</script>
<script type="text/javascript">

function chartFunction(){
	 Morris.Line({
	  // ID of the element in which to draw the chart.
	  element: 'allTicketchart',
	  // Chart data records -- each entry in this array corresponds to a point on
	  // the chart.
	  data: [
		{ year: '2008', value: 20 },
		{ year: '2009', value: 10 },
		{ year: '2010', value: 5 },
		{ year: '2011', value: 5 },
		{ year: '2012', value: 20 }
	  ],
          
          
	  // The name of the data record attribute that contains x-values.
	  xkey: 'year',
	  // A list of names of data record attributes that contain y-values.
	  ykeys: ['value'],
	  // Labels for the ykeys -- will be displayed when you hover over the
	  // chart.
	  labels: ['Value'],
	  resize: true
	});
}
</script>
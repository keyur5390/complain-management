//window resize events
$(window).resize(function() {
    //get the window size
    var wsize = $(window).width();
    if (wsize > 980) {
        $('.shortcuts.hided').removeClass('hided').attr("style", "");
        $('.sidenav.hided').removeClass('hided').attr("style", "");
    }

    var size = "Window size is:" + $(window).width();
    //console.log(size);

});



// document ready function
$(document).ready(function() {
    // for same tab open 	

//    $('a[href|="' + window.location.hash + '"]').tab("show");


    $("#chkStatus").change(function() {

        if ($("#chkStatus").prop("checked") == true)
        {
            $("#checkAct").html("Active");
        } else {
            $("#checkAct").html("Inactive");
        }

    });

    if ($("#chkStatus").prop("checked") == true)
    {
        $("#checkAct").html("Active");
    } else {
        $("#checkAct").html("Inactive");
    }


    $("#btnEdit").click(function() {
        $('form.form-horizontal').attr('action', $('ul.nav-tabs li.active a').attr('href'));
        //document.getElementById('frmCategory').action=$('ul.nav-tabs li.active a').attr('href');
    })
    //for id display last

    $("#btnSave").click(function() {
        $("#hdnEdit").val("0");
    })

    //Disable certain links
    $('a[href^=#]').click(function(e) {
        e.preventDefault()
    })

    $('.search-btn').addClass('nostyle');//tell uniform to not style this element


    //------------- Navigation -------------//

    mainNav = $('.mainnav>ul>li');
    mainNav.find('ul').siblings().addClass('hasUl').append('<span class="hasDrop icon16 icomoon-icon-arrow-down-2"></span>');
    mainNavLink = mainNav.find('a').not('.sub a');
    mainNavLinkAll = mainNav.find('a');
    mainNavSubLink = mainNav.find('.sub a').not('.sub li .sub a');
    mainNavCurrent = mainNav.find('a.current');


    //hover magic add blue color to icons when hover - remove or change the class if not you like.
    mainNavLinkAll.hover(
            function() {
                $(this).find('span.icon16').addClass('blue');
            },
            function() {
                $(this).find('span.icon16').removeClass('blue');
            }
    );

    //click magic
    mainNavLink.click(function(event) {
        $this = $(this);

        if ($this.hasClass('hasUl')) {
            event.preventDefault();
            if ($this.hasClass('drop')) {
                $(this).siblings('ul.sub').slideUp(500, 'jswing').siblings().removeClass('drop');
            } else {
                $(this).siblings('ul.sub').slideDown(500, 'jswing').siblings().addClass('drop');
            }
        } else {
            //has no ul so store a cookie for change class.
            $.cookie("newCurrentMenu", $this.attr('href'), {expires: 1});
        }
    });
    mainNavSubLink.click(function(event) {
        $this = $(this);

        if ($this.hasClass('hasUl')) {
            event.preventDefault();
            if ($this.hasClass('drop')) {
                $(this).siblings('ul.sub').slideUp(500).siblings().removeClass('drop');
            } else {
                $(this).siblings('ul.sub').slideDown(250).siblings().addClass('drop');
            }
        } else {
            //has no ul so store a cookie for change class.
            $.cookie("newCurrentMenu", $this.attr('href'), {expires: 1});
        }
    });

    //responsive buttons
    $('.resBtn>a').click(function(event) {
        $this = $(this);
        if ($this.hasClass('drop')) {
            $('#sidebar>.shortcuts').slideUp(500).addClass('hided');
            $('#sidebar>.sidenav').slideUp(500).addClass('hided');
            $('#sidebar-right>.shortcuts').slideUp(500).addClass('hided');
            $('#sidebar-right>.sidenav').slideUp(500).addClass('hided');
            $this.removeClass('drop');
        } else {
            if ($('#sidebar').length) {
                $('#sidebar').css('display', 'block');
                if ($('#sidebar-right').length) {
                    $('#sidebar-right').css({'display': 'block', 'margin-top': '0'});
                }
            }
            if ($('#sidebar-right').length) {
                $('#sidebar-right').css('display', 'block');
            }
            $('#sidebar>.shortcuts').slideDown(250);
            $('#sidebar>.sidenav').slideDown(250);
            $('#sidebar-right>.shortcuts').slideDown(250);
            $('#sidebar-right>.sidenav').slideDown(250);
            $this.addClass('drop');
        }
    });
    $('.resBtnSearch>a').click(function(event) {
        $this = $(this);
        if ($this.hasClass('drop')) {
            $('.search').slideUp(500);
            $this.removeClass('drop');
        } else {
            $('.search').slideDown(250);
            $this.addClass('drop');
        }
    });

    $('.enqDroplink').click(function() {
        $(this).toggleClass('drpActive').next('ul').toggleClass('drpShow');
    });

    $('.enqdropUl li a').click(function() {
        $(this).parents().removeClass('drpShow');
        $(this).parents().siblings('a').removeClass('drpActive');
    });



    //------------- widget box magic -------------//

    var widget = $('div.box');
    var widgetOpen = $('div.box').not('div.box.closed');
    var widgetClose = $('div.box.closed');
    //close all widgets with class "closed"
    widgetClose.find('div.content').hide();
    widgetClose.find('.title>.minimize').removeClass('minimize').addClass('maximize');

    widget.find('.title>a').click(function(event) {
        event.preventDefault();
        var $this = $(this);
        if ($this.hasClass('minimize')) {
            //minimize content
            $this.removeClass('minimize').addClass('maximize');
            $this.parent('div').addClass('min');
            cont = $this.parent('div').next('div.content')
            cont.slideUp(500, 'easeOutExpo'); //change effect if you want :)

        } else
        if ($this.hasClass('maximize')) {
            //minimize content
            $this.removeClass('maximize').addClass('minimize');
            $this.parent('div').removeClass('min');
            cont = $this.parent('div').next('div.content');
            cont.slideDown(500, 'easeInExpo'); //change effect if you want :)
        }


    })

    //show minimize and maximize icons
    widget.hover(function() {
        $(this).find('.title>a').show(50);
    }
    , function() {
        $(this).find('.title>a').hide();
    });

    //add shadow if hover box
    widget.hover(function() {
        $(this).addClass('hover');
    }
    , function() {
        $(this).removeClass('hover');
    });

    //------------- Check all checkboxes  -------------//

//    $("#masterCh").change(function() {
////		var checkedStatus = $(this).find('span').hasClass('checked');
//        var checkedStatus = $(this).prop("checked");
//        $("#checkAll tr .chChildren input:checkbox").each(function() {
//            this.checked = checkedStatus;
//            if (checkedStatus == true) {
//                this.checked = true;
//            }
//            else if (checkedStatus == false) {
//                this.checked = false;
//            }
//        });
//    });


    $("#masterCh").change(function() {
        //alert('hello');
//		var checkedStatus = $(this).find('span').hasClass('checked');
        var checkedStatus = $(this).prop("checked");
        $(".chekMain .chkInn input:checkbox").each(function() {
            this.checked = checkedStatus;
            if (checkedStatus == true) {
                this.checked = true;
            }
            else if (checkedStatus == false) {
                this.checked = false;
            }
        });
    });


    if ($(window).width() > 767) {
        var navigation = $('#nav-main').okayNav();
    }

    // Function for scrollto top
    $('.scrollTop').click(function() {
        $('html, body').animate({scrollTop: 0}, 800);
        return false;
    });

    // Function to fade in scroll arrow
    $(window).scroll(function() {
        if ($(this).scrollTop() > 100) {
            $('.scrollTop').fadeIn();
        } else {
            $('.scrollTop').fadeOut();
        }
    });

    $('.tabUl li').click(function() {
        var tab_id = $(this).attr('data-tab');
        $(this).parent('.tabUl').children('li').removeClass("current");
        //$(this).parent().next().children('.tabDiv').removeClass("current");
        $(this).parent().next().children().children('.tabDiv').removeClass("current");
        $(this).parent().next().children('.tabDiv').removeClass("current");
        $(this).addClass("current");
        $('#' + tab_id).addClass("current");
    })


    // Function for mobile menu toggle
    $('.menu-icon').click(function() {
        $(this).toggleClass('activeMenu');
        $('.menuPart nav').toggleClass('slideLeft');
        $('.wrapper').toggleClass('wrapperRight');
        $('body').toggleClass('fixedBody');
        $('#nav-main').toggleClass('menuVisible');
    });


    if ($(window).width() > 767) {
        $('.navUl li.hiddenLi').remove();
    }


    // Function for toggle search box 
    $('.searchBtn').click(function() {
        $('.searchBox').slideToggle('slow');
        $(this).toggleClass('closeLink');
        if ($(this).hasClass('closeLink')) {
            $(this).html('Close')
        }
        else {
            $(this).html('Search')
        }
    });

    if ($(window).width() > 767 && $(window).width() < 1200) {
        $(".topRight .resetBtn").after($(".searchBox"));
    }


    if ($(window).width() < 768) {
        // To change position of search box in mobile view	
        $(".wrapper").before($("#nav-main"));

        $('.descBtns #html-editor').click(function() {
            $('div.mce-container *,div.mce-container').removeAttr('style');
        });

        // To hide show search box in mobile
        $('.searchBtn').click(function() {
            $(this).toggleClass('searchClose');
            $('.searchBox').slideToggle('slow');
        });




        // To toggle action bor in mobile		  
        $('.table .checkbox').change(function() {
            if ($('.mobiAction').is(':hidden')) {
                $(".mobiAction").slideDown().addClass('actionShow');
            }
            $('.counterDiv').html($('.table .checkbox:not(#masterCh)').filter(':checked').length);
        });

        $('.closeAction').click(function() {
            $(".mobiAction").slideUp().removeClass('actionShow');
        });

        $('.accMain').click(function() {
            if ($(this).hasClass('arrowDown')) {
                $(this).next().slideUp();
                $(this).removeClass('arrowDown');
                //$("html, body").animate({scrollTop: $(".dearrowDown").offset().top});
            }
            else {
                $('.accMain').removeClass('arrowDown');
                $(this).addClass('arrowDown');
                $('.accDiv').slideUp();
                //$("html, body").animate({scrollTop: $(".dearrowDown").offset().top});
                $(this).next().slideDown();
                setTimeout(function() {
                    $("html,body").animate({
                        scrollTop: $('.arrowDown').offset().top
                    }, "slow");
                }, 500);

            }
        });
        // Function for remove and add class in tab
//        $('.tabMain .tabDiv').removeClass('current')
//        $('.tabMain > .accMain:first-child').addClass('arrowDown');
//        //$('#tab-1').show();
//        $('.tabMain > div:nth-child(2)').show();




    }

    $('.numOfRecord').change(function() {

        $("#numOfRecordForm").submit();
    });


    if ($('.accMain').hasClass('current')) {
        $(this).addClass('arrowDown')
    }
    // To hide show search box in ipad & mobile
    $('.cust_searchBtn').click(function() {
        $(this).toggleClass('searchClose');
        $('.cust_searchBox').slideToggle('slow');
    });

    //patch for the listing drop down
    //dt 10-8-2016
    $(".dropbox.bulkDrop select").each(function() {
        $(this).find("option").each(function() {
            var onclick = $(this).attr("onclick");
            $(this).removeAttr("onclick");
            $(this).attr("data-onclick", onclick)
        })
    })
    $(".dropbox.bulkDrop select").change(function(e) {
        var $this = $(this);
        e.preventDefault();
        var func = $($this).find("option:selected").attr("data-onclick");
        eval(func);
        return false;
    })
});


// globale pagging variable
var pageData = {
    url: "", // url to send recquest
    noOfRecords: "", // total no of records
    perPage: 1, // records to display per page
    start: 1, // paging start page
    pagingBlock: "", // paging no display blog id
    callbackFun: "", // callback function for displaying records
    searchField: "", // search field query string
    sortType: "", // sort type query string
    validateSearch: "", // search form validation function
    gridBlockId: "gridBlock", // whole grid block id. (combines both grid and paging block)
    noGridId: "noGrid", // no grid block id. (for displaying no record found message)
    startRecord: 0, // current page record start index (use in delete operation)
    endRecord: 0, // current page record end index (use in delete operation)
    totalPages: 0				// total no of pages (use in delete operation)
};

/**
 * Create ajax paging
 * 
 * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
 */
function doPaging(objData)
{

    $(pageData.pagingBlock).paging(pageData.noOfRecords, {
        format: "- < (q -) ncnnn (- p) >",
        perpage: pageData.perPage,
        lapping: 0,
        page: pageData.start,
        onSelect: function(page) {

            // reset master checkbox
            resetMasterCh();

            // store total no of pages. used in delete operation
            pageData.totalPages = this.pages;

            // get current start indesx for displaying no index in grid
            var startIndex = this.slice[0];

            // check objData has been set from search form function
            if (objData && objData != "")
            {
                loadGrid(objData, startIndex);
                objData = "";

            }
            else // execute paging ajax
            {
                // display proccess div over grid
                showGridProgress();

                // store current record to and from and current page. used in delete operation
                pageData.startRecord = this.slice[0];
                pageData.endRecord = this.slice[1];

                $.ajax({
                    "url": pageData.url + '&start=' + this.slice[0] + '&end=' + this.slice[1] + '&page=' + page + pageData.sortType + pageData.searchField + "&searchForm%5BnumOfRecord%5D=" + pageData.perPage,
                    "success": function(data) {
				
                        // store current page
                        pageData.start = page;

                        loadGrid(jQuery.parseJSON(data), startIndex);

                        // hide proccess div over grid
                        hideGridProgress();


                    }
                });
            }

        },
        onFormat: function(type) {

            switch (type) {

                case 'block':
                    var lable = this.value
                    if (this.value < 10)
                        lable = '0' + lable;
                    if (!this.active)
                        return '<a class="disabled">' + lable + '</a>';
                    else if (this.value != this.page)
                        return '<a href="#' + this.value + '" class="paginate_button">' + lable + '</a>';
                    return '<a class="paginate_active active">' + lable + '</a>';

                case 'next':
                    if (this.active)
                        return '<a href="#' + this.value + '" class="next paginate_button" style="margin-right:-11px;"> </a></div>';
                    return '<a class="disabled next" style="margin-right:-11px;" ></a></div>';

                case 'prev':
                    if (this.active)
                        return '<div class="paging-section pageBox"><a href="#' + this.value + '" class="previous paginate_button"></a>';
                    return '<div class="paging-section pageBox"><a class="disabled previous"></a>';

                case 'first':
                    if (this.active)
                        return '<a href="#' + this.value + '" class="first">|<</a>';
                    return '<span class="disabled">|<</span>';

                case 'last':
                    if (this.active)
                        return '<a href="#' + this.value + '" class="last">>|</a>';
                    return '<span class="disabled">>|</span>';

                case "leap":
                    if (this.active)
                        return "<em>...</em>";
                    return "";

                case 'fill':
                    if (this.active)
                    {
                        if (this.pos > 1)
                            return "<em>...</em>";



                        return "<span class='paging-detail'>Showing " + (this.slice[0] + 1) + " to " + this.slice[1] + " out of " + this.number + " records " + " </span>";
                    }
                    return "&nbsp;";
                case 'left':
                    if (this.page > 2 && this.pages > 5)
                        return '<a href="#1" class="paginate_button">1</a>';
                    return '&nbsp;';

                case 'right':
                    if (this.page < (this.pages - 3) && this.pages > 5)
                        return '<a href="#' + this.pages + '" class="paginate_button">' + this.pages + '</a>';
                    return '&nbsp;';

            }
        }
    });
}

/**
 * create data grid for records, display record not found block if records not found
 *
 * @param boject data record data object
 * @param int rowIndex start row index
 *
 * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
 */
function loadGrid(data, rowIndex)
{
    if (data.records.length != 0)
    {
        swapClass($("#" + pageData.gridBlockId), "hideBlock", "displayBlock");
        swapClass($("#" + pageData.noGridId), "displayBlock", "hideBlock");
        pageData.callbackFun(data, rowIndex + 1);
    }
    else
    {
        swapClass($("#" + pageData.gridBlockId), "displayBlock", "hideBlock");
        swapClass($("#" + pageData.noGridId), "hideBlock", "displayBlock");
    }
}

/**
 * Data sort function
 *
 * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
 */
function sortData()
{
    // add sort_both class in all columns have "sort" class. Skip column which have either sort_desc or sort_asc class
    $(".sort").each(function(index) {
        if ($(this).attr("class").indexOf("sort_asc") == -1 && $(this).attr("class").indexOf("sort_desc") == -1)
            $(this).addClass("sort_both");
    });

    // hangle sort column click event
    $(".sort").click(function() {

        var curClass = $(this).attr("class").split(" ");


        if ($(this).hasClass('sort_both'))	// do ascending sorting when click on first time
        {
            swapClass($(this), "sort_both", "sort_asc"); // swap sorting class
            setSorting("asc", $(this).attr("id"));		// set sorting criteria
        }
        else if ($(this).hasClass('sort_asc')) // do reverse descending sorting
        {
            swapClass($(this), "sort_asc", "sort_desc");	// swap sorting class
            setSorting("desc", $(this).attr("id"));		// set sorting criteria
        }
        else if ($(this).hasClass('sort_desc'))	// do reverse ascending sorting
        {
            swapClass($(this), "sort_desc", "sort_asc");	// swap sorting class
            setSorting("asc", $(this).attr("id"));		// set sorting criteria
        }
        resetColumns($(this));	// reset all other column to with "sort_both" class
        doPaging();	// call paging function
    });
}

/**
 * Rest all sorting column except current column by applying "sort_both" function
 *
 * @param object obj  current column object
 *
 * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
 */
function resetColumns(obj)
{
    $(".sort").each(function(index) {
        if ($(this).attr("id") != obj.attr("id"))
        {
            swapClass($(this), "sort_desc", "sort_both");
            swapClass($(this), "sort_asc", "sort_both");
        }
    });
}

/**
 * set sorting type for columns
 *
 * @param string oType
 * @param string oField
 *
 * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
 */
function setSorting(oType, oField)
{
    pageData.sortType = "&o_type=" + oType + "&o_field=" + oField;
}

/**
 * element css class swap function
 *
 * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
 */
function swapClass(obj, oldC, newC)
{
    obj.removeClass(oldC);
    obj.addClass(newC);
}

/**
 * Do ajex searching for form and reset paging
 *
 * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
 */
$("#searchForm,#numOfRecordForm").submit(function(event) {

    // check validate function is created or not
    if ($(this).attr('id') == "numOfRecordForm") {
        if ($(this).find('.numOfRecord').val() > 0) {
            pageData.perPage = $(this).find('.numOfRecord').val();



        } else {
            return false;
            event.preventDefault(); // do not submit form is validate function returns false;
        }
    } else {
        if (pageData.validateSearch != "")
        {
            // console.log(pageData.validateSearch);
            // validate search form
            if (pageData.validateSearch() == false)
            {
                return false;
                event.preventDefault(); // do not submit form is validate function returns false;
            }


        }
    }

    // display proccess div over grid
    showGridProgress();

    // create search query string
    pageData.searchField = "&" + $(this).serialize();
    if ($(this).attr('id') == "numOfRecordForm")
    {
        pageData.searchField += "&" + $('#searchForm').serialize();
    }



    $.ajax({
        "url": pageData.url + '&start=0&end=' + pageData.perPage + '&page=1' + pageData.sortType + pageData.searchField + "&getCount=1&searchForm%5BnumOfRecord%5D=" + pageData.perPage,
        "success": function(data) {

            var objData = jQuery.parseJSON(data);
            // set total no of records for paging
            pageData.noOfRecords = objData.totalRecords;
            // reset start page
            pageData.start = 1;
            // do paging
            doPaging(objData);

            // hide proccess div over grid
            hideGridProgress();
        }
    });

    event.preventDefault();
});
/*
*Search by role
*@author Bhavin Lunagariya<bhavin.datatech@gmail.com>
*/


/* Following Commented by Mayur Patel Bcz Of Role Selected Value And Search Textbox Value Combination Serach Issue And Also Filed Sorting Not Working */
/*
$('#searchByRole').change(
    function(){
		
		$("#user_name").val("");
		pageData.searchField = "";
		
           
        $.ajax({
        "url": pageData.url +'&role_id='+this.value+ '&start=0&end=' + pageData.perPage + '&page=1' + pageData.sortType + pageData.searchField + "&getCount=1&searchForm%5BnumOfRecord%5D=" + pageData.perPage,
        "success": function(data) {
			
            var objData = jQuery.parseJSON(data);
            // set total no of records for paging
            pageData.noOfRecords = objData.totalRecords;
            // reset start page
            pageData.start = 1;
            // do paging
            doPaging(objData);

            // hide proccess div over grid
            hideGridProgress();
        }
    });

    event.preventDefault();
    });
*/    
    
/*$('#searchByRegion').change(
    function(){
		
		$("#customer_name").val("");
		$("#searchByHelpDesk").val("");
		$("#searchByStatus").val("");
		pageData.searchField = "";
		pageData.noOfRecords = totalPages;
          
        $.ajax({
        "url": pageData.url +'&region='+this.value+ '&start=0&end=' + pageData.perPage + '&page=1' + pageData.sortType + pageData.searchField + "&getCount=1&searchForm%5BnumOfRecord%5D=" + pageData.perPage,
        "success": function(data) {
			
            var objData = jQuery.parseJSON(data);
            // set total no of records for paging
            pageData.noOfRecords = objData.totalRecords;
            // reset start page
            pageData.start = 1;
            // do paging
            doPaging(objData);

            // hide proccess div over grid
            hideGridProgress();
        }
    });

    event.preventDefault();
    });*/
/*$('#searchByStatus').change(
    function(){
		
		$("#customer_name").val("");
		$("#searchByHelpDesk").val("");
		$("#searchByRegion").val("");
		pageData.searchField = "";
		pageData.noOfRecords = totalPages;
          
        $.ajax({
        "url": pageData.url +'&status='+this.value+ '&start=0&end=' + pageData.perPage + '&page=1' + pageData.sortType + pageData.searchField + "&getCount=1&searchForm%5BnumOfRecord%5D=" + pageData.perPage,
        "success": function(data) {
			
            var objData = jQuery.parseJSON(data);
            // set total no of records for paging
            pageData.noOfRecords = objData.totalRecords;
            // reset start page
            pageData.start = 1;
            // do paging
            doPaging(objData);

            // hide proccess div over grid
            hideGridProgress();
        }
    });

    event.preventDefault();
    });*/
/*$('#searchByEngineer,#searchByHelpDesk,#searchByRegion,#searchByStatusReport,#customer').change(
    function(){
		
		//$("#ticket_subject").val("");
                
		//$("#customer").val('').trigger('change');
               // $("#searchByStatusReport").val('');
		//pageData.searchField = "";
		pageData.noOfRecords = totalPages;
                pageData.searchField = "&" + $('#searchForm').serialize();
//                if ($(this).attr('id') == "numOfRecordForm")
//                {
//                    pageData.searchField += "&" + $('#searchForm').serialize();
//                }
//alert(pageData.searchField);
        $.ajax({
        "url": pageData.url +'&start=0&end=' + pageData.perPage + '&page=1' + pageData.sortType + pageData.searchField + "&getCount=1&searchForm%5BnumOfRecord%5D=" + pageData.perPage,
        "success": function(data) {
			
            var objData = jQuery.parseJSON(data);
            // set total no of records for paging
            pageData.noOfRecords = objData.totalRecords;
            // reset start page
            pageData.start = 1;
            // do paging
            doPaging(objData);

            // hide proccess div over grid
            hideGridProgress();
        }
    });

    //event.preventDefault();
    });*/

  /*$('#searchByHelpDesk').change(
    function(){
		
		$("#customer_name").val("");
		$("#searchByRegion").val("");
		$("#searchByStatus").val("");
		pageData.searchField = "";
		pageData.noOfRecords = totalPages;
          
        $.ajax({
        "url": pageData.url +'&helpdesk='+this.value+ '&start=0&end=' + pageData.perPage + '&page=1' + pageData.sortType + pageData.searchField + "&getCount=1&searchForm%5BnumOfRecord%5D=" + pageData.perPage,
        "success": function(data) {
			
            var objData = jQuery.parseJSON(data);
            // set total no of records for paging
            pageData.noOfRecords = objData.totalRecords;
            // reset start page
            pageData.start = 1;
            // do paging
            doPaging(objData);

            // hide proccess div over grid
            hideGridProgress();
        }
    });

    event.preventDefault();
    });
*/
/**
 * Display date in dd-mm-yyyy format
 *
 * @author Kushan Antani<kushan.datatechmedia@gmail.com>
 */
function displayDate(val)
{
    dateString = val.toString();
    reggie = /(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/g;
    dateArray = reggie.exec(dateString);
    return dateArray[3] + "-" + dateArray[2] + "-" + dateArray[1];
}

/**
 * Display date in dd/mm/yyyy format
 *
 * @author parth parikh<parth.datatechmedia@gmail.com>
 */
function displayDateSlash(val)
{

    dateString = val.toString();

    reggie = /(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/g;
    dateArray = reggie.exec(dateString);

    return dateArray[3] + "/" + dateArray[2] + "/" + dateArray[1];
}
    
    
    
/**
 * get data for data grid. Also maintain old state of gris
 *
 * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
 */
function createDataGrid()
{
    if (oldPageState != "")
    {
        // display proccess div over grid
        showGridProgress();

        pageData.start = oldPageState.curPage;

        if (oldPageState.o_type)
        {
            setSorting(oldPageState.o_type, oldPageState.o_field);
            $("#" + oldPageState.o_field).addClass("sort_" + oldPageState.o_type);
        }

        if (oldPageState.searchData)
            pageData.searchField = "&" + $.param(oldPageState.searchData);



        // store current record to and from. used in delete operation
        pageData.startRecord = oldPageState.start;
        pageData.endRecord = oldPageState.end;
        var endRec = parseFloat(oldPageState.start) + parseFloat(pageData.perPage);
        $.ajax({
            "url": pageData.url + '&start=' + oldPageState.start + '&end=' + endRec + '&page=' + oldPageState.curPage + pageData.sortType + pageData.searchField + "&getCount=1",
            "success": function(data) {
				
                var objData = jQuery.parseJSON(data);
                // set total no of records for paging
                pageData.noOfRecords = objData.totalRecords;
                // do paging
                doPaging(objData);

                // hide proccess div over grid
                hideGridProgress();
            }
        });
    }
    else
        doPaging();
}

/**
 * Apply tooltip on all objects which have ".applyTooptip" class
 *
 * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
 */
function applyTooltip()
{
//    $('.applyTooptip').tooltip();
}

/**
 * Apply popover on all objects which have ".applyPopover" class
 *
 * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
 */
function applyPopover()
{
//    $('.applyPopover').popover({"html": true});
}


/**
 * Display date in dd-mm-yyyy format
 *
 * @author Kushan Antani<kushan.datatechmedia@gmail.com>
 */
function displayDate(val)
{
    dateString = val.toString();
    reggie = /(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/g;
    dateArray = reggie.exec(dateString);
    return dateArray[3] + "-" + dateArray[2] + "-" + dateArray[1];
}


/**
 * Display date in dd/mm/yyyy format
 *
 * @author parth parikh<parth.datatechmedia@gmail.com>
 */
function displayDateSlash(val)
{

    dateString = val.toString();

    reggie = /(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/g;
    dateArray = reggie.exec(dateString);

    return dateArray[3] + "/" + dateArray[2] + "/" + dateArray[1];
}

/**
 * Display progress div during fetching data for grid
 *
 * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
 */
function showGridProgress()
{
    $(".qLoverlay-new").addClass("showProcess");
    $(".qLbar-new").addClass("showProcess");
}

/**
 * Hide progress div of grid
 *
 * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
 */
function hideGridProgress()
{
    $(".qLoverlay-new").removeClass("showProcess");
    $(".qLbar-new").removeClass("showProcess");
}

/**
 * Validate tabullar form and enable tab of error element
 *
 * @param string frmName id of form
 *
 * @atuthor Rutwik Avasthi <php.datatechmedia@gmail.com>
 */
function validaeForm(frmName, rulesObj, messageObj, groupObj)
{
    // validate form

    $('#' + frmName).validate({
        ignore: '',
        onkeyup: false,
        errorClass: "error",
        validClass: "text-success",
        rules: rulesObj,
        messages: messageObj,
        groups: groupObj,
        invalidHandler: function(form, validator) {
        },
        showErrors: function(errorMap, errorList) {

            // create array of error list string

            var strElement = $.param(errorMap).split("&");



            // check error string is blank or not
            if ($.trim(strElement) != "")
            {
                // get id of first element
                ///following one line is added by keyur
                strElement[0] = unescape(strElement[0]);

                var arrName = strElement[0].split("=");

                // get element id

                var eleId = $('[name="' + arrName[0] + '"]').attr("id");

                // find tab div id of form element
                if (eleId == undefined)
                {///this condition is added by keyur
                    var parentId = $('[name="' + arrName[0] + '"]').parents('div[id]').parents('div[id]').attr("id");
                }
                else
                    var parentId = $("#" + eleId).parents('div[id]').attr("id");


                // active tab 
//                $('a[href|="#' + parentId + '"]').tab("show");

            }

            // show default error message
            this.defaultShowErrors();
        }
    });
}


/**
 * Display autohide message
 *
 * @param string type type of message(success, info, warning, error)
 * @param string title title of message
 * @param string msg description of message
 *
 * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
 */
function displayMessage(type, title, msg)
{
    if (type == "error")
        type = "errorMsg";
    else
        type = "successMsg";
    // display alert message
    var alert = '<div class="alert ' + type + '"><strong> ' + title + ': </strong>' + msg + '<a href="javascript:;" class="msgClose" onclick="" title="Close"></a></div>';
//    var alert = '<div role="alert" class="alert fade in alert-' + type + '"> \
//                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>\
//                                <strong> ' + title + ': </strong> ' + msg + '\
//                             </div>';
    $('#alertMessage').html(alert);
    $(".msgClose").bind("click", function() {
        $('.alert').remove();
    });
    // hide alert message after 5 second
    setTimeout(function() {
        $('.alert').remove();
    }, 5000);
}

/* Display active/inactive icon as per status
 *
 * @param int status status of record
 *
 * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
 */
function displayStatus(status)
{
    if (status == 1)
        return '<span class="statusSpan" title="Active"></span>';
    else
        return '<span class="statusSpan inactive" title="Inactive"></span>';
}


/**
 * Change status of single and multiple records
 *
 * @param string url
 * @param int id pass id for changing status of single record
 * @param int status pass new status for multiple records	
 *
 * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
 */
function changeStatus(url, id, status)
{
    var newStatus = 0;
    if (id && id != "")
    {
        // for single record make its checkbox checked
        checkSingle(id)

        // toggle to new status
        if ($("#status" + id).val() == 0)
            newStatus = 1;
    }
    else
    {
        // if record is not selected then give error message
        if (checkSelectedCheckbox() == 0)
        {
            resetAction();
            alert("Please select at least one record");



            return false;
        }
        // set new status if record is selected
        newStatus = status;
    }

    // take user confirmation before deleteing an iteam
//    console.log(url);
    if (url == "index.php?m=mod_admin&a=change_status") {
        if (confirm("Do you really want to make " + ((newStatus == 0) ? "unpaid" : "paid") + " this record(s) ?") == false)
        {
            uncheckSingle(id);
            return false;
        }
    } else {
        if (confirm("Do you really want to " + ((newStatus == 0) ? "Inactive" : "active") + " this record(s) ?") == false)
        {
            uncheckSingle(id);
            return false;
        }
    }

    // display proccess div over grid
    showGridProgress();

    $.ajax({
        "type": "post",
        "url": url + "&newstatus=" + newStatus,
        "data": (id && id != "" ? "status[" + id + "]=" + newStatus : $("#frmGrid").serialize()),
        "success": function(data) {
            var objData = jQuery.parseJSON(data);

            // reset master checkbox
            resetMasterCh()

            // reset action
            resetAction();

            // do paging
            doPaging();

            // display message
            //displayMessage("success",strTitle,strMessage);
            displayMessage(objData.result, objData.title, objData.message);
        }
    });

    return false;
}

/*
 * 
 * Reset Action Dropdown
 * @author Vishal Vasani <vishal.datatech@gmail.com>
 */
function resetAction()
{

    $(".bulkDrop select").attr("id", "Saction");
    $(".bulkDrop select#Saction").val("");
    // $("#S_action").val("");
}

/**
 * Reset master checkbox of grid
 *
 * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
 */
function resetMasterCh()
{
    if ($("#masterCh"))
    {
        $("#masterCh").prop("checked", false);
//			$(":checkbox").uniform();						
    }
}

/** check single uniform checkbox checked
 *
 * @param int id checkbox id
 *
 * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
 */
function checkSingle(id)
{
    // for single record make its checkbox checked
    $("#status" + id).prop("checked", true);
//		$("#status"+id).uniform({checkedClass: 'checked'});	
}

function uncheckSingle(id)
{
    $("#status" + id).prop("checked", false);
}

/** check single uniform checkbox checked
 *
 * @param int id checkbox id
 *
 * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
 */
function checkSelectedCheckbox()
{
    // for multiple record, check if any record is selected or not
    var flag = 0;
    $('[name*="status"]').each(function(index) {		//alert("hell");										
        if ($(this).prop("checked") == true)
        {
            flag = flag + 1;
        }
    });
    return flag;
}

/**
 * Delete record
 *
 * @param string url
 * @param int id	
 *
 * @author Rutwik Avathi <php.datatechmedia@gmail.com>
 */
function deleteRecord(url, id)
{
    var noOfCheckbox = 1;

    if (id && id != "")
    {
        // for single record make its checkbox checked
        checkSingle(id);
    }
    else
    {
        // find total no of checkbox checked
        var noOfCheckbox = checkSelectedCheckbox();

        // if record is not selected then give error message
        if (noOfCheckbox == 0)
        {
            resetAction();
            alert("Please select at least one record");
            return false;
        }
    }

    //console.log(url);
    // take user confirmation before deleteing an iteam               
    if (url == "index.php?m=mod_admin&a=delete_booking") {
        if (confirm("Do you really want to archive this record(s) ?") == false)
        {
            uncheckSingle(id);
            return false;
        }
    } else {
        if (confirm("Do you really want to delete this record(s) ?") == false)
        {
            uncheckSingle(id);
            return false;
        }
    }

    // if no of deleted record is more than perpage record than restore current page to previouse page
    if (noOfCheckbox >= ($('[type*="checkbox"]').length - 1))
    {
        // check current page is last page or not
        if (pageData.start == pageData.totalPages)
        {
            // check cur page is first page or not
            if (pageData.start > 1)
            {
                // restore to previous page
                pageData.startRecord = pageData.startRecord - pageData.perPage;
                pageData.endRecord = pageData.endRecord - pageData.perPage;
                pageData.start = pageData.start - 1;
            }
            else
            {
                pageData.startRecord = 0;
                pageData.endRecord = pageData.perPage;
                pageData.start = 1;
            }
        }
    }

    // display proccess div over grid
    showGridProgress();

    $.ajax({
        "type": "post",
        "url": url,
        //"data": $("#frmGrid").serialize(),
        "data": (id && id != "" ? "status[" + id + "]=" : $("#frmGrid").serialize()),
        "success": function(data) {

            var objDataDelete = jQuery.parseJSON(data);

            // reset master checkbox
            resetMasterCh()

            // reset action
            resetAction();

            // get page data
            $.ajax({
                "url": pageData.url + '&start=' + pageData.startRecord + '&end=' + pageData.endRecord + '&page=' + pageData.start + pageData.sortType + pageData.searchField + "&getCount=1",
                "success": function(data) {
                    var objData = jQuery.parseJSON(data);

                    // set total no of records for paging
                    pageData.noOfRecords = objData.totalRecords;

                    // do paging
                    doPaging(objData);

                    // hide proccess div over grid
                    hideGridProgress();

                    // display message
                    //if(objDataDelete.result && objDataDelete.result == "error")
                    displayMessage(objDataDelete.result, objDataDelete.title, objDataDelete.message);
                    //else
                    //displayMessage("success",strTitle,strMessage);
                }
            });
        }
    });
}




/**
 * Change status of single and multiple records
 *
 * @param string url
 * @param string value new value of sort order
 * @param string id testimonial id	 
 *
 * @author Kushan Antani <kushan.datatechmedia@gmail.com>
 */
function changeSortOrder(url, value, id)
{
    // display proccess div over grid
    showGridProgress();

    $.ajax({
        "type": "post",
        "url": url + "&val=" + value + "&id=" + id,
        "data": $("#frmGrid").serialize(),
        "success": function(data) {
			
            var objData = jQuery.parseJSON($.trim(data));

            // do paging
            doPaging();

            // display message
            displayMessage(objData.result, objData.title, objData.message);
        }
    });

    return false;
}


/* get proportiona height or width of an image
 *
 * @param int width image width
 * @param int height image height
 * @param int actualSize required proportional size
 *
 * @return array contact size lable (width or height) and its size
 * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
 */
function getProporstionalSize(width, height, actualSize)
{
    var newSize = "";
    var newLable = "";

    if (width > height)
    {
        newSize = width;
        newLable = "width";
    }
    else
    {
        newSize = height;
        newLable = "height";
    }
    if (newSize > actualSize)
        newSize = actualSize

    return new Array(newLable, newSize);
}


/**
 * Show page preview
 *
 * @param string frmId form id
 * @param string url	 
 *
 * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
 */
function setPreivew(frmId, url)
{
    var frmObj = $("#" + frmId);
    frmObj.attr("action", url);
    frmObj.attr("target", "_blank");
    frmObj.submit();
    frmObj.attr("target", "_self");
    frmObj.attr("action", "");
}

var fileUploadQueue = new Array();
var totalFiles = 1;
/**
 * Create file uploader. It will work for single and multiple file. It will work for any type of file
 * 
 * @param String uploaderId Id of file uploader. Same name will use to create hidden variable of uploaded file
 * @param String progressBarClass class of progress div
 * @param String fileGridId Id of grid which will display uploaded files
 * @param String fileGridFunction call back function to display file grid
 * @param String uploadURL Servar URL to save file
 * @param Array fileTypes array of required file types
 * @param String uploadDir file upload directory name
 * @param String deleteURL File delete URL
 * @param Object fileData existing file data
 * @param Integer recordId Current record id
 * @param Integer maxFiles maximum no of files allow to upload. Only for multiple         
 * @author Rutwik Avasthi <php.datatechmedia@gmail.com>        
 */
function createUploader(uploaderId, progressBarClass, fileGridId, fileGridFunction, uploadURL, fileTypes, uploadDir, deleteURL, fileData, recordId, maxFiles)
{

    var oldImage = "";

    // Display existing file list if passed

    // empty file grid
    $('#' + fileGridId).html("");

    if (recordId != "")
    {

        $.each(fileData, function(fileKey, curFile) {

            if (curFile.name != "")
            {

                curFile.url = "../image.php?image=" + getImageNameWithSize(curFile.name, "thumbAdmin") + "&dir=" + uploadDir;
                ;
                // display files
                var str = fileGridFunction(curFile, deleteURL, uploaderId, recordId);

                $(str).appendTo('#' + fileGridId);
            }
        });
    }
    //alert('sdf');
	
    $('#' + uploaderId).fileupload({
        url: uploadURL,
        dataType: 'json',
        formData: [
            {name: "fileInput", value: uploaderId},
            {name: "uploadDir", value: uploadDir},
            {name: "deleteURL", value: deleteURL}
        ],
        autoUpload: true,
        singleFileUploads: true,
        add: function(e, data) {

            // For single file upload check for existing image
            if ($("#" + uploaderId).attr("multiple") == null && $('#' + fileGridId).html() != "")
            {
                if (confirm("It will delete existing image, do you want to overwrite it ?"))
                {
                    // remove old file
                    deleteFile($('#' + fileGridId).children(".imageBox").children(), ((oldImage != "") ? oldImage : fileData[0].name), deleteURL, recordId, false);
                }
                else
                    return false;
            }
           $('.threeBtn').css('pointer-events', 'none');
            var invalidFile = "";

            // remove previouse file upload progress bar if exist for single file upload
            if ($("#" + uploaderId).attr("multiple") == null)  // check for single file upload
            {
                $("." + progressBarClass).html("");       // make progress bar div empty
                disableEnableFileUploadButton(uploaderId, true);
            }

            // Add Uploaded file in queue
            $.each(data.files, function(index, file) {
                
                $("#"+uploaderId).attr("disabled",true);
                var fileExt = file.name.split('.').pop();

                // check for valid file type
                if ($.inArray(fileExt, fileTypes) == -1)
                    invalidFile = "Invalid file type, it must be " + fileTypes.join(', ');
                else if (maxFiles && totalFiles > maxFiles)  // validate maximum no of files to upload
                    invalidFile = "Reached to maximum file upload limit, Maximum files allows to upload " + maxFiles;

                // save current file name
                oldImage = file.name;

                // create object of progress bar of file 
                data.files[index].progress = $('<div class="bx_main"><div style="margin-bottom:5px;" class="progress" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div style="width: 0%;height:20px;" class="progress-bar progress-bar-success" ></div></div>' + file.name.substring(0, 50) + " (" + formatSize(file.size) + ') <br/><span style="color:#ff0000;font-weight:bold;">' + invalidFile + '</span>' + ' <a href="#" title="Cancel" class="cancel-btn" onclick="cancelFileUpload(' + fileUploadQueue.length + ')">Cancel</a></div>').appendTo('.' + progressBarClass);
            });

            // store file object to cancel upload
            fileUploadQueue[fileUploadQueue.length] = data;

            // Upload added files if it is valid
            if (invalidFile == "")
            {
                totalFiles++;
                data.submit();
            }
            else
            {
                oldImage = "";
                disableEnableFileUploadButton(uploaderId, false);
            }
        },
        done: function(e, data) {
            $("#"+uploaderId).attr("disabled",false);
            $.each(data.result, function(objIndex, objFiles) {
                // Display uploaded file in grid
                $.each(objFiles, function(index, file) {
                    // Remove progress bar of uploaded file
                    data.files[index].progress.remove();

                    // display files
                    var str = fileGridFunction(file, deleteURL, uploaderId);

                    $(str).appendTo('#' + fileGridId);
                });
            });
            disableEnableFileUploadButton(uploaderId, false);
            $('.threeBtn').css('pointer-events', 'auto');
            
        },
        fail: function(e, data) {
			disableEnableFileUploadButton(uploaderId, false);
			//$("#" + uploaderId).attr("disabled", false);
                        $('.threeBtn').css('pointer-events', 'auto');
		},
        progress: function(e, data) {
            if (e.isDefaultPrevented()) {
                return false;
            }
            // Calculate upload progress of file
            var progress = Math.floor(data.loaded / data.total * 100);

            if (data.files) {
                // Display progress for each file
                $.each(data.files, function(index, file) {
                    file.progress.find('.progress')
                            .attr('aria-valuenow', progress)
                            .children().first().css(
                            'width',
                            progress + '%'
                            );
                });
            }
        }
    });

}

/* get image name with specified size
 * 
 * @param string name name of image
 * @param size size of image
 * @return string
 * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
 */
function getImageNameWithSize(name, size)
{

    var arrImg = name.split(".");

    var ext = arrImg[arrImg.length - 1];

    var baseName = name.replace("." + ext, "");
    return (baseName + "-" + size + "." + ext);
}

/**
 * Cancel file upload from existing queue
 * @param int index index of file upload queue
 * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
 */
function cancelFileUpload(index)
{
    
    fileUploadQueue[index].abort();
    fileUploadQueue[index].files[0].progress.remove();
}
/* return result of file uploading button 
 * @param uploaderId: file uploader id.
 * @flag: true/false
*/
function disableEnableFileUploadButton(uploaderId, flag) {
	$("#" + uploaderId).attr("disabled", flag);
	var parentDiv = $("#" + uploaderId).parent("div");
	$(parentDiv).addClass("disabled");
	if(!flag) {
		$(parentDiv).removeClass("disabled");
	}
}


/**
 * Display single file in file grid after upload
 * @param object file object of file
 * @param String deleteURL image delete URL
 * @param String uploaderId file uploader id. It is used to create hidden variable name e.g. 'fileImg_hdn[]'
 * @param Integer recordId current record id
 * @param String propURL this url is use to save property of image. It will use only for existing image.
 * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
 */
function displayUploadResult(file, deleteURL, uploaderId, recordId, propURL)
{
    // get extention of file
    var arrExt = file.name.split(".");
    var ext = arrExt[arrExt.length - 1].toLowerCase();

    if (!recordId)
        recordId = "";

    var fileImage = '<img class="imgMain" src="' + file.url + '" />';       // display image with property fuction                

    if (ext == "docx" || ext == "doc")
        fileImage = '<img class="imgMain" src="../templates/admin/images/file-icons/word_icon.png" />';
    else if (ext == "xlsx" || ext == "xls")
        fileImage = '<img class="imgMain" src="../templates/admin/images/file-icons/xlsx_icon.png" />';
    else if (ext == "pdf")
        fileImage = '<img class="imgMain" src="../templates/admin/images/file-icons/pdf_icon.png" />';

    // check for single or multiple file
    if ($("#" + uploaderId).attr("multiple") == null)
    {
        // return block for single file
        if ($("#" + uploaderId).data("required") != undefined) {

            $("#" + uploaderId).removeClass("required")
        }
		if(uploaderId=="flImage")
                {
                    document.getElementById("imageData").setAttribute('data-src', file.url);
                }
                else if(uploaderId=="flImage1")
                {
                    document.getElementById("imageData1").setAttribute('data-src', file.url);
                }
//        return  '<div class="bx_main imageBox"><div class="bx_2"><p>' + file.name + '</p></div><li><div class="bx_3 thumbMain bx_main imageBox"><input type="hidden" name="' + uploaderId + '_hdn" value="' + file.name + '" /><input type="hidden" name="' + uploaderId + '_title_hdn[]" value="' + (file.title ? file.title : "") + '"/><input type="hidden" name="' + uploaderId + '_alt_hdn[]" value="' + (file.alt ? file.alt : "") + '"/>' + fileImage + '<span class="delete" onclick="deleteFile(this,\'' + file.name + '\',\'' + deleteURL + '\',\'' + recordId + '\',true,\'' + uploaderId + '\')"></span></div></li></div>';
        return  '<li class="imageBox"><div class="bx_3 thumbMain bx_main"><input type="hidden" name="' + uploaderId + '_hdn" value="' + file.name + '" /><input type="hidden" name="' + uploaderId + '_title_hdn[]" value="' + (file.title ? file.title : "") + '"/><input type="hidden" name="' + uploaderId + '_alt_hdn[]" value="' + (file.alt ? file.alt : "") + '"/>' + fileImage + '<span class="delete" onclick="deleteFile(this,\'' + file.name + '\',\'' + deleteURL + '\',\'' + recordId + '\',true,\'' + uploaderId + '\')"></span></div></div></li>';
    }
    else
    {
		
        // return block for multiple file
//        return  '<div class="bx_main imageBox"><div class="bx_2"><p>' + file.name + '</p></div><li><div class="bx_3 thumbMain bx_main imageBox"><input type="hidden" name="' + uploaderId + '_hdn[]" value="' + file.name + '"/><input type="hidden" name="' + uploaderId + '_sort_hdn[]" value="' + (file.sort_order ? file.sort_order : 0) + '"/><input type="hidden" name="' + uploaderId + '_title_hdn[]" value="' + (file.title ? file.title : "") + '"/><input type="hidden" name="' + uploaderId + '_alt_hdn[]" value="' + (file.alt ? file.alt : "") + '"/>' + fileImage + '<span class="delete" onclick="deleteFile(this,\'' + file.name + '\',\'' + deleteURL + '\',\'' + recordId + '\',true)"></span></div></li></div>';
        return  '<li><div class="bx_3 thumbMain bx_main imageBox"><input type="hidden" name="' + uploaderId + '_hdn[]" value="' + file.name + '"/><input type="hidden" name="' + uploaderId + '_sort_hdn[]" value="' + (file.sort_order ? file.sort_order : 0) + '"/><input type="hidden" name="' + uploaderId + '_title_hdn[]" value="' + (file.title ? file.title : "") + '"/><input type="hidden" name="' + uploaderId + '_alt_hdn[]" value="' + (file.alt ? file.alt : "") + '"/>' + fileImage + '<span class="delete" onclick="deleteFile(this,\'' + file.name + '\',\'' + deleteURL + '\',\'' + recordId + '\',true)"></span></div></li>';

    }
}

/**
 * Delete uploaded file
 *
 * @param object boxObj object of delete button
 * @param string fileName image name
 * @param string dleteURL image delete url
 * @param int id image record id
 * @param boolean confirmUser take user confirmation to delete image
 *
 * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
 */
function deleteFile(boxObj, fileName, deleteURL, recordId, confirmUser, uploaderId)
{
    if (confirmUser && confirmUser == true) {
        if (confirm("Do you really want to delete this image ?") == false)
            return false;
    }
    console.log(uploaderId);
    // get object of file box
    var parentLi = $(boxObj).parents(".imageBox");

    // send image delete request
    $.ajax({
        "url": deleteURL + "&filename=" + fileName + ((recordId && recordId != "") ? "&id=" + recordId + "&lang_id=" + $("#lang_id").val() : ""),
        "async": false,
        "success": function(data) {
            // remove file box.

            if ((uploaderId != undefined && uploaderId != null) && $("#" + uploaderId).data("required") != undefined) {
                $("#" + uploaderId).addClass("required");
            }

            parentLi.remove();
        }
    });

    return false;
}

/**
 * Format file size
 * @param object file object of file
 * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
 */
function formatSize(bytes)
{
    if (typeof bytes !== 'number') {
        return '';
    }
    if (bytes >= 1000000000) {
        return (bytes / 1000000000).toFixed(2) + ' GB';
    }
    if (bytes >= 1000000) {
        return (bytes / 1000000).toFixed(2) + ' MB';
    }
    return (bytes / 1000).toFixed(2) + ' KB';
}

/** Display image property dialog box
 * 
 * @param Object imgObj image object         
 * @param String imgName name of image
 * @param String uploaderId image uploader id
 * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
 */
function displayImgProp(imgObj, imgName, uploaderId)
{

    var imgDate = new Date();       // create date object
    var imgId = "id" + imgDate.getTime();       // create image id with current time stamp
    $(imgObj).attr("id", imgId);     // assign new id to image

    var parentDiv = $(imgObj).parent("div"); // get parent div object

    $(".imgPrt").html('<div class="modal-dialog"> \
                                            <div class="modal-content"> \
                                                <div class="modal-header"> \
                                                    <button type="button" class="close" title="Close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> \
                                                    <h4 class="modal-title" id="exampleModalLabel">Image Properties</h4> <span class="subimgSpan">' + imgName + '</span>\
                                                </div> \
                                                <div class="modal-body"> \
                                                       <div class="form-group"> \
                                                          <span class="labelSpan">Image Title:</span> \
                                                          <div class="txtBox"><input type="text" class="txt" value="' + parentDiv.children("input[name='" + uploaderId + "_title_hdn[]']").val() + '" id="' + uploaderId + '_propTitle" maxlength="100"></div> \
                                                       </div> \
                                                       <div class="form-group"> \
                                                        <span class="labelSpan">Alt Text:</span> \
                                                        <div class="txtBox"><input type="text" class="txt" id="' + uploaderId + '_propAlt" value="' + parentDiv.children("input[name='" + uploaderId + "_alt_hdn[]']").val() + '" maxlength="100"></div>\
                                                       </div>' + (parentDiv.children("input[name='" + uploaderId + "_sort_hdn[]']").attr("type") ? '\
                                                       <div class="form-group"> \
                                                        <span class="labelSpan">Sort Order:</span> \
                                                        <div class="txtBox"><input type="text" class="txt" id="' + uploaderId + '_propOrder" value="' + parentDiv.children("input[name='" + uploaderId + "_sort_hdn[]']").val() + '" maxlength="3"></div>\
                                                       </div>' : "") + '\
                                                       </div> \
                                                <div class="modal-footer"> \
                                                    <button type="button" class="btn trans backBtn" title="Close" data-dismiss="modal">Close</button> \
                                                    <button type="button" class="btn trans" title="Done" data-dismiss="modal" onclick="saveImgProp(\'' + imgId + '\',\'' + uploaderId + '\')">Done</button> \
                                                </div> \
                                            </div> \
                                    </div>');
    $('.imgPrt').modal("show") // display popup
}

/** Update image property data in database using Ajax
 *          
 * @param string imgId id of image
 * @param String uploaderId image uploader id         
 * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
 */
function saveImgProp(imgId, uploaderId)
{
    var imgTitle = $("#" + uploaderId + "_propTitle").val();      // get new image title value
    var imgAlt = $("#" + uploaderId + "_propAlt").val();          // get new image alt value

    var parentDiv = $("#" + imgId).parent("div"); // parent div object

    parentDiv.children("input[name='" + uploaderId + "_title_hdn[]']").val(imgTitle);   // assign new title to hidden variable
    parentDiv.children("input[name='" + uploaderId + "_alt_hdn[]']").val(imgAlt);       // assign new alt text to hidden variable
    if ($("#" + uploaderId + "_propOrder").attr("type")) {          // check for sort order
        var imgOrder = $("#" + uploaderId + "_propOrder").val();  // get new sort order
        parentDiv.children("input[name='" + uploaderId + "_sort_hdn[]']").val(imgOrder);   // assign new sort order to hidden variable
    }
}

/* Display language options
 *          
 * @param string optionsDiv id of div contains language option
 * @param int landId current language id
 * @param string langURL url to get language data
 * @authod Rutwik Avasthi <php.datatechmedia@gmail.com>
 */
function languageOption(optionsDiv, langId, langURL)
{
    var arrLang = {"1": "English", "2": "Hindi", "3": "Gujarati"}
    var strLang = '<div class="btn-group" data-toggle="buttons">';

    $.each(arrLang, function(index, value) {
        if (index == langId)
            strLang = strLang + '<label class="btn btn-primary active"><input type="radio" name="options" id="option' + index + '"> ' + value + '</label>';
        else
        {
            if (!langURL)
                strLang = strLang + '<label class="btn btn-primary " onclick="return selectLanguage(event,' + index + ')"><input type="radio" name="options" id="option' + index + '"> ' + value + '</label>';
            else
                strLang = strLang + '<label class="btn btn-primary " onclick="return selectLanguage(event,' + index + ',\'' + langURL + '\')"><input type="radio" name="options" id="option' + index + '">' + value + '</label>';     // pass language url is exists
        }
    });

    strLang = strLang + '</div>';

    $("#" + optionsDiv).html(strLang);
}

/* load selected language data from server
 * 
 * @param object event object of current event         
 * @param Integer langId
 * @param string langURL
 * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
 */
function selectLanguage(event, langId, langURL)
{
    // hide form
    toggleFormLoad("show");

    var path = $(location).attr("href").split("?");

    // remove all has values from url
    path[1] = path[1].replace($(location).attr("hash"), "");

    // remove existing language value from query string
    var arrParam = path[0].split('&');
    for (i = 0; i < arrParam.length; i++)
    {
        if (arrParam[i].indexOf("lang_id") >= 0)
        {
            path[1] = path[1].replace(arrParam[i], "");
            break;
        }
    }

    // create language data url if not passed
    if (!langURL)
        langURL = path[0] + "?" + path[1];

    // get current language data
    $.ajax({
        "url": langURL + "&ajaxData=1&lang_id=" + langId,
        "success": function(data) {
            pageData = jQuery.parseJSON(data);
            fillForm();
        }
    });
    event.preventDefault();
}


/* Toggle form load div
 * 
 * @param String toggleType toggle type two value "show" and "hide"
 * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
 */
function toggleFormLoad(toggleType)
{
    var removeClassName = "hideFormLoad";
    if (toggleType == "hide")
        removeClassName = "showFormLoad";

    $("#formLoad").removeClass(removeClassName)
    $("#formLoad").addClass(toggleType + "FormLoad")
}

/** Create category drop down with tree structure
 * 
 * @param object catData
 * @param int dropDownId id of drop down
 * @param int selecteValue current selected value
 * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
 */
function createCatDropDown(catData, dropDownId, selecteValue)
{
    // get object of drop down
    var mySelect = $("#" + dropDownId)
    var space = 0;
    // create option of drop down
    $.each(catData, function(index, cat) {
        space = (cat.level > 2) ? cat.level : 0;
        if (cat.id == selecteValue)
            mySelect.append($('<option selected="selected"></option>').val(cat.id).html(Array(space * 1).join("&nbsp;&nbsp;") + "-&nbsp;" + cat.name));
        else
            mySelect.append($('<option></option>').val(cat.id).html(Array(space * 1).join("&nbsp;&nbsp;") + "-&nbsp;" + cat.name));
    });

    mySelect.prop("disabled", false);
}

/**
 * To type numberic value in text box
 *
 * @param evt ascill value of key code
 *
 * @author Kushan Antani <kushan.datatechmedia@gmail.com>
 */

function isNumberic(evt)
{
    var charCode = (evt.which) ? evt.which : evt.keyCode

    if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 46 && charCode != 8)
        return false;

    if (charCode == 46)
        return false;

    return true;
}

function isNumbericPrice(evt)
{

    var charCode = (evt.which) ? evt.which : evt.keyCode
//    console.log(charCode)
    if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 46 && charCode != 39 && charCode != 37 && charCode != 8)
        return false;

    /*if (charCode == 46)
     return false; */

    return true;
}


function bindListingClick() {
    // To toggle table record in mobile view
    $('.toggleLink').off('click');
    $('.toggleLink').on('click', function() {
        $(this).toggleClass('arrowUp');
        $(this).closest('li, tr').toggleClass('is-expanded');
    });
    if ($(window).width() < 768) {
        $('.table .checkbox').off('click');
        $('.table .checkbox').on('click', function() {
            if ($('.mobiAction').is(':hidden')) {
                $('.scrollTop').addClass('Btmspace');
                $(".mobiAction").slideDown().addClass('actionShow');
            }
            $('.counterDiv').html($('.table .checkbox:not(#masterCh)').filter(':checked').length);
        });

        $('.closeAction').off('click');
        $('.closeAction').on('click', function() {
            $('.scrollTop').removeClass('Btmspace')
            $(".mobiAction").slideUp().removeClass('actionShow');
        });

        $('.table li.commentLi').remove();



    }
    $('.commentBtn').off('click');
    $('.commentBtn').on('click', function() {
        $(this).parents("li").parents("li").next().toggleClass("commentShow");
    });
}
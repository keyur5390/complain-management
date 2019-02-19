if ($(window).width() > 767) {
$().ready(function () { 
      
      var setWaiAria = function(menuLi){
        menuLi.each(function (i,el) {
          var $el = $(el);
          $el.attr('aria-setsize',menuLi.length);
          $el.attr('aria-posinset',i+1);
        });
      }

      // set wai aria aria-setsize and aria-posinset before cloning elements in other list
      setWaiAria($("#nav-bar-filter > li"));

      //we reconstruct menu on window.resize
      $(window).on("resize", function (e) {                         
        var parentWidth = $("#nav-bar-filter").parent().width() - 40;
        var ulWidth = $("#more-nav").outerWidth();       
			
        var menuLi = $("#nav-bar-filter > li");         
        var liForMoving = new Array();
        var activeElement = $(document.activeElement)[0];

        // before remove item check if you have to reset the focus
        var removeOriginal = function(item,clone){
          // check focused element
          if(item.find('a')[0] === activeElement){
            activeElement = clone.find('a')[0];
          }
          
          item.remove();
        }

        //take all elements that can't fit parent width to array
        menuLi.each(function () {
			
          var $el = $(this);            
		  //newulWidth+=$el.outerWidth());
          ulWidth += $el.outerWidth(); 
          if (ulWidth > parentWidth ) {
			  
            liForMoving.unshift($el);
          }
        }); 
		
        if (liForMoving.length > 0) { //if have any in array -> move em to "more" ul
          e.preventDefault(); 

          liForMoving.forEach(function (item) {
			  
            var clone = item.clone();
            clone.prependTo(".subfilter");
            
            removeOriginal(item, clone);
          });
              
        }
        else if (ulWidth < parentWidth) { //check if we can put some 'li' back to menu
          liForMoving = new Array();
          
          var moved = $(".subfilter > li");
          for (var i=0, j = moved.length ; i < j; i++) { 
            var movedItem = $(moved[i]);

            var tmpLi = movedItem.clone();
            tmpLi.appendTo($("#nav-bar-filter"));


            ulWidth += movedItem.outerWidth();
            if (ulWidth < parentWidth) {
              removeOriginal(movedItem, tmpLi);
            }
            else {
              // dont move back
              ulWidth -= movedItem.outerWidth();
              tmpLi.remove();
            }

          }
        }           
        if ($(".subfilter > li").length > 0) { //if we have elements in extended menu - show it
          $("#more-nav").show();
        }
        else {
          // check if 'more' link has focus then set focus to last item in list
          if($('#more-nav').find('a')[0] === $(document.activeElement)[0]){
            activeElement = $("#nav-bar-filter > li:last-child a")[0];
          }

          $("#more-nav").hide();
        }

        // reset focus
        activeElement.focus();
      });
      
      $(window).trigger("resize"); //call resize handler to build menu right
    });
	
}
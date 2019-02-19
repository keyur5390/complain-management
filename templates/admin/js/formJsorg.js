/*
 * Initialize tiny mce
 *
 * @param string elementName coma seperated string e.g. description,short_description
 *
 * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
 */
 function loadEditor(elements)
 {
	 
	 tinyMCE.init({
        // General options
		height : '300',
                width : '10000',
                mode : "exact",

		elements: elements,
				setup : function(ed) {
  		  ed.on('change', function(ed) {
			//alert(document.getElementById(elements).classList); 
        	var dom = ed.dom,
            	doc = ed.getDoc(),
            	el = doc.content_editable ? ed.getBody() : (tinymce.isGecko ? doc : ed.getWin());
        tinymce.dom.Event.add(el, 'blur', function(e) {
		          if(document.getElementById(elements).classList.contains("requireEditor")==true) {
					 var lbl=elements.replace("txt","lbl");
					 
					 $.uniform.update(document.getElementById(lbl).style.display="none");
					
					 $("#"+elements).valid();
				  }
					   //console.log('blur');
        })
        tinymce.dom.Event.add(el, 'focus', function(e) {
           // console.log('focus');
        })        
    });

},
        theme : "advanced",
//        theme : "tinymce_skin",
					plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
			
					// Theme options
					theme_advanced_buttons1 : "pasteword,|,search,replace,|,undo,redo,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,formatselect",
					theme_advanced_buttons2 : ",image,cleanup,code,|,preview,|,forecolor,backcolor,|,tablecontrols",
					//theme_advanced_buttons3 : "charmap,emotions,iespell,media,advhr,|,ltr,rtl,|,styleprops,spellchecker",
					theme_advanced_toolbar_location : "top",
					theme_advanced_toolbar_align : "left",
					theme_advanced_statusbar_location : "bottom",
					theme_advanced_resizing : true,
					relative_urls : false,
        			remove_script_host : false,
					forced_root_block : false,			        
			
					// Skin options
					skin : "o2k7",
					skin_variant : "silver",
			
//					// Example content CSS (should be your site CSS)
//					content_css : "../templates/front/css/style.css",
                                        content_css : "../templates/admin/css/fck-style.css",
					// Drop lists for link/image/media/template dialogs
					template_external_list_url : "js/template_list.js",
					external_link_list_url : "js/link_list.js",
					external_image_list_url : "js/image_list.js",
					media_external_list_url : "js/media_list.js",
					file_browser_callback: 'openKCFinder'
			});
 }
 
 
 function openKCFinder(field_name, url, type, win) {
    tinyMCE.activeEditor.windowManager.open({
        file: editorPath + '/plugins/kcfinder/browse.php?opener=tinymce&type=' + type,
        title: 'KCFinder',
        width: 700,
        height: 500,
        resizable: "yes",
        inline: true,
        close_previous: "no",
        popup_css: false
    }, {
        window: win,
        input: field_name
    });
    return false;
}
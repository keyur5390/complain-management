<script type="text/javascript" src="<?php echo URI::getLiveTemplatePath() . "/js/jquery-ui.custom.js" ?>"></script>
<script type="text/javascript">
    //alert("js/new_parent_region call");
    var add_new_prd_dialog = "";
    /* Popup for adding new parent region */
    function add_new(counterNo) {
        
        var parent_region_name=$("#txtparentRegion").val();
//        alert(parent_region_name);
//        var proCode = $(counterNo).closest('span').prev().find('input').val();
//        var dropdownid = $(counterNo).closest('ul').attr('id').split("-");
//        dropdownid = dropdownid[1];
//        console.log(dropdownid);
        //create_new_parent_region_dialog('add_newproduct', dropdownid, proCode);
        create_new_parent_region_dialog('add_new_parent_region',parent_region_name);
    }
    
    /* Popup for adding new products */

    function create_new_parent_region_dialog(page, new_parent_region_name) {
//        alert("create_new_parent_region_dialog call");
        div = $(".new_add_parent_region_dialog");
        var table_data = "";

        div.html();
        div.dialog({
            autoOpen: true,
            modal: true,
            title: "Add New Parent Region",
            draggable: true,
            resizable: false,
            width: "800",
            height: "auto",
            dialogClass: 'dialog',
            closeOnEscape: false,
            position: ['center', 50],
            zIndex: "9999",
            open: function() {

                var pro_id = '';
                // clear remove value every time when the popup is open
//                $("#txtCode").removeData("previousValue");

                var rules = {
                    NewRegionName: {required: true},
                    NewCode: {required: true},
                    NewHelpDesk: {required: true}
                };
                var messages = {
                    NewRegionName: "Please enter region name",
                    NewCode: "Please enter region code",
                    NewHelpDesk:"Please select help desk manager"
                };

                // initialize form validator
                validaeForm("createParentRegion", rules, messages);

                $("#cancel").on("click", function() {
                    div.find("input").val("");
                    div.dialog("close");
                });

//                if (proCode != '' && proCode != 'undefined') {
//                    $('#txtCode').val(proCode).trigger('change');
//                    $('#txtCode').valid();
//                }

                //selectState();
                $(".ui-dialog-buttonset").find("button:first").html("Submit").addClass("applyTooptip").attr("data-title", "Submit");
                $(".ui-dialog-buttonset").find("button:last").html("Cancel").addClass("applyTooptip").attr("data-title", "cancel");
                $(".ui-dialog-buttonset").find("button").addClass("btn btn-primary");
                applyTooltip();

                div.find("label.text-error").remove();
            },
            close: function() {
                div.find("input").val("");
                div.dialog("destroy");
            },
            buttons: {
                "add_new_parent_region": function(e) {
                    var address_url;
                    if (page == "add_new_parent_region") {
                        address_url = '<?php echo URI::getURL("mod_region", "region_edit"); ?>';
                    }

                    if ($('#createParentRegion').valid()) {
                        add_new_parent_region(address_url);
                    }
                },
                "close": function() {
                    div.find("input").val("");
                    div.dialog("close");
                    $(":button[text='close']").attr("disabled", "disabled");
                }
            }
        });
    }



    function add_new_parent_region(address_url) {

        if (!$('#createParentRegion').valid())
        {
            return false;
        }

        $(".ui-dialog-buttonset").find(":button:last").remove();
        $(".tooltip").remove();
        $(".ui-dialog-buttonset").find(":button:first").prop("disabled", "disabled").html("Submitting...");
        $.ajax({
            url: address_url + '&ajaxAdd=true',
            data: $("#createParentRegion").serialize(),
            type: "post",
            success: function(datas) {

                //setProductData();
                if (datas)
                {
                    proQty = $.parseJSON(datas);

                    /* Commented by Keyur Mistry on 01-11-2016
                     // this is generating agina select2 dropdown on single value
                     var $example = $("#" + counterNo).select2({
                     data: proQty.items
                     });*/

                    //dropVal = $.parseJSON(proQty.items);
                    //console.log(proQty.items);

//                    $("#" + counterNo).empty().append('<option value="' + proQty.dd_id + '">' + proQty.dd_text + '</option>').val(proQty.dd_id).trigger('change');

                    $("#").empty().append($("<option/>").val(proQty.dd_id).text(proQty.dd_text))
                            .val(proQty.dd_id)
                            .trigger("change");



                    if ($("#" + counterNo).data('selected_ids') != undefined) {
                        notinids[proQty.dd_id] = proQty.dd_id;
                        if (selected_ids != undefined) {
                            selected_ids[proQty.dd_id] = proQty.dd_id;
                        }
                    }

                    getProductInfo(proQty, counterNo); // counterNo : it's select 2 dropdown id 

                    // $("#prdDropdown_0").select2("data", dta.items);
//                    var opts = $("#prdDropdown_0").data();
//                        opts.select2.triggerSelect(dta.items);
                    // $('#prdDropdown_0').val($('#prdDropdown_0 option:first-child').val()).trigger('change');                    
                    //  $example.on("change", function (e) {alert(); });

                    div.find("input").val("");
                    div.dialog("close");
                }
                else
                {
                    displayMessage("error", "Customer ", "Customer address creation failed");
                }
            }
        })
    }

</script>
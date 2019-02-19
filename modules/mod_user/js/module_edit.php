<script type="text/javascript" src="<?php echo URI::getLiveTemplatePath() . '/js/jquery.validate.js' ?>"></script>
<script src="<?php echo URI::getLiveTemplatePath() . "/js/jquery-ui.custom.js"; ?>" type="text/javascript"></script>
<link href="<?php echo URI::getLiveTemplatePath(); ?>/css/ui.dynatree.css" rel="stylesheet" type="text/css" id="skinSheet">
<script src="<?php echo URI::getLiveTemplatePath() . "/js/jquery.dynatree.js"; ?>" type="text/javascript"></script>
<script type="text/javascript">

    $(document).ready(function() {
         $("#btnSave,#btnFooterSave").click(function(event) {
            $('#frmSetmod').submit();
        });
        
                // --- Initialize sample trees
        $("#accrss_tree").dynatree({
            checkbox: true,
            selectMode: 3,
            classNames: {nodeIcon: ""},
            debugLevel: 0,
//                    children: treeData,
            onSelect: function(select, node) {
                // Get a list of all selected nodes, and convert to a key array:
                var selKeys = $.map(node.tree.getSelectedNodes(), function(node) {
                    return node.data.key;
                });
                $("#echoSelection3").text(selKeys.join(", "));

                // Get a list of all selected TOP nodes
                var selRootNodes = node.tree.getSelectedNodes(true);
                // ... and convert to a key array:
                var selRootKeys = $.map(selRootNodes, function(node) {
                    return node.data.key;
                });
                $("#echoSelectionRootKeys3").text(selRootKeys.join(", "));
                $("#echoSelectionRoots3").text(selRootNodes.join(", "));
            },
            onDblClick: function(node, event) {
                node.toggleSelect();
            },
            onKeydown: function(node, event) {
                if (event.which == 32) {
                    node.toggleSelect();
                    return false;
                }
            },
        });

       $('#frmSetmod').submit(function(e) {

            var formData = $(this).serializeArray();

//                // then append Dynatree selected 'checkboxes':
            var tree = $("#accrss_tree").dynatree("getTree");
            formData = formData.concat(tree.serializeArray());
           // console.log(formData[2].value);

            // and/or add the active node as 'radio button':
            if (tree.getActiveNode()) {
                formData.push({name: "activeNode", value: tree.getActiveNode().data.key});
            }
                var len = Object.keys(formData).length;
                
                if(len <= 2)
                {
                        alert('Please select atleast one moudule');
                }

//console.log(formData);
            $.ajax({
                    "url": '<?php echo URI::getURL(APP::$moduleName, APP::$actionName); ?>',
                    data: formData,
                    "type": "post",
                    "success": function() {
                            window.location.href = '<?php echo URI::getURL(APP::$moduleName, APP::$actionName); ?>';
                            
                           // console.log(data);
                    }
             });
//            $.post('<?php echo URI::getURL(APP::$moduleName, APP::$actionName); ?>',
//                    formData,
//                    function(data) {
//                        window.location.href = '<?php echo URI::getURL(APP::$moduleName, APP::$actionName); ?>';
//                        window.location.href = '<?php // echo URI::getURL(APP::$moduleName, APP::$actionName); ?>' + "&id=" + $.trim(data);
//                    }
//            );
            return false;

        });

    });
</script>

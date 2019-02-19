<?php

class Controls {

    /**
     * 
     * @param string $moduleKey
     * @param string $actionKey
     * @param string $class
     * @param string $toolTip
     * @return string
     */
    function createDashBoardBtn($moduleKey, $actionKey, $class, $toolTip) {
        $html = '<li><a class="tipB" href="' . URI::getURL($moduleKey, $actionKey) . '" oldtitle="' . $toolTip . ' Manager" title="' . $toolTip . ' Manager" aria-describedby="ui-tooltip-21"> <span class="icon ' . $class . '"></span><span class="txt">' . $toolTip . ' Manager</span></a></li>';
        return $html;
    }

    /**
     * User defined function to create drop down
     * @param string $moduleKey
     * @param string $actionKey
     * @param string $operation
     * @param string $class ( for example icomoon-icon-checkmark  greenColor)
     * @param string $toolTip
     * @return string
     */
    public function createDropDown($moduleKey, $actionKey, $operation, $class, $toolTip, $menutitle = "") {
        if ($operation != "delete" && $operation != "update") {
            $state = ($operation == "active") ? "1" : "0";
            $caption = ($operation == "active") ? "activated" : "inactivated";
            $function = "changeStatus('";
            $function.="index.php?m=" . $moduleKey . "&a=" . $actionKey . "',";
            $function.="'','" . $state . "','" . ucfirst($toolTip) . " Status','" . ucfirst($toolTip) . "(s) status have been " . $caption . " successfully')";
        } else if ($operation == "update") {
            $function = 'updateRecord(\'index.php?m=' . $moduleKey . '&a=' . $actionKey . '&op=update\')';
        } else {
            $function = 'deleteRecord(\'index.php?m=' . $moduleKey . '&a=' . $actionKey . '\',\'\',\'Delete ' . ucfirst($toolTip) . '\',\'' . ucfirst($toolTip) . '(s) have been deleted successfully\')';
        }
        if ($menutitle != "") {
            $title = $menutitle;
        } else {
            $title = $operation;
        }
        $html = '<li><a href="#" data-placement="left" class="" title="' . ucfirst($title) . ' selected ' . strtolower($toolTip) . '" data-title="' . ucfirst($title) . ' selected ' . strtolower($toolTip) . '" onclick="' . $function . '">' . ucfirst($title) . '</a></li>';
        return $html;
    }

    /**
     * button string for import manufacturer
     * 
     * @author Jignasha Patel <jignasha.seorank@gmail.com>
     */
    function import($moduleKey, $actionKey, $toolTip) {
        $html = '<a href="index.php?m=' . $moduleKey . '&a=' . $actionKey . '" title="Import' . '" class="btn btn-info" style="margin:0 7px;">Import' . '</a>';
        return $html;
    }

    /**
     * button string for export manufacturer
     * 
     * @author Jignasha Patel <jignasha.seorank@gmail.com>
     */
    function export($moduleKey, $actionKey, $toolTip, $function = "", $style = "") {
        if ($function == "") {
            $html = '<a href="index.php?m=' . $moduleKey . '&a=' . $actionKey . '" title="Export' . '" class="btn btn-info">Export' . '</a>';
        } else {
            $html = "<a href='javascript:;' " . $function . "  class=\"btn btn-info \" title=\"Export" . "\"";
            if ($style != "") {
                $html.="style=\"float: left; width: auto;\">";
            }
            $html.="Export" . "</a>";
        }
        return $html;
    }

    /*
     * to check PO prducts action 
     */

    function po_products($moduleKey, $actionKey, $toolTip) {
        $html = '<a href="index.php?m=' . $moduleKey . '&a=' . $actionKey . '" title="' . $toolTip . '" class="btn pd10  applyTooptip" style="width:90px;"><span class="icon16 icomoon-icon-upload-3 "></span>Import</a>';
        return $html;
    }

}

?>
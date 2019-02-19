<?php

/**
 * check if variable is set and is not empty
 * [9-5-2014]
 * @author sanjay parekh <sanjayp.datatech@gmail.com>
 * @param type $var
 * @return type
 */
function is_valid($var) {
    if (isset($var) && !empty($var)) {

        return true;
    }
    else
        return false;
}

/**
 * for debugging
 * @author sanjay parekh <sanjay.parekh@gmail.com>
 * [9-5-2014]
 * @param type $val
 * @param type $exit 0 = continue execution,1 = exit or die()
 */
function pre($val, $exit = 0) {
    echo "<pre>";
    print_r($val);
    echo "</pre>";
    if ($exit != 0)
        exit;
}


function display_breadcrumb($data = array(), $mainTitle = "") {
    include_once CFG::$absPath . "/" . CFG::$helper . "/templates/display_breadcrumb.php";
}


function display_banner($data = array(), $mainTitle = "") {
    
    include_once CFG::$absPath . "/" . CFG::$helper . "/templates/display_banner.php";
}

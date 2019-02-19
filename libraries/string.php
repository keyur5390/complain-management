<?php

/**
  This is string class contains string related function
 */
//restrict direct access to the page
defined('DMCCMS') or die('Unauthorized access');

class Stringd {

    /**
     * replace double quote(") with &quote;
     *
     * @param mixed $arrString  remove extra sapce or other unwanted character from array or string
     *
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function processString($arrString) {
        if (is_array($arrString)) {
            foreach ($arrString as $key => $val) {
                if (is_numeric($val) == false) {
                    $arrString[$key] = trim($val);
                }
            }
        }
        else
            $arrString = trim($arrString);
        return $arrString;
    }

    /**
     * Create javascript object from php arra
     *
     * @param string $objectName javascript object name
     * @param array $data array of data
     *
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function createJsObject($objectName, $data) {
        $objectData = "";
        $objectData = "var " . $objectName . "=" . json_encode($data);
        return $objectData;
    }

    /**
     * Remove whitespace and special characters from numeric value
     *
     * @param string $str
     *
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    function removeWhitespace($str) {
        return preg_replace('/\D/', "", $str);
    }
    
     /**
     * 
     * @param $description added description
     * this function will give strip tags and allowed paragraph,anchor,bold,strong,br and multiple br with single br 
     * @author Abhishek Panchal <abhishek.datatech@gmail.com>
     */
    public static function stripDescription($description = "") {
        $stripdesc = strip_tags($description, '<p><a><b><strong><br><ol><ul><li><h1><h2><h3><h4><h5><h6>');
        /* $removep = preg_replace("/<p[^>]*>&nbsp;<\\/p[^>]*>/", '', $stripdesc); */
        $removep = preg_replace("#<p>(\s|&nbsp;|</?\s?br\s?/?>)*</?p>#", '', $stripdesc);
        return preg_replace("/(<br\s*\/?>\s*)+/", "<br>", $removep);
    }

}


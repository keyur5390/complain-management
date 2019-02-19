<?php
//restrict direct access to the page
defined('DMCCMS') or die('Unauthorized access');

class Template {

    /**
     * This function must require. It is used by system to set common attributes of template
     *
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function setTemplate() {
        $path = URI::getLiveTemplatePath();

        // add css and js in header
        /* Layout::addHeader('<link rel="stylesheet" href="'.$path.'/css/menu.css" type="text/css"/>');
          Layout::addHeader('<link rel="stylesheet" href="'.$path.'/css/style.css" type="text/css">');
          Layout::addHeader('<link rel="stylesheet" href="'.$path.'/css/1140.css" type="text/css">'); */

        $absPath = URI::getAbsTemplatePath();

       // Layout::groupFiles("commonstyle", $absPath . "/css/menu.css", "css", "header");
        Layout::groupFiles("commonstyle", $absPath . "/css/style.css", "css", "header");
       // Layout::groupFiles("commonstyle", $absPath . "/css/1140.css", "css", "header");
        //Layout::groupFiles("commonjs", $absPath . "/js/jquery.min.js", "js", "header");

        // get all header css and js
        $jsData = Layout::bufferContent(URI:: getAbsTemplatePath() . "/js/jspage.php");
        Layout::addHeader($jsData);

        // get all footer css and js
        $jsFooter = Layout::bufferContent(URI:: getAbsTemplatePath() . "/js/jsfooter.php");
        Layout::addFooter($jsFooter);

        /* Layout::addFooter('<script src="'.$path.'/js/jquery-1.10.2.min.js" type="text/javascript"></script>');
          Layout::addFooter('<script src="'.$path.'/js/menu.js" type="text/javascript"></script>');
          Layout::addFooter('<script src="'.$path.'/js/jquery.themepunch.plugins.min.js"></script>');
          Layout::addFooter('<script src="'.$path.'/js/jquery.themepunch.showbizpro.min.js"></script>');
          Layout::addFooter('<script src="'.$path.'/js/custom.js"></script>');
          Layout::addFooter('<script src="'.$path.'/js/jquery.infieldlabel.min.js"></script>'); */


//                        Layout::groupFiles("commonjs",$absPath."/js/jquery-1.10.2.min.js","js","footer");
        
//         Layout::groupFiles("commonjs", $absPath . "/js/jquery.validate.js", "js", "footer");
//        Layout::groupFiles("commonjs", $absPath . "/js/menu.js", "js", "footer");
//        Layout::groupFiles("commonjs", $absPath . "/js/jquery.themepunch.plugins.min.js", "js", "footer");
//        Layout::groupFiles("commonjs2", $absPath . "/js/jquery.themepunch.showbizpro.min.js", "js", "footer");
//        Layout::groupFiles("commonjs3", $absPath . "/js/jquery.infieldlabel.min.js", "js", "footer");
//        Layout::groupFiles("commonjs5", $absPath."/js/jquery.icheck.js", "js", "footer");
//        Layout::groupFiles("commonjs4", $absPath . "/js/custom.js", "js", "footer");
        
      
        			//echo "<pre>";print_r(Layout::$groupFiles);exit;
        }
        }
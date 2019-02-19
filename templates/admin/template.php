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
// include all css
//			Layout::addHeader('<link href="'.URI::getLiveTemplatePath().'/css/main.css" rel="stylesheet" type="text/css" />');
//			Layout::addHeader('<link href="'.URI::getLiveTemplatePath().'/css/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css" />');			      
//			Layout::addHeader('<link href="'.URI::getLiveTemplatePath().'/css/datepicker.css" rel="stylesheet" type="text/css" />');			      
//                        Layout::addHeader('<link href="'.URI::getLiveTemplatePath().'/plugins/uniform/uniform.default.css" rel="stylesheet" type="text/css" />');
        $absPath = URI::getAbsTemplatePath();
        Layout::addHeader('<link href="' . URI::getLiveTemplatePath() . '/css/icons.css" rel="stylesheet" type="text/css" />');
        Layout::addHeader('<link href="'.URI::getLiveTemplatePath().'/js/morris.js-0.5.1/morris.css" rel="stylesheet" type="text/css" />');
        
        Layout::addHeader('<link href="' . URI::getLiveTemplatePath() . '/css/font-awesome.css" rel="stylesheet" type="text/css" />');
        Layout::groupFiles("commonstyle", $absPath . "/css/lightgallery.css", "css", "header"); // Add By Mayur Patel  22-02-2017 6:00 PM
        Layout::addHeader('<script src="' . URI::getLiveTemplatePath() . '/js/morris.js-0.5.1/jquery.min.js" type="text/javascript"></script>');
                        Layout::addHeader('<script src="' . URI::getLiveTemplatePath() . '/js/morris.js-0.5.1/raphael-min.js" type="text/javascript"></script>');
                        Layout::addHeader('<script src="' . URI::getLiveTemplatePath() . '/js/morris.js-0.5.1/morris.min.js" type="text/javascript"></script>');
        Layout::addHeader('<script src="' . URI::getLiveTemplatePath() . '/js/tinymce/tinymce.min.js" type="text/javascript"></script>');
//			Layout::addHeader('<link href="'.URI::getLiveTemplatePath().'/css/menu.css" rel="stylesheet" type="text/css" />');
// include all js
//			Layout::addFooter('<script type="text/javascript" src="'.URI::getLiveTemplatePath().'/js/jquery-1.8.3.min.js"></script>');
        /*
         * parth parikh 
         * dt 23-5-2016
         */
        Layout::addFooter('<script type="text/javascript" src="' . URI::getLiveTemplatePath() . '/js/jquery.min.js"></script>');
        Layout::addFooter('<script type="text/javascript" src="'.URI::getLiveTemplatePath().'/js/bootstrap/bootstrap.min.js"></script>');
        Layout::addFooter('<script type="text/javascript" src="' . URI::getLiveTemplatePath() . '/js/jquery.okayNav.js"></script>');
        /*
         * end
         * parth parikh 
         * dt 23-5-2016
         */
//                        Layout::addFooter('<script type="text/javascript" src="'.URI::getLiveTemplatePath().'/js/bootstrap/bootstrap.min.js"></script>');
//Layout::addFooter('<script type="text/javascript" src="'.URI::getLiveTemplatePath().'/js/jquery.validate.js"></script>');
        Layout::addFooter('<script type="text/javascript" src="' . URI::getLiveTemplatePath() . '/js/main.js"></script>');
//                           Layout::addFooter('<script type="text/javascript" src="'.URI::getLiveTemplatePath().'/plugins/uniform/jquery.uniform.min.js"></script>');	
        Layout::addFooter('<script type="text/javascript" src="' . URI::getLiveTemplatePath() . '/js/datepicker.js"></script>');
        /*
         * parth parikh 
         * dt 23-5-2016
         */
        Layout::addHeader('<link href="' . URI::getLiveTemplatePath() . '/css/style.css" rel="stylesheet" type="text/css" />');
        Layout::addHeader('<link href="' . URI::getLiveTemplatePath() . '/css/jquery-ui.css" rel="stylesheet" type="text/css" />');
        Layout::addHeader('<link href="' . URI::getLiveTemplatePath() . '/css/new-menu.css" rel="stylesheet" type="text/css" />');
        Layout::addHeader('<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800,600,400italic,700italic" type="text/css" />');
    }

}

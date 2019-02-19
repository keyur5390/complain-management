<?php

//restrict direct access to the page
defined('DMCCMS') or die('Unauthorized access');

class Error {

    /**
     * constructor of class page. do initialisation
     *
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    function __construct() {
        
    }

    /**
     * About company action
     *
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    function page_404() {
        // render layout
        Layout::renderLayout();
    }

    /**
     * About company action
     *
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    function page_error() {
        // render layout
        
        Layout::renderLayout();
    }

    /**
     * SCSS File compiler
     * @usage Pass File Name to compile or leave blank to compile folder
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    function scss_compile() {
      
        Load::loadHelper("error");
       
        $scssHelper=new ErrorHelper();
        
        if (isset($_REQUEST['cmbFile'])) {
             $data['errors']=$scssHelper->compileFile($_REQUEST['cmbFile']);
        }

        $jsData = Layout::bufferContent(URI::getAbsModulePath()."/js/error.php");
			
	//add javascript			
        Layout::addFooter($jsData);
        
        $data['obj']=$scssHelper;
       // render layout
        Layout::renderLayout($data);
    }

}

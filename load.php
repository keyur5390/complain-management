<?php

/** Load class contains function for loading libraries,
  configuration files and all other types of files.
 */
//restrict direct access to the page
defined('DMCCMS') or die('Unauthorized access');

class Load {

    /**
     * Load all files to built application
     *
     * @return void
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function loadApplication() {
        Load::loadConfig();
        Load::loadLibrary("db.class.php", "db");
        Load::loadLibrary("MCAPI.class.php", "mailchamp");
        Load::loadLibrary("application.php");
        Load::loadLibrary("language.php");
        Load::loadLibrary("utility.php");
        Load::loadLibrary("uri.php");
        Load::loadLibrary("layout.php");
        Load::loadLibrary("string.php");
        Load::loadLibrary("core.php");
        
        Load::loadSystemHelper("system_helper");
        
        
// config database class
        DB::$host = CFG::$host;
        DB::$user = CFG::$user;
        DB::$password = CFG::$password;
        DB::$dbName = CFG::$db;
        DB::$encoding = "utf8";
// get site config data
        APP::getSiteConfig();
// get slug parts
        URI::getSlugParts();
// detect current language
        Language::detectLanguage();
//echo Language::$langCode;exit;
    }

    /**
     * Include configuration file
     *
     * @return void
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function loadConfig() {
        if (file_exists("config.php"))
            require_once("config.php");
        else
            require_once("../config.php");
    }

    /**
     * Include specified file
     *
     * @param string $filePath filepath to include
     * @return void
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function loadFile($filePath) {
// Check file is exists or not
        
        
        if (is_file($filePath) && file_exists($filePath)) {
// include file
            require_once($filePath);
            return true;
        }
        else
            return false;
    }

    /**
     * Load library file
     *
     * @param string $libName library name
     * @param string $filePath file path
     * @return void
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function loadLibrary($filePath, $libName = "") {
        $path = CFG::$absPath . "/" . CFG::$libraries . "/" . $libName . "/" . $filePath;
        return Load::loadFile($path);
    }

    /**
     * Load library file
     *
     * @param string $modName module name
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function loadModule($modName) {
        $path = URI::getAbsModulePath($modName) . "/" . $modName . ".php";
        if (!Load::loadFile($path)) {
            UTIL::setErrorMsg("Module not found", "mod_error_page_error");
            URI::set404();
        }
    }

    /**
     * Include model file of module
     * 	
     * @param string $fileName model file name
     * @param string $moduleName module name
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function loadModel($fileName, $moduleName = "") {
// create model class name
        $modelPath = URI::getAbsModulePath($moduleName) . "/" . CFG::$model . "/" . $fileName . ".php";
// load model
        if (!Load::loadFile($modelPath)) {
            UTIL::setErrorMsg("Model '" . $moduleName . "' not found", "mod_error_page_error");
            URI::setErrorPage();
        }
    }

    /**
     * return current module template path
     * 	
     * @param string $moduleName module name
     * @return string return current module template path
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function getModuleTemplate($moduleName) {
        $pagePath = URI::getAbsModulePath($moduleName) . "/" . CFG::$view . "/" . APP::$actionName . ".php";
        if (UTIL::checkFile($pagePath))
            return $pagePath;
        else {
            UTIL::setErrorMsg("Current page template not found", "mod_error_page_error");
            URI::setErrorPage();
        }
    }

    /**
     * return current template path
     * 		 
     * @return $path string 
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function getTemplate() {
        $path = URI::getAbsTemplatePath() . "/index.php";
        if (UTIL::checkFile($path))
            return $path;
        else {
            UTIL::setErrorMsg("Current application template not found", "mod_error_page_error");
            URI::setErrorPage();
        }
    }

    /**
     * return current template path
     * 	
     * @param string $moduleName 
     * @param string $blockName
     * @return $path string
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function getBlockPath($moduleName, $blockName) {
        $path = URI::getAbsBlockPath($moduleName, $blockName) . "/" . $blockName . ".php";
        if (UTIL::checkFile($path))
            return $path;
        else {
            UTIL::setErrorMsg("Block '" . $blockName . "' not found", "mod_error_page_error");
            URI::setErrorPage();
        }
    }

    /**
     * return block template path
     * 	
     * @param string $moduleName 
     * @param string $blockName 
     * @return $path string
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function getBlockTemplatePath($moduleName, $blockName) {
        $path = URI::getAbsBlockPath($moduleName, $blockName) . "/" . CFG::$view . "/" . $blockName . ".php";
        if (UTIL::checkFile($path))
            return $path;
        else {
            UTIL::setErrorMsg("Template file of block '" . $blockName . "' not found", "mod_error_page_error");
            URI::setErrorPage();
        }
    }

    /**
     * Include template class file a
     *
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function loadTemplateClass() {
        $path = URI::getAbsTemplatePath() . "/template.php";
// load template class file
        if (!Load::loadFile($path)) {
            UTIL::setErrorMsg("Template class file not found", "mod_error_page_error");
            URI::setErrorPage();
        }
    }

    /**
     * Include helper file of module
     * 	
     * @param string $fileName model file name
     * @param string $moduleName module name
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function loadHelper($fileName, $moduleName = "") {
// create model class name
        $helperPath = URI::getAbsModulePath($moduleName) . "/" . CFG::$helper . "/" . $fileName . ".php";
// load model
        if (!Load::loadFile($helperPath)) {
            UTIL::setErrorMsg("Helper '" . $fileName . "' not found", "mod_error_page_error");
            URI::setErrorPage();
        }
    }
    
        /**

     * Include system helper file
     * @param string $fileName  file name
     * @author sanjay parekh <sanjayp.datatech@gmail.com>
     * @date : [9-5-2014]

     */
    public static function loadSystemHelper($fileName) {
        
        
        if (is_array($fileName)) {
            
            
            foreach ($filename as $file) {
                $helperPath = CFG::$absPath . "/" . CFG::$helper . "/" . $file . ".php";
                
                
                // load model

                if (!Load::loadFile($helperPath)) {

                    UTIL::setErrorMsg("Helper '" . $fileName . "' not found", "mod_error_page_error");

                    URI::setErrorPage();
                }
            }
        } else {
            // create model class name
            $helperPath = CFG::$absPath . "/" . CFG::$helper . "/" . $fileName . ".php";
            // load model
            
            

            if (!Load::loadFile($helperPath)) {

                UTIL::setErrorMsg("Helper '" . $fileName . "' not found", "mod_error_page_error");

                URI::setErrorPage();
            }
        }
    }

}


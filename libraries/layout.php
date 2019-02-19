<?php

/* Create layout of application */
//restrict direct access to the page
defined('DMCCMS') or die('Unauthorized access');

class Layout {

    /** Store position data of layout
      @var $positions array
     */
    private static $positions = array();

    /** Store content of current page
      @var $content string
     */
    private static $content = "";

    /** Store content to be display in header
      @var $header array
     */
    private static $header = array();

    /** Store content to be display in footer
      @var $footer array
     */
    private static $footer = array();

    /** Store module content 
      @var $moduleData mixed
     */
    public static $moduleData = array();

    /** Store list of all group of file.
      @var $groupFiles Array
     */
    public static $groupFiles = array();

    /**
     * render layout of application
     * 
     * @param array $data 
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function renderLayout($data = array()) {
// store module data in globle variable
        Layout::$moduleData = $data;
// load current module template
        $moduleTemplate = Load::getModuleTemplate(APP::$moduleName);
// load all blocks
        APP::loadBlocks();
// buffer current module template
        Layout::$content = Layout::bufferContent($moduleTemplate, $data);
// combine js and css
        Layout::combineFiles();
// set metadata of page
        Layout::setMetaData();
// get current template
        $templatePath = Load::getTemplate();
// buffer current template
        $template = Layout::bufferContent($templatePath);
// Set utf-8 content type for localisation
        header('Content-Type: text/html; charset=utf-8');
        echo $template;
    }

    /**
     * load page and buffer it
     * 
     * @param array $pagePath page path 
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function bufferContent($pagePath, $data = "") {
        $bufferOutput = "";
        
        
// start buffering
        ob_start();
// load page
         if(isset($_GET['debug']) == "dm"){
                echo $pagePath;
            }
        require_once($pagePath);
// get buffer content
        $bufferOutput = ob_get_contents();
// end buffer
        ob_end_clean();
        return $bufferOutput;
    }

    /**
     * return current module content
     * 		 
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function getModuleData() {
        return Layout::$content;
    }

    /**
     * return position content
     * 		 
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function getPosition($position) {
        $positionData = "";
        
        if (isset(Layout::$positions[$position])) {
           
            foreach (Layout::$positions[$position] as $posData)
                $positionData .= $posData;
            
        }
        
 
        return $positionData;
    }

    /**
     * set position content
     * 		 
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function setPosition($position, $data) {
        Layout::$positions[$position][] = $data;
        
    }

    /**
     * check whether position have block or not
     * 		 
     * @return bool return true or false
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function checkPosition($position) {
        return isset(Layout::$positions[$position]);
    }

    /**
     * Add content into header variable
     * 
     * @param string $str
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function addHeader($str) {
        Layout::$header[] = $str;
    }

    /**
     * Display content of header variable
     * 
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function displayHeader() {
        foreach (Layout::$header as $row) {
            echo $row . "\r\n";
        }
    }

    /**
     * Add content into footer variable
     * 
     * @param string $str
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function addFooter($str) {
        Layout::$footer[] = $str;
    }

    /**
     * Display content of footer variable
     * 
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function displayFooter() {
        foreach (Layout::$footer as $row) {
            echo $row . "\r\n";
        }
    }

    /**
     * Set meta data of page (meta content,favicon icon, extra seo content)
     *
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function setMetaData() {
        $metaData = array();
//set favicon icon

        $metaData[] = '<link rel="shortcut icon" href="' . URI::getLiveTemplatePath() . "/images/favicon.ico" . '" type="image/x-icon" /> ';
// set meta for admin section
        if (APP::$appType == "admin") {
            $title = APP::$moduleRecord['name'] . ((trim(APP::$actionRecord['name']) != "") ? " - " . APP::$actionRecord['name'] : "");
            $metaData[] = Core::setMeta($title, $title, $title);
        } else {
            $curRecord = "";
            if (isset(Layout::$moduleData['data']) && isset(Layout::$moduleData['data']->records)) {
                $curRecord = Layout::$moduleData['data']->records;
            }
// check that current page record have meta or not
            if (Core::checkMeta($curRecord) == true)
                $metaData[] = Core::setMeta($curRecord['meta_title'], $curRecord['meta_description'], $curRecord['meta_keyword']);
            else if (Core::checkMeta(APP::$actionRecord) == true) // set action meta					
                $metaData[] = Core::setDynamicMeta(APP::$actionRecord['meta_title'], APP::$actionRecord['meta_description'], APP::$actionRecord['meta_keyword']);
            else // set global meta
                $metaData[] = Core::setMeta(CFG::$siteConfig['site_meta_title'], CFG::$siteConfig['meta_description'], CFG::$siteConfig['meta_keyword']);
        }
        if (APP:: $appType == "front") {
            $metaData[] = CFG::$siteConfig['seo_header_content'];
        }
        Layout::$header = array_merge($metaData, Layout::$header);
        if (APP:: $appType == "front") {
            Layout::addFooter(CFG::$siteConfig['seo_footer_content']);
        }
    }

    /** Create group of files with its position
     *
     * @param string $groupName name of the group
     * @param string $fiePath physical path of file
     * @param string $groupType type of the group "js" or "css"
     * @param string $position position of file "header" or "footer"
     *
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function groupFiles($groupName, $filePath, $groupType, $position) {
// set position of current file and group
        Layout::$groupFiles[$groupType][$groupName]["position"] = $position;
// store file path if not exists
        if (@in_array($filePath, Layout::$groupFiles[$groupType][$groupName]['files']) == false)
            Layout::$groupFiles[$groupType][$groupName]['files'][] = $filePath;
    }

    /** Combines JS and css files if $mergeFiles flag is true
     * 
     *  @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function combineFiles() {
// loop through group types
        foreach (Layout::$groupFiles as $typeKey => $groupType) {
// loop through groups
            foreach ($groupType as $groupName => $group) {
                $position = "add" . ucfirst($group["position"]);
                if (CFG::$mergeFiles == true) {
                    if (!file_exists(URI:: getAbsTemplatePath() . "/" . CFG::$mergeDir . "/" . $groupName . "." . $typeKey)) {      // check cache file exists or not. Create cache file if not existing
// create file for current group
                        $fn = fopen(URI:: getAbsTemplatePath() . "/" . CFG::$mergeDir . "/" . $groupName . "." . $typeKey, "a+");
                        foreach ($group["files"] as $file) {
                            fwrite($fn, file_get_contents($file) . "\r\n\r\n\r\n\r\n");        // store content of currrent file in cache
                        }
                        fclose($fn);
                    }
                    if ($typeKey == "js")
                        Layout::$position('<script src="' . URI:: getLiveTemplatePath() . "/" . CFG::$mergeDir . "/" . $groupName . "." . $typeKey . '" type="text/javascript"></script>'); // include cache js file
                    else
                        Layout::$position('<link rel="stylesheet" href="' . URI:: getLiveTemplatePath() . "/" . CFG::$mergeDir . "/" . $groupName . "." . $typeKey . '" type="text/css"/>'); // include cache css file
                }
                else {    // include file individualy if cache is not enabled
                    foreach ($group["files"] as $file) {
                        if ($typeKey == "js")
                            Layout::$position('<script src="' . CFG::$livePath . str_replace(CFG::$absPath, "", $file) . '" type="text/javascript"></script>'); // include actual js file
                        else
                            Layout::$position('<link rel="stylesheet" href="' . CFG::$livePath . str_replace(CFG::$absPath, "", $file) . '" type="text/css"/>'); // include actual css file
                    }
                }
            }
        }
    }

}
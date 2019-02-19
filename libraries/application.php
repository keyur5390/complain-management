<?php

//restrict direct access to the page
defined('DMCCMS') or die('Unauthorized access');

class APP {

    /** Store current module name
      @var $moduleName string
     */
    public static $moduleName;

    /** Store current action name
      @var $actionName string
     */
    public static $actionName;

    /** Store current id
      @var $curId int
     */
    public static $curId;

    /** Store current url slug
      @var $urlSlug string
     */
    public static $urlSlug;

    /** store current application is admin or not
      @var $isAdmin string
     */
    public static $appType;

    /** Store current action id
      @var $actionId string
     */
    public static $actionId;

    /** Store access type of an action
      @var $actionId string
     */
    public static $accessType;

    /** Store action record
      @var $actionRecord array
     */
    public static $actionRecord;

    /** Store module record
      @var $moduleRecord array
     */
    public static $moduleRecord;

    /** Store slug part
      @var $slugParts array
     */
    public static $slugParts = array();

    /**
     * Create application
     *
     * @param string $type application type can get "admin". default value is null. its represent front end
     * @return void
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function createApplication($type = "front") {
        APP::$appType = $type;
// set current slug if sef url is enabled
        if (CFG::$sef == true && APP::$appType == "front")
            APP::$urlSlug = URI::getURLSlug();
// build application
        APP::buildeApplication();
    }

    /**
     * Build application
     *
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function buildeApplication() {
        
        
// Set module and action		
        APP::setModuleAction();
        
        
// Set module and action
        APP::checkPermission();
        
        
// Load module and create its object
        $objModule = APP::loadModule();
        
        
// load template and module language file language file
        Language::loadLanguage();
        
        //echo '1212458';exit;
// load and include template class
        Load::loadTemplateClass();
// set template
        Template::setTemplate();
// call action
        APP::exicuteAction($objModule);
    }

    /**
     * Get current module name
     *
     * @return module name
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    private static function setModuleAction() {
//        
        
// if sef url then get it from slug record		
        if (isset(URI::$slugRecord['module_key'])) {
            APP::$moduleName = URI::$slugRecord['module_key'];
            if (URI::$slugRecord['action_id'] == 0) {
                APP::$actionName = "view_entity";
//get action record
                APP::$actionRecord = DB::queryFirstRow("SELECT id,name,action,parent_action,default_action,action_type,admin_menu,admin_menu_label,access_type,meta_title,meta_keyword,meta_description,field_variables FROM " . CFG::$tblPrefix . "module_action WHERE module_key=%s and action=%s limit 1", APP::$moduleName, APP::$actionName);
// set action id
                APP::$actionId = APP::$actionRecord['id'];
// set access type
                APP::$accessType = APP::$actionRecord['access_type'];
            } else {
// set action id
                APP::$actionId = URI::$slugRecord['action_id'];
// get action record
                APP::$actionRecord = DB::queryFirstRow("SELECT action,name,parent_action,default_action,action_type,admin_menu,admin_menu_label,access_type,meta_title,meta_keyword,meta_description,field_variables FROM " . CFG::$tblPrefix . "module_action WHERE id=%d limit 1", URI::$slugRecord['action_id']);
                APP::$actionName = APP::$actionRecord['action'];
                APP::$accessType = APP::$actionRecord['access_type'];
            }
            if (URI::$slugRecord['entity_id'] != '')
                APP::$curId = URI::$slugRecord['entity_id'];
        }
        else if (isset($_GET['m'])) { // get module and action from url
            APP::$moduleName = UTIL::escapModule(urldecode($_GET['m']));
            if (isset($_GET['a']))
                APP::$actionName = UTIL::escapModule(urldecode($_GET['a']));
// check requested module and action is exists or not
            APP::$actionRecord = DB::queryFirstRow("SELECT id,name,module_key,action,parent_action,default_action,action_type,admin_menu,admin_menu_label,access_type,meta_title,meta_keyword,meta_description,field_variables FROM " . CFG::$tblPrefix . "module_action WHERE module_key=%s and action=%s and (action_type=%s or action_type=%s) limit 1", APP::$moduleName, APP::$actionName, APP::$appType, "both");
            if (!is_array(APP::$actionRecord))
                URI::set404();
            if (is_array(APP::$actionRecord)) {
// set action id
                APP::$actionId = APP::$actionRecord['id'];
// set module
                APP::$moduleName = APP::$actionRecord['module_key'];
// set action
                APP::$actionName = APP::$actionRecord['action'];
// set action access type
                APP::$accessType = APP::$actionRecord['access_type'];
// set id
                if (isset($_GET['id']) && $_GET['id'] != '')
                    APP::$curId = ((int) $_GET['id']) ? (int) $_GET['id'] : "";
                else if (isset(APP::$actionRecord['entity_id']))
                    APP::$curId = APP::$actionRecord['entity_id'];
            }
            else {
                echo "Record not found";
                exit;
            }
        } else { // load home page otherwise
            $moduleRecord = "";
// if application is front end then check menu for home page
            if (APP::$appType == "front") {
                $moduleRecord = DB::queryFirstRow("SELECT ma.id,ma.name,ma.module_key,ma.action,mi.entity_id,ma.parent_action,ma.default_action,ma.action_type,ma.admin_menu,ma.admin_menu_label,ma.access_type,ma.meta_title,ma.meta_keyword,ma.meta_description,ma.field_variables FROM " . CFG::$tblPrefix . "menu_items mi," . CFG::$tblPrefix . "module_action as ma WHERE ma.id=mi.action_id and mi.status='1' and mi.deleted='0' and mi.external_link='' and mi.is_home='1' limit 1");
            }
// get home page record from database;			
            if (!is_array($moduleRecord)) {
                $moduleRecord = DB::queryFirstRow("SELECT id,name,module_key,action,parent_action,default_action,action_type,admin_menu,admin_menu_label,access_type,meta_title,meta_keyword,meta_description,field_variables FROM " . CFG::$tblPrefix . "module_action WHERE default_action=%s limit 1", APP::$appType);
            }
            if (is_array($moduleRecord)) {
// set action id
                APP::$actionId = $moduleRecord['id'];
// set home page module
                APP::$moduleName = $moduleRecord['module_key'];
// set home page action
                APP::$actionName = $moduleRecord['action'];
// set action access type
                APP::$accessType = $moduleRecord['access_type'];
// set entity id if exists
                if (isset($moduleRecord['entity_id']))
                    APP::$curId = $moduleRecord['entity_id'];
                APP::$actionRecord = $moduleRecord;
            }
            else {
                /*
                 * Following Redirection Code For Redirect to Admin Login Page
                 * 
                 * @author Mayur Patel<mayur.datatech@gmail.com>
                 */
                UTIL::redirect(CFG::$livePath."/myAdmin/index.php?m=mod_complain&a=complain_list");
                
               // UTIL::redirect(CFG::$livePath."/myAdmin/");
                
                echo "Record not found";
                exit;
            }
        }
// set module record
        APP::$moduleRecord = DB::queryFirstRow("SELECT id,name,module_key,icon_class,module_table FROM " . CFG::$tblPrefix . "modules WHERE module_key=%s limit 1", APP::$moduleName);
    }

    /**
     * load current module
     *
     * @return module object
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function loadModule() {
// Load module controller
        Load::loadModule(APP::$moduleName);
// get module class name
        $className = UTIL::getClassName(APP::$moduleName);
        return UTIL::getClassObject($className);
    }

    /**
     * Execute requested action
     *
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function exicuteAction($objModule) {
        if (method_exists($objModule, APP::$actionName)) {
            call_user_func(array($objModule, APP::$actionName));
        } else {
            UTIL::setErrorMsg("'" . APP::$actionName . "' action not found", "mod_error_page_error");
            URI::setErrorPage();
        }
    }

    /**
     * Load all blocks
     *
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function loadBlocks() {
//get all common blocks
        $commonModule = DB::query("SELECT module_key,name,position,block_key,access_type FROM " . CFG::$tblPrefix . "block WHERE visible=%s and block_type=%s and status=%s", 'All', APP::$appType, '1');
//get action specific blocks
        $specificModule = DB::query("SELECT b.module_key,b.name,ba.position,b.block_key,b.access_type FROM " . CFG::$tblPrefix . "block as b," . CFG::$tblPrefix . "block_action as ba WHERE b.id=ba.block_id and b.visible=%s and b.block_type=%s and b.status=%s and ba.action_id=%d", 'Selected', APP::$appType, '1', APP::$actionId);
//get exclude blocks
        $excludModule = DB::query("SELECT module_key,name,position,block_key,access_type FROM " . CFG::$tblPrefix . "block WHERE visible=%s and block_type=%s and status=%s and id not in (select b.id from " . CFG::$tblPrefix . "block as b," . CFG::$tblPrefix . "block_action as ba where b.id=ba.block_id and visible=%s and block_type=%s and status=%s and ba.action_id=%d)", 'Exclude', APP::$appType, '1', 'Exclude', APP::$appType, '1', APP::$actionId);
// combine all blocks
        $blockList = array_merge($commonModule, $specificModule, $excludModule);
        foreach ($blockList as $block) {
            if ($block['access_type'] == "private" && !UTIL::isUserLogin())
                continue;
// get block path
            $blockPath = Load::getBlockPath($block['module_key'], $block['block_key']);
// include block file
            require_once($blockPath);
// get block class name
            $blockClass = "Block" . UTIL::getClassName($block['block_key']);
// get block object
            $objBlock = UTIL::getClassObject($blockClass);
// process block data
            $blockData = $objBlock->process();
            
// get block template
            $tplPath = Load::getBlockTemplatePath($block['module_key'], $block['block_key']);
//render block	
            Layout::setPosition($block['position'], Layout::bufferContent($tplPath, $blockData));
        }
    }

    /**
     * Check user permission for perticullar action
     *
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function checkPermission() {
// if action's access type is private then check user's access permission
        if (APP::$accessType == "private") {
// check user is logged in or not
            if (isset($_SESSION['user_login'])) {
//echo "<pre>";
//print_r($_SESSION['user_login']); exit; 
// check user is super administrator or not
                if ($_SESSION['user_login']['access_level'] == 'all') {
// do nothing
                } else if ($_SESSION['user_login']['access_level'] == APP::$appType && $_SESSION['user_login']['access_type'] == 'all') { // check application level access of user. eg. front or admin
// do nothing
                } else if ($_SESSION['user_login']['access_type'] == 'selected') {
					
                    if (in_array(APP::$actionId, $_SESSION['user_login']['action']) == false)
                        UTIL::invalidAccess();
                }
                else if ($_SESSION['user_login']['access_type'] == 'exclude') {
                    if (in_array(APP::$actionId, $_SESSION['user_login']['action']) == true)
                        UTIL::invalidAccess();
                }
                else
                    UTIL::invalidAccess();
            }
            else
                UTIL::doLogin();
        }
    }

    /*
     * get site config data from database
     *
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */

    public static function getSiteConfig() {
        $sitConfigData = DB::query("SELECT config_key,config_value FROM " . CFG::$tblPrefix . "configuration ");
        foreach ($sitConfigData as $key => $val) {
            CFG::$siteConfig[$val['config_key']] = $val['config_value'];
        }
    }

}


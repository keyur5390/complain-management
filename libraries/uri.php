<?php

//restrict direct access to the page
defined('DMCCMS') or die('Unauthorized access');

class URI {

    /** Store current slug record
      @var $slugRecord array
     */
    public static $slugRecord;

    /**
     * Get current slug from url
     *
     * @return slug
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function getURLSlug() {
        $urlSlug = "";
        if (isset(APP::$slugParts[0]))
            $urlSlug = UTIL::getURLString(urldecode(APP::$slugParts[0])); // Remove unwanted characters from slug
        if ($urlSlug != "" && $urlSlug != "index-php") {
// find slug in database to get module and action detail
            URI::$slugRecord = DB::queryFirstRow("SELECT module_key,slug,action_id,entity_id FROM " . CFG::$tblPrefix . "slug WHERE slug=%s limit 1", $urlSlug);
// if requested slug not found than check for old slug
            if (!is_array(URI::$slugRecord)) {
// check for old slug
                $oldSlugData = DB::queryFirstRow("SELECT module_key,slug,action_id,entity_id FROM " . CFG::$tblPrefix . "slug WHERE old_slug=%s limit 1", $urlSlug);
// if slug found in old slug then make 301 redirect to new slug
                if (is_array($oldSlugData)) {
                    $newSlugUrl = URI::getURLFromSlug($oldSlugData['slug']);
                    UTIL::parmenentRedirect($newSlugUrl);
                }
// load 404 page if slug is not found in database.
                URI::$slugRecord = URI::set404();
            }
            $urlSlug = URI::$slugRecord['slug'];
        }
        return $urlSlug;
    }

    /* Get all slugs from URL
     *
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */

    public static function getSlugParts() {
// get base directory from live path
        $baseDir = substr(CFG::$livePath, strpos(CFG::$livePath, $_SERVER['HTTP_HOST']) + strlen($_SERVER['HTTP_HOST']));
// remove query string from request URL
        $_SERVER['REQUEST_URI'] = str_replace("?" . $_SERVER['QUERY_STRING'], "", $_SERVER['REQUEST_URI']);
// get slug parts
        APP::$slugParts = explode("/", trim(str_replace($baseDir, "", $_SERVER['REQUEST_URI']), "/"));
// check base directory in live URL
//if(strpos(CFG::$livePath,$baseDir) == true)
//else
        /* $requestURL = $_SERVER['REQUEST_URI'];
          $pos = strpos($requestURL,"?");
          // remove query string variables
          if($pos !== false)
          $requestURL = substr($requestURL,0,$pos);
          // for local server
          if(strpos(CFG::$livePath,"/",strpos(CFG::$livePath,".")) !== false)
          {
          $rootFolders = substr(CFG::$livePath,strpos(CFG::$livePath,"/",strpos(CFG::$livePath,".")));
          // remove root direcories after host
          $requestURL = str_replace($rootFolders."/",'',$requestURL);
          APP::$slugParts = explode("/",$requestURL);
          }
          else // for live server
          {
          $requestURL = substr($requestURL,1);
          APP::$slugParts = explode("/",$requestURL);
          } */
    }

    /**
     * redirect to 404 page
     *
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function set404() {
// set 404 module name and action name	
        $_GET['m'] = 'mod_error';
        $_GET['a'] = 'page_404';
// set 404 status code
        header("HTTP/1.0 404 Not Found");
// build application
        APP::buildeApplication();
//$url = URI::getURL("mod_error","page_404");
//UTIL::redirect($url);			
    }

    /**
     * do redirect to error page
     *
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function setErrorPage() {
        $url = URI::getURL("mod_error", "page_error");
        UTIL::redirect($url);
    }

    /**
     * Return url from slug
     *
     * @return $url
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function getURLFromSlug($slug) {
        return CFG::$livePath . "/" . $slug;
    }

    /**
     * return url. use this function for setting url in both front-end and back-end
     *
     * @param string $moduleName name of module
     * @param string $actionName name of action
     * @param int $id optional parameter. id of an entity
     * @param string $param optional parameter.
     * @param array $slugPart use in SEF URL. Pass all additional slugs to add in URL
     * @return $url string
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function getURL($moduleName, $actionName, $id = "", $param = "", $slugPart = array()) {
        
		$url = "";
// check whether action is home page or not
        if (UTIL::isHome($moduleName, $actionName)) {
		
            if (APP::$appType == "front")
                $url = CFG::$livePath;
            else if (APP::$appType == "admin")
                $url = CFG::$livePath . "/" . CFG::$baseDir . "/";
        }
        else {
				
            if (trim($moduleName) != "" && trim($actionName) != "") {
// create sef url
                if (CFG::$sef == true && APP::$appType != "admin") {
// build query to find slug of an action
                    $query = "SELECT s.slug FROM " . CFG::$tblPrefix . "slug as s," . CFG::$tblPrefix . "module_action as ma WHERE s.action_id=ma.id and ma.module_key=%s and ma.action=%s ";
                    if (trim($id) != "") {
                        $query .= " and s.entity_id=%d";
                        $urlData = DB::queryFirstRow($query, $moduleName, $actionName, $id);
                    }
                    else
                        $urlData = DB::queryFirstRow($query, $moduleName, $actionName);
                    $strSlugPart = ((count($slugPart) == 0) ? "" : "/" . implode("/", $slugPart));
                    if (Language::$isDefault == 0 && CFG::$langURL == true)  // pass language code in URL if its enable and not default language
                        $url = CFG::$livePath . "/" . Language::$langCode . "/" . $urlData['slug'] . $strSlugPart;
                    else
                        $url = CFG::$livePath . "/" . $urlData['slug'] . $strSlugPart;
                    if (trim($param) != "")
                        $url .= "?" . $param;
                }
                else {
// create non sef url for front end
                    $url = "index.php?m=" . $moduleName . "&a=" . $actionName;
                    if (trim($id) != "")
                        $url .= "&id=" . $id;
                    if (trim($param) != "")
                        $url .= "&" . $param;
                    if (Language::$isDefault == 0 && CFG::$langURL == true)  // pass language code in URL if its enable and not default language
                        $url .= "&lang=" . Language::$langCode;
                    if (APP::$appType == "admin")
                        $url = CFG::$livePath . "/" . CFG::$baseDir . "/" . $url;
                    else
                        $url = CFG::$livePath . "/" . $url;
                }
            }
            else {
                $url = "";
            }
        }
        return $url;
    }

    /**
     * return absolute or live path
     * 	
     * @param string $path 
     * @param string $type type of path absolute or live
     * @return $path string
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function getPath($path, $type = "abs") {
        $prefix = CFG::$absPath;
        if ($type == "live")
            $prefix = CFG::$livePath;
        return $prefix . "/" . $path;
    }

    /**
     * return specific module absolute path if passed in parameter else return current module path
     * 	
     * @param string $moduleName module name
     * @return $path string
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function getAbsModulePath($moduleName = "") {
        if (trim($moduleName) == "")
            $moduleName = APP::$moduleName;
        return URI::getPath(CFG::$modules . "/" . $moduleName);
    }

    /**
     * return specific module live path if passed in parameter else return current module path
     * 	
     * @param string $moduleName module name
     * @return $url string
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function getLiveModulePath($moduleName = "") {
        if (trim($moduleName) == "")
            $moduleName = APP::$moduleName;
        return URI::getPath(CFG::$modules . "/" . $moduleName, "live");
    }

    /**
     * return specific block absolute path
     * 	
     * @param string $moduleName module name
     * @param string $blockName module name
     * @return $path string
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function getAbsBlockPath($moduleName, $blockName) {
        $path = "";
        if (trim($moduleName) != "" && trim($blockName) != "") {
            $path = URI::getAbsModulePath($moduleName) . "/" . CFG::$block . "/" . $blockName;
        }
        return $path;
    }

    /**
     * return specific block live path
     * 	
     * @param string $moduleName module name
     * @param string $blockName module name
     * @return $url string
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function getLiveBlockPath($moduleName, $blockName) {
        $path = "";
        if (trim($moduleName) != "" && trim($blockName) != "") {
            $path = URI::getLiveModulePath($moduleName) . "/" . CFG::$block . "/" . $blockName;
        }
        return $path;
    }

    /**
     * return current template's absolute path
     * 	
     * @return $path string
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function getAbsTemplatePath() {
        return CFG::$absPath . "/" . CFG::$templates . "/" . APP::$appType;
    }

    /**
     * return current template's live path
     * 		
     * @return $url string
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function getLiveTemplatePath() {
        return CFG::$livePath . "/" . CFG::$templates . "/" . APP::$appType;
    }

    /**
     * return media folder live path
     * 		
     * @param string $subPath inner direcroty path
     *
     * @return $url string
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function getAbsMediaPath($subPath = "") {
        if (trim($subPath) == "")
            return CFG::$absPath . "/" . CFG::$mediaDir;
        else
            return CFG::$absPath . "/" . CFG::$mediaDir . "/" . $subPath;
    }

    /**
     * return media folder live path
     * 		
     * @param string $subPath inner direcroty path
     *
     * @return $url string
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function getLiveMediaPath($subPath = "") {
        if (trim($subPath) == "")
            return CFG::$livePath . "/" . CFG::$mediaDir;
        else
            return CFG::$livePath . "/" . CFG::$mediaDir . "/" . $subPath;
    }
    
 /*
  * return url with slug
  * @param $modName current module name
  * @param $actionName  current action name
  * @param $catSlug page table slug
  * 
  * @author: Ratan rabari , vishal vasani data:12-08-2016 
  */   
    public static function getCustomURL($modName,$actionName,$catSlug,$subCat='') {
        $urlData = URI::getURL($modName, $actionName);
      //  echo $urlData;exit;
        
        $url = $urlData . "/" . UTIL::getURLString($catSlug);
        
        //echo $url;exit;
        if($subCat!=''){
            $url .= "/".UTIL::getURLString($subCat);
        }
     return $url;
}

}


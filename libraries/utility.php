<?php
/**
  This is utility class contains general operation function for site.
 */
//restrict direct access to the page
defined('DMCCMS') or die('Unauthorized access');

class UTIL {

    /**
     * Remove all special characters and replace "_" with "-" from string. It use while creating slug
     *
     * @param string $string
     * @return string
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    static function getURLString($string) {
        if ($string) {
            $string = preg_replace("`\[.*\]`U", "", $string);
            $string = preg_replace('`&(amp;)?#?[a-z0-9]+;`i', '-', $string);
            $string = htmlentities($string, ENT_COMPAT, 'utf-8');
            $string = preg_replace("`&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);`i", "\\1", $string);
            $string = preg_replace(array("`[^a-z0-9]`i", "`[-]+`"), "-", $string);
        }
        return strtolower(trim($string, '-'));
    }

    /**
     * Remove all special characters and space from string it allows underscore only
     *
     * @return string
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function escapModule($slug) {
        return preg_replace("`[^a-zA-Z0-9_]`", "", $slug);
    }
    
    /*
     * author: Vishal Vasani date:31-08-2016 subscribe email mailchimp
     * $email email address
     * @return message
     */
    
    public static function subscribeEmail($email) {
        $apikey = CFG::$siteConfig['apikey'];
        
        $listId = CFG::$siteConfig['listid'];
        
        $api = new MCAPI($apikey);
        
         $emailadd = $email;
         
         $retval = $api->listSubscribe($listId, $emailadd, '', '', true);
         
         if ($api->errorCode) {
            $valid = "Some error occurred while subscribing";
} else {
            $valid = "Subscription has been done successfully";
}

return $valid;
  }

    /**
     * Do 301 redirect
     *
     * @param string $url
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function parmenentRedirect($url) {
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: " . $url);
        exit;
    }

    /**
     * Do redirect
     *
     * @param string $url
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function redirect($url) {
        header("Location: " . $url);
        exit;
    }

    /**
     * Grab module class name from module name
     * 	 
     * @param string $module module name
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function getClassName($module) {
        $arrName = explode("_", $module);
        if (isset($arrName[1]) && !empty($arrName[1]))
            return ucfirst($arrName[1]);
        else {
            UTIL::setErrorMsg("Class name not found", "mod_error_page_error");
            URI::setErrorPage();
        }
    }

    /**
     * Check whether file is exists or not
     * 	 
     * @param string $filePath 
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function checkFile($filePath) {
        if (is_file($filePath) && file_exists($filePath))
            return true;
        else
            return false;
    }

    /**
     * return class object if class exists
     * 	 
     * @param string $className name of class
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function getClassObject($className) {
        if (class_exists($className))
            return new $className;
        else {
            UTIL::setErrorMsg("'" . $className . "' class not found", "mod_error_page_error");
            URI::setErrorPage();
        }
    }

    /**
     * return base directory name of path
     * 	 
     * @param string $path path to the directory
     * @return directory name
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function getBaseDir($path) {
        $arrTemp = explode(DIRECTORY_SEPARATOR, $path);
        return $arrTemp[count($arrTemp) - 1];
    }

    /**
     * set error message in session
     * 	 
     * @param string $sessionName session name variable
     * @param string $msg message
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function setErrorMsg($msg, $sessionName = "") {
        if (trim($sessionName) != "")
            $_SESSION[$sessionName] = $msg;
        else {
            $_SESSION[APP::$moduleName . "_" . APP::$actionName] = $msg;
        }
    }

    /**
     * return error message of specific session variable
     * 	 
     * @param string $sessionName session name variable. optional variable. if not set session name will build using module and action name 
     * @param bool $unset if set to 1 session will unset
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function getErrorMsg($sessionName = "", $unset = 0) {
        $msg = "";
        if (trim($sessionName) == "")
            $sessionName = APP::$moduleName . "_" . APP::$actionName;
        if (isset($_SESSION[$sessionName])) {
            $msg = $_SESSION[$sessionName];
//unset session if specify
            if ($unset == 1)
                unset($_SESSION[$sessionName]);
        }
        return $msg;
    }

    /**
     * raise permission denied error message and redirect to error page
     * 	 
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function invalidAccess() {
        UTIL::setErrorMsg("Permission denied, you are not allowed to access this page", "mod_error_page_error");
        URI::setErrorPage();
    }

    /**
     * Check user is logged in or not
     * 	 
     * @return boolean
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function isUserLogin() {
        if (isset($_SESSION['user_login']['username']) && trim($_SESSION['user_login']['username']) != "")
            return true;
        else
            return false;
    }

    /**
     * Redirect to login page
     * 	 
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function doLogin() {
        $returnUrl = "";
        if(isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING'])){
            $returnUrl = "returnURL=".  base64_encode($_SERVER['QUERY_STRING']);  //encode the query string
        }
        UTIL::redirect(URI::getURL("mod_user", APP::$appType . "_login", '', $returnUrl));
    }

    /**
     * use for paging
     * 
     * @param string $recordCountVar
     * @param string $fields contains list of comma seperated fields e.g. id,name,description
     * @param string $tables contains table detail e.g tbl_page as p, tbl_customer as c
     * @param string $where contains conditions e.g. id=2, name like '%a%'
     * @param string $order specify sort order e.g. created_date desc, sort_order desc
     * 
     * @return boolean
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function doPaging($recordCountVar, $fields, $tables, $where = "", $whereParam = array(),$order = "", $groupBy="") {
        
        if (trim($fields) != "" && trim($tables) != "") {
          //  print_r($_GET);
            if (isset($_GET['start']) && $_GET['start'] != "") {
                
              //   print_r($_GET);exit;
                $start = (int) $_GET['start'];
                $end = (int) $_GET['end'];
                $sql = "select " . $fields . " from " . $tables;
                if (trim($where) != "")
                    $sql .= " where " . $where;
                if (trim($groupBy))
                    $sql .= " group by " . $groupBy;
                if (trim($order))
                    $sql .= " order by " . $order;
                $sql .= " LIMIT " . $start . ", " . ($end - $start);
                
//DB::debugMode();
              
                $sqlData = DB::query($sql, $whereParam);
// store current state in session
                UTIL::storeCurrentState();
                if (isset($_GET['getCount']) && $_GET['getCount'] == 1)
                    echo json_encode(array("result" => "success", "records" => $sqlData, "totalRecords" => UTIL::dataCount($tables, $where, $whereParam)));
                else
                    echo json_encode(array("result" => "success", "records" => $sqlData));
                exit;
            }
            else {
                
                
                Layout::addFooter('<script type="text/javascript">var ' . $recordCountVar . ' = ' . UTIL::dataCount($tables, $where, $whereParam) . '</script>');
                UTIL::resetOldState();
            }
        }
        return false;
    }

    /**
     * return total no of records for given query
     * 
     * @param string $tables contains table detail e.g tbl_page as p, tbl_customer as c
     * @param string $where contains conditions e.g. id=2, name like '%a%'
     * 
     * @return integer
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function dataCount($tables, $where, $whereParam) {
        $sql = "select count(*) as recordCount from " . $tables;
        if (trim($where) != "")
            $sql .= " where " . $where;
        $sqlData = DB::query($sql, $whereParam);
        return isset($sqlData[0]['recordCount']) ? $sqlData[0]['recordCount'] : 0;
    }

    /**
     * Store current searching and sorting state in session
     *
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function storeCurrentState() {
        
//        echo $_SESSION[APP::$appType][APP::$moduleName . "_" . APP::$actionName]['start'] = $_GET['start'];exit;
        $_SESSION[APP::$appType][APP::$moduleName . "_" . APP::$actionName]['start'] = $_GET['start'];
        $_SESSION[APP::$appType][APP::$moduleName . "_" . APP::$actionName]['end'] = $_GET['end'];
        $_SESSION[APP::$appType][APP::$moduleName . "_" . APP::$actionName]['page'] = $_GET['page'];
        
        
        
        
// store search form data in session
        if (isset($_GET['searchForm']))
            $_SESSION[APP::$appType][APP::$moduleName . "_" . APP::$actionName]['searchForm'] = $_GET['searchForm'];
        else
            unset($_SESSION[APP::$appType][APP::$moduleName . "_" . APP::$actionName]['searchForm']); // unset search criteria is not set
// store sort order data in session	
        if (isset($_GET['o_type'])) {
            $_SESSION[APP::$appType][APP::$moduleName . "_" . APP::$actionName]['o_type'] = $_GET['o_type'];
            $_SESSION[APP::$appType][APP::$moduleName . "_" . APP::$actionName]['o_field'] = $_GET['o_field'];
        } else {
            unset($_SESSION[APP::$appType][APP::$moduleName . "_" . APP::$actionName]['o_type']);
            unset($_SESSION[APP::$appType][APP::$moduleName . "_" . APP::$actionName]['o_field']);
        }
    }

    /**
     * Store old page state in javascript object
     *
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function resetOldState() {
        
        if (isset($_SESSION[APP::$appType][APP::$moduleName . "_" . APP::$actionName]['start'])) {
            //echo 'zzz';exit;
            $sortVar = "";
            $searchVar = "";
// set javascript variable for sorting
            if (isset($_SESSION[APP::$appType][APP::$moduleName . "_" . APP::$actionName]['o_type'])) {
                $sortVar = '
o_type:"' . $_SESSION[APP::$appType][APP::$moduleName . "_" . APP::$actionName]['o_type'] . '",
o_field:"' . $_SESSION[APP::$appType][APP::$moduleName . "_" . APP::$actionName]['o_field'] . '"
';
            }
// set javascript variable for searching
            if (isset($_SESSION[APP::$appType][APP::$moduleName . "_" . APP::$actionName]['searchForm'])) {
                foreach ($_SESSION[APP::$appType][APP::$moduleName . "_" . APP::$actionName]['searchForm'] as $key => $val) {
                    $searchVar .= $key . ':"' . $val . '",';
                }
                $searchVar = ' searchData:{searchForm:{' . $searchVar . '}},';
            }
            $resetState = '
<script type="text/javascript">
var oldPageState = {													
start:' . $_SESSION[APP::$appType][APP::$moduleName . "_" . APP::$actionName]['start'] . ',
end:' . $_SESSION[APP::$appType][APP::$moduleName . "_" . APP::$actionName]['end'] . ',
curPage:' . $_SESSION[APP::$appType][APP::$moduleName . "_" . APP::$actionName]['page'] . ',
' . $searchVar . '
' . $sortVar . '
};
</script>
';
            Layout::addFooter($resetState);
        } else {
            $resetState = '
<script type="text/javascript">
var oldPageState = "";
</script>
';
            Layout::addFooter($resetState);
        }
    }

    /**
     * Initialize tinmce and kcfinder js plugin
     *
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function loadEditor() {
        $livePath = URI::getLiveTemplatePath();
        $_SESSION['editorPath'] = $livePath . "/plugins/tiny_mce";
        $_SESSION['editorFilePath'] = URI::getLiveMediaPath(CFG::$editorImgDir);
        echo '<script type="text/javascript">var editorPath = "' . $livePath . '"</script>';
        echo '<script type="text/javascript" src="' . $livePath . '/js/formJs.js"></script>';
    }

    public static function loadTinymce($image = '0', $id) {
        ?>
        <?php $path = URI::getLiveTemplatePath(); ?>
        <div class="descBtns">	
            <?php if ($image == '1') { ?>                                                     
                <input type="button" id="html-editor" onclick="tinymce.execCommand('mceImage', false, 'txaDescription');" value="Insert Image" title="Insert Image" class="btn backBtn"/> <?php } ?>
            <div class="editTab">
                <!--<a  class="btn activeLink" onclick="tinymce.execCommand('mceAddEditor', false, 'txaDescription');" title="Visual"><span>Visual</span></a>-->
                <!--<a  class="btn" onclick="tinymce.execCommand('mceRemoveEditor', false, 'txaDescription');" title="Html"><span>Html</span></a>-->
            </div>
        </div>     
        <textarea class="txt" name="txaDescription" id="<?php echo $id; ?>" title="Description"></textarea>

        <script type="text/javascript">
                    $(document).ready(function() {
                        tinymce.init({
							
                            content_css: "<?php echo $path; ?>/css/fck-style.css",
                            selector: '#txaDescription',
								formats : {
									alignleft : {selector : 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes : 'alignleft'},
									aligncenter : {selector : 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes : 'aligncenter'},
									alignright : {selector : 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes : 'alignright'},
								},
                            menubar: false,
                            relative_urls: false,
                            remove_script_host: false,
                            convert_urls: true,
							force_p_newlines:true,
//                                                        force_br_newlines:true,
                            plugins: [
                                "advlist autolink lists link image charmap print preview anchor hr",
                                "searchreplace visualblocks code fullscreen",
                                "insertdatetime media table contextmenu paste textcolor template"
                            ],
                            toolbar: " insertfile undo redo | template | hr | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link media | forecolor backcolor | mybutton",
                            forced_root_block: "",
                            link_class_list: [
                                {title: 'None', value: ''},
                                {title: 'cmsButton', value: 'cmsButton'}
                            
                            ],
                            templates: [
                                {title: '2 Columns', description: 'Adds a 2 columns table', url: "<?php echo $path; ?>/plugins/tiny_mce/themes/advanced/template/two_column.html"},
								{title: '3 Columns', description: 'Adds a 3 columns table', url: "<?php echo $path; ?>/plugins/tiny_mce/themes/advanced/template/three_column.html"}

                            ],
                            setup: function(editor) {

//                                editor.on('PostProcess', function(ed) {
//                                    // we are cleaning empty paragraphs
//                                    ed.content = ed.content.replace(/(<p>&nbsp;<\/p>)/gi, '<br />');
//                                });
                                
                                                                editor.addButton('mybutton', {
  text: "Add Button",
                                    onclick: function() {
      editor.windowManager.open({
  title: 'Add Button',
  width: 400,
  height: 200,
  body: [
            {type: 'textbox', name: 'name', label: 'Label'},
            {type: 'textbox', name: 'btnurl', label: 'Url'},
            {type: 'checkbox', name: 'target', label: 'New window ?'}
        ],
        onsubmit: function(e) {
          // Insert content when the window form is submitted
          // editor.insertContent('Title: ' + e.data.name);
          
                                                if (e.data.target == true)
              {
                  e.data.target = '_blank';
                                                } else {
                  e.data.target = '';
              }
              editor.focus();
                                                editor.selection.setContent('<a class="cmsButton" href="' + e.data.btnurl + '" target="' + e.data.target + '">' + e.data.name + '</a>');
        }
});
//     editor.focus();
//    editor.selection.setContent('<button>' + editor.selection.getContent() + '</button>');
  }
});

                            },
                             onchange_callback: function(editor) {
			tinyMCE.triggerSave();
			$("#" + editor.id).valid();
		},
                            file_browser_callback: function(field, url, type, win) {


                                tinyMCE.activeEditor.windowManager.open({
                                    file: '<?php echo $path; ?>/js/kcfinder/browse.php?opener=tinymce4&field=' + field + '&type=' + type,
                                    title: 'KCFinder',
                                    width: 700,
                                    height: 500,
                                    inline: true,
                                    close_previous: false,
                                }, {
                                    window: win,
                                    input: field
                                });
                                return false;
                            }

						
							
							

                        });
                    });
        </script>
        <?php
    }

    /**
     * Check whether action is home page or not
     *
     * @return boolean 
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function isHome($moduleName, $actionName) {

        if (APP::$appType == "front") {

// if application is front then check menu table first to check action is home page or not.
            $result = DB::query("select m.id from " . CFG::$tblPrefix . "menu_items as m," . CFG::$tblPrefix . "module_action as a where m.action_id=a.id and default_action='front' and a.module_key='" . $moduleName . "' and a.action = '" . $actionName . "'");
            if (count($result) > 0)
                return true;
        }

// check action table for both front and admin to find that action is home page or not
        $result = DB::query("select id from " . CFG::$tblPrefix . "module_action where default_action='" . APP::$appType . "' and action_type='" . APP::$appType . "' and module_key='" . $moduleName . "' and action = '" . $actionName . "'");

        if (count($result) > 0)
            return true;
        else
            return false;
    }

    /**
     * Resize image accoroding to width and height
     * $folderPath image directory where to resize
     * $imgName image name
     * $size image size eb. l, m, s, sm
     * $defaultImg default image name e.g no-image.jpg
     *
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    function getResizedImageSrc($folderPath, $imgName, $size, $defaultImg) {
        $absPath = URI::getAbsMediaPath($folderPath) . "/" . $imgName;

        //Added by abhishek panchal for blog post display on page
        if (strpos($folderPath, 'wp-content') !== false) {
            $absPath = CFG::$absPath . $folderPath . "/" . $imgName;
        }
        //echo $absPath;
        if ($imgName != "" && is_file($absPath) && file_exists($absPath))
            $imgName = UTIL::getImageNameWithSize($imgName, $folderPath, $size);
        else
            $imgName = UTIL::getImageNameWithSize($defaultImg, "tmpl", $size);
        $imagePath = CFG::$livePath . "/" . CFG::$sefCatalog . "/" . $imgName;
        return $imagePath;
    }

    /**
     * Resize image accoroding to width and height which image is from car feed folder 
     * $imgName image name
     * $size image size eb. l, m, s, sm
     * $defaultImg default image name e.g no-image.jpg
     *
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    function getCarFeedResizedImageSrc($imgName, $size, $defaultImg) {
        $absPath = CFG::$absPath . "/" . CFG::$carCSVDir . "/" . $imgName;
        $folderPath = CFG::$carCSVDir;
        if ($imgName != "" && is_file($absPath) && file_exists($absPath))
            $imgName = UTIL::getImageNameWithSize($imgName, $folderPath, $size);
        else {
            $imgName = UTIL::getImageNameWithSize($defaultImg, "tmpl", $size);
        }
        $imagePath = CFG::$livePath . "/" . CFG::$sefCatalog . "/" . $imgName;
        return $imagePath;
    }

    /** get image name append with folder namd and size         * 
     * @param $imgName name of image e.g xyz.jpg
     * @param $folderPath folder name within media folder
     * @param $size size of an image e.g s,m.l         *
     * @return string
     * 
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    function getImageNameWithSize($imgName, $folderPath, $size) {
// get image extension
        $arrExt = explode(".", $imgName);
        $ext = $arrExt[count($arrExt) - 1];
// get image base name
        $baseName = basename($imgName, "." . $ext);
        return ($folderPath . "/" . $baseName . "-" . $size . "." . $ext);
    }

    /**
     * Get substring without breking word
     * @param string $str
     * @param int $maxlen
     * @return string
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    function truncate_str($str, $maxlen) {
        if (strlen($str) <= $maxlen)
            return $str;
        $newstr = substr($str, 0, $maxlen);
        if (substr($newstr, -1, 1) != ' ')
            $newstr = substr($newstr, 0, strrpos($newstr, " "));
        return $newstr." ...";
    }

    /**
     * Include file upload js
     *
     * @return string
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function loadFileUploadJs() {
        $strJs = '<link rel="stylesheet" href="' . URI::getLiveTemplatePath() . '/css/fileupload/jquery.fileupload.css">
<script src="' . URI::getLiveTemplatePath() . '/js/fileupload/jquery.ui.widget.js"></script>
<script src="' . URI::getLiveTemplatePath() . '/js/fileupload/jquery.iframe-transport.js"></script>
<script src="' . URI::getLiveTemplatePath() . '/js/fileupload/jquery.fileupload.js"></script>
<script src="' . URI::getLiveTemplatePath() . '/js/fileupload/jquery.fileupload-process.js"></script>
<script src="' . URI::getLiveTemplatePath() . '/js/fileupload/jquery.fileupload-validate.js"></script>';
        return $strJs;
    }

    /** Return single record based on language id passed in query string or in post. If language id not found in request returns default language data. It return array of data if "ajaxData" not passed in request else display jason output
     * 
     * @param String $sql query to get single record from database         
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function getLanguageData($sql) {

// check language URL is enable or not.
        if (CFG::$langURL) {

            $langId = Language::getLangParam(); // get current language id            
            $data = DB::queryFirstRow($sql . " and lang_id=" . $langId . ""); // pass language id         
        } else {

            $data = DB::queryFirstRow($sql);    // execute query as it is
        }
        if (isset($_REQUEST['ajaxData']) && $_REQUEST['ajaxData'] == 1) {  // check for ajax request. use to get data for different language
            echo json_encode($data);
            exit;
        }
        else
            return $data;
    }

    /** Combines function argument in name, title and sort_order array
     * 
     * @return Array
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function combineValueInArray() {
// get all argument
        $arrParam = func_get_args();
        $data = array("name" => $arrParam[0], "title" => $arrParam[2], "alt" => $arrParam[3], "sort_order" => $arrParam[1]);
        if (isset($arrParam[4]) && !empty($arrParam[4])) {
            if ($arrParam[5] == 'link')
                $data['link'] = $arrParam[4];
            else
                $data['type'] = $arrParam[4];
    }
        return $data;
    }

    /** Delete particular file
     * 
     *  @param string $fileName name of the file
     *  @param string $filePath path of the file to delete
     *  @return boolean
     *  @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function unlinkFile($fileName, $filePath) {
        if (trim($fileName) != "" && file_exists($filePath . "/" . $fileName))
            return unlink($filePath . "/" . $fileName);
        else
            return false;
    }

    /** return countries list in all language
     * 
     *  @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function getCountryData() {
        return DB::query("SELECT c.id,group_concat(cc.country_name order by cc.lang_id) as countryName FROM " . CFG::$tblPrefix . "country as c, " . CFG::$tblPrefix . "country_content as cc where c.id=cc.country_id group by id");
    }

    /** Remove file name from array. This function is use to delete single image from gallery of some entity. e.g. page gallery
     * 
     * @param array $arrFile array of image
     * @param string $fileName image name to delete
     * @return array return updated file array
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function removeFileFromArray($arrFile, $fileName) {
        $newArray = array();
        foreach ($arrFile as $key => $file) {
            if ($file->name != $fileName)
                $newArray[] = $file;
        }
//echo "<pre>";print_r($arrFile);exit;
        return $newArray;
    }

    public static function dateDisplay($var) {
        $timeStamp = strtotime($var);
        $date = date('d/m/Y', $timeStamp);

        return $date;
    }

}


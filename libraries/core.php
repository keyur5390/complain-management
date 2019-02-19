<?php

/**
  This is core class. Which contains miscellaneous core function
 */
//restrict direct access to the page
defined('DMCCMS') or die('Unauthorized access');

class Core {

    /**
     * insert slug record of an entity
     *
     * @param string $slug 
     * @param int $d
     * @param string $moduleName name of module
     * @param string $actionName name of action
     *
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function saveSlug($slug, $id, $moduleName = "", $actionName = "") {
// remove special character from slug
        $slug = UTIL::getURLString($slug);
// get unique slug
        $slug = Core::checkUniqueSlug($slug, $id);
// get action record
        $actionId = Core::getActionRecord($moduleName, $actionName);
// save slug
        DB::insert(CFG::$tblPrefix . "slug", array("entity_id" => $id, "module_key" => APP::$moduleName, "slug" => $slug, "action_id" => $actionId, "created_date" => date("Y-m-d H:i:s"), "updated_date" => date("Y-m-d H:i:s")));
    }

    /**
     * Check slug is unique or not. If slug is not unique its find unique slug by attaching entity id.
     *
     * @param string $slug
     * @param int $id entity id
     * @param int $index
     *
     * @author Rutwik Avasthi <php.datatechmedai@gmail.com> 
     */
    public static function checkUniqueSlug($slug, $id = 0, $index = 0) {
        $tempSlug = $slug;
        if ($index == 0)
            $index = $id;
        else
            $tempSlug .= "-" . ($index - 1);
        $sql = "select id from " . CFG::$tblPrefix . "slug where slug=%s ";
        if ($id != 0)
            $sql .= " and id!=%d";
        $result = DB::query($sql, $tempSlug, $id);
        if (count($result) > 0)
            $tempSlug = Core::checkUniqueSlug($slug, $id, $index + 1);
        return $tempSlug;
    }

    /**
     * Update slug record, if slug not found then create new record for slug
     * 
     * @param string $slug 
     * @param int $id entity id
     * @param int $isAction check that slug record is for entity or action
     * @param string $moduleName name of module
     * @param string $actionName name of action
     *
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function updateSlug($slug, $id, $isAction = false, $moduleName = "", $actionName = "") {
// remove special character from slug
        $slug = UTIL::getURLString($slug);
        if ($moduleName != "" && $actionName != "")
            $actionId = Core::getActionRecord($moduleName, $actionName);
        if ($isAction)
            $slugRecord = DB::query("select id,slug,old_slug from " . CFG::$tblPrefix . "slug where action_id=%d ", $id);
        else
            $slugRecord = DB::query("select id,slug,old_slug from " . CFG::$tblPrefix . "slug where entity_id=%d and action_id=%d ", $id, $actionId);
//		echo "<pre>";print_r($slugRecord);exit;
        if (count($slugRecord) > 0) {
            $oldSlug = $slugRecord[0]['old_slug'];
// if slug is different then existing slug then check for unique slug
            if ($slug != $slugRecord[0]['slug']) {
                $oldSlug = $slugRecord[0]['slug'];
                $slug = Core::checkUniqueSlug($slug, $slugRecord[0]['id'], 0);
            }
            DB::update(CFG::$tblPrefix . "slug", array("slug" => $slug, "old_slug" => $oldSlug, "updated_date" => date("Y-m-d H:i:s")), " id=%d ", $slugRecord[0]['id']);
        }
        else
            Core::saveSlug($slug, $id, $moduleName, $actionName);
    }

    /**
     * Delete slug
     *
     * @param int $id entity id
     * @param string $mod_key key of module
     *
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com> 
     */
    function deleteSlug($id, $mod_key = "") {
        if ($mod_key == "")
            $mod_key = APP::$moduleName;
        DB::delete(CFG::$tblPrefix . "slug", " entity_id=%d and module_key=%s ", $id, APP::$moduleName);
    }

    /*
     * Display javascript message
     * 
     * @param string $sessionName name of the session
     * @param string $title title of the message
     *
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */

    public static function displayMessage($sessionName, $title) {
        if (isset($_SESSION[$sessionName])) {
            foreach ($_SESSION[$sessionName] as $key => $val)
                echo "displayMessage('" . $key . "','" . $title . "','" . $val . "');";
            unset($_SESSION[$sessionName]);
        }
    }

    /* return action id from module and action name
     *
     * @param string $moduleName name of the module
     * @param string $actionName name of the action
     *
     * @return int $actionId
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */

    public static function getActionRecord($moduleName, $actionName) {
        $actionId = 0;
        if ($moduleName != "" && $actionName != "") {
            $result = DB::query("select id from " . CFG::$tblPrefix . "module_action where module_key=%s and action=%s ", $moduleName, $actionName);
            if (count($result) > 0) {
                $actionId = $result[0]['id'];
            }
        }
        return $actionId;
    }

    /**
     *  Max. Id
     * 	@params table indicates name of table
     * 	@params idColName indicates name of id column name
     *  @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    public static function maxId($table, $idColName = "") {
        if ($idColName == "") {
            $idColName = "id";
        }
        return DB::queryFirstRow("SELECT max(" . $idColName . ") as maxId FROM " . CFG::$tblPrefix . $table);
    }

    /*
     * Return user session data
     *
     * @param string $field session field name
     *
     * @return string
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */

    public static function getUserData($field) {
        $fieldValue = "";
        if (isset($_SESSION['user_login'])) {
            if (isset($_SESSION['user_login'][$field]))
                $fieldValue = $_SESSION['user_login'][$field];
        }
        return $fieldValue;
    }

    /**
     * Preparing content for mail.
     * @param string subject header text
     * @param arrContactData body of mail
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    /*public static function loadMailTempleate($subject, $arrContactData) {
//Set Mail Header
        $arrTemplateHeader['livePath'] = CFG::$livePath;
        $arrTemplateHeader['logoImagePath'] = URI::getLiveTemplatePath() . "/images/logo.png";
        $arrTemplateHeader['logoImageWidth'] = "50";
        $arrTemplateHeader['logoImageHeight'] = "";
        $arrTemplateHeader['headerText'] = $subject;
//Set Footer 
        $arrTemplateFooter['footerText'] = "<b>Thank you,<br>" . CFG::$siteConfig['site_name'] . "</b>";
        $content = Core::mailTemplate($arrTemplateHeader, $arrContactData, $arrTemplateFooter, CFG::$absPath . "/mailTemplate/contact_us.php");
        return $content;
    }*/
    
    public static function loadMailTempleate($subject, $arrContactData) {
//Set Mail Header
        
        $arrTemplateHeader['livePath'] = CFG::$livePath;
        $arrTemplateHeader['logoImagePath'] = URI::getLiveTemplatePath() . "/images/logo.png";
        $arrTemplateHeader['logoImageWidth'] = "";
        $arrTemplateHeader['logoImageHeight'] = "";
        $arrTemplateHeader['headerText'] = $subject;
//Set Footer 
        $arrTemplateFooter['footerText'].='<td align="left" style="text-align:left; font-size: 12px;font-family:Arial, Helvetica, sans-serif;"><strong>Address:</strong> ' . CFG::$siteConfig['site_address'] . '<br /><strong>Phone:</strong> ' . CFG::$siteConfig['site_phone'] . '</td><td align="right" style="text-align:left; max-width: 330px; font-size: 12px;font-family:Arial, Helvetica, sans-serif;"><strong>Email:</strong> <a href="mailto:' . CFG::$siteConfig['site_email'] . '" style="color: #61259E;">' . CFG::$siteConfig['site_email'] . '</a><br /><strong>Website:</strong> <a href="' . CFG::$livePath . '" target="_blank"  style="color: #61259E;">' . CFG::$livePath . '</a></td>';
        $content = Core::mailTemplate($arrTemplateHeader, $arrContactData, $arrTemplateFooter, CFG::$absPath."/mailTemplate/contact_us.php");
        return $content;
      
    }

    /**
     * Preparing content for mail.
     * @param string subject header text
     * @param arrContactData body of mail
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    public static function loadTextMailTempleate($subject, $arrContactData) {
//Set Mail Header
        $arrTemplateHeader['livePath'] = CFG::$livePath;
        $arrTemplateHeader['logoImagePath'] = URI::getLiveTemplatePath() . "/images/logo.png";
        $arrTemplateHeader['logoImageWidth'] = "";
        $arrTemplateHeader['logoImageHeight'] = "";
        $arrTemplateHeader['headerText'] = $subject;
//Set Footer 
        $arrTemplateFooter['footerText'] = "<b>Thank you,<br>" . CFG::$siteConfig['site_name'] . "</b>";
        $content = Core::mailTextTemplate($arrTemplateHeader, $arrContactData, $arrTemplateFooter, CFG::$absPath . "/mailTemplate/contact_us.php");
        return $content;
    }

    /*
     * For getting template of mail
     * @param string arrTemplateHeader Template Header
     * @param string arrContactData Contact Data
     * @param string arrTemplateFooter Template Footer
     * @param string templateFile Template File
     * @return string
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */

    /*public static function mailTemplate($arrTemplateHeader, $arrContactData, $arrTemplateFooter, $templateFile) {
        $content = "";
        $PATH = $arrTemplateHeader['livePath'];
        if (!empty($arrTemplateHeader['logoImagePath'])) {
            $SITE_LOGO = "<img src='" . $arrTemplateHeader['logoImagePath'] . "' border='0' width='" . $arrTemplateHeader['logoImageWidth'] . "' height='" . $arrTemplateHeader['logoImageHeight'] . "'/>";
            $HEADER_HIDE = '';
        } else {
            $SITE_LOGO = "";
            $HEADER_HIDE = "none";
        }
        $HEADER = $arrTemplateHeader['headerText'];
        $contactData = "";
        foreach ($arrContactData as $key => $value) {
            if (!empty($value)) {
                $contactData .= "<tr>
<td width='25%' height='25' align='left' valign='top' ><strong>" . ucwords($key) . " :</strong></td>
<td width='75%' align='left' valign='top' >" . stripslashes($value) . "</td>
</tr>";
            } else {
                $contactData .= "<tr>
<td width='25%' colspan='2' height='25' align='left' valign='top' ><strong>" . ucwords($key) . " :</strong></td>							  
</tr>";
            }
        }
        $BODY_CONTENT = $contactData;
        $FOOTER = $arrTemplateFooter['footerText'];
        $content = file_get_contents($templateFile);
        $content = addslashes($content);
        eval("\$content = \"$content\";");
//echo $content;exit;
        return stripslashes($content);
    }*/
    public static function mailTemplate($arrTemplateHeader, $arrContactData, $arrTemplateFooter, $templateFile) {
//        $content = "";
//        $PATH = $arrTemplateHeader['livePath'];
//        if (!empty($arrTemplateHeader['logoImagePath'])) {
//            $SITE_LOGO = "<img src='" . $arrTemplateHeader['logoImagePath'] . "' border='0' width='" . $arrTemplateHeader['logoImageWidth'] . "' height='" . $arrTemplateHeader['logoImageHeight'] . "'/>";
//            $HEADER_HIDE = '';
//        } else {
//            $SITE_LOGO = "";
//            $HEADER_HIDE = "none";
//        }
//        $HEADER = $arrTemplateHeader['headerText'];
//        $contactData = "";
//        foreach ($arrContactData as $key => $value) {
//            if (!empty($value)) {
//                $contactData .= "<tr>
//<td width='25%' height='25' align='left' valign='top' ><strong>" . ucwords($key) . " :</strong></td>
//<td width='75%' align='left' valign='top' >" . stripslashes($value) . "</td>
//</tr>";
//            } else {
//                $contactData .= "<tr>
//<td width='25%' colspan='2' height='25' align='left' valign='top' ><strong>" . ucwords($key) . " :</strong></td>							  
//</tr>";
//            }
//        }
//        $BODY_CONTENT = $contactData;
//        $FOOTER = $arrTemplateFooter['footerText'];
//        $content = file_get_contents($templateFile);
//        $content = addslashes($content);
//        eval("\$content = \"$content\";");
////echo $content;exit;
//        return stripslashes($content);
        
        
        $content = "";

        $PATH = $arrTemplateHeader['livePath'];
        if (!empty($arrTemplateHeader['logoImagePath'])) {
            $SITE_LOGO = "<img src='" . $arrTemplateHeader['logoImagePath'] . "' style='margin-bottom:10px;' border='0' width='" . $arrTemplateHeader['logoImageWidth'] . "' height='" . $arrTemplateHeader['logoImageHeight'] . "' alt='" . CFG::$siteConfig['site_name'] . "' title='" . CFG::$siteConfig['site_name'] . "'/>";
            $HEADER_HIDE = '';
        } else {
            $SITE_LOGO = "";
            $HEADER_HIDE = "none";
        }

        $HEADER = $arrTemplateHeader['headerText'];
        $contactData = "<tbody>";
        foreach ($arrContactData as $key => $value) {
            if (!empty($value)) {
                $contactData .= "<tr>
			                   <td style='color:#000;font-family:Arial, Helvetica, sans-serif;padding:10px;border-right:1px solid #ccc;border-bottom:1px solid #ccc;width:34%;'><strong>" . ucwords($key) . " :</strong></td>
               				    <td style='font-family:Arial, Helvetica, sans-serif;padding:10px;border-bottom:1px solid #ccc;width:66%'>" . stripslashes($value) . "</td>
			                  </tr>";
            } else {
                $contactData .= "<tr>
				                   <td><b>" . ucwords($key) . " :</b></td>
                                                       </tr>";
            }
        }
        $contactData .= '</tbody>';

        $BODY_CONTENT = $contactData;
        $FOOTER = $arrTemplateFooter['footerText'];
        $content = file_get_contents($templateFile);
        $content = addslashes($content);
        eval("\$content = \"$content\";");
        //echo $content;exit;
        return stripslashes($content);
    }

   

    /*
     * For getting template of mail
     * @param string arrTemplateHeader Template Header
     * @param string arrContactData Contact Data
     * @param string arrTemplateFooter Template Footer
     * @param string templateFile Template File
     * @return string
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */

    public static function mailTextTemplate($arrTemplateHeader, $arrContactData, $arrTemplateFooter, $templateFile) {
        $content = "";
        $PATH = $arrTemplateHeader['livePath'];
        if (!empty($arrTemplateHeader['logoImagePath'])) {
            $SITE_LOGO = "<img src='" . $arrTemplateHeader['logoImagePath'] . "' border='0' width='" . $arrTemplateHeader['logoImageWidth'] . "' height='" . $arrTemplateHeader['logoImageHeight'] . "'/>";
            $HEADER_HIDE = '';
        } else {
            $SITE_LOGO = "";
            $HEADER_HIDE = "none";
        }
        $HEADER = $arrTemplateHeader['headerText'];
        $BODY_CONTENT = $arrContactData;
        $FOOTER = $arrTemplateFooter['footerText'];
        $content = file_get_contents($templateFile);
        $content = addslashes($content);
        eval("\$content = \"$content\";");
//echo $content;exit;
        return stripslashes($content);
    }

    /**
     * Return title, meta keyword and meta description text
     *
     * @param string $title page title
     * @param string $description meta description
     * @param string $keywords page keywords
     *
     * @return string
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function setMeta($title, $description, $keywords) {
        $metaStr = '<title>' . $title . '</title>
<meta content="' . $description . '" name="description" />
<meta content="' . $keywords . '" name="keywords" />';
        return $metaStr;
    }

    /**
     * Return title, meta keyword and meta description text
     *
     * @param string $title page title
     * @param string $description meta description
     * @param string $keywords page keywords
     *
     * @return string
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function setDynamicMeta($title, $description, $keywords) {
        if (isset(APP::$actionRecord['field_variables']) && trim(APP::$actionRecord['field_variables']) != "") {
            $arrFields = explode(",", APP::$actionRecord['field_variables']);
            foreach ($arrFields as $field) {
                $fielVal = isset(Layout::$moduleData['data']->records[$field]) ? Layout::$moduleData['data']->records[$field] : "";
                $title = str_replace("[" . $field . "]", $fielVal, $title);
                $description = str_replace("[" . $field . "]", $fielVal, $description);
                $keywords = str_replace("[" . $field . "]", $fielVal, $keywords);
            }
        }
        return Core::setMeta($title, $description, $keywords);
    }

    /**
     * check that array have meta content field or note
     *
     * @param array $dataArray
     *
     * @return boolean
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function checkMeta($dataArray) {
        if (isset($dataArray['meta_title']) && isset($dataArray['meta_description']) && isset($dataArray['meta_keyword'])) {
            if (trim($dataArray['meta_title']) != "" && trim($dataArray['meta_description']) != "" && trim($dataArray['meta_keyword']) != "")
                return true;
            else
                return false;
        }
        return false;
    }

    /**
     * Checks action is accessible or not
     * 
     * @param string $moduleKey
     * @param string $actionKey
     * @return int
     */
    public static function hasAccess($moduleKey, $actionKey) {
        $actionID = Core::getActionRecord($moduleKey, $actionKey);
        if ($_SESSION['user_login']['access_level'] == 'all') {
            return 1;
        } else if ($_SESSION['user_login']['access_type'] == 'selected') {
            if (in_array($actionID, $_SESSION['user_login']['action']) == false) {
                return 0;
            } else {
                return 1;
            }
        } else if ($_SESSION['user_login']['access_type'] == 'exclude') {
            if (in_array($actionID, $_SESSION['user_login']['action']) == true) {
                return 0;
            } else {
                return 1;
            }
        }
    }

    /**
     * Encrypts password
     * 
     * @param string $pass
     * @return string
     * 
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    public static function encryptPass($pass) {
        $cryptKey = 'qJB0rGtIn5UB1xG03efyCp';
        $qEncoded = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($cryptKey), $pass, MCRYPT_MODE_CBC, md5(md5($cryptKey))));
        return( $qEncoded );
    }

    /**
     * Decrypts password
     * 
     * @param string $pass
     * @return string
     * 
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    public static function decryptPass($pass) {
        $cryptKey = 'qJB0rGtIn5UB1xG03efyCp';
        $qDecoded = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($cryptKey), base64_decode($pass), MCRYPT_MODE_CBC, md5(md5($cryptKey))), "\0");
        return( $qDecoded );
    }

    /**
     * Returns total number of languages
     * 
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    public static function countLanguage() {
        $cntLanguage = DB::queryFirstRow("select count(*) as cnt from " . CFG::$tblPrefix . "language");
        return $cntLanguage['cnt'];
    }

    /**
     * return auto increment value 
     *
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    public static function getAutoIncrementedId($table) {
        $sql = "select auto_increment from information_schema.tables where table_schema = '" . CFG::$db . "' and table_name = '" . CFG::$tblPrefix . $table . "'";
        $data = DB::queryFirstRow($sql);
        return (int) $data['auto_increment'];
    }

    /* It will insert new record for all availabel languages
     * 
     * @param Array $langFields array of all fields
     * @param Integer $curId id of current record
     * @param String $tableName name of table in which data will insert
     * @param Integer $keyField key field name
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */

    public static function insertLangData($langFields, $curId, $tableName, $keyField) {
        $tempLang = $langFields;
        foreach ($tempLang as $key => $val) {
            if ($key != $keyField)
                $tempLang[$key] = "";
        }
        foreach (Language::$allLang as $lang) {
            if ($lang['default_lang'] == 1) {
                $langFields['lang_id'] = $lang['id'];
                DB::insert($tableName, Stringd::processString($langFields));
            } else {
                $tempLang['lang_id'] = $lang['id'];
                DB::insert($tableName, Stringd::processString($tempLang));
            }
        }
    }

    /**
     * Check slug is unique or not in specific table. If slug is not unique its find unique slug by attaching index number.
     *
     * @param string $slug
     * @param string $tableName name of table for which have to return unique slug
     * @param string $fieldName primary key field name
     * @param int $id entity id
     * @param int $index index number to start from
     *
     * @author Rutwik Avasthi <php.datatechmedai@gmail.com> 
     */
    public static function getUniqueSlug($slug, $tableName, $fieldName = "", $id = 0, $index = 0) {
        $tempSlug = $slug;
        if ($index == 0)
            $index = $id;
        else
            $tempSlug .= "-" . ($index - 1);
        $sql = "select " . $fieldName . " from " . CFG::$tblPrefix . $tableName . " where slug=%s ";
        if ($id != 0)
            $sql .= " and " . $fieldName . "!=%d";
        $result = DB::query($sql, $tempSlug, $id);
        if (count($result) > 0)
            $tempSlug = Core::getUniqueSlug($slug, $tableName, $fieldName, $id, $index + 1);
        return $tempSlug;
    }

    public static function getStateDropDown() {
        $state = DB::queryFirstColumn("select distinct state from " . CFG::$tblPrefix . "zones");
        $dropDown = "<select name='state' id='state' class='form-control applyPopover'>";
        $dropDown .= "<option value=''>Select state</option>";
        foreach ($state as $k => $v) {
            $dropDown .= "<option value='" . $v . "'>" . $v . "</option>";
        }
        $dropDown .= "</select>";
        return $dropDown;
    }

    public static function getRollsDropDown() {
        $state = DB::query("select name, id from " . CFG::$tblPrefix . "rolls");
        $dropDown = "<select name='roll_id' id='roll_id' class='form-control required applyPopover'>";
        $dropDown .= "<option value=''>Select roll</option>";
        foreach ($state as $k => $v) {
            $dropDown .= "<option value='" . $v['id'] . "'>" . $v['name'] . "</option>";
        }
        $dropDown .= "</select>";
        return $dropDown;
    }
    
    /**
        * @param array $actionArray
        * @param array $buttonData
        * @param bool $isAjax
        * @param string $callback
        * @param array $dataArray
        * */
       public static function getButtonLink($actionArray = array(), $buttonData = array(), $isAjax = false, $callback = "", $dataArray = array()) {
           /*
            * $this->moduleName
            * $this->actionName
            * $this->title
            * $this->text
            * $this->extraParam
            * $this->attributes
            */
           if (isset($actionArray) && !empty($actionArray)) {
               //list($module, $action) = $actionArray;
               $id = $extraPara = $attribute = $text = "";
               extract($actionArray);
               if (isset($module) && isset($action) && Core::hasAccess($module, $action)) {
                   /* Extra parameters to pass in URL */
                   if (isset($dataArray) && !empty($dataArray)) {
                       foreach ($dataArray as $key => $val) {
                           $extraPara[] = $key . "=" . $val;
                       }
                       $extraPara = implode("&", $extraPara);
                   }
                   /* Extra parameters to pass in URL */
                   /* button attributes */
                   if (isset($buttonData) && !empty($buttonData)) {
                       $attributeArray = array();
                       foreach ($buttonData as $key => $val) {
                           $attributeArray[] = $key . "='" . $val . "'";
                       }
                       $attribute = implode(" ", $attributeArray);
                   }
                   $redirectUrl = URI::getURL($module, $action, $id, $extraPara);
                   //echo "<a href=" . $redirectUrl . " title='" . $title . "' class='" . $class . "'><span>" . $buttonText . "</span></a>";
                   if (isset($callback) && !empty($callback))
                       echo "<a href='javascript:void(0)' " . $callback . " " . $attribute . ">" . $text . "</a>";
                   else
                       echo "<a href='" . $redirectUrl . "' " . $attribute . ">" . $text . "</a>";
               } else {
                   return;
               }
           }
       }
        public static function loadFileUploadJs() {

        $strJs = '<style>

					.qq-upload-list {

					text-align: left;

					}

					/* For the bootstrapped demos */

					li.alert-success {

					background-color: #DFF0D8;

					}

					li.alert-error {

					background-color: #F2DEDE;

					}

					.alert-error .qq-upload-failed-text {

					display: inline;

					}

					</style>

				  <link href="' . CFG::$livePath . "/" . CFG::$libraries . '/fine_uploader/client/fineuploader.css" rel="stylesheet" type="text/css"/>

				  <script type="text/javascript" src="' . CFG::$livePath . "/" . CFG::$libraries . '/fine_uploader/client/js/header.js"></script>

				  <script type="text/javascript" src="' . CFG::$livePath . "/" . CFG::$libraries . '/fine_uploader/client/js/util.js"></script>

				  <script type="text/javascript" src="' . CFG::$livePath . "/" . CFG::$libraries . '/fine_uploader/client/js/button.js"></script>

				  <script type="text/javascript" src="' . CFG::$livePath . "/" . CFG::$libraries . '/fine_uploader/client/js/handler.base.js"></script>

				  <script type="text/javascript" src="' . CFG::$livePath . "/" . CFG::$libraries . '/fine_uploader/client/js/handler.form.js"></script>

				  <script type="text/javascript" src="' . CFG::$livePath . "/" . CFG::$libraries . '/fine_uploader/client/js/handler.xhr.js"></script>

				  <script type="text/javascript" src="' . CFG::$livePath . "/" . CFG::$libraries . '/fine_uploader/client/js/uploader.basic.js"></script>

				  <script type="text/javascript" src="' . CFG::$livePath . "/" . CFG::$libraries . '/fine_uploader/client/js/dnd.js"></script>

				  <script type="text/javascript" src="' . CFG::$livePath . "/" . CFG::$libraries . '/fine_uploader/client/js/uploader.js"></script>

				  <script type="text/javascript" src="' . CFG::$livePath . "/" . CFG::$libraries . '/fine_uploader/client/js/jquery-plugin.js"></script>';

        return $strJs;
    }

}


<?php

//restrict direct access to the page
defined('DMCCMS') or die('Unauthorized access');

class Language {

    /** Store current language code
      @var $langCode string
     */
    public static $langCode;

    /** Store current language name
      @var $langName string
     */
    public static $langName;

    /** Store current language id
      @var $langId int
     */
    public static $langId;

    /** Store current language id
      @var $isDefault int
     */
    public static $isDefault;

    /** available languages
      @var $allLang array
     */
    public static $allLang;

    /**
     * Detect current language	
     *
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */
    public static function detectLanguage() {
// retrive all available languages
        Language::$allLang = Language::loadLanguages();
        $curLang = "";
        $varLang = "";
        if (CFG::$sef == true) {
            if (isset(APP::$slugParts[0]) && Language::isLang(APP::$slugParts[0])) {
                $varLang = array_shift(APP::$slugParts);
// get language parameter value
                $varLang = UTIL::getURLString($varLang);
// check language is valid or not
                if (Language::isLang($varLang))
                    $curLang = $varLang;
            }
        }
        else {
            if (isset($_GET['lang']) && trim($_GET['lang']) != "") {
                $varLang = $_GET['lang'];
// get language parameter value
                $varLang = UTIL::getURLString($varLang);
// check language is valid or not
                if (Language::isLang($varLang))
                    $curLang = $varLang;
                else {
                    echo "Oops... Document not available in requested language";
                    exit;
                }
            }
        }
        Language::setLanguage($curLang);
    }

    /*
     * Load languages from database
     *
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */

    public static function loadLanguages() {
// check for language session
        if (isset($_SESSION['languages']))
            return $_SESSION['languages']; // return language session
        else {
// load available languages from database
            $arrLang = DB::query("select * from " . CFG::$tblPrefix . "language");
            $_SESSION['languages'] = DBHelper::reIndex($arrLang, 'language_code');
            return $_SESSION['languages'];
        }
    }

    /*
     * check language is available or not
     *
     * @param $langCode language code
     * @return boolean
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */

    public static function isLang($langCode) {
        return array_key_exists($langCode, Language::$allLang);
    }

    /*
     * Set current languiage
     *
     * @param $langCode language code
     *
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */

    public static function setLanguage($langCode) {
        if ($langCode != "")
            Language::assignLanguage(Language::$allLang[$langCode]);
        else
            Language::assignLanguage(Language::$allLang[Language::getDefaultLangCode()]);
    }

    /*
     * Assign language properties to class
     *
     * @param array $langArr language array
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */

    public static function assignLanguage($langArr) {
        Language::$langCode = $langArr['language_code'];
        Language::$langName = $langArr['language'];
        Language::$langId = $langArr['id'];
        Language::$isDefault = $langArr['default_lang'];
    }

    /*
     * return default language from available language
     *
     * @return array
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */

    public static function getDefaultLang() {
        foreach (Language::$allLang as $lang) {
            if ($lang['default_lang'] == 1)
                return $lang;
        }
    }

    /*
     * return default language code from available language
     *
     * @return array
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */

    public static function getDefaultLangCode() {
        foreach (Language::$allLang as $key => $lang) {
            if ($lang['default_lang'] == 1)
                return $key;
        }
    }

    /*
     * Load language files of current template and current moduel
     *
     * @author Rutwik Avasthi <php.datatechmedia@gamil.com>
     */

    public static function loadLanguage() {
// build current template's language file path
        $path = URI::getAbsTemplatePath() . "/" . CFG::$languageDir . "/" . Language::$langCode . "_language.ini";
// buffer current template's language file content if exists
        if (file_exists($path) && !is_dir($path)) {
            ob_start();
            require_once $path;
            ob_end_clean();
        }
// load current module's language file
        $path = URI::getAbsModulePath(APP::$moduleName) . "/" . CFG::$languageDir . "/" . Language::$langCode . "_language.ini";
// buffer current module's language file content if exists
        if (file_exists($path) && !is_dir($path)) {
            ob_start();
            require_once $path;
            ob_end_clean();
        }
    }

    /* Return current language id passed in get or post request
     * @return int returns language id
     * @author Rutwik Avasthi <php.datatechmedia@gmail.com>
     */

    public static function getLangParam() {
        $langId = Language::$langId;
        if ((isset($_GET['lang_id']) && (int) $_GET['lang_id'] != 0) || (isset($_POST['lang_id']) && (int) $_POST['lang_id'] != 0))
            $langId = $_REQUEST['lang_id'];
        else
            $langId = Language::$langId;
        return $langId;
    }

}


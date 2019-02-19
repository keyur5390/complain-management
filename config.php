<?php

//restrict direct access to the page
defined('DMCCMS') or die('Unauthorized access');
// set australian time zone
date_default_timezone_set('Australia/Sydney');
// Start the session
session_start();
// Set error reporting
error_reporting(0);

class CFG {

    /** Store absolute path of site			
      @var $absPath string
     */
    public static $absPath = __DIR__;

    /** Store live url of site			
      @var $livePath string
     */
    public static $livePath = 'http://localhost/complain-manager';
    public static $liveSite = '';

    /** Store host detail of database
      @var $host string
     */
    public static $host = "localhost";

    /** Store user detail of database
      @var $user string
     */
    public static $user = "root";

    /** Store password detail of database
      @var $password string
     */
    public static $password = "";

    /** Store database name detail of database
      @var $db string
     */
    public static $db = "complain";

    /** Store database table name prefix value
      @var $tblPrefix string
     */
    public static $tblPrefix = "dtm_";

    /** Store libraties folder name
      @var $libraries string
     */
    public static $libraries = "libraries";
    
    /** Store session key name for login user
      @var $session_key string
     */
    public static $session_key = "user_login_testing";


    /** Store database name detail of database
      @var $modules string
     */
    public static $modules = "modules";

    /** Store template folder name
      @var $templates string
     */
    public static $templates = "templates";

    /** Store model folder name
      @var $model string
     */
    public static $model = "model";

    /** Store view folder name
      @var $view string
     */
    public static $view = "view";

    /** Store block folder name
      @var $block string
     */
    public static $block = "block";

    /** Store helper folder name
      @var $helper string
     */
    public static $helper = "helper";

    /** Store media folder name
      @var $mediaDir string
     */
    public static $mediaDir = "media";

    /** Store editor image folder name
      @var $mediaDir string
     */
    public static $editorImgDir = "editor";

    /** SEF url enable or disable
      @var $sef string
     */
    public static $sef = true;

    /** It will set language option in URL
      @var $langURL string
     */
    public static $langURL = false;

    /** Meta title length
     *  @var string length of meta title
     */
    public static $metaTitleLen = 100;

    /** Meta title length
     *  @var string length of meta description
     */
    public static $metaDescLen = 150;

    /** Meta title length
     *  @var string length of meta keyword
     */
    public static $metaKeywordLen = 180;

    /** if set to true will combine JS and CSS files
      @var $mergeFiles string
     */
    public static $mergeFiles = false;

    /** Name of merge directory
      @var $mergeDir string
     */
    public static $mergeDir = "cache";

    /** SEF slug for dynamic image
      @var $sefCatalog string
     */
    public static $sefCatalog = "image-catalog";

    /** Store base directory of an application
      @var $baseDir string
     */
    public static $baseDir = "";
    public static $bannerDir = 'banner';

    /** Maximum file upload limit (in MB)
      @var $maxFileSize string
     */
    public static $maxFileSize = 10;

    /** store site config data
      @var $siteConfig string
     */
    public static $siteConfig = array();

    /** No of days to display in graph at dashboard
      @var $graphDays int
     */
    public static $graphDays = 31;

    /**
     * For whole site paging pagesize limit
     * @var $pageSize Integer
     */
    public static $pageSize = 10;

    /**
     * Google analytic project client id. Get it from https://console.developers.google.com/project/aqueous-flight-810/apiui/credential
     * @var $googleClientId String
     */
    public static $googleClientId = "753972924160-cnv724un3caj6ohiq6f04vo3ji8e93vr.apps.googleusercontent.com";

    /**
     * Google analytic project email id. Get it from https://console.developers.google.com/project/aqueous-flight-810/apiui/credential
     * @var $googleEmailId String
     */
    public static $googleEmailId = "753972924160-cnv724un3caj6ohiq6f04vo3ji8e93vr@developer.gserviceaccount.com";

    /**
     * Google analytic project Secret Key. Get it from https://console.developers.google.com/project/aqueous-flight-810/apiui/credential
     * @var $googleSecretKey String
     */
    public static $googleSecretKey = "3E6ETXlZjUSyXPuCnolE9OMl";

    /**
     * Google analytic project Redirect URL. Get it from https://console.developers.google.com/project/aqueous-flight-810/apiui/credential
     * @var $googleRedirectURL String
     */
    public static $googleRedirectURL = "https://www.hairhealthandbeautyprofessional.com.au/crons/get_current_analytic_feed.php";

    /**
     * Google analytic site view id. Get it from URL of analytics. e.g. https://www.google.com/analytics/web/?hl=en#report/visitors-overview/a56217106w89604906p93124716/ - "93124716" is table id from URL
     * @var $google_tableId String
     */
    public static $google_tableId = "ga:8589073";

    /**
     * Google analytic site profile id.
     * @var $google_profileId String
     */
    public static $google_profileId = "8589073";

    /** Language folder path
      @var $languageDir string
     */
    public static $languageDir = "local";
    
    public static  $stateArray = array("NSW" => "New South Wales",
        "VIC" => "Victoria",
        "ACT" => "Australian Capital Territory",
        "QLD" => "Queensland",
        "WA" => "Western Australia",
        "TAS" => "Tasmania",
        "SA" => "South Australia",
        "NT" => "Northern Territory");
    
    public static  $ticketStatusArray = array(
        "open" => "Open",
        "inprogress" => "In Progress",
        "hold" => "Hold",
        "closed" => "Closed",
        "closedwithoutreport" => "Closed Without Report"
        );
    public static  $companydealerArray = array(
        "agl" => "AGL",
        "iocl" => "IOCL",
        "bpcl" => "BPCL",
        "essar" => "ESSAR"
        );
    public static  $priorityArray = array(
        "0" => "Very High",
        "1" => "High",
        "2" => "Medium",
        "3" => "Low"
        );
    /** Page images folder name
      @var $pageDir string"inprogress" => "In Progress",
     */
    
    public static $pageDir = "page";
	public static $categoryDir = "category";
	public static $productDir = "product";
        public static $ticketDir = "ticket";
         public static $fileDir = "file-icons";
          public static $csvDir = "import-csv";
    
    public static $imageSize = array("thumb" => array(80, 80),
        "sl" => array(740, 320),
		"small" => array(140, 68),
        "vs" => array(190, 105), // video small image
         'ib' => array(1375, 220) // For banner image 
    );
    public static $pageGalleryDir = "page-gallery";
	public static $categoryGalleryDir = "category-gallery";
	public static $productGalleryDir = "product-gallery";
    public static $sliderDir = "slider";
    public static $galleryDir = "gallery";
    public static $default_banner = "inner-banner.jpg";

//    public static $settlement = array(0 => "Not at fault",
//        1 => "At fault"
//    );

}
<?php

//restrict direct access to the page
defined('DMCCMS') or die('Unauthorized access');

class ErrorHelper {
    
    /**
     * @variable Abs Path string
     * Contains CSS Folder Absolute Path
     * 
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    public $absPath="";
      
    /**
     * Source Folder Name inside templates/front/css
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    public $source;
    
    /**
     * Global Object for scss class
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    public $scss;
    
    /**
     * constructor of class error helper. do initialisation
     *
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    function __construct() {
        
        $this->absPath=CFG::$absPath. '/templates/front/css/';
        Load::loadFile(CFG::$absPath . "/" . CFG::$libraries . "/scss/scss.php"); 
        $this->scss=new scssc();
        $this->source="scss";
    }

    /**
     * Function to file exists or not
     * @param type $fileName
     * @return boolean
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    
    function checkFile($fileName) {
        if (file_exists($this->absPath.$this->source."/".$fileName)) {
            return true;
        }
        return false;
    }
    /**
     * Function compile all scss files of folder
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    function compileFolder(){
        foreach (glob($this->absPath.$this->source.'/*.scss') as $filename) {
            //Pass base name compile file function
            $this->compileFile(basename($filename));
        }
    }

    /**
     * Compile single file
     * @param string $fileName
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    function compileFile($fileName){
        
        if($this->checkFile($fileName)){
            $scssIn = file_get_contents($this->absPath.$this->source."/".$fileName);
            return $this->compileScss($scssIn,$fileName);
        }       
    }
    
    /**
     * Compiles scss source file
     * @param string $input
     * @param string $filename
     * @author Kushan Antani <kushan.datatechmedia@gmail.com>
     */
    function compileScss($input, $filename) {
        //error_reporting(E_ALL);
        $error=array();
       try {
            $cssOut = $this->scss->compile($input);
        } catch (Exception $e) {

           // echo "<p>=====================<br><span style='color:red'>" . $filename . "</span><br>=====================</p>";
           // echo $e->getMessage();
            $error[]=$e->getMessage();
        }
        if (isset($cssOut)) {
            $cssFile=str_replace(".scss", ".css", $filename);
            file_put_contents( $this->absPath.$cssFile, $cssOut);
        }
        return $error;
    }    
    
    /**
     * This is function return array of files which is used to file in dropdown
     * 
     * @author Kushan Antani<kushan.datatechmedia@gmail.com>
     */
    public function loadFiles(){
        $files=array();
        foreach (glob($this->absPath.$this->source.'/*.scss') as $filename) {
            $files[]=basename($filename);
        }
        return $files;
    }

}

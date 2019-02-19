<?php
define('DMCCMS', 1);

require_once('load.php');
Load::loadApplication();
error_reporting(0);


if (isset($_GET['file']) && basename($_GET['file']) == $_GET['file']) {
	$filename = $_GET['file'];
} else {
	$filename = NULL;
}

$err = '<p style="color:#990000">Sorry, the file you are requesting is unavailable.</p>';

if (!$filename) {
	// if variable $filename is NULL or false display the message
	echo $err;
} else {
	// define the path to your download folder plus assign the file name
	$path = URI::getAbsMediaPath(CFG::$ticketDir) . '/' .$filename;
//      echo $path;
//      exit;
	// check that file exists and is readable
	if (file_exists($path) && is_readable($path)) {
		// get the file size and send the http headers
           
              $ext = pathinfo($path, PATHINFO_EXTENSION);
		$size = filesize($path);
                if($ext=="doc" || $ext=="DOC" || $ext=="docx" || $ext=="DOCX"){
		header('Content-Type: application/msword');
                } else if($ext=="pdf" || $ext=="PDF"){
                    header('Content-Type: application/pdf');
                }
		header('Content-Length: '.$size);
		header('Content-Disposition: attachment; filename="' . $filename . '"');
                readfile($path);
//		header('Content-Transfer-Encoding: binary');
		// open the file in binary read-only mode
		// display the error message if file can't be opened
//		$file = @ fopen($path, 'rb');
		
	} else {
		echo $err;
	}
}

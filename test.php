<?php 
	$headers = 'From: info@datatech.in' . "\r\n" .
	$status = mail("info@datatech.in","datatech","datatech ignore mail",$headers);
	
	if($status === true)
		echo "sent";
	else
		echo "error";
?>
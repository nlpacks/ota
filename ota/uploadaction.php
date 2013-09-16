<?php

function __autoload($class_name) {
	require_once $class_name . '.php';
}
try {
	session_start();
	date_default_timezone_set('Asia/Chongqing');
	
	
	$up =new uploadfile();
	$up->uploadfileCheck($_FILES);
	
	
	$db=new db();
	$db->connect();
	
	$file=$up->receiveFile($_FILES,config::$Upload_Basedir.DIRECTORY_SEPARATOR.$_POST["product"].DIRECTORY_SEPARATOR.$_POST["revision"]);
	echo "upload file :".$file;

	
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$url="http://".$host.$uri."/".$_POST["product"]."/".$_POST["revision"]."/".$_FILES["file"]["name"];
	
	$up->logUploadFile($file,$_POST["product"],$_POST["revision"],$_POST["ftype"],"test",$_SERVER["REMOTE_ADDR"],$url,$_POST["remark"]);
	//$up->analysisFlexExcel($file, $key);
	$db->disconnect();
	
	echo "<br><a href=\"#\" onclick=\"javascript:history.go(-1)\">back</a>";
}
catch (Exception $e)
{
	echo $e->getMessage();
	echo "<br><a href=\"#\" onclick=\"javascript:history.go(-1)\">back</a>";
}

?>
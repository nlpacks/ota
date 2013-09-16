<?php

function __autoload($class_name) {
	require_once $class_name . '.php';
}
try {
	session_start();
	date_default_timezone_set('Asia/Chongqing');
	
	
	$db = new db ();
	$db->connect();
	
	$pid=$_GET["id"];
	
	$pd=new product();
	$plist=$pd->loadById($pid);
	
	

	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
			<html>
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
			<title>product detail</title>
			</head>
			<body>
				<table border="1">
					<tr>
						<td>id</td>
						<td>name</td>
						<td>platform</td>
						<td>integrater</td>
						<td>leader</td>
						<td>src</td>
					</tr>';
	foreach ( $plist as $value )
	{
		echo "		<tr>
						<td>$value->id</td>
						<td>$value->name</td>
						<td>$value->platform</td>
						<td>$value->integrater</td>
						<td>$value->leader</td>
						<td>$value->src</td>
					</tr>";
	}
	
	
	echo '		</table><br>
			<a href="upload.php">upload file</a>			
		</body>
		</html>';
	
	
	
	$db->disconnect();
	
	echo "<br><a href=\"#\" onclick=\"javascript:history.go(-1)\">back</a>";
}
catch (Exception $e)
{
	echo $e->getMessage();
	echo "<br><a href=\"#\" onclick=\"javascript:history.go(-1)\">back</a>";
}

?>
<?php
function __autoload($class_name) {
	require_once $class_name . '.php';
}

try {
	session_start ();
	date_default_timezone_set('Asia/Chongqing');
	
	$db = new db ();
	$db->connect();
	$pd = new product ();
	$pdlist = $pd->load ();
	
	$up=new uploadfile();
	$ufils=$up->listUploadFile();
	
	
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
			<html>
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
			<script type="text/javascript" src="./jquery-1.10.2.min.js"></script>
			<script type="text/javascript" src="./build.js"></script>
			<title>ota</title>
			</head>
			<body>
				<table border="1">
					<tr>
						<td>product</td>
						<td>revision</td>
						<td>detail</td>
						<td>generate ota</td>
					</tr>';
	foreach ( $pdlist as $value )
	{
		$revision_list="";
		if ( isset($ufils[$value->name]["targetfile"]) )
		{
			$pfs=$ufils[$value->name]["targetfile"];
			foreach ($pfs as $file)
			{
				$revision_list=$revision_list.$file->url."<br/>";
			}
		}

		echo "<tr>
				<td>$value->name</td>
				<td>$revision_list</td>
				<td><a href=\"detail.php?id=$value->id\">detail</a></td>
				<td><input type=\"button\" value=\"ota\" onclick=\"generateota($value->id,'$value->name','1.2 1.3 1.4 1.5 1.6 1.7 1.8 1.9')\" /></td>
			</tr>";
	}
		
	
	echo '		</table>
		</body>
		</html>';
	
	$db->disconnect ();
} catch ( Exception $e ) {
	echo $e->getMessage ();
}
?>
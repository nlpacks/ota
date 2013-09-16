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
	
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
			<html>
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
			<title>upload files</title>
			</head>
			<body>
				<form action="uploadaction.php" method="post" enctype="multipart/form-data">
				<input type=hidden name="MAX_FILE_SIZE" value="1073741824">
				<label for="file">select file</label> 
				<input type="file" name="file"	id="file" /><br/>			
				<label for="file">select product</label> 
				<select name="product">';
	foreach ( $pdlist as $value )
		echo "<option value=\"" . $value->name . "\">" . $value->name . "</option>";
	
	echo '		</select><br/>
				<label for="file">upload file type</label> 
				<select name="ftype">
					<option value="targetfile" selected>ota target file</option>
					<option value="apk">apk</option>
					<option value="tools">tools</option>
					<option value="signkey">sign keys</option>
				</select><br/>		
				<label for="file">revision</label>
				<input type="text" name="revision" ><br /> 
			
				<label for="file">description</label><br>
				<textarea name="remark" rows="3" cols="50"></textarea>	<br /> 
				<input type="submit" name="submit" value="Submit" />
			</form>
		</body>
		</html>';
	
	$db->disconnect ();
} catch ( Exception $e ) {
	echo $e->getMessage ();
}
?>
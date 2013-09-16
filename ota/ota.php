<?php
function __autoload($class_name) {
	require_once $class_name . '.php';
}
try {
	session_start ();
	date_default_timezone_set ( 'Asia/Chongqing' );
	$db = new db ();
	$db->connect();	
	
	$pid=$_POST["id"];
	$product=$_POST["product"];
	$vlist=$_POST["revs"];

// 		$pid=1;
// 		$product="PD1120";
// 		$vlist='1 2 3 4 5 6 7 8 9 10 11 12 13';
	
	//get server counts
	$ser=new server();
	$serlist=$ser->load();
	//这里需要过滤掉那些不能连接的服务器
	
	$varr=explode(" ",$vlist);
	sort($varr);
	
	$oj=new otajob();
	$jobs=$oj->loadBalanc($serlist, $varr);
	$oj->submit($jobs, $product);
	
	
	
	//get jobs counts
	//load balanc
	
	echo "job has been submit, just to wait it.";
	
	$db->disconnect ();
	
// 	echo "<br><a href=\"#\" onclick=\"javascript:history.go(-1)\">back</a>";
} catch ( Exception $e ) {
	echo $e->getMessage ();
// 	echo "<br><a href=\"#\" onclick=\"javascript:history.go(-1)\">back</a>";
}

?>
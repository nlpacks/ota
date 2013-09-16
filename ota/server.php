<?php
class server
{
	public function load()
	{
		$collection=array();
		$sql="select id,name,host,port from server where state=1 order by name ";
		
		$result=mysql_query($sql);
		if (!$result)
			throw new Exception("list server fail:".mysql_error());
		
		while(($row = mysql_fetch_array($result))!==false)
		{
			$ov=new server();
			$ov->id=$row["id"];
			$ov->name=$row["name"];
			$ov->host=$row["host"];
			$ov->port=$row["port"];

			$collection[]=$ov;
		}
		return $collection;
	}
	public function getServerPort($host)
	{
		$sql="select  port from server where state=1 and host='$host' ";
		$port=2000;
		
		$result=mysql_query($sql);
		if (!$result)
			throw new Exception("get server port fail:".mysql_error());
	
		while(($row = mysql_fetch_array($result))!==false)
		{
			$port=$row["port"];	
		}
		return $port;
	}	
}
?>
<?php
class product
{
	public function load()
	{
		$collection=array();
		$sql="select * from product where state=1 order by name ";
		
		$result=mysql_query($sql);
		if (!$result)
			throw new Exception("list product fail:".mysql_error());
		
		while(($row = mysql_fetch_array($result))!==false)
		{
			$ov=new product();
			$ov->id=$row["id"];
			$ov->name=$row["name"];
			$ov->platform=$row["platform"];
			$ov->integrater=$row["integrater"];
			$ov->leader=$row["leader"];
			$ov->src=$row["src"];
			$collection[]=$ov;
		}
		return $collection;
	}
	public function loadById($id)
	{
		$collection=array();
		$sql="select * from product where id=$id ";
	
		$result=mysql_query($sql);
		if (!$result)
			throw new Exception("list product fail:".mysql_error());
	
		while(($row = mysql_fetch_array($result))!==false)
		{
			$ov=new product();
			$ov->id=$row["id"];
			$ov->name=$row["name"];
			$ov->platform=$row["platform"];
			$ov->integrater=$row["integrater"];
			$ov->leader=$row["leader"];
			$ov->src=$row["src"];
			$collection[]=$ov;
		}
		return $collection;
	}
}
?>
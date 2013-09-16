<?php
class uploadfile
{
	public function uploadfileCheck($formArray)
	{
		if (! isset($formArray["file"]["error"]))
		{
			throw new Exception("upload file max size is 1024M, please check it first.");
			return;
		}
		
		if ($formArray["file"]["error"] == 3 )
		{
			throw new Exception("upload not completed .");
			return ;
		}
// 		if ($formArray["file"]["type"] != "application/x-zip-compressed")
// 		{
// 			throw new Exception("not support ".$formArray["file"]["type"].", zip file only.");
// 			return;
// 		}
		$suffix=strrchr($formArray["file"]["name"], ".");
		if ($suffix != ".zip")
		{
			throw new Exception("file name error, only support *.zip .");
			return;		
		}
	}
	public function receiveFile($formArray,$savepath)
	{
		clearstatcache();
		$uploadfile = $savepath."/". $formArray["file"]["name"];

		if (!file_exists(dirname($uploadfile)))
			if (!mkdir(dirname($uploadfile),0744,true))
			throw new Exception("create template upload dir [".dirname($uploadfile)."] fail, please check.");

		if (file_exists($uploadfile))
			throw new Exception("upload file $uploadfile already exists ,please rename it first.");
		$ismoved = move_uploaded_file($formArray["file"]["tmp_name"],	$uploadfile);
		if ($ismoved == false)
			throw new Exception("save template file $uploadfile failure.");
		return $uploadfile;
	}
	
	function logUploadFile($file,$product,$revision,$ftype,$whoupload,$remotehost,$url,$description)
	{
		// 		date_default_timezone_set("Asia/Chongqing");
		$sql="insert into uploadfile (filename,uploader,uploadtime,uploadhost,product,revision,ftype,url,state,remark)
				values ('".$file."','".$whoupload."','".date('Y-m-d H:i:s')."','".$remotehost."','".$product."','".$revision."','".$ftype."','".$url."',1,'".addslashes($description)."');";
		$result=mysql_query($sql);
		if (!$result)
			throw new Exception("log upload file fail:".mysql_error());
	}
	function listUploadFile()
	{
		$collection=array();
		$sql="select * from uploadfile where state=1 order by product,ftype,revision";

		$result=mysql_query($sql);
		if (!$result)
			throw new Exception("list upload file fail:".mysql_error());

		while(($row = mysql_fetch_array($result))!==false)
		{
			$ov=new uploadfile();
			$ov->id=$row["id"];
			$ov->filename=$row["filename"];
			$ov->uploader=$row["uploader"];
			$ov->uploadtime=$row["uploadtime"];
			$ov->product=$row["product"];
			$ov->ftype=$row["ftype"];
			$ov->revision=$row["revision"];
			$ov->url=$row["url"];
			$ov->remark=$row["remark"];
			$collection[$row["product"]][$row["ftype"]][]=$ov;
		}
		return $collection;
	}
}

?>
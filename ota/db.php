<?php

class db
{
	public $con;

	public function connect()
	{
		$con=mysql_connect(config::$Database_Host_Address, config::$Database_User_Name, config::$Database_User_Password);
		if (!$con)
		{
			throw new Exception('Could not connect: '.mysql_error());
		}
		$this->con=$con;
		mysql_query("SET NAMES UTF8");
		mysql_query("SET CHARACTER SET UTF8");
		mysql_query("SET CHARACTER_SET_RESULTS=UTF8");
		mysql_select_db(config::$Database_Name, $con);
	}
	public function executeSql($sql)
	{
		$result=mysql_query($sql);
		if (!$result)
			throw new Exception("[".$sql."] execute failed :".mysql_error());
		return $result;
	
	}
	public function executeSqlArray($sqlArray)
	{
		foreach ($sqlArray as $sql)
			if (!mysql_query($sql))
			throw new Exception("[".$sql."] execute failed :".mysql_error());
	}
	public function disconnect()
	{
		mysql_close($this->con);
	}
}

?>
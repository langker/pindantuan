<?php
	//数据库连接参数配置
	define("sql", "mongodb://localhost:27017/admin:admin");
	function ConnectDB($dbname)
	{
		$m = new MongoClient(constant("sql"));
 
		$db = $m->pingdantuan;
		return $db->$dbname;
	}

?>
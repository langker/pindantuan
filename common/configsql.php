<?php
	//数据库连接参数配置
	//define("sql", "mongodb://localhost:27017/admin:admin");
	define("sql", "mongodb://langker:(pindantuan)@localhost:27017");
	function ConnectDB($dbname)
	{
		$m = new MongoClient(constant("sql"));
 		//if(file_exists("release"))//是否是测试服务器，该文件存在则为线上版本，不存在则为线上测版
			$db=$m->pingdantuan;
		//else
			//$db=$m->test;

		return $db->$dbname;
	}
	//var_dump();

?>
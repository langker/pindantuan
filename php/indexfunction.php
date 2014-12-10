<?php
	
	include_once "../common/configsql.php";
	include_once "../common/json.php";
	switch($_POST["func"])
	{
		case "recommendFunc":
			recommendFunc();break;
	}

	function recommendFunc()
	{
		$db=ConnectDB("goods_shoes");
		$arr=array();
		for($i=0;$i<4;$i++)
		{
			$row=$db->find(array("goodsid"=>$_POST["goodsId"][$i],"iskey"=>1));
			foreach($row as $key=>$value)
			{
				array_push($arr,array("title"=>$value["goodsname"],"sale"=>$value["sellnum"],"price"=>$value["subprice"]));
			}
		}
		echo JSON($arr);
	}

?>

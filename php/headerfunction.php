<?php
	
	include_once "../common/session.php";
	include_once "../common/json.php";
	include_once "../common/user.php";
	//session_start();
	switch($_POST["func"])					//根据前端参数直接执行
	{
		case "ChangeAddress":
			ChangeAddress();break;
		case "GetInfo":
			Getinfo();break;
		case "quit":
			quit();break;
		case "backurl":
			backurl();break;
		case "GetSaveMoney":
			GetSaveMoney();break;
		//case "SendKeyword":
		//	SendKeyword();break;
			
	}
	function GetSaveMoney()
	{
		$db=ConnectDB("memeda");
		$rows=$db->find();
		$return=0;
		foreach($rows as $key=>$value)
		{
			$return=$value["savemoney"]+rand(0,1);
			$db->update(array("savemoney"=>$value["savemoney"]),array('$set'=>array("savemoney"=>$return)));
		}
		
		echo $return;
	}
	function GetInfo()  						//更改header的信息
	{
		//if(!isset($_SESSION["nameid"]))
		//	return;
		$user = new user();				
		$user->init($_SESSION["nameid"]);
		$arr1=$user->GetRecevinfo();			//获得地址信息
		//var_dump($_SESSION["nameid"]);
		$bucket = new bucket();
		$bucket ->SetBucketID($_SESSION["nameid"]);//获得当前购物车里商品数量
		
		//var_dump(session_id());
		$array=array("username"=>$_SESSION['name'],
				 "address"=>$arr1["area"],
				 //"bucketNum"=>$bucket->GetBucketNum(),
				 //"lastvisited"=>array($user->GetLastVisited()),
				 "myorderurl"=>"myOrder.html",
				 "mybucketurl"=>"bucket.html",
			);
		//var_dump($arr1["area"]);
		if(!isset($_SESSION["nameid"]))
			$array["bucketNum"]=0;
		else
			$array["bucketNum"]=$bucket->GetBucketNum();
		echo JSON($array);
	}
	function ChangeAddress()   //更改前台发来的商圈
	{
		$user = new user();
		$user->init($_SESSION["nameid"]);
		$arr=array("area"=>(string)$_POST["newAddress"]);
		
		$user->SetNewAddress($arr);
	}
	function quit()			//清空session当做退出
	{
		//$_SESSION["name"]="";
		//$_SESSION["nameid"]="";
		session_destroy();
		return;
	}
	
	function backurl()  
	{
		$var=$_POST["url"];
		$_SESSION["url"]=$var;
		//$_SESSION["url"]="http://www.baidu.com";
		//$_SESSION["url"]=$_POST["url"];
		//var_dump($_SESSION);

	}

?>

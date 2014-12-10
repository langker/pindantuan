<?php

	include_once "../../common/configsql.php";
	include_once "../../common/json.php";
	switch($_POST["func"])
	{
		case "init":
			init();break;
		case "like":
			like();break;
	}
	function like()
	{
		$db=ConnectDB("article");
		$row=$db->find(array("id"=>$_POST["id"]));
		foreach($rows as $key=>$value)
		{
			$db->update(array("id"=>$_POST["id"]),array('$set'=>array("like"=>$value["like"]++)));
		}
	}

	function init()
	{
		$goods=array();
		$goodsid=array();
		$article=array();


		$db=ConnectDB("article");

		
		$row=$db->find(array("id"=>$_POST["id"],));
		foreach($row as $key=>$value)
		{
			$goodsid=$value["goodsid"];
			//$qian=array(" ","　","\t","\n","\r");
			//$hou=array("","","","","");
			//$arr=str_replace($qian, $hou,$value["content"]);

			$article=array("title"=>$value["title"],"url"=>"article.php?id=".$value["id"],"pic"=>"photo/".$value["id"].".jpg","data"=>$value["data"],"phase"=>$value["phase"],"like"=>$value["like"],"content"=>base64_encode(stripslashes($value["content"])));
		}
		$db=ConnectDB("goods_shoes");
		for($i=0;$i<count($goodsid);$i++)
		{
			$rows=$db->find(array("goodsid"=>$goodsid[$i],"iskey"=>array('$ne'=>0)));
			foreach($rows as $key=>$value)
			{
				array_push($goods,array("pic"=>"photo/".$vlaue["id"]."/1.jpg","title"=>$value["goodsname"],"type"=>$value["iskey"]-1,"TBprice"=>$value["origprice"],"PDprice"=>$value["subprice"],"url"=>$value["url"]));
			}

		}
		echo JSON(array("article"=>$article,"goods"=>$goods));

	}
?>

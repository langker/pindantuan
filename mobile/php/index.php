<?php

	include_once "../../common/configsql.php";
	include_once "../../common/json.php";
	switch($_POST["func"])
	{
		case "init":
			init();break;
	}
	function init()
	{
		$carousel=array();
		$article=array();


		$db=ConnectDB("article");

		$row=$db->find(array("iskey"=>1))->limit(4);
		foreach($row as $key=>$value)
		{
			array_push($carousel,array("titile"=>$value["title"],"url"=>"detail.php?id=".$value["id"],"pic"=>"photo/".$value["id"].".jpg"));

		}
		$row=$db->find();
		foreach($row as $key=>$value)
		{
			array_push($article,array("titile"=>$value["title"],"url"=>"detail.php?id=".$value["id"],"pic"=>"photo/".$value["id"].".jpg","data"=>$value["data"],"phase"=>$value["phase"],"like"=>$value["like"]));
		}
		echo JSON(array("carousel"=>$carousel,"article"=>$article));

	}
?>

<?php

	include_once "../common/configsql.php";
	include_once "../common/json.php";
	$a=ConnectDB("goods_shoes");

	$t=array("iskey"=>1,"status"=>1);
	$query=array('sellnum'=>-1);

	$row=$a->find($t);

	$rows=$row->sort($query)->skip($_POST["page"])->limit(9);
	/*foreach($rows as $key=>$value)
	{
		var_dump($value);
	}*/
	$goods=array();
	$good=array();
	foreach($rows as $key=>$value)
	{
		//var_dump("memda");
		//if($value["status"]==0)
		//	break;
		$good=array(
			"url"=>"detail.php?id=".$value["goodsid"],
			"name"=>$value["goodsname"],
			"orgiprice"=>$value["origprice"],
			"curprice"=>$value["subprice"],
			"sellnum"=>$value["sellnum"],
			"imgurl"=>"photo/".$value["goodsid"]."/1.jpg",
			"goodsid"=>$value["goodsid"]
			);
		array_push($goods,$good);
	}
	//var_dump($goods);
	$db=ConnectDB("comment");
	for($r=0;$r<count($goods);$r++)
	{
		$row=$db->find(array("goodsid"=>$goods[$r]["goodsid"]))->limit(2);
		$goods[$r]["comment"]=array();
		foreach($row as $key=>$value)
		{
			//var_dump("memeda");
			array_push($goods[$r]["comment"],array("username"=>$value["name"],"detail"=>$value["detail"]));
		}	
	}
	//array_push($goods,$good);	*/
	echo JSON($goods);
?>

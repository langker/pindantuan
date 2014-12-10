<?php

	include_once "../common/configsql.php";
	include_once "../common/json.php";
	include_once "../common/goods.php";

	switch($_POST["func"])
	{
		case "GetInfo":
			GetInfo();break;
		case "AddOrder":
			AddOrder();break;
		case "mobileDetail":
			mobileDetail();break;
	}
	function mobileDetail()
	{
		$db=ConnectDB("goodsforweb");
		$num=$db->find()->count();
		$rowss=$db->find();
		$rows=$rowss->skip($_POST["page"]-1)->limit(1);
		$array=array();
		foreach($rows as $key=>$value)
		{
			$dbs=ConnectDB("goods_shoes");
			$row=$dbs->find(array("goodsid"=>$value["goodsid"],"iskey"=>1));
			foreach($row as $key=>$values)
			{

				$array["id"]=$values["goodsid"];
				$array["PDPrice"]=$values["subprice"];
				$array["TBPrice"]=$values["origprice"];
				$array["pic"]=array("photo/".$values["goodsid"]."/1.jpg");
				$array["title"]=$values["goodsname"];
				if($_POST["page"]<$num)
					$array["page"]=$_POST["page"]+1;
				else 
					$array["page"]="end";
				for($g=2;$g<=4;$g++)
				{
					if(file_exists("../photo/".$value["goodsid"]."/".$g.".jpg"))
					{
						$array["pic"][$g-1]="photo/".$value["goodsid"]."/".$g.".jpg";
					}
					else
					{
						
						break;
					}
				}


			}
		}
		echo JSON($array);
	}
	function GetInfo()
	{
		$goods = new goods();

		$goods ->SetGoodsID($_POST["goodsid"]);			
		$array = $goods->GetDetail();
		echo JSON($array);
		
	}
	function AddOrder()
	{
		$db=ConnectDB("orderforoffline");
		date_default_timezone_set ("Asia/Shanghai");
		$content=array("goodssid"=>$_POST["goodssid"],"name"=>$_POST["name"],"cellphone"=>$_POST["cellphone"],"status"=>"0","num"=>$_POST["num"]);
		if(date('H')<16)
				$content["date"]=date('Y-m-d');
			else 
				$content["date"]=date("Y-m-d",strtotime("+1 day"));
		$content["orderid"]=0;
		$db->insert($content);
		$db->update(array("orderid"=>0),array('$set'=>array("orderid"=>(string)$content['_id'])));//更改orderid
	}
?>

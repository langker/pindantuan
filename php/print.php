<?php
	include_once "../common/configsql.php";
	include_once "../common/json.php";

	function orderbyorder()//列出所有订单并按照店名排列
	{
		$db = ConnectDB("order");
		
		$row=$db->find(array("date"=>date('Y-m-d')));
		


		$str=array();
		$arr=array();
		$order=array();
		$num=array();
		$nameid="";
		$name="";
		$price=0;
		$date="";
		$status=0;
		//拆分当前所有订单
		foreach($row as $key=>$value)	//order库
		{

			$str=explode("&",$value["goodsid"]);
			$num=explode("+",$value["goodsnum"]);	//先分割每个订单

			$string=$value["isfinish"];
			$h=explode("&",$string);
			//var_dump($h);
			//for($i=0;$i<count($h)-1;$h++)
			//	if(strcmp($h[$i],"1")==0)
			//		break;
			$y=str_replace($_GET["storename"],"1",$string);//进行替换

			
			
			$r=$db->update(array("orderiid"=>$value["orderiid"]),array('$set'=>array("isfinish"=>$y)));
			var_dump($r);
			$nameid=$value["orderid"];
			
			$name="";

			$date=$value["date"];
			//$status=explode("&",$value["isfinish"]);	//上述参数作为临时变量
			$dbs=ConnectDB("user");
			$rows=$dbs->find(array("nameid"=>$value["nameid"]));
			foreach($rows as $key=>$values)
			{
				$name=$values["name"];
			}
			//获得每一个物品的具体参数
			for($i=0;$i<(count($str)-1);$i++)
			{
				
				$dbss = ConnectDB("goods_shoes");	//连接商品库
				//$rows=$db->find(array("goodsid"=>$str,"iskey"=>1));
				$rows=$dbss->find(array("goodssid"=>$str[$i]));
         
				foreach($rows as $key=>$valuess)
				{
					//var_dump("memeda");
					$g=array(
						"pic"=>"photo/".$valuess["goodsid"]."/1.jpg",
						//"title"=>$value["goodsname"],
						"optvalue"=>array($valuess["class1"],$valuess["class2"],$valuess["class3"],$valuess["class4"],$valuess["class5"]),
						"TBPrice"=>$valuess["orgiprice"],
						"PDPrice"=>$valuess["nowprice"],
						"num"=>$num[$i],
						"totalPrice"=>$num[$i]*$valuess["nowprice"],
						"status"=>$status[$i],//此处为我们是否下单
						"name"=>$name,
						"nameid"=>$nameid,
						"date"=>$date,
						//"storename"=>$value[""];
						);
					
					//var_dump("memeda");
					$y=$dbss->find(array("goodsid"=>$valuess["goodsid"],"iskey"=>1));	
					foreach($y as $key=>$valuesss)
					{
						$g["optname"]=array($valuesss["name1"],$valuesss["name2"],$valuesss["name3"],$valuesss["name4"],$valuesss["name5"]);
						$g["title"]=$valuesss["goodsname"];
						$g["storename"]=$valuesss["from"];
						$g["url"]=$valuesss["url"];
						
					}
					//var_dump($g);
					array_push($arr,$g);		
				}
			}

		}//拆分结束，$arr为拆分为当前所有商品订单信息的集合
		
		//var_dump($arr);
		

		$db=ConnectDB("stores");
		$row=$db ->find();//获得当前所有商家
		//$k=0;
		foreach($row as $key=>$value)
		{
			//var_dump($value["storesname"]);
			for($o=0;$o<count($arr);$o++)
			{

				
				if(strcmp($value["storesname"],$arr[$o]["storename"])==0)	//当前订单属于该商家
				{
					//var_dump($arr[$o]["name"]);
					$t=array("status"=>$arr[$o]["status"],
							"stores"=>$arr[$o]["storename"],
							"user"=>$arr[$o]["name"],
							"date"=>$arr[$o]["date"]);
					$t["goods"]=array();
					array_push($t["goods"],$arr[$o]);
					$t["price"]+=$arr[$o]["totalPrice"];
					
					//var_dump($arr[$o]["totalPrice"]);
					
					$db = ConnectDB("receinfo");
					$row=$db->find(array("receinfoid"=>$arr[$o]["nameid"]));
					//var_dump($arr[$o]);
					foreach($row as $key=>$go)
					{
						$t["address"]=$go["address"];
						$t["area"]=$go["area"];
						$t["realname"]=$go["realname"];
						$t["cellphone"]=$go["cellphone"];
					}

					array_push($order,$t);
				}
			
			}

		}//以上代码获得当前所有订单,$order为生成的所有订单
		
		
		$d=array();//按照指定参数筛选
		for($f=0;$f<count($order);$f++)
		{
			//var_dump();
			if(strcmp($_GET["storename"],$order[$f]["stores"])==0)
				array_push($d,$order[$f]);
		}	
		return $d;	//已拆分的所有的订单
	}

	
	$arr=orderbyorder();
	echo "<html><head><meta charset='utf-8'><title>商家订单详情</title><link type='text/css' rel='stylesheet' href='css/pure-min.css'></head><body><div class='storeOrder'><div class='storeHeader'>";
	echo date("Y-m-d")."&nbsp;&nbsp;&nbsp;";
	echo $_GET["storename"];
	$db=ConnectDB("address");

	$row=$db->find();
	//var_dump($arr[1]);
	/*foreach($row as $key=>$value)
	{

		
		for($r=0;$r<count($arr);$r++)
		{
			//var_dump($arr[$r]);
			if(strcmp($value["address"],$arr[$r]["area"])==0)
			{
				echo"<span>地址：</span><span>".$value["address"]."</sapn>
				<span>姓名：</span><span>刘文涛</span><span>电话：</span><span>18328738633</span><span>日期：</span><span>".date("Y-m-d")."</span>";
				echo "<span>物品：</span>";
			}
		}
	}*/
	echo "</span></div><div class='storeDetail'>";
	$row=$db->find();
	//var_dump($arr[$r]["goods"]["0"]["url"]);
	foreach($row as $key=>$value)
	{


		for($r=0;$r<count($arr);$r++)
		{
			if(strcmp($value["address"],$arr[$r]["area"])==0)
			{
				//var_dump($arr[0]);
				echo "<ul><li><span>".$arr[$r]["realname"]."&nbsp;&nbsp;&nbsp;</span><span>".$arr[$r]["cellphone"]."&nbsp;&nbsp;&nbsp;</span><span>".$arr[$r]["address"]."&nbsp;&nbsp;&nbsp;</span><span>".$arr[$r]["goods"][0]["title"]."X".$arr[$r]["goods"][0]["num"]."(".$arr[$r]["goods"][0]["optvalue"][0].$arr[$r]["goods"][0]["optvalue"][1].$arr[$r]["goods"][1]["optvalue"][0].$arr[$r]["goods"][0]["optvalue"][2].$arr[$r]["goods"][0]["optvalue"][3].$arr[$r]["goods"][0]["optvalue"][4]."X".$arr[$r]["goods"][0]["num"].")"."</span>"."&nbsp;&nbsp;&nbsp;<a href='".$arr[$r]["goods"]["0"]["url"]."'>商品链接</a>";
				echo "</li></ul></div></div></body></html>";
			}
		}
	}
				
						
						
						
						
?>
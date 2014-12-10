<?php
	
	include_once "../common/session.php";
	include_once "../common/json.php";
	include_once "../common/goods.php";
	include_once "../common/user.php";
	
	require_once("danbaoapi/alipay.config.php");
	require_once("danbaoapi/lib/alipay_submit.class.php");
	//$_SESSION["buynow"]="bucketid";
	//$_SESSION["nameid"]=1;	//测试数据
	//$_SESSION["goodsid"]="1";

	switch($_POST["func"])
	{
		case "BuyNow":
			if(!empty($_SESSION["nameid"]))
			{
				
				$varstr=AddOrder();
				//var_dump($_POST["num"]);
				Alipay($varstr);break;
			}
			else
				header("Loctaion ".$_SERVER["HTTP_REFERER"]);
		case "GetInfo":
			GetInfo();break;
	}
	function Alipay($orderiid)
	{

		$var=$_POST["goodsid"];
		$foo=ConnectDB("goods_shoes");
		$pay=0;
		for($v=0;$v < count($_POST["goodsid"]);$v++)
		{
			$f=$foo->find(array("goodssid"=>$_POST["goodsid"][$v],"iskey"=>0));
			foreach($f as $key=>$value)
			{
				$pay+=$value["nowprice"]*$_POST["num"][$v];
			}
		}//从数据库计算订单总价

		$parameter = array(
		"service" => "create_partner_trade_by_buyer",
		"partner" => '2088511499375693',//trim($alipay_config['partner']),
		"payment_type"	=> "1",
		"notify_url"	=> "http://www.pindantuan.cn/php/danbaoapi/notify_url.php",
		"return_url"	=> "http://www.pindantuan.cn/myOrder.php",
		"seller_email"	=> "tjzb525@126.com",
		"out_trade_no"	=> $orderiid,
		"subject"	=> "pindantuan",
		"price"	=> (string)$pay,
		"quantity"	=> "1",
		"logistics_fee"	=> "0.00",
		"logistics_type"	=> "EXPRESS",
		"logistics_payment"	=> "SELLER_PAY",
		"body"	=> "",
		"show_url"	=> "",
		"receive_name"	=>"pindantuan", //$_POST["name"],
		"receive_address"	=>"uestc", //$_POST["address"],
		"receive_zip"	=> "18349209818",
		"receive_phone"	=> "18349209818",
		"receive_mobile"	=> "",//$_POST["phone"],
		"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
		);
		//var_dump($_POST);
		//建立请求
		$alipaySubmit = new AlipaySubmit($alipay_config);
		$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
		echo $html_text;
	
	}
	function GetInfo()
	{
		//var_dump($_POST);
		switch($_POST["buynow"])		//设置数据
		{
			case "goodsid":
				SetGoods();break;
			case "bucketid":
				SetBucket();break;
		}
	}
		/*if($_POST["func"]=="BuyNow")
		{
			AddOrder();
		}*/
	//以下代码更新地址信息
	
	
	function SetGoods()
	{
		$t=explode("+",$_POST["goodsid"]);
		$goods = new goods();
		$goods->SetGoodsID($t[0]);
		$good=$goods->SetALL($_POST["num"]);
		$y=$goods->GetClass($_POST["goodsid"]);

		$good["optionValue"][0]=$y[0];
    	$good["optionValue"][1]=$y[1];
    	$good["optionValue"][2]=$y[2];
    	$good["optionValue"][3]=$y[3];
    	$good["optionValue"][4]=$y[4];
    	$good["goodssid"]=$_POST["goodsid"];
    	$good["newPrice"]=$y[5];
    	$good["oriPrice"]=$y[6];
		$user = new user();
		$user ->init($_SESSION["nameid"]);
		$rece=$user->GetRecevinfo();


		echo JSON(array("goods"=>$good,"rece"=>$rece,"method"=>0));
	}
	function SetBucket()
	{	
		$user= new user();
		$user -> init($_SESSION["nameid"]);
		
		echo JSON(array("bucket"=>$user->GetUserBucketByDetail($_POST["goodsid"],$_POST["num"]),"rece"=>$user->GetRecevinfo(),"method"=>1));
	}
	function AddOrder()
	{	
		//以下代码更新地址信息
		$connection = ConnectDB("receinfo");
		$content=array("address"=>$_POST["address"],"cellphone"=>$_POST["phone"],"realname"=>$_POST["name"],"area"=>$_POST["area"]);
		$connection->update(array("receinfoid"=>$_SESSION["nameid"]),array('$set'=>$content));

		//以下代码增加新订单
		$user = new user();
		$user ->init($_SESSION["nameid"]);
		$t=$user ->GetOrderNum();
		$connection = ConnectDB("order");
		
		//var_dump($_POST);
		if(strcmp($_POST["buynow"],"bucketid")==0)
		{
			//$conn=ConnectDB("bucket");
			//$conn->find("bucketid"=>$_SESSION["nameid"]);
			
			//foreach($g as $key=>$value)
			//{
				$b=$_POST["goodsid"];//获得goodssid
				$v=$_POST["num"];//explode("&",$_POST["num"]);//数组
			//}	
			$strb="";
			$strv="";
			$strm="";
			$strg="";
			$goodstore=ConnectDB("goods_shoes");

			for($f=0;$f<count($v);$f++)
			{
				$vargoodsid=explode("+",$b[$f]);
				$row=$goodstore->find(array("goodsid"=>$vargoodsid[0],"iskey"=>1));
				foreach($row as $key=>$values)
				{
					$strg=$strg.$values["from"]."&";//获得商家，用于物流号
				}
				$strb=$strb.$b[$f]."&";
				$strv=$strv.$v[$f]."+";
				$strm=$strm."0&";

			}
			date_default_timezone_set ("Asia/Shanghai");
			$content = array("orderid"=>$_SESSION["nameid"],
						 "orderiid"=>$_SESSION["nameid"]."+".$t,
						 "nameid"=>$_SESSION["nameid"],//用ID还是NAME在讨论
						 "goodsid"=>$strb,
						 "goodsnum"=>$strv,
						 "status"=>$strm,
						 "isfinish"=>$strg,
						 "area"=>$_POST["area"],
						 "wuliuid"=>$strg,	//用于替换
						 "iszhifubao"=>0,
						 "address"=>$_POST["address"]);
						 //"date"=>date('Y-m-d'));
			if(date('H')<16)
				$content["date"]=date('Y-m-d');
			else 
				$content["date"]=date("Y-m-d",strtotime("+1 day"));
			$connection->insert($content);
		
			//以下代码删除购物车的记录
		
			$collection = ConnectDB("bucket");
			$query=array("bucketid"=>$_SESSION["nameid"]);
			$row=$collection->find($query);
			$strgoodsid="";
			$strgoodsnum="";
			foreach($row as $key=>$value)
			{
				$strgoodsid=explode("&",$value["goodsid"]);
				$strgoodsnum=explode("+",$value["goodsnum"]);
			}	//提取BUCKET的字符串

			
			
			
			
			$goodsid=$_POST["goodsid"];
			//var_dump($goodsid);
			for($g=0;$g<count($strgoodsid)-1;$g++)
			{
				for($j=0;$j<count($goodsid);$j++)
				{
					if(strcmp($strgoodsid[$g],$goodsid[$j])==0)	//找到对应的物品进行删除
					{
						$strgoodsid[$j]=0;
						$strgoodsnum[$j]=0;
					}
				}
			}
			
			$str1="";
			$str2="";
			for($t=0;$t<count($strgoodsnum)-1;$t++)
			{
				if($strgoodsnum[$t]!=0)
				{
					$str1=$str1.$strgoodsid[$t]."&";
					$str2=$str2.$strgoodsnum[$t]."+";
				}
			}
			//var_dump($str1);
			$r=array("goodsid"=>$str1,"goodsnum"=>$str2);
			//var_dump($r);
			$where=array("bucketid"=>$_SESSION["nameid"]);
			$collection->update($where,array('$set'=>$r));
		}
		else if(strcmp($_POST["buynow"],"goodssid")==0)
		{
			$goodstore=ConnectDB("goods_shoes");
			$r=explode("+",$_POST["goodsid"][0]);
			$row=$goodstore->find(array("goodsid"=>$r[0],"iskey"=>1));
			//$strh="";
			foreach($row as $key=>$value)
			{
				$strg=$strg.$value["from"]."&";
				
			}
			date_default_timezone_set ("Asia/Shanghai");
			$content = array("orderid"=>$_SESSION["nameid"],
						 "orderiid"=>$_SESSION["nameid"]."+".$t,
						 "nameid"=>$_SESSION["nameid"],
						 "goodsid"=>$_POST["goodsid"][0]."&",
						 "goodsnum"=>$_POST["num"][0]."+",
						 "status"=>"0&",
						 "isfinish"=>$strg,
						 "wuliuid"=>$strg,
						 "area"=>$_POST["area"],
						 "iszhifubao"=>0,
						 "address"=>$_POST["address"]);
			if(date('H')<16)
				$content["date"]=date('Y-m-d');
			else 
				$content["date"]=date("Y-m-d",strtotime("+1 day"));
						
		
			$connection->insert($content);
		}

		return $_SESSION["nameid"]."+".$t;	//return orderiid
	}

?>

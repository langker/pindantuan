<?php
	include_once "../common/session.php";
	include_once "../common/user.php";
	include_once "../common/configsql.php";
	include_once "../common/json.php";
	include_once "../common/comment.php";
	require_once("danbaoapi/alipay.config.php");
	require_once("danbaoapi/lib/alipay_submit.class.php");
	
	switch($_POST["func"])
	{
		case "sendOrder":
			sendOrder();break;
		case "deleteOrder":
			deleteOrder();break;
		case "GetInfo":
			GetInfo();break;
		case "orderCommentFunc":
			AddComment();break;
		case "payment":
			payment();break;
		case "logisticFunc":
			logisticFunc();break;
	}
	function logisticFunc()
	{
		$wuliuarr=array();
		$db=ConnectDB("order");
		$rows=$db->find(array("orderiid"=>$_POST["orderId"]));
		
		
		
		$arr=explode("@",$_POST["wuliuid"]);//$arr[1]为快递公司，$arr[0]为快递号码
		$url ='http://api.kuaidi100.com/api?id=1d9196e1d7b2e747&com='.$arr[1].'&nu='.$arr[0].'&show=0&muti=1&order=asc';
		$curl = curl_init();
  		curl_setopt ($curl, CURLOPT_URL, $url);
  		curl_setopt ($curl, CURLOPT_HEADER,0);
  		curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
  		curl_setopt ($curl, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
  		curl_setopt ($curl, CURLOPT_TIMEOUT,5);
  		$get_content = curl_exec($curl);//获得快递信息
  		curl_close ($curl);
  		$t=json_decode($get_content);
  		//var_dump($t->message);
  		$wuliuarr=array("data"=>$t->data,"orderId"=>(string)$_POST["orderId"],"comany"=>$arr[1],"logisticId"=>$arr[0],"message"=>$t->message);

		
		if($t->state==3)//如果已经收到的话
		{
			//$rows=$db->find(array("orderiid"=>$_POST["orderId"]));
			$var=$db->find(array("orderiid"=>$_POST["orderID"]));
		
			//以下代码用于改变每个物品对应的状态
			$status="";
			$wuliuid="";
			foreach($var as $key=>$value)
			{
				$stauts=explode("&",$value["status"]);
				$wuliuid=explode("&",$value["wuliuid"]);
			}
			for($i=0;$i<count($wuliuid)-1;$i++)
			{
				if(strcmp($wuliuid[$i],$_POST["wuliuid"])==0)
				{
					$status[$i]="2";
				}
			}
			for($r=0;$r<count($status);$r++)
				$status=$status."&";


			$db->update(array("orderiid"=>(string)$_POST["orderId"]),array('$set'=>array("status"=>$status)));//更新订单状态
		}
		echo JSON($wuliuarr);
	}
	function payment()
	{
		$db=ConnectDB("order");
		$rows=$db->find(array("orderiid"=>$_POST["orderId"]));
		//var_dump($_POST["orderId"]);
		$var=array();
		$num=array();
		foreach($rows as $key=>$value)
		{
			$var=explode("&",$value["goodsid"]);
			$num=explode("+",$value["goodsnum"]);
		}
		//var_dump($var);
		//var_dump($num);
		$foo=ConnectDB("goods_shoes");
		$pay=0;
		for($v=0;$v < count($var)-1;$v++)
		{
			$f=$foo->find(array("goodssid"=>$var[$v],"iskey"=>0));
			foreach($f as $key=>$value)
			{
				//var_dump($value["nowprice"]);
				$pay+=$value["nowprice"]*$num[$v];
			}
		}//从数据库计算订单总价
		//var_dump($pay);
		$parameter = array(
		"service" => "create_partner_trade_by_buyer",
		"partner" => '2088511499375693',//trim($alipay_config['partner']),
		"payment_type"	=> "1",
		"notify_url"	=> "http://www.pindantuan.cn/php/danbaoapi/notify_url.php",
		"return_url"	=> "http://www.pindantuan.cn/myOrder.php",
		"seller_email"	=> "tjzb525@126.com",
		"out_trade_no"	=> $_POST["orderId"],
		"subject"	=> "pindantuan",
		"price"	=> (string)$pay,
		"quantity"	=> "1",
		"logistics_fee"	=> "0.00",
		"logistics_type"	=> "EXPRESS",
		"logistics_payment"	=> "SELLER_PAY",
		"body"	=> "",
		"show_url"	=> "",
		"receive_name"	=> "uestc",
		"receive_address"	=> "uestc",
		"receive_zip"	=> "",
		"receive_phone"	=> "18349209818",
		"receive_mobile"	=> "",//$_POST["phone"],
		"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
		);

		//建立请求
		$alipaySubmit = new AlipaySubmit($alipay_config);
		$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
		echo $html_text;
	}
	function GetInfo()						//载入时获得信息
	{
		$user = new user();
		$user -> init($_SESSION["nameid"]);
		
		echo JSON($user -> GetUserOrder());
	}
	function sendOrder()				//进行下单
	{

		$_SESSION["orderid"]=$_POST["num"];		
		//当前的订单ID保存到SESSION里面，然后在支付宝回调页面进行状态修改
	}
	function deleteOrder()	//删除订单
	{
		$collection = ConnectDB("order");
		
		
		$where=array('orderiid'=>(string)$_POST["num"]);
	 	$collection->remove($where);

		
	}
	function AddComment()
	{
		$comment = new comment();
		$comment->SetGoodsID($_POST["goodsId"]);
		$db = ConnectDB("goods_shoes");
		$row=$db->find(array("goodsid"=>$_POST["goodsId"]));
		$goodsname="";
		foreach($row as $key=>$value)
		{
			$goodsname=$value["goodsname"];
		}
		$comment->AddComment($_POST["orderContent"],$_SESSION["name"],$goodsname);//添加评论
		//添加评论后用于更改状态
		$db = ConnectDB("order");
		$row=$db->find(array("orderiid"=>$_POST["orderId"]));
		$status="";
		$goodsid="";
		foreach($row as $key=>$value)
		{
			$status=explode("&",$value["status"]);
			$goodsid=explode("&",$value["goodsid"]);
		}
		for($i=0;$i<count($status)-1;$i++)
		{
			if(strcmp($goodsid[$i],$_POST["goodsId"])==0)
			{
				$status[$i]="3";
			}
		}
		$v="";
		for($r=0;$r<count($status);$r++)
		{
			$v=$v.$status[$r];
		}
		//var_dump($_POST);
		$db->update(array("orderiid"=>$_POST["orderid"]),array('$set'=>array("status"=>$v)));
		//header("location: http://www.pindantuan.cn/myOrder.php");//重定向
	}
	
?>

<?php
	include_once "../common/session.php";
	include_once "../common/comment.php";
	include_once "../common/json.php";
	include_once "../common/user.php";
	include_once "../common/goods.php";
	
	switch($_POST["func"])
	{
		case "AddBucket":
			AddBucket();break;
		case "GetInfo":
			Getinfo();break;
		case "BuyNow":
			BuyNow();break;
	}
	
	function GetInfo()						//初始化时更新信息
	{
		$goods = new goods();
		$user = new user();
		$user -> init($_SESSION["nameid"]);
		//$_POST["goodsid"]="1";	//测试代码
		$goods ->SetGoodsID((string)$_POST["goodsid"]);			//一定要为字符串,强制转成string防止SQL注入
		$array = $goods->GetDetail();
		$comment = new comment();
		$comment -> SetGoodsID($_POST["goodsid"]);
		$urlbucket="bucket.html";								//这两个是死
		$urlbuynow="settlement.html";							//参数
		array_push($array,$comment -> GetComment(),$urlbucket,$urlbuynow);
		//NewVisit();		//添加当前访问地址
		echo JSON($array);
	}
	function AddBucket()								//增加购物车时的函数
	{
		$user = new user();
		$user ->init($_SESSION["nameid"]);
		//echo $_POST["goodssid"].$_POST["num"];
		//在购物车里写入商品信息
		//var_dump($_SESSION["nameid"]);
		$user -> SetNewUserBucket($_POST["goodssid"],$_POST["num"]);		
		
	}
	function BuyNow()									//用来标识从哪个页面跳转来的
	{
		$_SESSION["buynow"]="goodsid";					//标识来自立即购买
		$_SESSION["goodsid"]=$_POST["goodssid"];//记录goodssid
		$_SESSION["num"]=$_POST["num"];			
	}
	function NewVisit()
	{
		//if(isset($_SESSION["nameid"]))	登陆后是否让浏览需要谈论
		if($_SESSION["visitnum"]%3==0||!isset($_SESSION["visitnum"]))
			$_SESSION["visitnum"]=1;
		else
			$_SESSION["visitnum"]++;

		
		//$arr=$goods->GetVisitedGood();
		$array=array("web".$_SESSION["visitnum"]=>"detail.php?id=".$_POST["goodsid"],
					 "photo".$_SESSION["visitnum"]=>"photo/".$_POST["goodsid"]."/1.jpg",
					 "name".$_SESSION["visitnum"]=>$_POST["goodsname"]
			            );
		$where=array("nameid"=>$_SESSION["nameid"]);
		$collection = ConnectDB("lastvisited");
		$collection->update($where,array('$set'=>$array));
	}


?>

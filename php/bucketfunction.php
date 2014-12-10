<?php
	include_once "../common/session.php";
	include_once "../common/json.php";
	include_once "../common/user.php";
	switch($_POST["func"])			//根据函数判断
	{
		case "GetInfo":
			GetInfo();break;
		//case "BuyBucket":
		//	BuyBucket();break;
		case "deleteGoods":
			deleteGoods();break;
		case "AddSub":
			AddSub();break;

	}
	function GetInfo()						//载入时获得信息
	{
		if(!isset($_SESSION["nameid"]))
			return;
			//var_dump(isset($_SESSION["nameid"]));
		$user = new user();
		$user->init($_SESSION["nameid"]);
		echo JSON($user->GetUserBucket());	
	}
	function AddSub()	//对当前的物品数量进行修改进行修改
	{
		
		$collection = ConnectDB("bucket");
		
		$query = array("bucketid"=>$_SESSION["nameid"]);
		$row = $collection->find($query);
		$str1="";
		$str2="";
		foreach($row as $key=>$value)
		{
			$str1=$value["goodsid"];
			$str2=$value["goodsnum"];
		}
		$str1=explode("&",$str1);	//改成数组
		$str2=explode("+",$str2);

	 	for($i=0;$i<count($str1)-1;$i++)
	 	{
	 		for($a=0;$a<count($_POST["goods"]);$a++)
	 		{
	 			if(strcmp($_POST["goods"][$a],$str1[$i])==0)
	 			{
	 				$str2[$i]=$_POST["num"];
	 			}
	 		}
	
	 	}
	 	
	 	$r="";
	 	$t="";
	 	for($h=0;$h<count($str1)-1;$h++)
	 	{
	 		
	 			$r=$r.$str1[$h]."&";
	 			$t=$t.$str2[$h]."+";
	 		
	 	}

	 	$arr=array("goodsid"=>$r,"goodsnum"=>$t);

	 	$where=array('bucketid'=>$_SESSION["nameid"]);
	 	$collection->update($where,array('$set'=>$arr));

	}

	function deleteGoods()			//删除商品
	{	
		//echo json_encode($_POST["goodssid"]);
		
		$collection = ConnectDB("bucket");
		$query=array('bucketid'=>$_SESSION["nameid"]);
		$row=$collection->find($query);
		$str="";
		$num="";
		foreach($row as $key=>$value)		//查询当前bucket里面的商品数量并修改
		{
			$str=$value["goodsid"];
			$num=$value["goodsnum"];
		}

		$g=$_POST["goodssid"];	//传递数组
		

		//寻找goodsid对应的num的位置 进行分割字符串
		$e=explode("&",$str);
		$n=explode("+",$num);

		for($a=0;$a<count($g);$a++)			//第一个循环实现			
		{
			for($r=0;$r<count($e)-1;$r++)
			{
				if(strcmp($e[$r],$g[$a])==0)
				{
					$n[$r]=0;
					break;	
				}
			}
			//对发过来的数组里的每个物品进行替换
			$str=str_replace($g[$a]."&","",$str);		

		}
		//var_dump($n);
		$anum="";
		for($t=0;$t<count($n)-1;$t++)
		{
			if($n[$t]!=0)
				$anum=$anum.$n[$t]."+";
		}
		
		$arr=array("goodsid"=>$str,"goodsnum"=>$anum);
		$where=array('bucketid'=>$_SESSION["nameid"]);
	 	$collection->update($where,array('$set'=>$arr));//更新数据
	
		echo JSON(TRUE);
	}
?>

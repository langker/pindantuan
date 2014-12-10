<?php
	include_once "../common/configsql.php";
	include_once "../common/json.php";
	include_once "../common/session.php";
	

	//if($_SESSION["admin"]!=1)
	//	return;
	$db = ConnectDB("goods_shoes");	//连接数据库
	date_default_timezone_set('Asia/Shanghai'); 
	switch($_POST["func"])
	{
		case "CancelOfflineOrderStatus":
			CancelOfflineOrderStatus();break;
		case "OrderForOfflined":
			OrderForOffline("1");break;
		case "OrderForOffline":
			OrderForOffline("0");break;
		case "ChangeOfflineOrderStatus":
			ChangeOfflineOrderStatus();break;
		case "allCommen":
			allCommen();break;
		case "allOrder":
			allOrder();break;
		case "goodsCreate":
			goodsCreate($_POST["type"]);break;
		case "editeGoods":
			editeGoods();break;
		case "deleteGoods":
			deteleGoods();break;
		case "goodsShow":
			goodsShow();break;
		//case "allOrder":
		//	allOrder();break;
		case "requestKinds":
			requestKinds();break;
		case "init":
			init();break;
		case "finishedOrder":
			finishedOrder("1");break;
		case "finishOrder":
			finishedOrder("0");break;
		case "finishedCommon":
			finishedCommon(0);break;
		case "finishCommon":
			finishedCommon(1);break;
		case "deleteGoodsShow":
			deleteGoodsShow();break;
		case "pushGoods":
			pushGoods();break;
		case "GetStoreName":
			GetStoreName(1);break;
		case "PostStoreName":
			GetStoreName(0);break;
		case "orderNumber":
			orderNumber();break;
		case "orderNumberCreate":
			orderNumberCreate();break;
		case "Statistics":
			Statistics();break;
		case "postPay":
			postPay();break;
		case "deleteWillOrder":
			deleteWillOrder();break;
     	case "setSheet":
     		setSheet();break;
     	case "includeFunc":
     		includeFunc();break;
     	case "AddArticle":
     		AddArticle();break;
    }
    function AddArticle()
    {
    	$art=$_POST["article"];
    	$db=ConnectDB("article");
    	$phase=$db->find()->count();
    	$str=str_replace("\"","\'",$_POST["content1"]);
    	$array=array("content"=>$str,"date"=>$_POST["date"],"title"=>$_POST["title"],"like"=>0,"goodsid"=>explode("&",$_POST["goodsId"]),"id"=>0,"iskey"=>0,"goodsTit"=>$_POST["goodsTit"],"phase"=>$phase);
    	var_dump($db->insert($array));
    	$db->update(array("id"=>0),array('$set'=>array("id"=>(string)$array['_id'])));
    	$_SESSION["artid"]=$array['_id'];
    }
    function includeFunc()
    {
    	$db = ConnectDB("order");
		
		$row=$db->find();
		//$totalOrder=$db->find()->count();

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
		foreach($row as $key=>$value)
		{
			$str=explode("&",$value["goodsid"]);
			$num=explode("+",$value["goodsnum"]);	//先分割每个订单
			//$status=explode("");
			


			$date=$value["date"];
			$status=explode("&",$value["status"]);	//上述参数作为临时变量
			

			//获得每一个物品的具体参数
			for($i=0;$i<(count($str)-1);$i++)
			{
				
				$db = ConnectDB("goods_shoes");	//连接商品库
				
				$rows=$db->find(array("goodssid"=>$str[$i]));
         
				foreach($rows as $key=>$value)
				{
					//var_dump("memeda");
					$g=array(
						"TBPrice"=>$value["orgiprice"],
						"PDPrice"=>$value["nowprice"],
						"totalPrice"=>$num[$i]*$value["nowprice"],
						"num"=>$num[$i],
						"status"=>$status[$i],//此处为订单状态
						"date"=>$date,
						//"storename"=>$value[""];
						);
					$t=explode("+",$str[$i]);
					$row=$db->find(array("goodsid"=>$t[0],"iskey"=>1));
					foreach($row as $key=>$values)
					{
						$g["purchase"]=$values["purchase"];
					}
					
					array_push($arr,$g);		
				}
			}
		}//拆分结束，$arr为拆分为当前所有商品订单信息的集合

		$totalOrder=count($arr);//总订单数
		//date_default_timezone_set('Asia/Shanghai'); 
		$todayProfit=0;
		$todayIncome=0;
		$todayOrder=0;
		$todaySave=0;
		$todayUnfinishedOrder=0;
		for($i=0;$i<count($arr);$i++)
		{
			if(strcmp($arr[$i]["status"],"1")==0&&strcmp(date("Y-m-d"),$arr[$i]["date"])==0)//当前订单已经付款
			{
				$todayProfit+=($arr[$i]["PDPrice"]-$arr[$i]["purchase"])*$arr[$i]["num"];//今日利润
				
				$todayIncome+=$arr[$i]["totalPrice"];//今日收入
				$todaySave+=($arr[$i]["TBPrice"]-$arr[$i]["PDPrice"])*$arr[$i]["num"];
				//var_dump($arr[$i]["purchase"]);
				$todayOrder++;//今日订单
			}
			if(strcmp($arr[$i]["status"],"0")==0&&strcmp(date("Y-m-d"),$arr[$i]["date"])==0)
			{
				$todayUnfinishedOrder++;//今日未完成
			}
		}
		$i=0;
		$totalProfi=0;
		$totalSave=0;
		$totalUnfinishedOrder=0;
		$status=0;


		$db=ConnectDB("statistics");
		$istoday=$db->find(array("date"=>date("Y-m-d")))->count();
		

		if($istoday)//找到了今日的记录，加上今日记录直接显示
		{
			$rows=$db->find(array("date"=>date("Y-m-d")));
			foreach($rows as $key=>$value)	
			{
				$totalProfi=$value["totalProfi"]+$todayProfit;
				$totalSave=$value["totalSave"]+$todaySave;
				$status=$value["status"];
				$db->update(array("date"=>date("Y-m-d")),array('$set'=>array("totalSave"=>$totalSave,"totalProfi"=>$totalProfi)));
				
			}

		}
		else
		{
		
			$isyesterday=$db->find(array("date"=>date("Y-m-d",strtotime("-1 day"))))->count();//寻找昨天的记录
			if(!$isyesterday)//没有昨天记录，进行初始化操作
			{
				$totalProfi=$todayProfit;
				$totalSave=$todaySave;
				$totalUnfinishedOrder=$todayUnfinishedOrder;
				$db->insert(array("status"=>0,"totalProfi"=>$totalProfi,"totalSave"=>$totalSave,"totalUnfinishedOrder"=>$totalUnfinishedOrder,"date"=>date("Y-m-d")));
			}
			else//昨天有记录，新增今日记录
			{
				foreach($rows as $key=>$value)
				{
					$totalProfi=$value["totalProfi"]+$todayProfit;
					$totalSave=$value["totalSave"]+$todaySave;
					$totalUnfinishedOrder=$value["totalUnfinishedOrder"]+$todayUnfinishedOrder;
				}
			
				$status=0;
				$db->insert(array("status"=>$status,"totalProfi"=>$totalProfi,"totalSave"=>$totalSave,"totalUnfinishedOrder"=>$totalUnfinishedOrder,"date"=>date("Y-m-d")));
			}
		}

		//echo JSON(array("status"=>$status,"todayProfit"=>$todayProfit,"todayIncome"=>$todayIncome,"totalOrder"=>$totalOrder,"todayOrder"=>$todayOrder,"todayUnfinishedOrder"=>$todayUnfinishedOrder,"totalProfi"=>$totalProfi,"totalSave"=>$totalSave,"totalUnfinishedOrder"=>$totalUnfinishedOrder));
		
		

    }
    function setSheet()
    {
    	$db = ConnectDB("order");
        
        $row=$db->find(array("date"=>date("Y-m-d",strtotime("-1 day"))));//获取当日订单
        
        $arr=array();
        $date="";
        $orderiid="";
        $orderid="";
        $store=array();
        $area="";
        $name="";
        $cellphone="";
       
        foreach($row as $key=>$value)
        {
            
            if(strstr($value["status"],"1"))//没付款不显示哼
            {   
                $orderiid=$value["orderiid"];
                $date=$value["date"];
                $area=$value["area"];
                $dbs=ConnectDB("receinfo");
                $rows=$dbs->find(array("receinfoid"=>$value["orderid"]));
                foreach($rows as $key=>$values)
                {
                    $name=$values["realname"];
                    $cellphone=$values["cellphone"];
                }
                //$dbs=ConnectDB("goods_shoes");
                //$dbs->find();
                //var_dump(count(array_unique(explode("&",$value["wuliuid"]))));
                $p=array_unique(explode("&",$value["wuliuid"]));
                for($i=0;$i<count($p)-1;$i++)
                    array_push($arr,array("store"=>$p[$i],"name"=>$name,"cellphone"=>$cellphone,"date"=>$date,"address"=>$area,"orderid"=>$orderiid,"status"=>0));
            }
            else
                continue;
        }
    



        $dbs=ConnectDB("orderforoffline");
        
        $row=$dbs->find(array("date"=>date("Y-m-d",strtotime("-1 day")),"status"=>"0"));//获取当日订单
        //var_dump(array("date"=>date('Y-m-d')));
        
        foreach($row as $key=>$value)
        {
            //var_dump("memeda");
            $orderiid=$value["orderid"];
            $date=$value["date"];
            $num=$value["num"];
            $goodssid=$value["goodssid"];
            $name=$value["name"];
            $cellphone=$value["cellphone"];
            $db=ConnectDB("goods_shoes");
            $t=explode("+",$goodssid);
            $rows=$db->find(array("goodsid"=>$t[0],"iskey"=>1));
            $from="";
            foreach($rows as $key=>$values)
            {
            	$from=$values["from"];
            }
            $rows=$db->find(array("goodssid"=>$goodssid));
            $price="";
            foreach($rows as $key=>$values)
            {
            	$price=$values["nowprice"]*$num;
            }
            array_push($arr,array("price"=>$price,"store"=>$from,"name"=>$name,"cellphone"=>$cellphone,"date"=>$date,"address"=>"电子科技大学沙河校区","orderid"=>$orderiid,"status"=>"1"));
            
        }
        echo JSON($arr);
		
    }
	function CancelOfflineOrderStatus()
	{
		$db=ConnectDB("orderforoffline");
		$r=$db->update(array("order"=>$_POST["orderid"]),array('$set'=>array("status"=>"0")));
		echo $r;
	}
	function deleteWillOrder()
	{
		$db=ConnectDB("orderforoffline");
		$r=$db->remove(array("order"=>$_POST["orderid"]));
		echo $r;
	}
	function postPay()
	{
		$db=ConnectDB("statistics");
		$row=$db->find(array("date"=>date('Y-m-d'),"status"=>0));
		$r=0;
		foreach($row as $key=>$value)
		{
			$r=$db->update(array("date"=>date('Y-m-d'),"status"=>0),array('$set'=>array("totalProfi"=>$value["totalProfi"]-$_POST["money"],"stauts"=>1)));
		}
		echo $r;
	}
	function Statistics()
	{
		$db = ConnectDB("order");
		
		$row=$db->find();
		//$totalOrder=$db->find()->count();

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
		foreach($row as $key=>$value)
		{
			$str=explode("&",$value["goodsid"]);
			$num=explode("+",$value["goodsnum"]);	//先分割每个订单
			//$status=explode("");
			


			$date=$value["date"];
			$status=explode("&",$value["status"]);	//上述参数作为临时变量
			

			//获得每一个物品的具体参数
			for($i=0;$i<(count($str)-1);$i++)
			{
				
				$db = ConnectDB("goods_shoes");	//连接商品库
				
				$rows=$db->find(array("goodssid"=>$str[$i]));
         
				foreach($rows as $key=>$value)
				{
					//var_dump("memeda");
					$g=array(
						"TBPrice"=>$value["orgiprice"],
						"PDPrice"=>$value["nowprice"],
						"totalPrice"=>$num[$i]*$value["nowprice"],
						"num"=>$num[$i],
						"status"=>$status[$i],//此处为订单状态
						"date"=>$date,
						//"storename"=>$value[""];
						);
					$t=explode("+",$str[$i]);
					$row=$db->find(array("goodsid"=>$t[0],"iskey"=>1));
					foreach($row as $key=>$values)
					{
						$g["purchase"]=$values["purchase"];
					}
					
					array_push($arr,$g);		
				}
			}
		}//拆分结束，$arr为拆分为当前所有商品订单信息的集合

		$totalOrder=count($arr);//总订单数
		//date_default_timezone_set('Asia/Shanghai'); 
		$todayProfit=0;
		$todayIncome=0;
		$todayOrder=0;
		$todaySave=0;
		$todayUnfinishedOrder=0;
		for($i=0;$i<count($arr);$i++)
		{
			if(strcmp($arr[$i]["status"],"1")==0&&strcmp(date("Y-m-d"),$arr[$i]["date"])==0)//当前订单已经付款
			{
				$todayProfit+=($arr[$i]["PDPrice"]-$arr[$i]["purchase"])*$arr[$i]["num"];//今日利润
				
				$todayIncome+=$arr[$i]["totalPrice"];//今日收入
				$todaySave+=($arr[$i]["TBPrice"]-$arr[$i]["PDPrice"])*$arr[$i]["num"];
				//var_dump($arr[$i]["purchase"]);
				$todayOrder++;//今日订单
			}
			if(strcmp($arr[$i]["status"],"0")==0&&strcmp(date("Y-m-d"),$arr[$i]["date"])==0)
			{
				$todayUnfinishedOrder++;//今日未完成
			}
		}
		$i=0;
		$totalProfi=0;
		$totalSave=0;
		$totalUnfinishedOrder=0;
		$status=0;


		$db=ConnectDB("statistics");
		$istoday=$db->find(array("date"=>date("Y-m-d")))->count();
		

		if($istoday)//找到了今日的记录，加上今日记录直接显示
		{
			$rows=$db->find(array("date"=>date("Y-m-d")));
			foreach($rows as $key=>$value)	
			{
				$totalProfi=$value["totalProfi"];
				$totalSave=$value["totalSave"];
				$status=$value["status"];
				//$db->update(array("date"=>date("Y-m-d")),array('$set'=>array("totalSave"=>$totalSave,"totalProfi"=>$totalProfi)));
				
			}

		}
		else
		{
		
			$isyesterday=$db->find(array("date"=>date("Y-m-d",strtotime("-1 day"))))->count();//寻找昨天的记录
			if(!$isyesterday)//没有昨天记录，进行初始化操作
			{
				$totalProfi=$value["totalProfi"]+$todayProfit;
				$totalSave=$value["totalSave"]+$todaySave;
				$totalUnfinishedOrder=$todayUnfinishedOrder;
				//$db->insert(array("status"=>0,"totalProfi"=>$totalProfi,"totalSave"=>$totalSave,"totalUnfinishedOrder"=>$totalUnfinishedOrder,"date"=>date("Y-m-d")));
			}
			else//昨天有记录，新增今日记录
			{
				foreach($rows as $key=>$value)
				{
					$totalProfi=$value["totalProfi"]+$todayProfit;
					$totalSave=$value["totalSave"]+$todaySave;
					$totalUnfinishedOrder=$value["totalUnfinishedOrder"]+$todayUnfinishedOrder;
				}
			
				$status=0;
				//$db->insert(array("status"=>$status,"totalProfi"=>$totalProfi,"totalSave"=>$totalSave,"totalUnfinishedOrder"=>$totalUnfinishedOrder,"date"=>date("Y-m-d")));
			}
		}

		echo JSON(array("status"=>$status,"todayProfit"=>$todayProfit,"todayIncome"=>$todayIncome,"totalOrder"=>$totalOrder,"todayOrder"=>$todayOrder,"todayUnfinishedOrder"=>$todayUnfinishedOrder,"totalProfi"=>$totalProfi,"totalSave"=>$totalSave,"totalUnfinishedOrder"=>$totalUnfinishedOrder));
	}

	function ChangeOfflineOrderStatus()
	{
		$db=ConnectDB("orderforoffline");
		$result=$db->update(array("orderid"=>$_POST["orderid"]),array('$set'=>array("status"=>"1")));
		$rows=$db->find(array("orderid"=>$_POST["orderid"]));
		$goodsid="";
		foreach($rows as $key=>$value)
		{
			$goodsid=$value["goodssid"];
		}
		
		$db=ConnectDB("goods_shoes");
		$t=explode("+",$goodsid);
		$row=$db->find(array("goodsid"=>$t[0],"iskey"=>1));
		foreach($row as $key=>$value)
		{

			$db->update(array("goodsid"=>$t[0],"iskey"=>1),array('$set'=>array("sellnum"=>$value["sellnum"]+1)));
		}
		echo $result;
	}
	function OrderForOffline($f)
	{
		$dbs=ConnectDB("orderforoffline");
		$rows=$dbs->find(array("status"=>$f));
		//var_dump($f);
		$goodssid="";
		$num=0;
		$orderid="";
		$date="";
		$name="";
		$tel="";
		$tatalprice=0;
		$arr=array();
		foreach($rows as $key=>$values)
		{
			//var_dump("memeda");
			$goodsid=$values["goodssid"];
			$num=$values["num"];
			$orderid=$values["orderid"];
			$date=$values["date"];
			$name=$values["name"];
			$tel=$values["tel"];
			$db=ConnectDB("goods_shoes");
			$rows=$db->find(array("goodssid"=>$goodsid,"iskey"=>0));
        	//$arr=array();
			foreach($rows as $key=>$value)
			{
				$totalprice=$num*$value["nowprice"];
				$g=array(
				"pic"=>"photo/".$value["goodsid"]."/1.jpg",
				"optvalue"=>array($value["class1"],$value["class2"],$value["class3"],$value["class4"],$value["class5"]),
				"TBPrice"=>$value["orgiprice"],
				"PDPrice"=>$value["nowprice"],
				"num"=>$num[$i],
				"totalPrice"=>$num*$value["nowprice"]);
				
				$y=$db->find(array("goodsid"=>$value["goodsid"],"iskey"=>1));	
				foreach($y as $key=>$value)
				{
					$g["optname"]=array($value["name1"],$value["name2"],$value["name3"],$value["name4"],$value["name5"]);
					$g["title"]=$value["goodsname"];
				}
				$g["orderid"]=$orderid;
				$g["date"]=$date;
				array_push($arr,array("goods"=>array($g),"id"=>$orderid,"tel"=>$tel,"date"=>$date,"price"=>$totalprice,"user"=>$name,"status"=>$f));		
			}
		}
		echo JSON($arr);
	}


	
	function orderNumberCreate()
	{
		$array=$_POST["order"];
		//var_dump($array["date"]);
		$db=ConnectDB("order");
		$row=$db->find(array("iszhifubao"=>0,"area"=>$array["address"],"date"=>$array["date"]));
		
		foreach($row as $key=>$value)
		{

			$r=str_replace($array["storeName"],$array["number"]."@".$array["express"],$value["wuliuid"]);//将当前订单中的商品买家替换成物流号
			
			$db->update(array("iszhifubao"=>0,"area"=>$array["address"],"date"=>$array["date"]),array('$set'=>array("wuliuid"=>$r)));//进行物流号的填写
		}
		$row=$db->find(array("iszhifubao"=>0,"area"=>$array["address"],"date"=>$array["date"]));//订单号
		$dbstore=ConnectDB("stores");
		$rows=$dbstore->find();//商家

		foreach($rows as $key=>$values)
		{
			foreach($row as $key=>$value)
			{
				if(!strstr($value["wuliuid"],$values["storesname"]))//判断是否填充完整
				{
					$db->update(array("orderiid"=>$value["orderiid"]),array('$set'=>array("iszhifubao"=>1)));//如果都填完了，就设置该标志为1
				}
			}

		}
		echo TRUE;
	}
	function orderNumber()
	{
		$arr=array();
		$db=ConnectDB("order");
		$dbstore=ConnectDB("stores");
		$rows=$dbstore->find();
		$row=$db->find(array("iszhifubao"=>0));
		foreach($rows as $key=>$values)
		{
			foreach($row as $key=>$value)	//拆分所有订单
			{
				
				
			
				if(strstr($value["wuliuid"],$values["storesname"]))
				{//当前商户若在订单中，则添加，
					array_push($arr,array("date"=>$value["date"],"address"=>$value["area"],"storeName"=>$values["storesname"]));
					break;
				}
			}
			
		}
		echo JSON($arr);
	}
	function GetStoreName($isfinished)
	{
		$db = ConnectDB("order");
		
		$row=$db->find();
		

		$str=array();
		$arr=array();
		$order=array();
		$num=array();
		$nameid="";
		$name="";
		$price=0;
		$date="";
		$status=0;
		$orderiid="";
		//拆分当前所有订单
		foreach($row as $key=>$value)
		{
			$str=explode($value["goodsid"],"&");
			$num=explode($value["goodsnum"],"+");	//先分割每个订单

			$orderiid=$value["orderiid"];
			$nameid=$value["orderid"];
			$name=$value["name"];
			$date=$value["date"];
			$status=$value["isfinish"];	//上述参数作为临时变量


			//获得每一个物品的具体参数
			for($i=0;$i<count($num);$i++)
			{

				$db = ConnnectDB("goods_shoes");	//连接商品库
				//$rows=$db->find(array("goodsid"=>$str,"iskey"=>1));
				$rows=$db->find(array("goodssid"=>$str[$i]));

				foreach($rows as $key=>$value)
				{
					
					$g=array(
						"pic"=>"photo/".$value["goodsid"]."1.jpg",
						//"title"=>$value["goodsname"],
						"optvalue"=>array($value["calsss1"],$value["calsss2"],$value["calsss3"],$value["calsss4"],$value["calsss5"]),
						"TBPrice"=>$value["orgiprice"],
						"PDPrice"=>$value["nowprice"],
						"num"=>$num[$i],
						"totalPrice"=>$num[$i]*$value["nowprice"],
						"status"=>$status,//此处为我们是否下单
						"name"=>$name,
						"date"=>$date,
						"goodssid"=>$str[$i]
						//"storename"=>$value[""];
						);
					//$price+=$num[$i]*$value["nowprice"];
					$y=$db->find(array("goodsid"=>$value["goodsid"],"iskey"=>1));	
					foreach($y as $key=>$value)
					{
						$g["optname"]=array($value["name1"],$value["name2"],$value["name3"],$value["name4"],$value["name5"]);
						$g["title"]=$value["goodsname"];
						$g["storename"]=$value["from"];
					}
					array_push($arr,$g);		
				}
			}
		}//拆分结束，$arr为拆分为当前所有商品订单的集合
		

		
		

		
		for($o=0;$o<count($arr);$o++)
		{
			if(strcmp($_POST["storeName"],$arr[$o]["storename"])==0)	//当前订单属于该商家
			{
				$db = ConnectDB("order");
				$db->find(array("orderiid"=>$orderiid));	//获得当前订单
				foreach($rows as $key=>$value)
				{
					$a=explode($value["goodsid"],"&");
					$b=explode($value["isfinish"],"&");
					//分割对应的下单状态
					for($p=0;$p<count($a);$p++)	//进行更改
						if(strcmp($a[$p],$arr[$o]["goodssid"])==0)
							$b[$p]=$isfinished;
				}
				$l="";
				for($h=0;$h<count($b);$h++)
				{
					$l=$l.$b[$h]."&";
				}
				$db->update(array("orderiid"=>$orderiid),array('$set'=>array("isfinish"=>$l)));
					
			}
				
		}

		


	}
	function pushGoods()
	{
		$db=ConnectDB("goods_shoes");
		$db->update(array("goodsname"=>$_POST["name"],"iskey"=>1),array('$set'=>array("status"=>1)));
		echo JSON(TRUE);
	}
	function deleteGoodsShow()
	{
		$db=ConnectDB("goods_shoes");
		$goods=array();
		if($_POST["name"]=="")
			$query=array("status"=>0,"iskey"=>1);
		else
			$query=array("status"=>0,"iskey"=>1,"from"=>$_POST["name"]);
		$row=$db->find($query);
		foreach($row as $key=>$value)
		{
			$g=array("title"=>$value["goodsname"],
				"name"=>$value["from"],
				"sales"=>$value["sellnum"],
				"img"=>"photo/".$value["goodsid"]."/1.jpg");
			array_push($goods,$g);
		}
		echo JSON($goods);;
	}
	function allCommen()
	{
		$db = ConnectDB("comment");
		$row=$db->find();
		$comment=array();
		foreach($row as $key=>$value)
		{
			$g=array(
				"user"=>$value["name"],
				"date"=>$value["time"],
				"status"=>$value["isfinish"],
				"content"=>$value["detail"],
				"goodsname"=>$value["goodsname"]);
			array_push($comment,$g);
		}
		//以上comment为所有的评论
		$arr=array();
		//echo JSON($comment);
		if($_POST["type"]==0)
			for($i=0;$i<count($g);$i++)
			{
				if(strcmp($_POST["value"],$g["user"]))
					array_push($arr,array("comment"=>$g));
			}
		else if($_POST["type"]==1)
		{
			$row=$db->find();
			$rows=$row->$rows->sort(array("time"=>1));
			foreach($row as $key=>$value)
			{
				$g=array(
					"user"=>$value["name"],
					"date"=>$value["time"],
					"status"=>$value["isfinish"],
					"content"=>$value["detail"],
					"goodsname"=>$value["goodsname"]);
				array_push($comment,array("common"=>$g));
			}
			//var_dump($comment);
			echo JSON($comment);

		}
		else if($_POST["type"]==2)
			for($i=0;$i<count($g);$i++)
			{
				if(strcmp($_POST["value"],$g["time"]))
					array_push($arr,array("comment"=>$g));
			}

		echo JSON($arr);
	}
	function finishedCommon($b)	//参数$b为comment的status，1为已阅，0为未阅，
	{
		$db = ConnectDB("comment");
		date_default_timezone_set('Asia/Shanghai'); 
		$row=$db->find(array("status"=>$b,"time"=> new MongoRegex("/.*".date("Y-m-d").".*/i")));
		//var_dump(date("Y-m-d"));
        
		$comment=array();
		foreach($row as $key=>$value)
		{
			$g=array(
				"user"=>$value["name"],
				"date"=>$value["time"],
				"status"=>$value["status"],
				"content"=>$value["detail"]);
			array_push($comment,$g);
			//$db->update(array("name"=>$value["name"],"content"=>$value["detail"]),array('$set'=>array("status"=>1)));
		}
		//$set=array("status"=>1);	//更改当前状态为已阅
		//$db->update(array(),array('$set'=>$set));
		echo JSON($comment);
	}

	function allOrder()
	{
		switch($_POST["type"])
		{
			case 0:
				orderbyorder("stores");break;
			case 1:
				orderbyorder("user");break;
			case 2:
				orderbyorder("area");break;
			case 3:
				orderbyorder("status");break;
			case 4:
				orderbyorder("order");break;
			case 5:
				orderbyorder("date");break;
			case 6:
				orderbyorder("all");break;
		}
		
	}
	function orderbyorder($bbb)//参数为按照什么筛选,获得所有的订单并按照$bbb筛选
	{
		$db = ConnectDB("order");
		
		$row=$db->find();
		

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
		foreach($row as $key=>$value)
		{
			$str=explode("&",$value["goodsid"]);
			$num=explode("+",$value["goodsnum"]);	//先分割每个订单
			//$status=explode("");

			$nameid=$value["orderid"];
			
			$name="";

			$date=$value["date"];
			$status=explode("&",$value["status"]);	//上述参数作为临时变量
			$dbs=ConnectDB("user");
			$rows=$dbs->find(array("nameid"=>$value["nameid"]));
			foreach($rows as $key=>$values)
			{
				$name=$values["name"];
			}
			//获得每一个物品的具体参数
			for($i=0;$i<(count($str)-1);$i++)
			{
				
				$db = ConnectDB("goods_shoes");	//连接商品库
				//$rows=$db->find(array("goodsid"=>$str,"iskey"=>1));
				$rows=$db->find(array("goodssid"=>$str[$i]));
         
				foreach($rows as $key=>$value)
				{
					//var_dump("memeda");
					$g=array(
						"pic"=>"photo/".$value["goodsid"]."/1.jpg",
						//"title"=>$value["goodsname"],
						"optvalue"=>array($value["class1"],$value["class2"],$value["class3"],$value["class4"],$value["class5"]),
						"TBPrice"=>$value["orgiprice"],
						"PDPrice"=>$value["nowprice"],
						"num"=>$num[$i],
						"totalPrice"=>$num[$i]*$value["nowprice"],
						"status"=>$status[$i],//此处为我们是否下单
						"name"=>$name,
						"nameid"=>$nameid,
						"date"=>$date,
						//"storename"=>$value[""];
						);
					
					//var_dump("memeda");
					$y=$db->find(array("goodsid"=>$value["goodsid"],"iskey"=>1));	
					foreach($y as $key=>$value)
					{
						$g["optname"]=array($value["name1"],$value["name2"],$value["name3"],$value["name4"],$value["name5"]);
						$g["title"]=$value["goodsname"];
						$g["storename"]=$value["from"];
						
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

				//if(strcmp("159357lwt",$arr[$o]["name"])==0)
					//var_dump($arr[$o]["storename"]);
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
					}

					array_push($order,$t);
				}
			
			}

		}//以上代码获得当前所有订单,$order为生成的所有订单
		//var_dump($k);
		if(strcmp("all",$bbb)==0)
		{
			echo JSON($order);
			return;
		}

		if(strcmp($bbb,"order")==0)	//按照时间排序
		{
			array_multisort($arr["date"],SORT_DESC,SORT_STRING, $files);
			echo JSON($arr);
			exit;
		}

		$d=array();//按照指定参数筛选
		for($f=0;$f<count($order);$f++)
		{
			//var_dump();
			if(strcmp($_POST["value"],$order[$f][$bbb])==0)
				array_push($d,$order[$f]);
		}	
		echo JSON($d);
		exit;
	}
		
	function finishedOrder($f)
	{
		$db = ConnectDB("order");
		date_default_timezone_set ("Asia/Shanghai");
		//$query=array("date"=>date('Y-m-d',time()));
		$query=array("date"=>date('Y-m-d'));
		//var_dump($query);
		//var_dump($query);

		$arr=array();
		$order=array();
		$row=$db->find($query);
		$str=array();
		$num=array();
		$nameid="";
		$name="";
		$price=0;
		$date="";
		//$status=0;
		//拆分当前所有订单
		foreach($row as $key=>$value)
		{	
			//var_dump("memeda");
			$str=explode("&",$value["goodsid"]);
			$num=explode("+",$value["goodsnum"]);
			$status=explode("&",$value["status"]);
			$isfinish=explode("&",$value["isfinish"]);
			
			//var_dump($status);
			$nameid=$value["nameid"];
			$name=$value["name"];
			$date=$value["date"];
			//$status=$value["status"];
			//拆分每一个用户的订单
			for($i=0;$i<count($num)-1;$i++)
			{

				$db = ConnectDB("goods_shoes");
				//$rows=$db->find(array("goodsid"=>$str,"iskey"=>1));
				$rows=$db->find(array("goodssid"=>$str[$i]));
				//var_dump($str);
				foreach($rows as $key=>$value)
				{
					
					$g=array(
						"pic"=>"photo/".$value["goodsid"]."1.jpg",
						//"title"=>$value["goodsname"],
						"optvalue"=>array($value["class1"],$value["class2"],$value["class3"],$value["class4"],$value["class5"]),
						"TBPrice"=>$value["orgiprice"],
						"PDPrice"=>$value["nowprice"],
						"num"=>$num[$i],
						"totalPrice"=>$num[$i]*$value["nowprice"],
						"status"=>$status[$i],
						"isfinish"=>$isfinish[$i],
						"name"=>$name,
						"date"=>$date,
						//"storename"=>$value[""];
						);
					//$status[$i]
					//$price+=$num[$i]*$value["nowprice"];
					$y=$db->find(array("goodsid"=>$value["goodsid"],"iskey"=>1));	
					foreach($y as $key=>$value)
					{
						$g["optname"]=array($value["name1"],$value["name2"],$value["name3"],$value["name4"],$value["name5"]);
						$g["title"]=$value["goodsname"];
						$g["storename"]=$value["from"];
					}
					array_push($arr,$g);		
				}
			}
		}//$arr为拆分为当前所有订单的集合
		
		
		//var_dump($arr);
		$db=ConnectDB("stores");
		$result=$db->find();
		$k=0;
		foreach($result as $key=>$value)
		{	
			$var=array();
			for($o=0;$o<count($arr);$o++)
			{
				//var_dump($arr[$o]["storename"]);
				if(strcmp($value["storesname"],$arr[$o]["storename"])==0&&strcmp($arr[$o]["status"],"1")==0)	//当前订单属于该商家且有买单的话
				{
					//var_dump();
					if(strcmp($f,"0")==0&&strcmp($arr[$o]["isfinish"],"1")!=0)
						//如果是遍历未下订单的话
					{
						$var=$arr[$o]["storename"];
						$k++;
					}
					else if(strcmp($f,"1")==0&&strcmp($arr[$o]["isfinish"],"1")==0)
					{
						$var=$arr[$o]["storename"];
						$k++;
					}
				}
				
			}
			
			//var_dump($arr[0]["status"]);
			if($k!=0)
				array_push($order,array("name"=>$var,"orderNum"=>$k));
			$k=0;
		}
		echo JSON($order);

	}
	function init()
	{
		$store=array();
		$kinds1=array();
		$user=array();
		$goods=array();
		$address=array();
		$db = ConnectDB("stores");
		$row=$db->find();

		foreach($row as $key=>$value)
		{
			array_push($store,$value["storesname"]);
		}

		$db = ConnectDB("class");
		$row=$db->find();

		foreach($row as $key=>$value)	//此处要做测试
		{
			array_push($kinds1,$value["class"]);
		}

		$db = ConnectDB("user");
		$row=$db->find()->limit(10);

		foreach($row as $key=>$value)
		{
			array_push($user,$value["name"]);
		}

		$db = ConnectDB("goods_shoes");
		$row=$db->find(array("iskey"=>1));

		foreach($row as $key=>$value)
		{
			$t=array(
				"img"=>"photo/".$value["goodsid"]."1.jpg",
				"title"=>$value["goodsname"],
				"name"=>$value["from"],
				"sales"=>$value["sellnum"],
				);
			array_push($goods,$t);
		}

		$db = ConnectDB("address");
		$row=$db->find();

		foreach($row as $key=>$value)
		{
			array_push($address,$value["address"]);
		}
		echo JSON(array("store"=>$store,"kinds1"=>$kinds1,"user"=>$user,"goods"=>$goods,"address"=>$address));


	}
	function requestKinds()//此处同样要做测试
	{
		$db = ConnectDB("class");
		$row = $db->find();
		$t=array();
		foreach($row as $key=>$value)
		{
			for($i=0;$i<count($_POST["kinds"]);$i++)
			{
				$value=$value[$_POST["kinds"][$i]];
			}
			
		}
		echo JSON(array("kingsSon"=>$value));
	}
	
	function goodsShow()
	{
		$db=ConnectDB("goods_shoes");
		if(strcmp($_POST["name"],"")!=0)
		{
			$query=array("from"=>$_POST["name"]);
			$a=array('sellnum'=>-1);
			$row=$db->find($query)->sort($a);
		}
		else 
		{
			$row=$db->find(array("iskey"=>1,"status"=>1));
		}
		$arr=array();
		foreach($row as $key=>$value)
		{
			$h=array("title"=>$value["goodsname"],
				     "name"=>$value["from"],
				     "sales"=>$value["sellnum"],
				     "img"=>"photo/".$value["_id"]."/1.jpg"
				     );
			array_push($arr, $h);
		}
		echo JSON($arr);
	}
	function deteleGoods()
	{
		$db=ConnectDB("goods_shoes");
		$query=array("goodsname"=>$_POST["name"],"iskey"=>1);
		$newdata=array('$set'=>array("status"=>0));
		//var_dump($query);
		$test=$db->update($query,$newdata);

		echo json_encode($test);
		
	}
	function editeGoods()
	{
		$db=ConnectDB("goods_shoes");
		$query=array("goodsname"=>$_POST["goodsName"],"iskey"=>1);
		//echo JSON($query);
		$row=$db->find($query);

		$arr=array();
		foreach($row as $key=>$value)
		{
			$arr=array("goodsid"=>$value["goodsid"],
					   "storeName"=>$value["from"],
					   "storeUrl"=>$value["url"],
					   "title"=>$value["goodsname"],
					   "pic"=>array("photo/".$value["_id"]."/1.jpg",
					   				"photo/".$value["_id"]."/2.jpg",
					   				"photo/".$value["_id"]."/3.jpg",
					   				"photo/".$value["_id"]."/4.jpg"),
					   "TBPrice"=>$value["origprice"],
					   "PDPrice"=>$value["subprice"],
					   "onsale"=>$value["sellnum"],
					   "keywords"=>$value["keyword"],
					   "kinds"=>$value["class"],
					   "purchase"=>$value["purchase"]);
				     
			$arr["option"]=array(array("name"=>$value["name1"],"value"=>$value["value1"]),
						         array("name"=>$value["name2"],"value"=>$value["value2"]),
						         array("name"=>$value["name3"],"value"=>$value["value3"]),
						         array("name"=>$value["name4"],"value"=>$value["value4"]),
						         array("name"=>$value["name5"],"value"=>$value["value5"]),
								);

		}

		$row=$db->find(array("goodsname"=>$_POST["goodsName"],"iskey"=>0));
		$arr["OPTPrice"]=array();
		foreach($row as $key=>$value)
		{
			array_push($arr["OPTPrice"],array("OPTValue"=>array($value["class1"],$value["class2"],$value["class3"],$value["class4"],$value["class5"]),"OPTTBPrice"=>$value["orgiprice"],"OPTPDPrice"=>$value["nowprice"]));
		}
		//var_dump($arr);
		//echo true;
		//var_dump(JSON($arr));
		echo JSON($arr);
	}

	function goodsCreate($n)
	{
		$db = ConnectDB("goods_shoes");
		$goodsarray=$_POST["goods"];
		$goodsid="";
		
		$array=array(
			"from"=>$goodsarray["storeName"],
			"goodsname"=>$goodsarray["title"],
			"iskey"=>1,
			"purchase"=>$goodsarray["purchase"],
			"keyword"=>$goodsarray["keyword"],
			"name1"=>$goodsarray["option"][0]["name"],
			"name2"=>$goodsarray["option"][1]["name"],
			"name3"=>$goodsarray["option"][2]["name"],
			"name4"=>$goodsarray["option"][3]["name"],
			"name5"=>$goodsarray["option"][4]["name"],
			"value1"=>$goodsarray["option"][0]["value"],
			"value2"=>$goodsarray["option"][1]["value"],
			"value3"=>$goodsarray["option"][2]["value"],
			"value4"=>$goodsarray["option"][3]["value"],
			"value5"=>$goodsarray["option"][4]["value"],
			"origprice"=>floatval($goodsarray['TBPrice']),
			"sellnum"=>0,
			"status"=>1,
			"subprice"=>floatval($goodsarray["PDPrice"]),
			"url"=>$goodsarray["storeUrl"],
			"class"=>$goodsarray["kinds"]
			);//插入主商品信息

		if(!$n)//为新建
		{
			$array["goodsid"]=0;
			$db->insert($array);
		
			$db->update(array("goodsid"=>0),array('$set'=>array("goodsid"=>(string)$array['_id'])));//更改goodsid为_id
			$str="../photo/".$array['_id'];
			$_SESSION["photodir"]=$array["_id"];
			//var_dump($str);
			mkdir($str);	//新建图片文件夹
			chmod($str,0777);
		}
		else//此处为编辑
		{
			$db->update(array("goodsname"=>$goodsarray["title"],"iskey"=>1),array('$set'=>$array));//如果名字变了一切白搭，直接进行更新
			$db->remove(array("goodsname"=>$goodsarray["title"],"iskey"=>0));
			//删除原来的参数数据
			$foo=$db->find(array("goodsname"=>$goodsarray["title"],"iskey"=>1));
			foreach($foo as $key=>$value)
			{
				$goodsid=$value["goodsid"];
			}//获得刚更新的goodsid
			$_SESSION["photodir"]=$goodsid;//用于上传

		}


		for($i=0;$i<count($goodsarray["OPTPrice"]);$i++)
		{
			$class=array(
				"class1"=>$goodsarray["OPTPrice"][$i]["OPTValue"][0],
				"class2"=>$goodsarray["OPTPrice"][$i]["OPTValue"][1],
				"class3"=>$goodsarray["OPTPrice"][$i]["OPTValue"][2],
				"class4"=>$goodsarray["OPTPrice"][$i]["OPTValue"][3],
				"class5"=>$goodsarray["OPTPrice"][$i]["OPTValue"][4],
				"iskey"=>0,
				//"goodsid"=>(string)$array['_id'],
				"nowprice"=>$goodsarray["OPTPrice"][$i]["OPTPDPrice"],
				"orgiprice"=>$goodsarray["OPTPrice"][$i]["OPTTBPrice"],
				//"goodssid"=>(string)($array['_id']."+".$i),
				"goodsname"=>$goodsarray["title"]
				);
			
			if(!$n)
			{
				$class["goodsid"]=(string)$array['_id'];
				$class["goodssid"]=(string)($array['_id']."+".$i);
			}
			else
			{
				$class["goodsid"]=(string)$goodsid;
				$class["goodssid"]=(string)($goodsid."+".$i);
			}
			$db->insert($class);	//不管新建还是编辑都要插入

				//$db->update(array("goodssid"=>$array['_id']."+".$i),array('$set'=>$class));
		}
		//var_dump(count($goodsarray["OPTPrice"]));
		echo json_encode(TRUE);
		
		
	}


?>
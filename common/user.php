<?php 
	include_once "bucket.php";
	include_once "order.php";
	include_once "receinfo.php";
	include_once "lastvisited.php";
	include_once "configsql.php";
	class user
	{
		private $nameid;
		private $receinfoid;
		private $bucketid;
		private $orderid;
		public function init($nameid)	//获得用户名ID后直接查询相关信息的ID
		{
  
			$collection = ConnectDB('user');
			$query = array('nameid'=>$nameid);
			$row = $collection->find($query);
			foreach($row as $key=>$value)
			{
				$this->receinfoid=$value["receinfo"];
				$this->bucketid=$value["bucketid"];
				$this->orderid=$value["orderid"];
				
			}
			$this->nameid=$nameid;
			
		}
		public function GetUserBucket()		//获得当前用户的购物车
		{
			//数据库查询Bucketid
			$bucket = new bucket();
			$bucket->SetBucketID($this->bucketid);
			return $bucket->Getbucket();
		}
		public function GetUserBucketByDetail($goodssid,$num)		//从购物车跳转到立即支付,记载响应物品
		{
			//数据库查询Bucketid
			$bucket = new bucket();
			$bucket->SetBucketID($this->bucketid);
			return $bucket->GetbucketByDetail($goodssid,$num);
		}
		
		public function GetUserOrder()		//获得当前用户的订单
		{
			//数据库查询orderid
			$orderid= new order();
			$collection = ConnectDB("order");
			$query=array('orderid'=>$_SESSION["nameid"]);
			$order=array();
			
			$row=$collection->find($query);
			
			foreach($row as $key=>$value)		
			{	

				//if($value["status"]==0)//如果只是物流信息的话
				//{
					$orderid->Setorderid($value["orderiid"]);
					$all=array("id"=>$value["orderiid"],"date"=>$value["date"],"goods"=>$orderid->Getorder()/*,"status"=>$orderid->GetStatus()*/);
					array_push($order,$all);
				//}
				//else 
				//{
					
				//}
			}
			
			
			return $order;
		}
		public function GetRecevinfo()		//获得当前用户的订单地址
		{
			$receinfo= new receinfo();
			$receinfo->SetID($this->receinfoid);
			return $receinfo->GetReceinfo();
		}
		public function GetLastVisited()
		{
			$lastvisited= new lastvisited();
			$lastvisited->SetNameID($this->nameid);
			return $lastvisited->GetLastVisited();
		}
		public function SetNewUserBucket($goodssid,$num)
		{	
			$bucket = new bucket();
			$bucket->SetBucketID($this->bucketid);
			return $bucket->SetNewBucket($goodssid,$num);
		}
		public function SetUserOrder($Array)
		{

		}
		public function SetReceinfo($Array)	//设置新的收货地址
		{

		}
		public function SetNewAddress($arr)		//更改默认的商圈
		{
			$collection = ConnectDB("receinfo");

			$where=array('receinfoid'=>$this->nameid);
			$collection->update($where,array('$set'=>$arr));
		}
		public function GetbucketID()
		{
			return $this->bucketid;
		}
		public function GetOrderNum()				//每调用一次都会自增
		{
			$collection = ConnectDB("user");
			$query=array('nameid'=>$_SESSION["nameid"]);
			$a="";
			$row=$collection->find($query);
			foreach($row as $key=>$value)
			{
				$a=$value["ordernum"];
			}
			$a++;
			$where=array("nameid"=>$_SESSION["nameid"]);
			$arr=array("ordernum"=>$a);
			$collection->update($where,array('$set'=>$arr));
			return $a;
		}


	}
?>
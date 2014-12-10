<?php
	 include_once "goods.php";
	 include_once "configsql.php";
	 class bucket
	 {
	 	private $goodsid;		//获得商品ID
	 	private $goodsnum;		//获得商品ID所对应的数量
	 	private $bucketid;		//根据购物车ID获得相对应的商品
	 	private $bucketidnum;	//获得当前商品的数量
	 	private	$goods;			//抽象商品类
	 	
	 	public function bucket()
	 	{
	 		 $this->goods = new goods();
	 		 
	 	}
	 	public function SetBucketID($id)	//设置当前要查询的Bucketid
	 	{
	 		$this->bucketid=$id;
	 	}

	 	public function GetBucket()			//获得当前购物车
	 	{
	 		$collection = ConnectDB("bucket");

	 		//通过数据库查询获得goodsid和goodsnum所对应的字符串
	 		$query=array('bucketid'=>$this->bucketid);
	 		$row = $collection->find($query);
	 		$bucket=array();
	 		$goodsid=array();
	 		$goodsnum=array();
	 		$num=0;
	 		foreach($row as $key=>$value)
	 		{
	 			$goodsid=explode("&",$value["goodsid"]);
	 			$goodsnum=explode("+",$value["goodsnum"]);
	 			//$num = $value["bucketnum"];
    		}
    		
    		for($i=0;$i<count($goodsid)-1;$i++)
    		{
    			$goods = new goods();
    			
    			
    			$arr=$goods->GetDetailByID($goodsid[$i],$goodsnum[$i]);
    			array_push($bucket,$arr);
    		}
	 		return $bucket;
	 		
	 	}
	 	public function GetbucketByDetail($goodssid,$num)
	 	{
	 		
	 		//通过数据库查询获得goodsid和goodsnum所对应的字符串
	 	
    		$bucket=array();
    		for($i=0;$i<count($goodssid);$i++)
    		{
    			$goods = new goods();
    			
    			
    			$arr=$goods->GetDetailByID($goodssid[$i],$num[$i]);

    			array_push($bucket,$arr);
    		}
	 		return $bucket;
	 		
	 	}
	 	public function SetNewBucket($goodssid,$num)	//购物车里增加新的物品
	 	{
	 		$collection = ConnectDB("bucket");
	 		
	 		$query=array('bucketid'=>$this->bucketid);
			$collection ->find($query);
			$row = $collection->find($query);
			$arr=array();

			foreach($row as $key=>$value)
	 		{
	 			if(strstr($value["goodsid"],$goodssid)==false)//如果不在购物车的话
	 			{

	 				$goodsid=$value["goodsid"].$goodssid."&";	//在末尾增加新加入的商品ID
	 			
	 				$goodsnum=$value["goodsnum"].$num."+";//增加对应的商品数量
	 				$arr=array("goodsnum"=>$goodsnum,"goodsid"=>$goodsid);
	 			
	 				$where=array('bucketid'=>$this->bucketid);
					$collection->update($where,array('$set'=>$arr));
				}
				else //该物品已经在购物车了
				{

					$str="";
					$good=explode("&",$value["goodsid"]);
					$numm=explode("+",$value["goodsnum"]);
					
					for($p=0;$p<count($good)-1;$p++)
					{
						if(strcmp($good[$p],$goodssid)==0)
						{
							$numm[$p]=(int)$numm[$p]+(int)$num;
							for($h=0;$h<count($numm)-1;$h++)
							{
								$str=$str.$numm[$h]."+";
							}
							$arr=array("goodsnum"=>$str);
	 			
	 						$where=array('bucketid'=>$this->bucketid);
							$collection->update($where,array('$set'=>$arr));
							break;
						}
					}
				}

			}
    	}
    		public function GetBucketNum()
	 		{
	 			$collection = ConnectDB("bucket");
	 		 	$query=array('bucketid'=>$this->bucketid);
	 			$row = $collection->find($query);
		 		
	 			$num="";
	 			foreach($row as $key=>$value)
	 			{
	 				$num = $value["goodsid"];
    			}
    			//if($num=="")
    			//	return 0;
    			//else
	 		 		return count(explode("&",$num))-1;
	 		}

	 	

	 }
?>
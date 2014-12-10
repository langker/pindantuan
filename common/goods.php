<?php
	include_once "configsql.php";
	class goods
	{
		private $goodsid;									//商品ID
		private $subprice;									//现价
		private $origprice;									//原价
		private $photo;										//图片地址
		private $from;										//商家名字
		private $bucketnum;									//被放在购物车中的数量
		private $goodsnanme;								//商品名称
		private $sellnum;									//销量
		private $keyword;									//商品关键词
		private $status;									//商品状态
		private $classnum;									//属性数量
		private $class;										//商品属性									

		public function SetGoodsID($ID)			//设置当前商品ID
		{
			$this->goodsid=$ID;
		}
		public function SetAll($num)					//根据ID去查询,参数num为当前数量
		{

			$collection = ConnectDB("goods_shoes");
			$query=array('goodsid'=>$this->goodsid,"iskey"=>1);
			//var_dump($this->goodsid);
			$row=$collection->find($query);
			$goods=array();
			foreach($row as $key=>$value)
			{	
				$goods=array(
					"goodsid"=>$value["goodsid"],
					"newPrice"=>$value["subprice"],								//现价
					"oriPrice"=>$value["origprice"],									//原价
					"pic"=>array(
							"pic1"=>"photo/".$this->goodsid."/1.jpg",
					),										//图片地址
					"storeName"=>$value["from"],										//商家名字
					"num"=>$num,
					"url"=>"detail.php?id=".$this->goodsid,
					"bucketnum"=>$value["bucketnum"],									
					"goodsTitle"=>$value["goodsname"],								//商品名称
					"sales"=>$value["sellnum"],								//销量
					"keyword"=>$value["keyword"],									//商品关键词
					//"status"=>$value["status"],	//商品状态
					"optionName"=>array(
						$value["name1"],$value["name2"],$value["name3"],$value["name4"],$value["name5"],
						)						
					
					);
			//$query=array('goodssid'=>$this->goodsid,"iskey"=>0);

			//$row=$collection->find($query);
				
				
			}
			return $goods;

		}
		public function GetDetail()
		{
			$collection = ConnectDB("goods_shoes");
			$query=array("goodsid"=> $this->goodsid,"iskey"=>1);
			//var_dump($query);
			//$query=array('goodsid'=>$this->goodsid);
			$row=$collection->find($query);
			$goods=array();
			foreach($row as $key=>$value)
			{	

				$goods=array(
					"newPrice"=>$value["subprice"],								//现价
					"oriPrice"=>$value["origprice"],									//原价
					"pic"=>array(
							"pic1"=>"photo/".$value["goodsid"]."/1.jpg",
							
					),									//图片地址
					"storeName"=>$value["from"],										//商家名字
					"url"=>$value["url"],
					"bucketnum"=>$value["bucketnum"],									
					"title"=>$value["goodsname"],								//商品名称
					"sales"=>$value["sellnum"],								//销量
					"keyword"=>$value["keyword"],									//商品关键词
					"status"=>$value["status"],	//商品状态
					"optionName"=>array(
						$value["name1"],$value["name2"],$value["name3"],$value["name4"],$value["name5"]
						),						
					"optionValue"=>array($value["class1"],
					$value["class2"],
					$value["class3"],
					$value["class4"],
					$value["class5"]),
					);
				for($g=2;$g<=4;$g++)
				{
					if(file_exists("../photo/".$value["goodsid"]."/".$g.".jpg"))
					{
						$goods["pic"]["pic".$g]="photo/".$value["goodsid"]."/".$g.".jpg";
					}
					else
					{
						$goods["pic"]["pic".$g]="";
						break;
					}
				}
			}
			$query=array('goodsid'=>$this->goodsid,"iskey"=>0);
			$row=$collection->find($query);
			$class=array();
			foreach($row as $key=>$value)
			{
				$arr=array("class1"=>$value["class1"],
						"class2"=>$value["class2"],
						"class3"=>$value["class3"],
						"class4"=>$value["class4"],
						"class5"=>$value["class5"],
						"orgiprice"=>$value["orgiprice"],
						"nowprice"=>$value["nowprice"],
						"goodssid"=>$value["goodssid"],
					);
				array_push($class,$arr);
			}
			return array("goods"=>$goods,"class"=>$class);
		}
		public function GetDetailByID($goodssid,$num)
		{
			$collection = ConnectDB("goods_shoes");
			$l=explode("+",$goodssid);

			$query=array("goodsid"=>$l[0],"iskey"=>1);
			$row=$collection->find($query);
			$goods=array();
			//var_dump($query);
			foreach($row as $key=>$value)
			{	
				$goods=array(
					"newPrice"=>$value["subprice"],								//现价
					"oriPrice"=>$value["origprice"],									//原价
					"pic"=>"photo/".$l[0]."/1.jpg",							//图片地址
					"storeName"=>$value["from"],										//商家名字
					"url"=>"detail.php?id=".$l[0],
					"goodssid"=>$goodssid,
					"bucketnum"=>$value["bucketnum"],						
					"num"=>$num,			
					"title"=>$value["goodsname"],								//商品名称
					"sales"=>$value["sellnum"],								//销量
					"keyword"=>$value["keyword"],									//商品关键词
					"status"=>$value["status"],	//商品状态
					"optionName"=>array(
						$value["name1"],$value["name2"],$value["name3"],$value["name4"],$value["name5"],
						),						
					"optionValue"=>array($value["class1"],
					$value["class2"],
					$value["class3"],
					$value["class4"],
					$value["class5"],),
					);
			}
			//var_dump($goods);
			$query=array('goodsid'=>$l[0],"iskey"=>0,'goodssid'=>$goodssid);
			//var_dump($query);
			$row=$collection->find($query);
			$class=array();
			foreach($row as $key=>$value)
			{
				$arr=array("class"=>array($value["class1"],
						$value["class2"],
						$value["class3"],
						$value["class4"],
						$value["class5"]),
						"orgiprice"=>$value["orgiprice"],
						"nowprice"=>$value["nowprice"],
						"goodssid"=>$value["goodssid"],
					);
				array_push($class,$arr);
			}
			return array("goods"=>$goods,"classify"=>$class);
		}
		public function SelectDB($id)		//根据商品ID的首项来选择查询数据库
		{
			
		}

		public function SetNewGoods()	//设置新的物品
		{

		}
		public function AddGoods()		//加入购物车时增加//需求已变，可删
		{
			$collection = ConnectDB("goods_shoes");
			$query=array('goodsid'=>$this->goodsid);
			$row=$collection->find($query);
			foreach($row as $key=>$value)
			{
				$arr=(int)$value["bucketnum"];
				$arr++;
				$arr=array("bucketnum"=>$arr);
				//$arr=array("goodsnum"=>$goodsnum,"goodsid"=>$goodsid);
	 			$where=array('bucketid'=>$this->bucketid);
	 			$collection->update($where,array('$set'=>$arr));
			}
		}
		public function SubGoods()		//加入购物车时增加
		{
			$collection = ConnectDB("goods_shoes");
			$query=array('goodsid'=>$this->goodsid);
			$row=$collection->find($query);
			foreach($row as $key=>$value)
			{
				$arr=(int)$value["bucketnum"];
				$arr--;
				$arr=array("bucketnum"=>$arr);
				//$arr=array("goodsnum"=>$goodsnum,"goodsid"=>$goodsid);
	 			$where=array('bucketid'=>$this->bucketid);
	 			$collection->update($where,array('$set'=>$arr));
			}
		}
		public function SetList()					
		{

			$collection = ConnectDB("goods_shoes");
			$query=array("goodsid"=>(string)$this->goodsid,"iskey"=>1);

			//var_dump($query);
			$row=$collection->find($query);
			$goods=array();
			foreach($row as $key=>$value)
			{	
				$goods=array(
					"goodsid"=>$value["goodsid"],
					"newPrice"=>$value["subprice"],								//现价
					"oriPrice"=>$value["origprice"],									//原价
					"pic"=>array(
							"pic1"=>"photo/".$value["goodsid"]."/1.jpg",
							"pic2"=>"photo/".$value["goodsid"]."/2.jpg",
							"pic3"=>"photo/".$value["goodsid"]."/3.jpg",
							"pic4"=>"photo/".$value["goodsid"]."/4.jpg",
					),										//图片地址
					"storeName"=>$value["from"],										//商家名字
					"num"=>$num,
					"url"=>"detail.php?id=".$value["goodsid"],
					"bucketnum"=>$value["bucketnum"],									
					"title"=>$value["goodsname"],								//商品名称
					"sales"=>$value["sellnum"],								//销量
					"keyword"=>$value["keyword"],									//商品关键词
					"status"=>$value["status"],	//商品状态
					"optionName"=>array(
						$value["name1"],$value["name2"],$value["name3"],$value["name4"],$value["name5"],
						),						
					"optionValue"=>array($value["class1"],
					$value["class2"],
					$value["class3"],
					$value["class4"],
					$value["class5"],),
					);
				
				
			}
			return $goods;

		}
		public function GetClass($goodssid)		//根据goodssid获取参数
		{

			$collection = ConnectDB("goods_shoes");
			$query=array('goodssid'=>$goodssid,"iskey"=>0);

			$row=$collection->find($query);
			
			$array=array();
			foreach($row as $key=>$value)
			{
				$array=array($value["class1"],
							 $value["class2"],
							 $value["class3"],
							 $value["class4"],
							 $value["class5"],
							 $value["nowprice"],
							 $value["orgiprice"]);
			}
			return $array;
		}
		public function GetVisitedGood()
		{
			$collection = ConnectDB("goods_shoes");
			$query=array('goodssid'=>$goodssid,"iskey"=>1);
			$row=$collection->find($query);
			foreach($row as $key=>$value)
			{
				$array=array("web"=>$value["url"],
							 "photo"=>$value["pic"],
							 "name"=>$value["goodsname"]);
			}
			return $array;
		}

	}
 ?>
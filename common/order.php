<?php
	include_once "goods.php";
	include_once "configsql.php";
	class order
	{
		private $orderid;
		private $status;
		private $goodsid;
		private $goodsnum;
		private $time;
		private $goods;

		public function order()
		{
			$this->goods= new goods();
		}
		public function Setorderid($id)
		{
			$this->orderid=$id;
		}
		public function Getorder()
		{
			
			
			$collection = ConnectDB("order");

			//根据指定ORDERID进行查询
			$query=array('orderiid'=>$this->orderid);
			$row = $collection->find($query);
			
			foreach($row as $key=>$value)
			{
				$array=array();
    			//$this->status=$value["status"];
    			$goods = new goods();
    			$p=explode("&",$value["goodsid"]);		//分割ID
    			$q=explode("+",$value["goodsnum"]);		//分割销量
    			$wuliu=explode("&",$value["wuliuid"]);
    			$arrstatus=explode("&",$value["status"]);

    			$k=array();
    			for($a=0;$a<count($p)-1;$a++)
    			{
    				$t=explode("+",$p[$a]);
    				$k[$a]=$t[0];
    			}

    			for($i=0;$i<count($p)-1;$i++)
    			{

    				$goods->SetGoodsID($k[$i]);
    				
    				$arr=$goods->SetALL($q[$i]);		//设置GOODSID

    				$y=$goods->GetClass($p[$i]);

					$arr["optionValue"][0]=$y[0];
    				$arr["optionValue"][1]=$y[1];
    				$arr["optionValue"][2]=$y[2];
    				$arr["optionValue"][3]=$y[3];
    				$arr["optionValue"][4]=$y[4];
    				$arr["newPrice"]=$y[5];
    				$arr["oriPrice"]=$y[6];
    				$arr["wuliuid"]=$wuliu[$i];//此处为物流ID
					//var_dump($arr["optionValue"]);
    				$arr["status"]=$arrstatus[$i];
    				array_push($array,$arr);
    			}
    		}
    		
			return $array;
			
			
		}
		public function SetNewOrder()			//添加新订单
		{

		}
		public function GetStatus()
		{
			return $this->status;
		}

	} 
?>
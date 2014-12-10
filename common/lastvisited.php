<?php
	include_once "configsql.php";
	class lastvisited
	{
		private $nameid;
		private $web1;
		private $web2;
		private $web3;

		public function SetNameid($id)
		{
			$this->nameid=$id;
		}
		public function GetLastVisited()
		{
			
			$collection = ConnectDB("lastvisited");

			$query=array('nameid'=>$this->nameid);
			$row = $collection->find($query);
			$array=array();
			foreach($row as $key=>$value)
			{
				$array=array(
					"web1"=>$value["web1"],
					"photo1"=>$value["photo1"],
					"name1"=>$value["name1"],
					"web2"=>$value["web2"],
					"photo2"=>$value["photo2"],
					"name2"=>$value["name2"],
					"web3"=>$value["web3"],
					"photo3"=>$value["photo3"],
					"name3"=>$value["name3"],
					);
			}
			//var_dump($array);
			return $array;
			
			
		}
		public function SetNewOrder()			//添加新订单
		{

		}

	} 
?>
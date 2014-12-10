<?php 
	include_once "configsql.php";
	
	class comment
	{
		private $nameid;
		private $detail;
		private $time;
		private $goodsid;

		public function SetGoodsID($id)
		{
			$this->goodsid=$id;
		}
		public function GetComment()
		{
			
	 		$collection = ConnectDB("comment");

	 		$query=array('goodsid'=>$this->goodsid);
	 		$row = $collection->find($query);
	 		$array=array();
	 		$all=array();
	 		foreach($row as $key=>$value)
	 		{
    			$array=array("name"=>$value["name"],
    				"contents"=>$value["detail"],
    				"data"=>$value["time"],
    				);
    			array_push($all,$array);
    		}
    		return $all;

		}
		public function AddComment($str,$name,$goodsname)
		{
			date_default_timezone_set ("Asia/Shanghai");
			$collection = ConnectDB("comment");
			$arr=array("detail"=>$str,
					   "goodsid"=>$this->goodsid,
					   "name"=>$name,
					   "time"=>date('Y-m-d H:i:s',time()),
					   "status"=>0,
					   "goodsname"=>$goodsname
						);
			$collection->insert($arr);
		}

	}
?>
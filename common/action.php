<?php 

	include_once "configsql.php";
	class action
	{
		private $actionid;
		private $goods;

		public function SetActionID($id)
		{
			$this->actionid=$id;
		}
		public function GetGoods()
		{
			$conn=ConnectDB("action");
			$query=array('bucketid'=>$this->actionid);
			$row = $conn->find($query);
			foreach($row as $key=>$value)
	 		{
	 			$goodsid=explode("+",$value["goods"]);
    		}
    		return $goodsid;
		}
		public function GetPhotoUrl()
		{
			$conn=ConnectDB("action");
			$query=array('bucketid'=>$this->actionid);
			$row = $conn->find($query);
			$array=array();
			foreach($row as $key=>$value)
	 		{
	 			$array=$value["pic"];
    		}

    		return $array;
		}
		public function GetActionNmae()
		{
			$conn=ConnectDB("action");
			$query=array('bucketid'=>$this->actionid);
			$row = $conn->find($query);
			$array=array();
			foreach($row as $key=>$value)
	 		{
	 			$array=$value["actionName"];
    		}

    		return $array;
		}
	}

?>
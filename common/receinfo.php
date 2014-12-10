<?php
	include_once("configsql.php");
	class receinfo
	{
		private $receinfoid;
		private $address;
		private $cellphone;
		private $realname;
		private $postcode;

		public function SetID($id)
		{
			$this->receinfoid=$id;
		}
		public function GetReceinfo()
		{
			$collection = ConnectDB('receinfo');
			$query=array('receinfoid'=>$this->receinfoid);
			$row = $collection->find($query);
			$array=array();
			foreach ($row as $key => $val)
			{
    			$array=array("address"=>$val["address"],
    				"tel"=>$val["cellphone"],
    				"realName"=>$val["realname"],
    				"area"=>$val["area"]
    				);
			}
			
			
			return $array;
		}
		public function SetNewReceinfo()
		{
			
		}
	}

?>
<?php
	include_once "../common/configsql.php";
	include_once "../common/json.php";
	include_once "../common/goods.php";
	$query=array();         //根据class选择搜索规则
	//var_dump($_POST[""]);
    switch($_POST["class"])
    {
    	case 0:
            $query=array('sellnum'=>-1);break;
    	case 1:
            $query=array('sellnum'=>1);break;
    	case 2:
            $query=array('sellnum'=>-1);break;
        default:
            $query=array('sellnum'=>-1);break;
    }

	$collection = ConnectDB("goods_shoes");


    $count= $collection->find(array("iskey"=>1,"class"=>$_POST["classify"]))->count();
	$rows = $collection->find(array("iskey"=>1,"class"=>$_POST["classify"]));
    $row = $rows->sort($query)->skip(($_POST["page"]-1)*40)->limit(40);        
	$array=array($count);
	foreach($row as $key=>$value)
	{
		$goods=new goods();
		if($value["status"]==0)
        {
            $array[0]-=1;
            continue;
        }
		$goods->SetGoodsID($value["goodsid"]);
		array_push($array,$goods->SetList());
	}
	//echo($count);
	echo JSON($array);
	

?>

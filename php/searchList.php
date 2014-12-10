<?php
	include_once "../common/configsql.php";
    include_once "../common/json.php";
    include_once "../common/goods.php";
	
    $query=array();         //根据class选择搜索规则
    switch($_POST["order"])
    {
    	case 0:
            $query=array('sellnum'=>-1);break;
    	case 1:
            $query=array('subprice'=>1);break;
    	case 2:
            $query=array('subprice'=>-1);break;
        default:
            $query=array('subprice'=>1);break;
    }
    
	$collection = ConnectDB("goods_shoes");
    $keyword=array("keyword"=> new MongoRegex("/.*".(string)$_POST["key"].".*/i"));

    $count = $collection->find($keyword)->count();
	$rows = $collection->find($keyword);
    
    $row = $rows->sort($query)->skip(($_POST["page"]-1)*40)->limit(40);        

	$array=array($count);
	foreach($row as $key=>$value)
	{
		$goods =new goods();
        if($value["status"]==0)
        {
            $array[0]-=1;
            continue;
        }
		$goods->SetGoodsID($value["goodsid"]);
		array_push($array,$goods->SetList());
	}
	echo JSON($array);
?>

<?php
        
        include_once "common/configsql.php";
        include_once "common/json.php";
        include_once "common/session.php";
        date_default_timezone_set('Asia/Shanghai'); 
		$db = ConnectDB("order");
        
        $row=$db->find(array("date"=>date('Y-m-d')));//获取当日订单
        
        $arr=array();
        $date="";
        $orderiid="";
        $orderid="";
        $store=array();
        $area="";
        $name="";
        $cellphone="";
       
        foreach($row as $key=>$value)
        {
            
            if(strstr($value["status"],"1"))//没付款不显示哼
            {   
                $orderiid=$value["orderiid"];
                $date=$value["date"];
                $area=$value["area"];
                $dbs=ConnectDB("receinfo");
                $rows=$dbs->find(array("receinfoid"=>$value["orderid"]));
                foreach($rows as $key=>$values)
                {
                    $name=$values["realname"];
                    $cellphone=$values["cellphone"];
                }
                //var_dump(count(array_unique(explode("&",$value["wuliuid"]))));
                for($i=0;$i<count(array_unique(explode("&",$value["wuliuid"])))-1;$i++)
                    array_push($arr,array("name"=>$name,"cellphone"=>$cellphone,"date"=>$date,"address"=>$area,"orderid"=>$orderiid,"status"=>0));
            }
            else
                continue;
        }
    



        $dbs=ConnectDB("orderforoffline");
        
        $row=$dbs->find(array("date"=>date('Y-m-d')));//获取当日订单
        //var_dump(array("date"=>date('Y-m-d')));
        
        foreach($row as $key=>$value)
        {
            //var_dump("memeda");
            $orderiid=$value["orderid"];
            $date=$value["date"];
            
            $name=$value["name"];
            $cellphone=$value["cellphone"];
            array_push($arr,array("name"=>$name,"cellphone"=>$cellphone,"date"=>$date,"address"=>"电子科技大学沙河校区","orderid"=>$orderiid,"status"=>"1"));
            
        }
        echo JSON($arr);
?>
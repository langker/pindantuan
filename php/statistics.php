<?php
    define("sql", "mongodb://langker:(pindantuan)@localhost:27017");
    function ConnectDB($dbname)
    {
        $m = new MongoClient(constant("sql"));
        //if(file_exists("debug"))
            //$db=$m->test;
        //else
            $db = $m->pingdantuan;

        return $db->$dbname;
    }
        
        date_default_timezone_set('Asia/Shanghai'); 
		$db = ConnectDB("order");
        
        $row=$db->find(array("date"=>date('Y-m-d',strtotime("-1 day"))));//定时程序放在00:10分，故检索前一天记录
        $str=array();
        $arr=array();
        $order=array();
        $num=array();
        $nameid="";
        $name="";
        $price=0;
        $date="";
        $status=0;
        //拆分当前所有订单
        foreach($row as $key=>$value)
        {
            $str=explode("&",$value["goodsid"]);
            $num=explode("+",$value["goodsnum"]);   //先分割每个订单
            //$status=explode("");
            


            $date=$value["date"];
            $status=explode("&",$value["status"]);  //上述参数作为临时变量
            
            //if(strstr($value["status"],"0"))//如果没付款的话
              //  continue;

            //获得每一个物品的具体参数
            for($i=0;$i<(count($str)-1);$i++)
            {
                
                $db = ConnectDB("goods_shoes"); //连接商品库
                
                $rows=$db->find(array("goodssid"=>$str[$i]));
         
                foreach($rows as $key=>$value)
                {
                    //var_dump("memeda");
                    $g=array(
                        "TBPrice"=>$value["orgiprice"],
                        "PDPrice"=>$value["nowprice"],
                        "totalPrice"=>$num[$i]*$value["nowprice"],
                        "num"=>$num[$i],
                        "status"=>$status[$i],//此处为订单状态
                        "date"=>$date,
                        //"storename"=>$value[""];
                        );
                    $t=explode("+",$str[$i]);
                    $row=$db->find(array("goodsid"=>$t[0],"iskey"=>1));
                    foreach($row as $key=>$values)
                    {
                        $g["purchase"]=$values["purchase"];
                    }
                    
                    array_push($arr,$g);        
                }
            }
        }//拆分结束，$arr为拆分为当前所有商品订单信息的集合

        $totalOrder=count($arr);//总订单数
        //date_default_timezone_set('Asia/Shanghai'); 
        $todayProfit=0;
        $todayIncome=0;
        $todayOrder=0;
        $todaySave=0;
        $todayUnfinishedOrder=0;
        for($i=0;$i<count($arr);$i++)
        {
            if(strcmp($arr[$i]["status"],"1")==0&&strcmp(date("Y-m-d"),$arr[$i]["date"])==0)//当前订单已经付款
            {
                $todayProfit+=($arr[$i]["PDPrice"]-$arr[$i]["purchase"])*$arr[$i]["num"];//今日利润
                
                $todayIncome+=$arr[$i]["totalPrice"];//今日收入
                $todaySave+=($arr[$i]["TBPrice"]-$arr[$i]["PDPrice"])*$arr[$i]["num"];
                //var_dump($arr[$i]["purchase"]);
                $todayOrder++;//今日订单
            }
            if(strcmp($arr[$i]["status"],"0")==0&&strcmp(date("Y-m-d"),$arr[$i]["date"])==0)
            {
                $todayUnfinishedOrder++;//今日未完成
            }
        }
        $i=0;
        $totalProfi=0;
        $totalSave=0;
        $totalUnfinishedOrder=0;
        $status=0;


        $db=ConnectDB("statistics");
        $istoday=$db->find(array("date"=>date('Y-m-d',strtotime("-2 day"))))->count();
        

        if($istoday)//找到了前日的记录，加上昨日记录保存入库
        {
            $rows=$db->find(array("date"=>date('Y-m-d',strtotime("-2 day"))));
            foreach($rows as $key=>$value)  
            {
                $totalProfi=$value["totalProfi"]+$todayProfit;
                $totalSave=$value["totalSave"]+$todaySave;
                $totalUnfinishedOrder=$value["totalUnfinishedOrder"]+$todayUnfinishedOrder;
                $db->insert(array("status"=>0,"totalProfi"=>$totalProfi,"totalSave"=>$totalSave,"totalUnfinishedOrder"=>$totalUnfinishedOrder,"date"=>date('Y-m-d',strtotime("-1 day"))));
                
            }

        }
        else
        {
            $db->insert(array("status"=>0,"totalProfi"=>$todayProfit,"totalSave"=>$todaySave,"totalUnfinishedOrder"=>$todayUnfinishedOrder,"date"=>date('Y-m-d',strtotime("-1 day"))));
        }

        
        
?>
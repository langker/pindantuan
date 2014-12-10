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
        
        $row=$db->find(array("date"=>date('Y-m-d',strtotime("-3 day"))));//
        foreach($row as $key=>$value)
        {
            if(strstr($value["status"],"1"))
            {
                $y=str_replace("1", "2", $value["status"]);
                $db->update(array("orderiid"=>$value["orderiid"]),array('$set'=>array("status"=>$y)));
            }
        }
        
        
        
?>
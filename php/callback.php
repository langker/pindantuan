<?php
	include_once "../common/configsql.php";
	session_start();
	
	$response="";
	$result="";
	$userdata="";
	if(isset($_GET['code']) && trim($_GET['code'])!='')//获得授权码
	{
	    	/*$ci=curl_init();
	        curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, FALSE);
	        curl_setopt($ci, CURLOPT_RETURNTRANSFER, 1);
	        curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 30);
	        curl_setopt($ci, CURLOPT_TIMEOUT, 30);
	        curl_setopt($ci, CURLOPT_POST, TRUE);
	        //if($postfields!='')
	        //	curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
	        $headers[]="User-Agent: qqPHP(piscdong.com)";
	        curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
	        curl_setopt($ci, CURLOPT_URL, "https://graph.qq.com/oauth2.0/token?grant_type=authorization_code&client_id=101144437&client_secret=f4bb1b7fb636e639326a2178f0ce1e53&redirect_uri=".urlencode("http://www.pindantuan.cn/php/callback.php")."&code=".$_GET['code']);
	        $result=curl_exec($ci);
	        //var_dump("memeda");
	        var_dump($result);
	        curl_close($ci);*/
	        $result= file_get_contents("https://graph.qq.com/oauth2.0/token?grant_type=authorization_code&client_id=101144437&client_secret=f4bb1b7fb636e639326a2178f0ce1e53&redirect_uri=".urlencode("http://www.pindantuan.cn/php/callback.php")."&code=".$_GET['code']);
	        
	}//以上代码获得access_code

	//if(isset($result['access_token']) && $result['access_token']!='')
	//{
	    //echo '授权完成，请记录<br/>access token：<input size="50" value="',$result['access_token'],'">';
	 
	    //保存登录信息，此示例中使用session保存
	    //$_SESSION['qq_t']=$result['access_token']; //access token
	    /*$ci=curl_init();
	    curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, FALSE);
	    curl_setopt($ci, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 30);
	    curl_setopt($ci, CURLOPT_TIMEOUT, 30);
	    curl_setopt($ci, CURLOPT_POST, TRUE);
	    if($postfields!='')curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
	    $headers[]="User-Agent: qqPHP(piscdong.com)";
	    curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
	    curl_setopt($ci, CURLOPT_URL, "https://graph.qq.com/oauth2.0/me?access_token=".$result['access_token']);
	    $response=curl_exec($ci);
	    curl_close($ci);*/
	    $params = array();
     	parse_str($result, $params);
     	//var_dump($params["access_token"]);
     	$response=file_get_contents("https://graph.qq.com/oauth2.0/me?access_token=".$params["access_token"]);//获得openid
	    //$openid=$response['openid'];//获取用户openid
	    //var_dump($response);
	    //var_dump($response);
     	if (strpos($response, "callback") !== false)
     	{
        	$lpos = strpos($response, "(");
        	$rpos = strrpos($response, ")");
        	$response  = substr($response, $lpos + 1, $rpos - $lpos -1);
     	}
     	$response = json_decode($response);
     	//var_dump($response->openid);
	    /*$ci=curl_init();
	    curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, FALSE);
	    curl_setopt($ci, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 30);
	    curl_setopt($ci, CURLOPT_TIMEOUT, 30);
	    curl_setopt($ci, CURLOPT_POST, TRUE);
	    if($postfields!='')curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
	    $headers[]="User-Agent: qqPHP(piscdong.com)";
	    curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
	    curl_setopt($ci, CURLOPT_URL,"https://graph.qq.com/user/get_user_info?access_token=".$result['access_token']."&oauth_consumer_key=101144437&openid=".$openid."&format=json");
	    $userdata=curl_exec($ci);
	    curl_close($ci);
	    //var_dump($userdata);//打印信息
		*/
	    $userdata=file_get_contents("https://graph.qq.com/user/get_user_info?access_token=".$params['access_token']."&oauth_consumer_key=101144437&openid=".$response->openid."&format=json");
	    $userdata=json_decode($userdata);
	    
	    $_SESSION["name"]=$userdata->nickname;//唯一的用户名字
	    $_SESSION["nameid"]=$response->openid;//唯一的用户编码
		
	//以下代码负责插入
	$connection = ConnectDB("user");

	$query=array("nameid"=>$response->openid);
	
	$row=$connection -> find($query);
	
	foreach($row as $key=>$value)	//如果数据库有用户数据的话就会执行这里
	{	
		//$b="location: ".$_SESSION["url"];
		//var_dump($_SESSION);
		//$b="location: ";
		//header("location: http://www.pindantuan.cn");
		$connection->update(array("nameid"=>$_SESSION["nameid"]),array('$set'=>array("name"=>$_SESSION["name"])));
		echo '<script>window.close();</script>'; 
		//header($b);
		exit;
	}
	//不然执行下面
	$content=array("name"=>$_SESSION["name"],"nameid"=>$_SESSION["nameid"],"receinfo"=>$_SESSION["nameid"],"bucketid"=>$_SESSION["nameid"],"orderid"=>$_SESSION["nameid"],"ordernum"=>0);


	$connection->insert($content);

	$connection = ConnectDB("bucket");
	$content=array("bucketid"=>$_SESSION["nameid"],"goodsnum"=>"","goodsid"=>"");
	$connection->insert($content);
  
	$connection = ConnectDB("receinfo");
	$content=array("address"=>"","area"=>"","cellphone"=>"","realname"=>"","receinfoid"=>$_SESSION["nameid"]);
	$connection->insert($content);

		
	

	//close current windows
	echo '<script>window.close();</script>'; 
	exit;
?>

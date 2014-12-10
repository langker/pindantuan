<?php
	include_once "../common/session.php";
	include_once "../common/configsql.php";


	header("Content-Type:text/html;charset=utf-8"); 
	function send_post($url, $post_data) //该函数提交POST请求从淘宝获得登录数据
	{   
  
  	$postdata = http_build_query($post_data);   
 	 $options = array(   
      'http' => array(   
      'method' => 'POST',   
      'header' => 'Content-type:application/x-www-form-urlencoded',   
      'content' => $postdata,   
      'timeout' => 15 * 60 // 超时时间（单位:s）   
    )   
  ); 
    $ch = curl_init();  
  	//$context = stream_context_create($options);   
  	//$result = file_get_contents($url, false, $context);   
  	curl_setopt($ch, CURLOPT_URL, $url);
  	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  	curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);  
    curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, substr($postdata,0,-1));
	//curl_setopt ($ch, CURLOPT_HEADER, 0); 
   
	$result=curl_exec ($ch); 
	//$result = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close ($ch); 
  	return $result;   
	}   
  
 
   
	  

	$post_data=array();
	$post_data["code"]=$_REQUEST["code"];
	$post_data["grant_type"]="authorization_code";
	$post_data["client_id"]="21784972";
	$post_data["view"]="web";
	$post_data["state"]=$_REQUEST["state"];
	$post_data["client_secret"]="79960095580edcc3e977e2e82c2d5447";
	$post_data["redirect_uri"]="http://114.215.203.217/pindantuan/php/redirect_url.php";
	
	$arr=send_post('https://oauth.taobao.com/token', $post_data); 
	$a=json_decode($arr);	//获得用户信息
	
	$_SESSION["nameid"]=$a->taobao_user_id;
	$_SESSION["name"]=urldecode($a->taobao_user_nick);

	$connection = ConnectDB("user");

	$query=array("name"=>$_SESSION["name"],"nameid"=>$_SESSION["nameid"]);
	
	$row=$connection -> find($query);
	
	foreach($row as $key=>$value)	//如果数据库有用户数据的话就会执行这里
	{	
		//$b="location: ".$_SESSION["url"];
		var_dump(session_id());
		//header($b);
		//exit;
	}
	//不然执行下面
	$content=array("name"=>$_SESSION["name"],"nameid"=>$_SESSION["nameid"],"receinfo"=>$_SESSION["nameid"],"bucketid"=>$_SESSION["nameid"],"orderid"=>$_SESSION["nameid"],"ordernum"=>0);


	$connection->insert($content);

	$connection = ConnectDB("bucket");
	$content=array("bucketid"=>$_SESSION["nameid"],"goodsnum"=>"","goodsid"=>"");
	$connection->insert($content);
  
	$connection = ConnectDB("receinfo");
	$content=array("address"=>"","area"=>"","cellphone"=>"","realname"=>"","receinfoid"=>$_SESSION["nameid"],"detailAddress"=>"");
	$connection->insert($content);


	
	$connection = ConnectDB("lastvisited");
	$content=array("nameid"=>$_SESSION["nameid"],"web1"=>"","name1"=>"","photo1"=>"","web2"=>"","name2"=>"","photo2"=>"","web3"=>"","name3"=>"","photo3"=>"");
	$connection->insert($content);
		
	$b="location: ".$_SESSION["url"];

	header($b);
?>

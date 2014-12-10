<?php 
	
	
	define("sql", "mongodb://langker:(pindantuan)@localhost:27017");
//var_dump($_GET['user']);
	$m = new MongoClient(constant("sql"));
 		
	$f = $m->zhaoxin;
	$db = $f->memeda;
	$db->insert(array("name"=>$_GET["name"],"gender"=>$_GET["gender"],"mobile"=>$_GET["mobile"],"college"=>$_GET["college"],"grade"=>$_GET["grade"],"email"=>$_GET["email"],"introduce"=>$_GET["introduce"],"experience"=>$_GET["experience"],"product_or_dev"=>$_GET["product_or_dev"],"art_or_code"=>$_GET["art_or_code"],"front_or_back"=>$_GET["front_or_back"]));
	
	echo $_GET["callback"]."(".json_encode(array("status"=>"success")).')';
?>

















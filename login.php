<?php
	include_once "common/session.php";
    include_once "common/json.php";
   
	if(!isset($_SESSION["islogin"]))
		$_SESSION["islogin"]=0;
	if(strcmp($_POST["name"],"admin")==0&&strcmp($_POST["password"],"admin")==0)
	{
		$_SESSION["islogin"]++;
		if($_SESSION["islogin"]==3)
		{
			$_SESSION["islogin"]=0;
			$_SESSION["admin"]=1;
			//header("location: background.html");
			echo 1;
		}
		else
			echo 0;
	}
	else
		echo 0;

	//echo FALSE;
?>

<?php
		include_once "../common/session.php";

		$str="../photo/".$_SESSION["photodir"];
		$count = count($_FILES['pic']['name']);
        //var_dump($_FILES['pic']['name']);
        //var_dump($_FILES['pic']['tmp_name']);
        //file_put_contents("123.txt",$str.$FILES["pic"]);
		for ($i = 1; $i <=$count; $i++) 
		{
        	$tmpfile = $_FILES['pic']['tmp_name'][$i-1];
        	
        	$dstfile = $str."/".$i.".jpg";
            //var_dump($tmpfile);

        	if (move_uploaded_file($tmpfile, $dstfile)) 
        	{
                header("location: ../background.html");
            	echo json_encode("succe");
        	} 
        	else 
        	{
            	echo json_encode("failed");
        	}
    	}	
?>
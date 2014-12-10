<?php
		include_once "../common/session.php";

		
		$count = count($_FILES['picture']['name']);
        
		for ($i = 1; $i <=$count; $i++) 
		{
            $dstfile = "../mobile/photo/".$_SESSION["artid"].".jpg";
            
        	$tmpfile = $_FILES['picture']['tmp_name'];
        	
        	if(file_exists($dstfile))
                unlink($dstfile);
            

        	if (move_uploaded_file($tmpfile, $dstfile)) 
        	{
                header("location: http://www.pindantuan.cn/kindeditor-4.1.7/php/demo.php");
            	echo json_encode("succe");
        	} 
        	else 
        	{
            	echo json_encode("failed");
        	}
    	}	
?>
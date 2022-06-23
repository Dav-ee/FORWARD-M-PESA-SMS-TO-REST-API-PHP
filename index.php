<?php	
date_default_timezone_set('Africa/Nairobi');
$php_date=  date('d/m/Y  H:i:s');
include_once "../db/dbconn.php";

	$phone = "N/A";
	if(isset($_POST["phone"])){
		$phone =  $_POST["phone"];
	}else if(isset($_GET["phone"])){
		$phone =  $_GET["phone"];
	}
	$text = "N/A";
	if(isset($_POST["text"])){
		$text =  $_POST["text"];
	}else if(isset($_GET["text"])){
		$text =  $_GET["text"];
	}
	
	// extra post parameters
	$extra1 = "N/A";
	if(isset($_POST["extra1"])){
	    $extra1 =  $_POST["extra1"];
	}else if(isset($_GET["extra1"])){
	    $extra1 =  $_GET["extra1"];
	}
	if(strlen($extra1)>15){
	    $extra1= substr($extra1, 0,15);
	}
	
	$extra2 = "N/A";
	if(isset($_POST["extra2"])){
	    $extra2 =  $_POST["extra2"];
	}else if(isset($_GET["extra2"])){
	    $extra2 =  $_GET["extra2"];
	}
	
	$device = "";
	if(isset($_POST["device"])){
		$device =  $_POST["device"];
	}
	$sim = "N/A";
	if(isset($_POST["sim"])){
		$sim =  $_POST["sim"];
	}else if(isset($_GET["sim"])){
		$sim =  $_GET["sim"];
	}
	
	
	$myfile = fopen("testfile.txt", "w");
	fwrite($myfile, pack("CCC",0xef,0xbb,0xbf));  // convert to utf8
	fwrite($myfile, "phone=$phone\n");
	fwrite($myfile, "text=$text\n");
	fwrite($myfile, "sim=$sim\n");
	if($device!=""){
		fwrite($myfile, "device=$device\n");
	}
	fclose($myfile);

// works with till numbers	
$my_array1 = explode(" ", $text);
$Tcode = $my_array1[0];
$amount = substr($my_array1[5], 5); 
$sanitizeAmount = str_replace(",", "", $amount);
$GETfinalAmount = substr($sanitizeAmount, 0, -3);

// works with send money
// $amount = substr($my_array1[5], 3); 
// $sanitizeAmount = str_replace(",", "", $amount);
// $finalAmount = substr($sanitizeAmount, 2, -3);

// 	insert to db
$activationInsert= "INSERT INTO `deposits`(`transId`, `date`, `phone`,`amout`,`status`) VALUES ('$Tcode','$php_date','$phone','$GETfinalAmount',0)";
mysqli_query($conn,$activationInsert); 


	//must return "OK" or APP will consider message as failed
	echo "OK";
?>

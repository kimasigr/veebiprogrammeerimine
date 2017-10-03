<?php
	require ("functions.php");
	
	//kas pole sisse loginud
	if(!isset($_SESSION["userId"])){
		header("Location: login.php");
		exit();
	}
	
	//Väljalogimine
	if(isset($_GET["logout"])){
		session_destroy();
		header("Location: login.php");
		exit();
	
	$picsDir = "../../pics/";
	$picFileTypes = ["jpg", "jpeg", "png", "gif"];
	$picFiles = [];
	
	$allFiles = array_slice(scandir($picsDir), 2);
	//var_dump($allFiles);
	foreach ($allFiles as $file){
		$fileType = pathinfo($file, PATHINFO_EXTENSION);
		if (in_array($fileType, $picFileTypes) == true){
			array_push($picFiles, $file);
		}
	}
	
	//$picFiles = array_slice($allFiles, 2);
	//var_dump($picFiles);
	
	$picCount = count($picFiles);
	
	$picNum = mt_rand(0,($picCount -1));
	$picFile = $picFiles[$picNum];
	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	
</head>
<body style =background-color:SEASHELL;">
	<h1>Kasutajad</h1>
	<p><a href="?logout=1<?php echo $notice; ?>">Logi Välja!</a></p>
	
</body>
</html>
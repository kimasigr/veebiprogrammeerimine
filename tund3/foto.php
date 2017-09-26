<?php
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
	<h1>Foto</h1>
	<img src="<?php echo $picsDir .$picFile; ?>" alt="Tallinna Ülikool">
	
</body>
</html>
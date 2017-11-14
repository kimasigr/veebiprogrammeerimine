<?php
	require("functions.php");
	require("editideafunctions.php");
	$notice = "";
	
	//kas pole sisse loginud
	if(!isset($_SESSION["userId"])){
		header("Location: login.php");
		exit();
	}
	
	//väljalogimine
	if(isset($_GET["logout"])){
		session_destroy();
		header("Location: login.php");
		exit();
	}
	
	if(isset($_POST["ideaButton"])){
		updateIdea($_POST["id"], test_input($_POST["idea"]), $_POST["ideaColor"]);
		header("Location: ?id=" .$_POST["id"]);
	}
	
	if(isset($_GET["delete"])){
		deleteIdea($_GET["id"]);
		header("Location: usersideas.php");
		exit();
	}
	
	
	if(isset($_GET["id"])){
		$currentIdea = getSingleIdea($_GET["id"]);
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Sigrid Kimask veebiprogrammeerimine</title>
</head>
<body>
	<h1>Head mõtted</h1>
	<p>See leht on loodud õppetöö raames ning ei sisalda mingit tõsiseltvõetavat sisu.</p>
	<p><a href="?logout=1">Logi välja!</a></p>
	<p><a href="usersideas.php">Tagasi mõtete lehele</a></p>
	<hr>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<!-- Peidetud sisend -->
		<input name="id" type="hidden" value="<?php echo $_GET["id"]; ?>">
		
		<label>Hea mõte: </label>
		<textarea name="idea"><?php echo $currentIdea->text; ?></textarea>
		<br>
		<label>Mõttega seotud värv: </label>
		<input name="ideaColor" type="color" value="<?php echo $currentIdea->color; ?>">
		<br>
		<input name="ideaButton" type="submit" value="Salvesta mõte!">
		<span><?php echo $notice; ?></span>
	</form>
	<p><a href="?id=<?php echo $_GET["id"]; ?>&delete=true">Kustuta</a> See mõte!</p>
	<!-- href="?id=17&delete=true" -->
	<hr>
	
</body>
</html>
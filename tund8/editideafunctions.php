<?php
	require("../../config.php");
	$database = "if17_kimasigr";
	
	//ühe kindla mõtte lugemine
	function getSingleIdea($id){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT idea, color FROM vpuserideas WHERE id=?");
		$stmt->bind_param("i", $id);
		$stmt->bind_result($idea, $color);
		$stmt->execute();
		$ideaObject = new Stdclass();
		if($stmt->fetch()){
			$ideaObject->text = $idea;
			$ideaObject->color = $color;
		} else {
			//kui sellist mõtet ei leitud
			header("Location:vpuserideas.php");
			exit();
		}
		
		$stmt->close();
		$mysqli->close();
		return $ideaObject;
	}
	
	function updateIdea($id, $idea, $color){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE vpuserideas SET idea=?, color=? WHERE id=?");
		$stmt->bind_param("ssi", $idea, $color, $id);
		$stmt->execute();
		
		$stmt->close();
		$mysqli->close();
	}
	
	function deleteIdea($id){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE vpuserideas SET deleted = NOW() WHERE id=?");
		$stmt->bind_param("i", $id);
		$stmt->execute;
		
		$stmt->close();
		$mysqli->close();
	}
?>
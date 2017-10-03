<?php
	$database = "if17_kimasigr";
	
	//kasutaja andmebaasi salvestamine
	function signUp($signupFirstName, $signupFamilyName, $signupBirthDate, $gender, $signupEmail, $signupPassword){
	//ühendus serveriga
		
		$mysqli = new mysqli($GLOBALS["$serverHost"], $GLOBALS["$serverUsername"], $GLOBALS["$serverPassword"], $GLOBALS["$database"]);
		//käsk serverile
		$stmt = $mysqli->prepare("INSERT INTO vpusers (firstname, lastname, birthDay, gender, email, password) VALUES(?, ?, ?, ?, ?, ?)");
		echo $mysqli->error;
		//seome õiged andmed
		//s-string ehk tekst
		//i-täisarv ehk integer
		//d-komaga arv ehk decimal ehk ujukomaarv
		$stmt->bind_param("sssiss", $signupFirstName, $signupFamilyName, $signupBirthDate, $gender, $signupEmail, $signupPassword);
		if ($stmt->execute()){
			echo "Õnnestuski!";
	} else {
			echo "Tekkis viga: " .$stmt->error;
	}
	$stmt->close();
	$mysqli->close();
	}
	
	
	//sisestuse testimise funktsioon
	function test_input($data){
		$data = trim($data); //eemaldab lõpust tühikuid, TAB jne..
		$data = stripcslashes($data); //eemaldab "\"
		$data = htmlspecialchars($data); //eemaldab keelatud märgid
		return $data;
	}
	
	/*$x = 4;
	$y = 9;
	echo "Esimene summa on: " .($x+$y);
	addValues();
	function addValues(){
		echo "Teine summa on: " .($x+$y);
		echo "Teine summa on: " .($GLOBALS["x"] + $GLOBALS["y"]);
		$a = 1;
		$b = 2;
		echo "Neljas summa on: " .($a + $b);
	}
	echo "Viies summa on: " .($a + $b);*/
		
	
?>
<?php
	$database = "if17_kimasigr";
	
	//alustame sessiooni
	session_start();
	
	//määrame sessiooni muutujad
	$_SESSION["userId"] = $id;
	$_SESSION["userEmail"] = $emailFromDb;
	
	function signIn($email, $password){
		$notice = "";
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, email, password FROM vpusers WHERE email = ?");
		$stmt->bind_param("s", $email);
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb);
		$stmt->execute();
		
		//kui vähemalt üks tulemus stmt-statement
		if ($stmt->fetch()){
			$hash = hash("sha512", $password);
			if($hash == $passwordFromDb){
				$notice = "Kõik õige! Logisite sisse!";
				//liigume pealehele
				header("Location: main.php");
				exit();
			} else { 
				$notice = "Vale salasõna!";
			}
		} else	{
			$notice = "Sellist kasutajat (" .$email .") ei leitud!";
		}
		$stmt->close();
		$mysqli->close();
		return $notice;
	}
	
	function signUp($signupFirstName, $signupFamilyName, $signupBirthDate, $gender, $signupEmail, $signupPassword){
		//loome andmebaasiühenduse
		
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		//valmistame ette käsu andmebaasiserverile
		$stmt = $mysqli->prepare("INSERT INTO vpusers (firstname, lastname, birthday, gender, email, password) VALUES (?, ?, ?, ?, ?, ?)");
		echo $mysqli->error;
		//s - string
		//i - integer
		//d - decimal
		$stmt->bind_param("sssiss", $signupFirstName, $signupFamilyName, $signupBirthDate, $gender, $signupEmail, $signupPassword);
		//$stmt->execute();
		if ($stmt->execute()){
			echo "\n Õnnestus!";
		} else {
			echo "\n Tekkis viga : " .$stmt->error;
		}
		$stmt->close();
		$mysqli->close();
	}
	
	//sisestuse kontrollimise funktsioon
	function test_input($data){
		$data = trim($data); //liigsed tühikud, TAB, reavahetused jms
		$data = stripslashes($data); //eemaldab kaldkriipsud"\"
		$data = htmlspecialchars($data);
	return $data;
	}
	
	/*  //global(globaalsed) versus local(lokaalsed)
	$x = 7;
	$y = 4;
	echo "Esimene summa on: " .($x + $y) ."\n";
	addValues();
	
	function addValues(){
		echo "Teine summa on: " . ($GLOBALS["x"] + $GLOBALS["y"]) . "\n";
		$a = 3;
		$b = 2;
		echo "Kolmas summa on: " . ($a + $b) . "\n";
		$x = 1;
		$y = 2;
		echo "Hoopis teine summa on: " . ($a + $b) . "\n";
	}
	echo "Neljas summa on: " . ($a + $b) . "\n";
	*/
	
?>
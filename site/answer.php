<?php
session_start();
$servername = "129.161.69.63";
$db_username = "user";
$db_password = "";
$dbname = "crowdsourcing";
//if($_SESSION["logged_in"]=true)
//{
	// Create connection
	$conn = new mysqli($servername, $db_username, $db_password, $dbname);

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	// prepare and bind
	$answer = json_decode(url_decode($_POST["json"]));
	print_r($answer);
	//echo($_SESSION["username"]);
	$stmt = $conn->prepare("INSERT INTO answers (answer,question_id,username,rating,image) VALUES (?,?,?,0,0)");
	$stmt->bind_param("sis", $answer->content,$answer->question,$_SESSION["username"]);
	$testing = "something";
	// set parameters and execute
	$stmt->execute();

	$stmt->close();


	$conn->close();

//}
?>

<?php
session_start();
$servername = "129.161.69.63";
$db_username = "user";
$db_password = "";
$dbname = "crowdsourcing";
if($_SESSION["logged_in"]=true)
{
	// Create connection
	$conn = new mysqli($servername, $db_username, $db_password, $dbname);

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	// prepare and bind
	$question = json_decode($_POST["json"]);
	//print_r($question);
	//echo($_SESSION["username"]);
	$stmt = $conn->prepare("INSERT INTO questions (question,description,asker,lat,lng,tags,accepted_answer,rating) VALUES (?,?,?,?,?,?,0,?)");
	$stmt->bind_param("sssddsi", $question->title,$question->description,$_SESSION["username"], $question->lat,$question->long,$question->tags,$question->rating);
	$testing = "something";
	// set parameters and execute
	$stmt->execute();

	$stmt->close();


	$conn->close();

}
?>
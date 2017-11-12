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
	print_r($question);
	$stmt = $conn->prepare("INSERT INTO questions (question,description,asker,location,tags,accepted_answer,rating) VALUES (?,?,?,?,?,0,?)");
	$stmt->bind_param("sssssi", $question->title,$question->description,$_SESSION["username"], $question->location,$question->tags,$question->rating);
	$testing = "something";
	// set parameters and execute
	$stmt->execute();

	$stmt->close();


	$conn->close();

}
?>
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
	$question = json_decode(urldecode($_POST["json"]));
	//print_r($question);
	//echo($_SESSION["username"]);
	$stmt = $conn->prepare("INSERT INTO questions (question,description,asker,lat,lng,accepted_answer,rating,time) VALUES (?,?,?,?,?,0,0,?)");
	echo($_SESSION["username"] . "\n");
	$stmt->bind_param("sssdds", $question->title,$question->description,$_SESSION["username"], $question->meta->lat,$question->meta->lng,$question->meta->time);
	$testing = "something";
	// set parameters and execute
	$stmt->execute();

	$stmt->close();


	$conn->close();

}
else
{
	echo("Not logged in!");
}
?>
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
	$question_id = json_decode(url_decode($_POST["json"]));
	$stmt = $conn->prepare('SELECT * FROM questions WHERE id = ?');
	$stmt->bind_param("i", $question_id);
	// set parameters and execute
	$stmt->execute();
	$result=$stmt->get_result();
	$question_row = $result->fetch_assoc();
	//print_r($question_row);
	//echo("<br />");
	$stmt2 = $conn->prepare('SELECT * FROM answers WHERE question_id = ?');
	$stmt2->bind_param("i", $question_id);
	$stmt2->execute();
	$result2 = $stmt2->get_result();
	$answers = array();
	while($row = $result2->fetch_assoc())
	{
		$answers[] = $row;
	}
	
	$stmt2->close();


	$conn->close();
	$question_row["answers"] = $answers;
	$question_row["meta"] = new \stdClass();
	$question_row["meta"]->time = $question_row["time"];
	$question_row["meta"]->lat = $question_row["lat"];
	$question_row["meta"]->lng = $question_row["lng"];
	$question_row["meta"]->tags = $question_row["tags"];
	
	//print_r($answers);
	//echo("<br />");
	echo(json_encode($question_row));
	
//}
?>
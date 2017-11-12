<?php
$servername = "129.161.69.63";
$username = "user";
$password = "";
$dbname = "crowdsourcing";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(urldecode($_POST["json"]));
$lng = $data->lng;
$lat = $data->lat;
$tags = array();
if(array_key_exists("tags",$data))
{
	$tmp = $data->tags;
	$tags = explode(",", $tmp);
	// var_dump($tags);
}

$query = 'SELECT * FROM questions WHERE (lat-$lat) < 0.07 AND (lng-$lng) <0.07 ORDER BY rating';
$result = $conn->query($query);
$questions = array();
while($row = $result->fetch_assoc()) {
	$questions[] = $row;
	$index = count($questions)-1;
	$questions[index]["meta"] = new \stdClass();
	$questions[index]["meta"]->time = $questions[index]["time"];
	$questions[index]["meta"]->lat = $questions[index]["lat"];
	$questions[index]["meta"]->lng = $questions[index]["lng"];
    }
$question_head->questions = $questions;
echo(json_encode($question_head));
$conn->close();
?>
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
//print_r($data);
// var_dump($data);
// echo $data->action;
if(property_exists("data","action"))
{
	// prepare and bind
	$stmt = $conn->prepare("INSERT INTO users (username,password,first_name,last_name) VALUES (?, ?, ?, ?)");
	$stmt->bind_param("ssss", $user, $pass, $first, $last);

	// set parameters and execute
	$user = $data->username;
	$pass = password_hash($data->password, PASSWORD_DEFAULT);
	$first = $data->first;
	$last = $data->last;
	if(!$stmt->execute())
	{

		$result = "This user already exists";
		$json = json_encode($result);
		echo($json);
	}
	$stmt->close();
}
else
{
	// prepare and bind
	$stmt = $conn->prepare("SELECT password FROM users WHERE username=?");
	// echo($conn->error);
	$stmt->bind_param("s", $user);

	// set parameters and execute
	$user = $data->username;
	if(!$stmt->execute())
	{
		$result = "Try Again.";
		$json = json_encode($result);
		echo $json;
	}

    $stmt->bind_result($dbpassword);
    $stmt->fetch();

    if(password_verify ($data->password , PASSWORD_DEFAULT))
    {    	
		$result = "Try Again.";
		$json = json_encode($result);
		echo $json;
    }
    else
    {
	    session_start();
	    $_SESSION["logged_in"] = true;
	    $_SESSION["username"] = $user;
		$json = '{"id":"' . session_id() . '"}';
	    echo $json;
    }
	$stmt->close();
}

$conn->close();
?>
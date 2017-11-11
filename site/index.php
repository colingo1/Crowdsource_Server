<html>

<?php
$servername = "localhost";
$username = "user";
$password = "GurQFa27qzH5VxaA";
$dbname = "crowdsourcing"

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// prepare and bind
$stmt = $conn->prepare("INSERT INTO users (username,password) VALUES (?, ?)");
$stmt->bind_param("sb", $username, $password);

// set parameters and execute
$username = "User1";
$password = "Password1";
$stmt->execute();

$stmt->close();
$conn->close();
?>

working on this stuff
I can edit.
</html>
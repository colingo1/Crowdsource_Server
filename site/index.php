<html>

<?php
$servername = "localhost";
$username = "user";
$password = "GurQFa27qzH5VxaA";
$dbname = "crowdsourcing";

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


$sql = "SELECT * FROM users";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "username " . $row["username"]. " - Password: " . $row["password"]. "<br>";
    }
} else {
    echo "0 results";
}



$conn->close();
?>

</html>
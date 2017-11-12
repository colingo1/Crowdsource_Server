<html>


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

$data = json_decode($_POST["json"]);
$lng = $data->lng;
$lat = $data->lat;
$tags = array();
if(array_key_exists("tags",$data))
{
	$tmp = $data->tags;
	$tags = explode(",", $tmp);
	// var_dump($tags);
}

$query = "SELECT questions.id,question,description,asker,accepted_answer,timestamp,time,picture_required,(abs(rating)+abs(COALESCE(arate,0))+dist_diff+COALESCE(diff_time,0)) as relevance FROM `questions` LEFT JOIN ( SELECT SUM(rating) AS arate, question_id FROM answers GROUP BY question_id ) AS answ ON answ.question_id = questions.id LEFT JOIN (SELECT (abs(lng-1)*abs(lng-1) + abs(lat-1)*abs(lat-1))/4761 as dist_diff, id FROM questions) AS dist ON dist.id = questions.id LEFT JOIN tags ON questions.id = tags.qid LEFT JOIN (SELECT (UNIX_TIMESTAMP(CURRENT_TIMESTAMP)-UNIX_TIMESTAMP(time))/360 as diff_time, id FROM questions WHERE time <= UNIX_TIMESTAMP(CURRENT_TIMESTAMP)) AS timediff ON timediff.id = questions.id ";
$numtags = count($tags);
$params = "";
$crazy = array();
if($numtags != 0)
{
	echo("NUM TAGS IS NOT ZERO: " . $numtags);
	$query .= "WHERE tag IN (";
	$numtags--;
	echo($numtags);
	for(;$numtags>0;$numtags--)
	{
		echo($numtags);
		$query .= "?,";
		$params .= "s";
		array_push($crazy, '$tags['.$numtags."]");
		echo("<br/>");
		var_dump($crazy);
		echo("<br/>");
	}
	array_push($crazy, '$tags[0]');
	// $crazy .= '$tags[0]';
	// array_push($crazy, '$tags[0]');
			echo("<br/>");
		print_r($crazy);
		echo("<br/>");
	$query .= "?) ";
	$params .= "s";
}
$query .= "GROUP BY questions.id ORDER BY relevance";

// prepare and bind
$stmt = $conn->prepare($query);


$refs = array();
foreach($crazy as $k => $v)
// for($i = 0; $i < count($tags); $i++)
{
	// $refs[] &= $crazy[$i];
	$refs[] = &$crazy[$k];
		echo("<br/>");
		echo "refs";
		echo("<br/>");
		print_r($refs);
		echo("<br/>");
		echo("<br/>");
}
echo("THERE ARE " . count($crazy) . " ELEMENTS");
		echo("<br/>");
		echo("<br/>");
		echo"vardump crazy";
		echo("<br/>");
var_dump($crazy);
		echo("<br/>");
		echo("<br/>");
		echo "vardumpref";
		echo("<br/>");
var_dump($refs);
$param_arr = array_merge(array(str_repeat("s", count($crazy))), array_values($refs));
call_user_func_array(array(&$stmt, 'bind_param'), $param_arr);
		echo("<br/>");
		echo("<br/>");


// set parameters and execute
if(!$stmt->execute())
{
	$res = $stmt->result_metadata();
	// print_r($res->fetch_fields());
	// var_dump($stmt->error);
	echo ("sad it didn't work");
}
else
{
	$result = $stmt->get_result();
	$answers = array();
	while($row = $result->fetch_assoc())
	{
		$answers[] = $row;
		echo $row;
		echo("in while");
	}
	var_dump($answers);
	echo(json_encode($answers));
	echo("WHAT!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!1");
	echo($query);
	var_dump($param_arr);
	echo($tags[0]);
}
$stmt->close();

$conn->close();
?>

</html>
<?php

/*
 *
 *  External Time Until Restart Clock/Timer
 *  Created for Arma 3 Exile Servers
 *
 *  Created by: Kurewe
 *  Website: http://cantankerousoldgoats.enjin.com/
 *
 */

include('include/dbinfo.php');

// Create connection
$conn = new mysqli($serveraddr, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT time_until_restart FROM restart_timer WHERE id = 1";
$result = $conn->query($sql);

if (!$result) {
    echo "DB Error, could not query the database\n";
    echo 'MySQL Error: ' . mysql_error();
    exit;
}

$row = $result->fetch_assoc();
$timer = $row['time_until_restart'];

$zero    = new DateTime('@0');
$offset  = new DateTime('@' . $timer * 60);
$diff    = $zero->diff($offset);
echo 'Example of PHP output';
echo '<br/>';
echo 'Time Until Restart: '.$diff->format('%h:%I');

?>

<!DOCTYPE html>
<html>
  <body>
		<center>
			<b>Example of HTML output</b>
			<br>
			<b><font size="7" color="#209200">Time Until Restart</font></b>
			<br>
			<b><font size="7" color="#209200"><?php echo $diff->format('%h:%I');?></font></b>
		</center>
  </body>
</html>
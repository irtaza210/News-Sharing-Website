<?php


$mysqli = new mysqli('localhost', 'root', 'y0kId432', 'module3');

if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	header('Location: homepage2.php');
	exit;
}
?>
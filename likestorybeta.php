<?php 
session_start();
require 'database.php';
$username = $_SESSION['username'];
$story_id = $_POST['story_id'];
echo "<form name='input' action='likes.php' method='POST'>
<input type = 'hidden' value = $username name = 'username2'>
<input type = 'hidden' value = $story_id name = 'story_id'>
</form>";
header("Location: likes.php");
?>

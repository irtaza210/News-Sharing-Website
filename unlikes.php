<?php
session_start();
// a story is unliked by deleting the like from database
require 'database.php';
$stmt= $mysqli->prepare("delete from likesbeta where story_id=? AND username = ?");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}
$stmt->bind_param('ss', $_POST['story_id'], $_SESSION['username']);
$stmt->execute();
$stmt->close();
echo "Story successfully unliked, click the homepage button to return to homepage";
    echo "<form action = 'homepage2.php' method = 'post'>
        <input type = 'submit' name = 'homepage' value = 'Homepage'>
        </form>"; 
?>
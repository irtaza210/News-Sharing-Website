<h1> hello </h1>
<?php
session_start();
require 'database.php';
echo $_POST['story_id'];
// we will first check if the user can even access this page. if the user is not logged in, they will
// immediately be redirected to homepage and they cant see the contents of this page at all
// an extra security check is also done by verifying the session token and the token posted
// from the previous page the user was on
if(!isset($_SESSION['username'])){ 
    header("Location: homepage2.php");
    exit;
}
else if(!hash_equals($_SESSION['token'], $_POST['newtoken'])){
    echo $_SESSION['username']."<br />";
    echo $_SESSION['token']."<br />";
    echo $_POST['newtoken'];
    die("You are accessing a page you do not have acccess to");
}
// the story is deleted from database
$stmt= $mysqli->prepare("delete from stories where story_id=? AND authorid = ?");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}
$stmt->bind_param('ss', $_POST['story_id'], $_SESSION['username']);
$stmt->execute();
$stmt->close();
header("Location: homepage2.php");
?>
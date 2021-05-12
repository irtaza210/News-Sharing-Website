<?php
session_start();
require 'database.php';
// echo $_POST['comment'];
// we will first check if the user can even access this page. if the user is not logged in, they will
// immediately be redirected to homepage and they cant see the contents of this page at all
// an extra security check is also done by verifying the session token and the token posted
// from the previous page the user was on
$token = $_POST['token'];
if(!isset($_SESSION['username'])){ 
    header("Location: homepage2.php");
    exit;
} 
else if(!hash_equals($_SESSION['token'], $token)){
    die("You are accessing a page you do not have acccess to");
}
$stmt= $mysqli->prepare("delete from comments where comment_id=? AND username=?");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}
$stmt->bind_param('ss', $_POST['comment_id'], $_SESSION['username']);
$stmt->execute();
$stmt->close();
echo "Your comment has been successfully deleted. Please click back and refresh the page to see the changes. <br>";
echo "<button onclick='window.history.go(-1)'>Back</button>";
?>
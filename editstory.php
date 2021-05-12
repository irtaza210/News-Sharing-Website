<h1> hello </h1>
<?php
session_start();
require 'database.php';
date_default_timezone_set('America/Chicago');
// we will first check if the user can even access this page. if the user is not logged in, they will
// immediately be redirected to homepage and they cant see the contents of this page at all
// an extra security check is also done by verifying the session token and the token posted
// from the previous page the user was on
$token = $_POST['newtoken'];
$token2 = $_SESSION['token'];
// the date is also updated to reflect the latest time the edit was made
$date = date("Y-m-d g:i:s");
if(!isset($_SESSION['username'])){  
    header("Location: homepage2.php");
    exit;
} 
else if(!hash_equals($_SESSION['token'], $token)){
    die("You are accessing a page you do not have acccess to");
}
echo $_POST['editstoryname'];
echo $_POST['storyauthor'];
echo $_POST['editstorybody'];
echo $_POST['editstorylink'];
$editstorylink = $_POST['editstorylink'];
$story_id= $_POST['story_id'];
if ($editstorylink != "") {
    if (filter_var($editstorylink, FILTER_VALIDATE_URL)===FALSE) {
        die("Not a valid URL");
    }
}
$stmt = $mysqli->prepare("update stories set storyname = ?, storybody=?, storylink=?, storytime=? where story_id = ?");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}
$stmt->bind_param('sssss', $_POST['editstoryname'], $_POST['editstorybody'], $editstorylink, $date, $story_id);
$stmt->execute();
$stmt->close();
header('Location: homepage2.php');
?>
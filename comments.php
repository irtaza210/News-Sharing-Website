<?php
session_start();
require 'database.php';
date_default_timezone_set('America/Chicago');
?>
<?php
session_start();
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
// comment inserted into database
if(isset($_POST['comment'])) {
    $username = $_SESSION['username'];
    $story_id= $_POST['story_id'];
    $comment = $_POST['comment'];
    $date = date("Y-m-d g:i:s");
    $stmt = $mysqli->prepare("INSERT INTO comments (username, story_id, comment, commenttime) VALUES (?, ?, ?, ?)");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('ssss', $username, $story_id, $comment, $date);
    $stmt->execute();
    $stmt->close();
    echo "Comment successfully posted, click the homepage button to return to homepage";
    echo "<form action = 'homepage2.php' method = 'post'>
        <input type = 'submit' name = 'homepage' value = 'Homepage'>
        </form>"; 
}
?>
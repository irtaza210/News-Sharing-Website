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
// all data is submitted into stories database and user is taken to homepage which shows the submitted story
if(isset($_POST['storyname']) AND isset($_POST['storyauthor']) AND isset($_POST['storybody']) AND isset($_POST['storylink'])) {
    $authorid = $_SESSION['username'];
    $storyname = $_POST['storyname'];
    $storyauthor = $_POST['storyauthor'];
    $storybody = $_POST['storybody'];
    $storylink = $_POST['storylink'];
    $date = date("Y-m-d g:i:s");
    if ($storylink != "") {
        if (filter_var($storylink, FILTER_VALIDATE_URL)===FALSE) {
            die("Not a valid URL");
        }
    }
    $stmt = $mysqli->prepare("INSERT INTO stories (authorid, storyname, storyauthor, storybody, storylink, storytime) VALUES (?, ?, ?, ?, ?, ?)");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('ssssss', $authorid, $storyname, $storyauthor, $storybody, $storylink, $date);
    $stmt->execute();
    $stmt->close();
    header("Location: homepage2.php");
}
// else {
//     echo "failure";
// }
?>
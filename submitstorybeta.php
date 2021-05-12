<?php
session_start();
require 'database.php';
echo "<link rel='stylesheet' type='text/css' href='submitstorybetastyle.css'>";
?>
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
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
else {
    $token = $_SESSION['token'];
    $username = $_SESSION['username'];
// form asks the storyname, storybody, and story link (optional) and when you click submit all the data goes to 
// submitstory.php which puts this data into the database using a sql query
echo"
<form class = 'submitform' name='input' action='submitstory.php' method='POST'>
    <input type = 'hidden' value = '$token' name = 'newtoken'> 
    <input type = 'hidden' value = '$username' name = 'username'> 
    <label class = 'storynamelabel' for='storyname'>Story Name</label>
    <input class = 'storynameinput' type='storyname' name='storyname' id='storyname' />
    <br>
    <input class = 'storyauthorinput' type='hidden' name='storyauthor' id='storyauthor' />
    <br>
    <label class = 'storybodylabel' for='storybody'>Story Body</label>
    <textarea name = 'storybody' class = 'storybodyinput' cols='50' rows='10'></textarea>
    <br>
    <label class = 'storylinklabel' for='storylink'>Story Link</label>
    <input class = 'storylinkinput' type='storylink' name='storylink' id='storylink' />
    <br>
    <input class = 'submitbutton' type='submit' value='Submit' />
</form>";
}
?>
<?php
session_start();
require 'database.php';
$username = (string) $_POST['username'];
$book = $_POST['book'];
$stmt = $mysqli->prepare("select username, security from users where username = ?");
if (!$stmt) {
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}
$stmt->bind_param('s', $username);
$stmt->execute();

$stmt->bind_result($username2, $security);
$stmt->fetch();
// if information is wrong they are redirected back
if($username2!=$username){
    echo "That user doesn't exist";
    echo "<form name='input' action='loginpart.html' method='POST'>
    <input type='submit' value='Back' />
    </form>";
}
else if(!password_verify($book, $security)){
    echo "Incorrect answer to security quesiton. Try again.";
    echo "<form name='input' action='resetpassword.php' method='POST'>
    <input type='submit' value='Back' />
    </form>";
    // since all the information was correct, they can now reset their password
}else{
    echo "<form name='input' action='newpassword.php' method='POST'>
    <input type = 'hidden' value = '$username' name = 'username'/>
    <label for='password'>Enter your new Password</label>
    <input type='password' name='password' id='password' />
    <input type='submit' value='Submit' />
    </form>";
}
?>



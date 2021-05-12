<!DOCTYPE html>
<html>
<head>
</head>
<body>
    
<form name="input" action="editcomment.php" method="POST">
    <?php 
    session_start();
    require 'database.php';
    $token = $_POST['token'];
    // we will first check if the user can even access this page. if the user is not logged in, they will
// immediately be redirected to homepage and they cant see the contents of this page at all
// an extra security check is also done by verifying the session token and the token posted
// from the previous page the user was on 
    if(!isset($_SESSION['username'])){  
        header("Location: homepage2.php");
        exit;
    } 
    else if(!hash_equals($_SESSION['token'], $token)){
        die("You are accessing a page you do not have acccess to");
    }
    // form allows you to edit the comment and you are then taken to editcomment.php which inserts editted comment into database
    $username = $_POST['username'];
    $comment = $_POST['comment'];
    $comment_id = $_POST['comment_id'];

    echo "<input type = 'hidden' value = '$comment' name = 'comment'>
    <input type = 'hidden' value = '$comment_id' name = 'comment_id'>
    <input type = 'hidden' value = '$token' name = 'token'>";
    ?>
    <label for="newcomment">Comment</label>
    <input type="text" name="newcomment" id="newcomment" />
    <input type="submit" value="Submit" />
</form>
</body>
</html>
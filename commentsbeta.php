
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<form name="input" action="comments.php" method="POST">
    <?php 
    // the form allows you to input your comment and then comment is posted to comments.php which inserts comment into database
    // and redirects to homepage
    session_start();
    require 'database.php';
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
    $username = $_SESSION['username'];

    $story_id = $_POST['story_id'];
    $token = $_SESSION['token'];
    echo "<input type = 'hidden' value = $username name = 'username2'>
    <input type = 'hidden' value = '$token' name = 'newtoken'> 
    <input type = 'hidden' value = $story_id name = 'story_id'>
    ";
    ?>
    <label for="comment">Comment</label>
    <input type="text" name="comment" id="comment" />
    <input type="submit" value="Submit" />
</form>
</body>
</html>
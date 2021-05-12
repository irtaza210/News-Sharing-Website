<!DOCTYPE html>
<html>
<head>
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
</head>
<body>
<?php
session_start();
require 'database.php';
echo "<link rel='stylesheet' type='text/css' href='fullstorystyle.css'>";
$secureusername = $_SESSION['username'];
$token = $_SESSION['token'];
$newtoken = $_POST['newtoken'];
$username = $_POST['username'];
$storyname = $_POST['storyname'];
$storyauthor = $_POST['storyauthor'];
$storybody = $_POST['storybody'];
$storylink = $_POST['storylink'];
$story_id = $_POST['story_id'];
$storytime = $_POST['storytime'];
$authorid = $_POST['authorid'];
echo "<h3> Title </h3>";
    echo $storyname;
    echo "<h3> Author </h3>";
    echo $authorid;
    echo "<h3> Description </h3>";
    echo $storybody;
    echo "<h3> Time Posted </h3>";
    echo $storytime;
    echo "<br>";
    echo "<h3> Story Link </h3>";
    echo "<a href = '$storylink'>$storylink</a>";
    echo "<br>";
    // if the user is logged they can comment or like on the story
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $token = $_SESSION['token'];
        echo "<form action= 'commentsbeta.php' method='post'>
        <input type = 'hidden' value = '$token' name = 'newtoken'> 
        <input type = 'hidden' value = $username name = 'username'>
        <input type = 'hidden' value = '$story_id' name = 'story_id'>
        <input type = 'hidden' value = $storyname name = 'storyname'><br>
        <input type='submit' name = 'Comment' value='Comment'><br>
        </form>
        <br>
        <form action = 'likes.php' method = 'post'>
        <input type = 'hidden' value = '$username' name = 'username'>
        <input type = 'hidden' value = '$story_id' name = 'story_id'>
        <input type = 'submit' name = 'likestory' value = 'Like Story'><br>
        </form>"; 
        
    }
// displaying likes
$stmt2 = $mysqli->prepare("select username from likesbeta where story_id=?");
if (!$stmt2) {
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}
$stmt2->bind_param('s', $story_id);
$stmt2->execute();
$stmt2->bind_result($username2);
echo "<h3> Likes </h3>";
while ($stmt2->fetch()) {
    echo "This story was liked by ";
    echo $username2;
    echo "<br>";
}
$stmt2->close();
// displaying comments
$stmt = $mysqli->prepare("select comment_id, username, comment, commenttime from comments where story_id=?");
if (!$stmt) {
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}
$stmt->bind_param('s', $story_id);
$stmt->execute();
$stmt->bind_result($comment_id, $username2, $comment, $time);
echo "<h3> Comments </h3>";
while ($stmt->fetch()) {
    echo $username2;
    echo ": ";
    echo $comment;
    echo "<br>";
    echo "Time: ";
    echo $time;
    echo "<br>";
    echo "<br>";
    // if user is logged in they can edit and delete a comment they have made
    if ($secureusername == $username2 && ($token == $newtoken)) { 
        echo "<form action= 'deletecomment.php' method = 'post'>
        <input type = 'hidden' value = '$secureusername' name = 'secureusername'>
        <input type = 'hidden' value = '$comment' name = 'comment'>
        <input type = 'hidden' value = '$token' name = 'token'>
        <input type = 'hidden' value = '$comment_id' name = 'comment_id'><br>
        <input type='submit' name = 'Delete' value='Delete Comment'>
        </form> 
        <form action= 'editcommentbeta.php' method = 'post'>
        <input type = 'hidden' value = '$username2' name = 'username'>
        <input type = 'hidden' value = '$comment' name = 'comment'>
        <input type = 'hidden' value = '$token' name = 'token'>
        <input type = 'hidden' value = '$comment_id' name = 'comment_id'><br>
        <input type='submit' name = 'Delete' value='Edit Comment'>
        </form> 
    
        <br>";
    
    }
}
?>
</body>
</html>
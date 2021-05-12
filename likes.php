<?php
session_start();
require 'database.php';
?>
<?php
session_start();
// this is our creative feature. users can like a story or unlike a story they previously liked
echo $_POST['username2'];
$checkusername = $_SESSION['username'];
$story_id = $_POST['story_id'];
$stmt = $mysqli->prepare("select username from likesbeta where story_id=?");
if (!$stmt) {
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}
$stmt->bind_param('s', $story_id);
$stmt->execute();
$stmt->bind_result($username2);
// echo $username2;
// echo $comment;
while ($stmt->fetch()) {
    if ($checkusername == $username2) {
        // if the user has already liked the story, they are given the option to unlike
        echo "you have already liked this story. If you want to unlike the story, please click below";
        echo "<form name='input' action='unlikes.php' method='POST'>
        <input type = 'hidden' value = '$username' name = 'username2'>
        <input type = 'hidden' value = '$story_id' name = 'story_id'>
        <input type='submit' name = 'unlike' value='Unlike Story'>
        </form>";
        echo "Or return to homepage";
        echo "<form name='input' action='homepage2.php' method='POST'>
        <input type='submit' name = 'unlike' value='Homepage'>
        </form>";
        exit;
    }
}
$stmt->close();

    $username = $_SESSION['username'];
    $story_id= $_POST['story_id'];
    $stmt2 = $mysqli->prepare("INSERT INTO likesbeta (username, story_id) VALUES (?, ?)");
    if(!$stmt2){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt2->bind_param('ss', $username, $story_id);
    $stmt2->execute();
    $stmt2->close();
    echo "Story successfully liked, click the homepage button to return to homepage";
    echo "<form action = 'homepage2.php' method = 'post'>
        <input type = 'submit' name = 'homepage' value = 'Homepage'>
        </form>"; 

?>
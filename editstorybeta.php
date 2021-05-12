
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<!-- the form allows the user to make edits to the story they posted, after submitting the form theyre redirected to 
editstory.php which makes a sql query to insert the updated story into database -->
<form name="input" action="editstory.php" method="POST">
    <?php 
    session_start();
    require 'database.php';
    // we will first check if the user can even access this page. if the user is not logged in, they will
// immediately be redirected to homepage and they cant see the contents of this page at all
// an extra security check is also done by verifying the session token and the token posted
// from the previous page the user was on
    $token = $_POST['newtoken'];
    $token2 = $_SESSION['token'];
    if(!isset($_SESSION['username'])){  
        header("Location: homepage2.php");
        exit;
    } 
    else if(!hash_equals($_SESSION['token'], $token)){
        die("You are accessing a page you do not have acccess to");
    }
    $storyauthor = $_POST['storyauthor'];
    $story_id = $_POST['story_id'];
    echo "
    <input type = 'hidden' value = '$token2' name = 'newtoken'> 
    <input type = 'hidden' value = $storyauthor name = 'storyauthor'>
    <input type = 'hidden' value = $story_id = name ='story_id'>";
    
    ?>
    <label for="storyname">Story Name</label>
    <input type="storyname" name="editstoryname" id="storyname" /><br><br>
    <label for="storybody">Story Body</label><br>
    <textarea cols="50" rows="10" type="text" name="editstorybody" id="storybody"></textarea><br><br>
    <label for="storylink">Story Link</label>
    <input type="storylink" name="editstorylink" id="storylink" /><br><br>
    <input type="submit" value="Submit" />
</form>
</body>
</html>
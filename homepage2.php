<?php
session_start();
require 'database.php';
echo "<link rel='stylesheet' type='text/css' href='homepage2style.css'>";
?>
<h1 class = "welcomeheader"> Welcome </h1>
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
<?php
if (isset($_SESSION['username'])) {
    $username =$_SESSION['username'];
    echo "<form class = 'logutform' name='input' action='logout.php' method = 'post'>
    <input type = 'hidden' value = $username = 'username'>
    <input class = 'logoutbutton' type='submit' value='Log Out'/>
    </form>";
}
else {
    echo "<form name='input' action='makeaccount.html'>
    <input type='submit' value='Register'/>
    </form>
    <form name='input' action='loginpart.html'>
    <input type='submit' value='Log In'/>
    </form>";
}
?>
<h2 class = "userheader">User: <?php 
session_start();
         $username = $_SESSION['username'];
        echo htmlentities($_SESSION['username']);
        ?></h2>
<?php
session_start();
// submit story button will only be shown if user is logged in
if (isset($_SESSION['username'])) {
    $token = $_SESSION['token'];
    $username = $_SESSION['username'];
    echo"
    <form class = 'submitform' action = 'submitstorybeta.php' method = 'post'>
        <input type = 'hidden' value = '$token' name = 'newtoken'> 
        <input type = 'hidden' value = '$username' name = 'username'> 
        <input class = 'submitbutton' type='submit' value='Submit a Story'>
    </form>";
    // creative feature allows user to search for stories
    echo "
    <form class = 'searchform' action = 'searchstories.php' method = 'post'> 
    <input type = 'hidden' value = '$token' name = 'newtoken'> 
    <input type = 'hidden' value = '$username' name = 'username'> 
    <label class = 'searchlabel' for='search'>Search Stories</label><br>
<input class = 'searchbox' type='text' name='search' id='search' /><br>
<input class = 'searchbutton' type='submit' value='Search' />
</form><hr>";
}
else {
    echo "
    <form action = 'searchstories.php' method = 'post'> 
    <label for='search'>Search Stories</label>
    <input type='text' name='search' id='search' />
    <input type='submit' value='Search' />
    </form><hr>";
}
?>

<?php
echo "<h2 class = 'storiesheader'> Stories </h2>";
session_start();
$stmt= $mysqli->prepare("select story_id, authorid, storyname, storyauthor, storybody, storylink, storytime from stories");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}
$stmt->execute();
$stmt->bind_result($story_id, $authorid, $storyname, $storyauthor,$storybody, $storylink, $storytime);

// all stories will be shown on homepage
while ($stmt->fetch()) {
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
    $secureusername = $_SESSION['username'];
    $token = $_SESSION['token'];
    // clicking learn more button will take you to fullstory.php which allows you to make comments and like the story and 
    // view other likes/comments
    echo "<form action= 'fullstory.php' method='post'>
        <input type = 'hidden' value = '$secureusername' name = 'secureusername'>
        <input type = 'hidden' value = '$token' name = 'newtoken'> 
        <input type = 'hidden' value = '$username' name = 'username'>
        <input type = 'hidden' value = '$storyname' name = 'storyname'>
        <input type = 'hidden' value = '$story_id' name = 'story_id'>
        <input type = 'hidden' value = '$storyauthor' name = 'storyauthor'>
        <input type = 'hidden' value = '$storybody' name = 'storybody'>
        <input type = 'hidden' value = '$storylink' name = 'storylink'>
        <input type = 'hidden' value = '$storytime' name = 'storytime'>
        <input type = 'hidden' value = '$authorid' name = 'authorid'>
        <br>
        <input type='submit' name = 'learnmore' value='Click here to view comments/likes and like/comment on the story'>
        </form>"; 
    
    
    // creative feature: allow the user to like the story if theyre logged in
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $token = $_SESSION['token'];
        
        echo "<form action = 'likes.php' method = 'post'>
        <input type = 'hidden' value = '$username' name = 'username'>
        <input type = 'hidden' value = '$story_id' name = 'story_id'>
        <input type = 'submit' name = 'likestory' value = 'Like Story'>
        </form>"; 
        
    }
    // if the person who posted the story is the user whos logged in then they can delete or edit their story
    if ($authorid == $_SESSION['username']) { 
        $token = $_SESSION['token'];
        $username = $_SESSION['username'];
        echo "<form action= 'deletestory.php' method = 'post'>
        <input type = 'hidden' value = '$story_id' name = 'story_id'>
        <input type = 'hidden' value = '$story_id' name = 'story_id'>
        <input type = 'hidden' value = '$token' name = 'newtoken'> 
        <input type = 'hidden' value = '$username' name = 'username'> 
        <input type='submit' name = 'Delete' value='Delete Story'>
        </form>

        <form action= 'editstorybeta.php' method = 'post'>
        <input type = 'hidden' value = $storyauthor name = 'storyauthor'>
        <input type = 'hidden' value = '$story_id' name = 'story_id'>
        <input type = 'hidden' value = '$token' name = 'newtoken'> 
        <input type='submit' name = 'Delete' value='Edit Story'>
        </form> 
        <hr>
        <br>";
   
    }
    
    else {
        echo "<hr>";
        echo "<br>";
    }
}
?>
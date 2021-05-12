<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
<?php 
    session_start();
    require 'database.php';
    echo "<link rel='stylesheet' type='text/css' href='searchstoriesstyle.css'>";
    $search = $_POST['search'];
    if (isset($_SESSION['username'])) {
    $token = $_SESSION['token'];
    $username = $_SESSION['username'];
    $username2 = $_POST['username'];
    $newtoken = $_POST['newtoken'];
    }
    // user searches for a story on the homepage and a sql query is made to fetch all stories that have similar keywords to the storyname and they are
    // then displayed, this is our creative
    // feature
    echo "<h2> Search Results </h2>";
        $stmt=$mysqli->prepare("select story_id, authorid, storyname, storyauthor, storybody, storylink, storytime from stories where storyname like '%$search%'");
        if (!$stmt) {
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->execute();
        $stmt->bind_result($story_id, $authorid, $storyname, $storyauthor,$storybody, $storylink, $storytime);
        while ($stmt->fetch()) {
            echo $storyname;
            if (isset($_SESSION['username'])) {
            $secureusername = $_SESSION['username'];
            $token = $_SESSION['token'];
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
        <input type = 'hidden' value = '$authorid' name = 'authorid'><br>
        <input type='submit' name = 'learnmore' value='Learn More'>
        </form>"; 
            }
            else {
                echo  
            "<form action= 'fullstory.php' method='post'>
            <input type = 'hidden' value = '$storyname' name = 'storyname'>
            <input type = 'hidden' value = '$story_id' name = 'story_id'>
            <input type = 'hidden' value = '$storyauthor' name = 'storyauthor'>
            <input type = 'hidden' value = '$storybody' name = 'storybody'>
            <input type = 'hidden' value = '$storylink' name = 'storylink'>
            <input type = 'hidden' value = '$storytime' name = 'storytime'>
            <input type = 'hidden' value = '$authorid' name = 'authorid'><br>
            <input type='submit' name = 'learnmore' value='Learn More'>
            </form>";
            }
        }
        $stmt->close();
    

    
?>
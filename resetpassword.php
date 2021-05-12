<?php
session_start();
// this is our creative feature, users can reset their passwrd. they input their username and answer to security question 
// and when they click submit are redirected to a page that verifies their answers with the database
require 'database.php';
echo "<form name='input' action='correctanswers.php' method='POST'>
<label for='username'>Username</label>
<input type='text' name='username' id='username' />
<label for='book'>What is the name of your favorite book?</label>
<input type='text' name='book' id='book' />
<input type='submit' value='Submit' />
</form>";
?>
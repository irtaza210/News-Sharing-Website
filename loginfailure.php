<?php
echo "Log In failed. Username/Password incorrect";
echo "<form action = 'loginpart.html' method = 'post'>
<input type='submit' value='Try Again'>
</form>";
echo"
    <h3> Forgot Password? </h3>
    <form action = 'resetpassword.php' method = 'post'>
        <input type='submit' value='Reset Password'>
    </form>";
?>
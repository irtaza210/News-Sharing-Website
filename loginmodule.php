<?php
session_start();
require 'database.php';
?>

<?php
    if(isset($_POST['user']) AND isset($_POST['password'])) {
        $user = $_POST['user'];
        $normalpassword = $_POST['password'];
        $stmt = $mysqli->prepare("SELECT COUNT(*), username, password FROM users WHERE username=?");
        $stmt->bind_param('s', $user);
        $stmt->execute();
        $stmt->bind_result($count, $username, $hashedpassword);
        $stmt->fetch();
        if($count > 0 && password_verify($normalpassword, $hashedpassword)) {
            session_start();
            $_SESSION['username'] = $username;
            // generates a session token for security purposes acknolweding that a session for the user has been started
            $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
            header('Location: homepage2.php');
        }
        else{
            session_destroy();
            // login failed so will now take you to a page that tells you to try again or reset your password (creative feature)
            header('Location: loginfailure.php');
            exit;
        }
    }
?>
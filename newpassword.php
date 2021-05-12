<?php
// the new password is updated in the database
    require 'database.php';
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashedpassword = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $mysqli->prepare("update users set password = ? where username = ?");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
   
    $stmt->bind_param('ss', $hashedpassword, $username);
    $stmt->execute();
    $stmt->close();
    header('Location: loginpart.html');
?>


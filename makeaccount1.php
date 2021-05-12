<?php
    session_start();
    require 'database.php';
    $user = (string) $_POST['user'];
    $password = (string) $_POST['password'];
    $book = $_POST['book'];
    $hashedpassword = password_hash($password, PASSWORD_BCRYPT);
    $hashedbook = password_hash($book,PASSWORD_BCRYPT);
    $stmt = $mysqli->prepare("insert into users (username, password, security) values (?,?, ?)");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('sss', $user, $hashedpassword, $hashedbook);
    $stmt->execute();
    $stmt->close();
    header('Location: loginpart.html');
    
?>
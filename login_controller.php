<?php
require_once 'conf/conection.php';
session_start();
if(isset($_GET['logout']))
{
    session_unset();
    header("Location: login.php");
        exit;
}

if (!empty($_POST['email']) && !empty($_POST['password'])) {

    $email = htmlspecialchars(strip_tags($_POST['email']));
    $password = htmlspecialchars(strip_tags($_POST['password']));
    $query = "SELECT * FROM users WHERE email = '{$email}' AND password = '{$password}'";
   
    $result = $conn->query($query);
    $user = $result->fetch_assoc();
    if ($user) {
        $_SESSION['user'] = $user['name'];
        $_SESSION['role'] = $user['role'];
        
        header("Location: admin/index.php");
        exit;
    } else {
        $_SESSION['message'] = " Invalid email or password ";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }
} else {
    $_SESSION['message'] = " Please the all informations are required ";
    header("Location: " . $_SERVER['HTTP_REFERER']);
    // header("Location: login.php");
    exit;
}

// print $_SESSION['message'];
// if ($_SERVER["REQUEST_METHOD"] == "POST")
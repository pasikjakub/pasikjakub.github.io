<?php 

session_start();

include('admin_check_userType.php');

if(isset($_GET['logout'])){
    if(isset($_SESSION['logged_in'])){
        unset($_SESSION['logged_in']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_type']);
        header('location: ../login.php');
        exit;
    }
}


?>
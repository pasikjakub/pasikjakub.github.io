<?php 
if (!isset($_SESSION['user_type']) || ($_SESSION['user_type'] !== 2 && $_SESSION['user_type'] !== 3)) {
    header('Location: ../login.php');
    exit;
}

 ?>

 
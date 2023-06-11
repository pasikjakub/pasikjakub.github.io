<?php 
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 2) {
    header('Location: ../login.php');
    exit;
}
 ?>
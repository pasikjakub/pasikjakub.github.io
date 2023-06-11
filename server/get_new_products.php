<?php
include('connection.php');

$statement = $db->prepare("SELECT * FROM products ORDER BY product_id DESC LIMIT 4");

$statement->execute();

$featured_prod = $statement->get_result();
?>
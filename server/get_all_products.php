<?php
include('connection.php');

$statement = $db->prepare("SELECT * FROM products ORDER BY product_id");

$statement->execute();

$all_prod = $statement->get_result();
?>
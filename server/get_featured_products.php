<?php 

include('connection.php');

$statement = $db->prepare("SELECT * FROM products LIMIT 4");

$statement->execute();

$featured_prod = $statement->get_result();


?>
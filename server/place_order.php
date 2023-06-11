<?php 

session_start();
include('connection.php');

if(isset($_POST['place_order'])){

    //pobierz informacje uzytkownika i przechowaj w bazie
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];
    $address = $_POST['address'];
    $order_cost = $_SESSION['total'];
    $order_status = "Nie zapłacone";
    $user_id = $_SESSION['user_id'];
    $order_date = date('Y-m-d H:i:s');

    $statement = $db->prepare("INSERT INTO orders (order_cost, order_status, user_id, user_phone, user_city, user_address, order_date)
    VALUES (?, ? ,?, ?, ? ,?, ?);");

    $statement->bind_param('isiisss', $order_cost, $order_status, $user_id, $phone, $city, $address, $order_date);

    $statement->execute();

    


    //pzechowaj zamowienie w bazie
    $order_id = $statement->insert_id;



    //pobierz produkty ^
   // $_SESSION['cart']; //[4=>[] , 5=>[]]
    foreach($_SESSION['cart'] as $key => $value){
        $product = $_SESSION['cart'][$key];
        $product_id = $product['product_id'];
        $product_name = $product['product_name'];
        $product_image = $product['product_image'];
        $product_price = $product['product_price'];
        $product_quantity = $product['product_quantity'];

        //kazdy pojedynnczy produkt do order_items
        $statement1 = $db->prepare("INSERT INTO order_items (order_id, product_id, product_name, product_image, product_price, product_quantity, user_id, order_date)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        $statement1->bind_param('iissiiis', $order_id, $product_id, $product_name, $product_image, $product_price, $product_quantity, $user_id, $order_date);

        $statement1->execute();

    }

    


    //usuniecie z koszyka -- jesli zaplaci
    //unset($_SESSION['cart']);
    

    //poinformowanie ze zamowienie przeszlo
    header('location: ../payment.php?order_status=zamówienie złożone poprawnie');

}

?>
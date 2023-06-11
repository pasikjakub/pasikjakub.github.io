<?php



session_start();

if (isset($_POST['add-to-cart'])) {

    //jesli juz ma produkty
    if (isset($_SESSION['cart'])) {

        $products_array_ids = array_column($_SESSION['cart'], "product_id");
        //jesli produkt nie zostal jeszcze dodany
        if (!in_array($_POST['product_id'], $products_array_ids)) {

            $product_id = $_POST['product_id'];
            $product_name = $_POST['product_name'];
            $product_price = $_POST['product_price'];
            $product_image = $_POST['product_image'];
            $product_quantity = $_POST['product_quantity'];

            $product_array = array(
                'product_id' => $_POST['product_id'],
                'product_name' => $_POST['product_name'],
                'product_price' => $_POST['product_price'],
                'product_image' => $_POST['product_image'],
                'product_quantity' => $_POST['product_quantity']
            );

            $_SESSION['cart'][$product_id] = $product_array;

        }
        //zostal juz dodany
        else {

            echo '<script>alert("Produkt został dodany już do koszyka")</script>';
            // echo '<script>window.location="index.php"</script>';
        }


    } // jesli pierwszy produkt
    else {
        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_image = $_POST['product_image'];
        $product_quantity = $_POST['product_quantity'];

        $product_array = array(
            'product_id' => $product_id,
            'product_name' => $product_name,
            'product_price' => $product_price,
            'product_image' => $product_image,
            'product_quantity' => $product_quantity
        );

        $_SESSION['cart'][$product_id] = $product_array;
 
        
    }

    //obliczanie lacznej kwoty
    calculateTotal();

}
//usuniecie
else if (isset($_POST['remove_product'])) {

    $product_id = $_POST['product_id'];
    unset($_SESSION['cart'][$product_id]);

    calculateTotal();

} else if (isset($_POST['edit_quantity'])) {

    $product_id = $_POST['product_id'];
    $product_quantity = $_POST['product_quantity'];

    // id produktu z tablicy sesji
    $product_array = $_SESSION['cart'][$product_id];

    //dawna ilosc                        nowa ilosc - update ilosci
    $product_array['product_quantity'] = $product_quantity;

    //return tablicy
    $_SESSION['cart'][$product_id] = $product_array;

    calculateTotal();

} else {
   // header('location: index.php');
}

// obliczenie lacznej sumy
function calculateTotal()
{

    $total = 0;

    foreach ($_SESSION['cart'] as $key => $value) {

        $product = $_SESSION['cart'][$key];

        $price = $product['product_price'];
        $quantity = $product['product_quantity'];

        $total += ($price * $quantity);
    }

    $_SESSION['total'] = $total;

}


?>



<?php include('layouts/header.php'); ?>



    <section id="cart" class="main cart" style="min-height: 100vh; margin-top: 150px; position: relative;">

        <div class="container">
            <h1>Twój koszyk</h1>
            <div class="product-line"></div>


            <table>
                <tr>
                    <th>Produkt</th>
                    <th>ilość</th>
                    <th>Wartość</th>
                </tr>

                <?php foreach ($_SESSION['cart'] as $key => $value) { ?>
                    <tr>
                        <td>
                            <div class="product-cart-info">
                                <img src="assets/images/<?php echo $value['product_image']; ?>" alt="">
                                <div>
                                    <p>
                                        <?php echo $value['product_name']; ?>
                                    </p>
                                    <small>
                                        <?php echo $value['product_price']; ?><span>zł</span>
                                    </small>
                                    <br>
                                    <form method="POST" action="cart.php" style="margin-top: 0">
                                        <input type="hidden" name="product_id"
                                            value="<?php echo $value['product_id']; ?>" />
                                        <input type="submit" name="remove_product" class="remove-btn" value="Usuń" />
                                    </form>
                                </div>
                            </div>
                        </td>
                        <td>
                            <form method="POST" action="cart.php">
                                <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?>" />
                                <input type="number" name="product_quantity"
                                    value="<?php echo $value['product_quantity']; ?>" />
                                <input type="submit" value="Edytuj" name="edit_quantity" class="edit-btn" />
                            </form>
                        </td>
                        <td>
                            <span class="cart-price">
                                <?php echo $value['product_quantity'] * $value['product_price']; ?>
                            </span>
                            <span>zł</span>
                        </td>
                    </tr>
                <?php } ?>


            </table>

            <div class="cart-total">
                <table>
                    <tr>
                        <td>Do zapłaty</td>
                        <td><?php echo $_SESSION['total']; ?> zł</td>
                    </tr>

                </table>
            </div>

            <div class="cart-continue">
                <form method="POST" action="checkout.php">
                    <input type="submit" class="checkout-btn" name="checkout" value="Przejdź dalej" />
                </form>
                
            </div>

        </div>





    </section>


    <?php include('layouts/footer.php'); ?>
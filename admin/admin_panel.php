<?php
session_start();

include('admin_check_userTypeMod.php');

include('../server/connection.php');


?>

<?php include('../layouts/sidebar.php'); ?>

<div class="col py-3">
<?php

function displayProducts($products)
{
        echo '<table class="product-table">';
        echo '<tr>';
        echo '<th>ID</th>';
        echo '<th>Nazwa</th>';
        echo '<th>Obraz</th>';
        echo '<th>Opis</th>';
        echo '<th>Cena</th>';
        echo '<th>Kolor</th>';
        echo '</tr>';

        while ($row = $products->fetch_assoc()) {
                $description = $row['product_description'];
                $shortDescription = strlen($description) > 100 ? substr($description, 0, 100) . '...' : $description;

                echo '<tr>';
                echo '<td>' . $row['product_id'] . '</td>';
                echo '<td>' . $row['product_name'] . '</td>';
                echo '<td><img style="width: 80px; height: 80px;" src="../assets/images/' . $row['product_image'] . '" alt="' . $row['product_name'] . '" class="product-image"></td>';
                echo '<td><span class="description">' . $shortDescription . '</span></td>';
                echo '<td>' . $row['product_price'] . ' PLN</td>';
                echo '<td>' . $row['product_color'] . '</td>';
                echo '</tr>';
        }

        echo '</table>';
}

include('../server/get_all_products.php');
echo '<h3>Produkty</h3>';
displayProducts($all_prod);

?>
</div>

<?php include('../layouts/admin_footer.php') ?>
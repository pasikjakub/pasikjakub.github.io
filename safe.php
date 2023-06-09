<form method="POST" action="cart.php">
    <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?>" />
    <input type="number" name="product_quantity" value="<?php echo $value['product_quantity']; ?>" />
    <input type="submit" value="Edytuj" name="edit_quantity" class="edit-btn" />
</form>


<?php foreach($_SESSION['cart'] as $key => $value) { ?>

<tr>
    <td>
        <div class="product-cart-info">
            <img src="assets/images/<?php echo $value['product_image']; ?>" >
            <div>
                <p><?php echo $value['product_name']; ?></p>
                <small><?php echo $value['product_price']; ?><span>zł</span></small>
                <br>
                <form method="POST" action="cart.php" style="margin-top: 0">
                    <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?>"/>
                    <input type="submit" name="remove_product" class="remove-btn" value="Usuń"/>
                </form>
                
            </div>
        </div>
    </td>
    <td>
        
    

        
    </td>
    <td>
        <span class="cart-price">139.99</span>
        <span>zł</span>
    </td>

</tr>

    <?php } ?>
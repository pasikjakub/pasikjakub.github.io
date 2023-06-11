<?php 
    session_start();
    
?>




<?php include('layouts/header.php'); ?>


<section id="main" class="main" style="min-height: 1200px; margin-top: 130px; position: relative;">
    <div class="container">
        <div class="row">
            <div class="banner_middle">
                <div class="banner_row">
                    <div class="header">
                        <h1>Kuchnie pod zabudowe</h1>
                        <span>Najszerszy wybór w całej Polsce</span>
                    </div>
                    <button>Sprawdz</button>
                </div>
            </div>
        </div>

        <div class="space-line"></div>

        <div class="products-section">
            <h2>Polecane</h2>
            <div class="row product-container">
                <?php include('server/get_featured_products.php') ?>

                <?php while ($row = $featured_prod->fetch_assoc()) { ?>
                    <a class="product" href="<?php echo "product.php?product_id=" . $row['product_id']; ?>">
                        <img src="assets/images/<?php echo $row['product_image']; ?>" alt="">
                        <span class="product-name">
                            <?php echo $row['product_name']; ?>
                        </span>
                        <div class="product-price">
                            <span>
                                <?php echo $row['product_price']; ?>
                            </span>
                            <span class="product-currency">PLN</span>
                        </div>
                    </a>

                <?php } ?>

            </div>
        </div>

        <div class="space-line"></div>



        <div class="space-line"></div>

        <div class="products-section">
            <h3>Nowości</h3>
            <div class="row product-container">
                <?php include('server/get_new_products.php') ?>

                <?php while ($row = $featured_prod->fetch_assoc()) { ?>
                    <a class="product" href="<?php echo "product.php?product_id=" . $row['product_id']; ?>">
                        <img src="assets/images/<?php echo $row['product_image']; ?>" alt="">
                        <span class="product-name">
                            <?php echo $row['product_name']; ?>
                        </span>
                        <div class="product-price">
                            <span>
                                <?php echo $row['product_price']; ?>
                            </span>
                            <span class="product-currency">PLN</span>
                        </div>
                    </a>

                <?php } ?>

            </div>
        </div>



    </div>


</section>

<?php include('layouts/footer.php'); ?>
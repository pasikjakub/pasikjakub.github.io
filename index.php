<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sklep meblowy</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/line-awesome.min.css">
    <link rel="stylesheet" href="assets/css/style.css">

</head>

<body>
    <nav class="navbar navbar-expand-sm navbar-light navbar-style">
        <div class="container-fluid nav-container">
            <a class="navbar-brand" href="index.php">Logo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarID"
                aria-controls="navbarID" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarID" style="flex-grow: 0;">
                <div class="navbar-nav navbar-functions">
                    <a class="nav-link active" aria-current="page" href="#">
                        Kategorie
                    </a>
                    <a class="nav-link active userFunctions" aria-current="page" href="login.php">
                        <i class="las la-user"></i>
                        Zaloguj się
                    </a>
                    <a class="nav-link active userFunctions" aria-current="page" href="#">
                        <i class="lar la-heart"></i>
                        Ulubione
                    </a>
                    <a class="nav-link active userFunctions" aria-current="page" href="cart.php">
                        <i class="las la-shopping-cart"></i>
                        Koszyk
                    </a>

                </div>
            </div>
        </div>
    </nav>

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

                    <?php while($row = $featured_prod->fetch_assoc()){ ?>
                    <a class="product" href="<?php echo "product.php?product_id=". $row['product_id']; ?>">
                        <img src="assets/images/<?php echo $row['product_image']; ?>" alt="">
                        <span class="product-name"><?php echo $row['product_name']; ?></span>
                        <div class="product-price">
                            <span><?php echo $row['product_price']; ?></span>
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

                    <?php while($row = $featured_prod->fetch_assoc()){ ?>
                    <a class="product" href="<?php echo "product.php?product_id=". $row['product_id']; ?>">
                        <img src="assets/images/<?php echo $row['product_image']; ?>" alt="">
                        <span class="product-name"><?php echo $row['product_name']; ?></span>
                        <div class="product-price">
                            <span><?php echo $row['product_price']; ?></span>
                            <span class="product-currency">PLN</span>
                        </div>
                    </a>
                    
                        <?php } ?>

                </div>
            </div>



        </div>




    </section>


    <div class="newsletter-container">
        <h4>Zapisz się do newslettera!</h4>
        <div class="">
            <div class="newsletter-form">
                <input class="sub-form" type="text" placeholder="Podaj swój email">
                <button class="subscribe-btn">Zasubskrybuj</button>
            </div>

        </div>
    </div>
    <div class="faq-container"></div>


    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>
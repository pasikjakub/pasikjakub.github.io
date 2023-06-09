<?php 

session_start();

if(!empty($_SESSION['cart']) && isset($_POST['checkout'])){
    
} //wyslanie znowu na index
else {
    header('location: index.php');
}

?>



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



    <section id="checkout" class="checkout" style="min-height: 70vh; margin-top: 150px; position: relative;">
        <div class="container">
        <h1>Podaj dane</h1>
        <form id="checkout-form" method="POST" action="server/place_order.php">
            <div class="form-group small-element">
                <label>Imię</label>
                <input type="text" class="form-control" id="checkout-name" name="name" placeholder="Imię" required/>
            </div>
            <div class="form-group small-element">
                <label>Email</label>
                <input type="text" class="form-control" id="checkout-email" name="email" placeholder="Email" required/>
            </div>
            <div class="form-group small-element">
                <label>Numer Telefonu</label>
                <input type="tel" class="form-control" id="checkout-phone" name="phone" placeholder="Telefon" required/>
            </div>
            <div class="form-group small-element">
                <label>Miasto</label>
                <input type="text" class="form-control" id="checkout-city" name="city" placeholder="Miejscowość" required/>
            </div>
            <div class="form-group large-element">
                <label>Adres</label>
                <input type="text" class="form-control" id="checkout-address" name="address" placeholder="Adres" required/>
            </div>
            <div class="form-group checkout-btn-container">
                <input type="submit" class="btn-checkout" id="checkout-btn" name="place_order" value="Place order"/>
            </div>
        </form>

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

    <script src="assets/js/main.js"></script>
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php

session_start();

if(!isset($_SESSION['logged_in'])){
    header('location: login.php');
    exit;
}

if(isset($_GET['logout'])){
    if(isset($_SESSION['logged_in'])){
        unset($_SESSION['logged_in']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        header('location: login.php');
        exit;
    }
}


if (isset($_POST['change_password'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $new_password_confirm = $_POST['new_passwordConfirm'];

    
    include('server/connection.php');

    
    $user_id = $_SESSION['user_id'];

    // pobranie aktualnego zhashowanego hasla z bazy
    $q = $db->prepare("SELECT user_password FROM users WHERE user_id = ? LIMIT 1");
    $q->bind_param("i", $user_id);
    $q->execute();
    $result = $q->get_result();
    $row = $result->fetch_assoc();
    $hashed_password = $row['user_password'];

    // sprawdzenie czy pasuje do tego z bazy
    if (password_verify($old_password, $hashed_password)) {
        // nowe haslo = nowe haslo confirm
        if ($new_password === $new_password_confirm) {
            // hashowanie nowego
            $hashed_new_password = password_hash($new_password, PASSWORD_ARGON2I);

            // update hasla
            $update_query = $db->prepare("UPDATE users SET user_password = ? WHERE user_id = ?");
            $update_query->bind_param("si", $hashed_new_password, $user_id);
            if ($update_query->execute()) {
                header('location: account.php?message=Hasło zostało zmienione');
                exit;
            } else {
                header('location: account.php?error=Błąd podczas aktualizacji hasła');
                exit;
            }
        } else {
            header('location: account.php?error=Nowe hasło i powtórzone hasło nie są zgodne');
            exit;
        }
    } else {
        header('location: account.php?error=Błędne stare hasło');
        exit;
    }

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



    <section id="account" class="acccount-info-section" style="min-height: 50vh; margin-top: 150px; position: relative;">
        <div class="container">
            <h1>Twój profil</h1>
            <div class="product-line"></div>
            <div class="info-row">
                <div class="account-info">
                    
                    
                    <p>Imię: <span><?php if(isset($_SESSION['user_name'])) { echo $_SESSION['user_name']; } ?></span></p>
                    <p>Email: <?php if(isset($_SESSION['user_email'])) { echo $_SESSION['user_email']; } ?></p>
                    <a href="#orders" id="account-orders">Twoje zamówienia</a>
                    <a href="account.php?logout=1" name="logout" id="logout-btn">Wyloguj się</a>
                </div>
                <div class="user-password-change">
                    <h2 style="text-align: center;">Zmmiana hasła</h2>
                    <form id="password-change-form" method="POST" action="account.php">
                        <div class="form-group">
                            <label>Stare hasło</label>
                            <input type="password" class="form-control" id="old-password" name="old_password" placeholder="Stare hasło"
                                required />
                        </div>
                        <div class="form-group">
                            <label>Nowe hasło</label>
                            <input type="password" class="form-control" id="new-password" name="new_password" placeholder="Nowe hasło"
                                required />
                        </div>
                        <div class="form-group">
                            <label>Nowe hasło ponownie</label>
                            <input type="password" class="form-control" id="new-passwordConfirm" name="new_passwordConfirm" placeholder="Nowe hasło ponownie"
                                required />
                        </div>
                        <div class="form-group register-btn-container">
                            <input type="submit" class="btn" id="login-btn" name="change_password" value="Zmień hasło" />
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>
    <section id="orders" class="acccount-info-section" style="min-height: 100vh; margin-top: 150px; position: relative;">
        <div class="container">
                <div class="account-info">
                    <h1>Twoje zamówienia</h1>
                    <div class="product-line"></div>
                    <p>Imię: Jan</p>
                    <p>Email: kowalskijannusz@wp.pl</p>
                    <a href="#orders" id="account-orders">Twoje zamówienia</a>
                    <a href="#change-password" id="changepasswd-btn">Zmień hasło</a>
                    <a href="account.php?logout=1" id="logout-btn">Wyloguj się</a>
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



    <script src="assets/js/main.js"></script>
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>
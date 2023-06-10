<?php

session_start();

include('server/connection.php');

if (isset($_POST['register'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    //czyszczenie emailu
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);

    //jesli nie pasuja do siebie
    if ($password !== $confirmPassword) {
        header('location: register.php?error=passwords dont match');
    }
    // jesli spelnia wymagania
    else if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 6) {
        header('location: register.php?error=passwords must match all requirements');
    }
    // jesli nie ma errorow
    else {
        //sprawdzenie czy jest juz taki email czy nie
        $statement1 = $db->prepare("SELECT count(*) FROM users WHERE user_email = ?");
        $statement1->bind_param('s', $email);
        $statement1->execute();
        $statement1->bind_result($num_rows);
        $statement1->store_result();
        $statement1->fetch();

        //jesli jest juz uzytkownik z takim mailem
        if ($num_rows != 0) {
            header('location: register.php?error=user with this email already exist');

            //jesli nie ma
        } else {
            //tworzenie uzytkownika
            $q = $db->prepare("INSERT INTO users VALUES (NULL, ?, ?, ?)");
            $passwordHash = password_hash($password, PASSWORD_ARGON2I);
            $q->bind_param('sss', $name, $email, $passwordHash);

            $result = $q->execute();

            //jeslii konto zostalo poprawnie utworzone
            if($result){
                $_SESSION['user_email'] = $email;
                $_SESSION['user_name'] = $name;
                $_SESSION['logged_in'] = true;
                header('location: account.php?register=You register successfully');

                // nie zostalo utworzone
            }else {
                header('location: register.php?error=cos poszlo nie tak');
            }

        }


    }



// jesli uzytkonik juz sie zarejestrowal
}else if(isset($_SESSION['logged_in'])){
    header('location: account.php');
    exit;
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



    <section id="checkout" class="register" style="min-height: 80vh; margin-top: 150px; position: relative;">
        <div class="container">
        <h1>Rejestracja</h1>
        <form id="register-form" method="POST" action="register.php">
            <p style="color: red;"><?php if(isset($_GET['error'])) { echo $_GET['error']; } ?></p>
            <div class="form-group">
                <label>Imię</label>
                <input type="text" class="form-control" id="register-name" name="name" placeholder="Imię" required/>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" class="form-control" id="register-email" name="email" placeholder="Email" required/>
            </div>
            <div class="form-group">
                <label>Hasło</label>
                <input type="password" class="form-control" id="register-password" name="password" placeholder="Hasło" required/>
            </div>

            <div class="form-group">
                <label>Hasło ponownie</label>
                <input type="password" class="form-control" id="register-confirm-password" name="confirmPassword" placeholder="Hasło ponownie" required>
            </input>
            </div>
            <label class="requirements">Hasło musi zawierać:
                <ul>
                    <li>Hasło musi składać się z co najmniej 8 znaków.</li>
                    <li>Hasło musi zawierać co najmniej jedną wielką literę.</li>
                    <li>Hasło musi zawierać co najmniej jedną cyfrę.</li>
                    <li>Hasło musi zawierać co najmniej jeden znak specjalny.</li>
                    <li>Hasło muszą być identyczne.</li>
                </ul>
            </label>
            <div class="form-group register-btn-container">
                <input type="submit" class="btn" id="register-btn" name="register" value="Zarejestruj się"/>
            </div>
            <div class="form-group register-btn-container">
                <a href="login.php" id="login-url" class="btn">Posiadasz już konto? <span>Zaloguj się</span></a>
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
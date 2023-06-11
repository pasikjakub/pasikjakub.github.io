<?php

session_start();
include('server/connection.php');

if(isset($_SESSION['logged_in'])){
    header('location: account.php');
    exit;
}

if (isset($_POST['login_btn'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    $q = $db->prepare("SELECT user_id, user_name, user_email, user_password FROM users WHERE user_email = ? LIMIT 1");
    $q->bind_param("s", $email);
    $q->execute();
    $q->bind_result($user_id, $user_name, $user_email, $user_password);
    $q->store_result();

    if ($q->num_rows() == 1 && $q->fetch()) {
        if (password_verify($password, $user_password)) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_name'] = $user_name;
            $_SESSION['user_email'] = $user_email;
            $_SESSION['logged_in'] = true;
            header('location: account.php?message=zalogowano poprawnie');
            exit;
        } else {
            header('location: login.php?error=bledny login lub haslo');
            exit;
        }
    } else {
        header('location: login.php?error=bledny login lub haslo');
        exit;
    }
}




?>



<?php include('layouts/header.php'); ?>


    <section id="login" class="register" style="min-height: 60vh; margin-top: 150px; position: relative;">
        <div class="container">
            <h1>Logowanie</h1>
            <form id="login-form" method="POST" action="login.php">
                <p style="color: red;">
                    <?php if (isset($_GET['error'])) {
                        echo $_GET['error'];
                    } ?>
                </p>
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" id="login-email" name="email" placeholder="Email"
                        required />
                </div>
                <div class="form-group">
                    <label>Hasło</label>
                    <input type="password" class="form-control" id="login-password" name="password" placeholder="Hasło"
                        required />
                </div>

                <div class="form-group register-btn-container">
                    <input type="submit" class="btn" id="login-btn" name="login_btn" value="Zaloguj się" />
                </div>
                <div class="form-group register-btn-container">
                    <a href="register.php" id="register-url" class="btn">Nie posiadasz jeszcze konta? <span>Zarejestruj
                            się</span></a>
                </div>
            </form>

        </div>

    </section>

    <?php include('layouts/footer.php'); ?>
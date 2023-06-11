<?php

session_start();
include('server/connection.php');

if (isset($_SESSION['logged_in']) && $_SESSION['user_type'] == 1) {
    header('location: account.php');
    exit;
}
else if(isset($_SESSION['logged_in']) && $_SESSION['user_type'] == 2){
    header('location: admin/admin_panel.php');
    exit;
}

if (isset($_POST['login_btn'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('location: login.php?error=bledny login lub haslo');
        exit;
    }
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    $q = $db->prepare("SELECT user_id, user_name, user_email, user_password, user_type FROM users WHERE user_email = ? LIMIT 1");
    $q->bind_param("s", $email);
    $q->execute();
    $q->bind_result($user_id, $user_name, $user_email, $user_password, $user_type);
    $q->store_result();

    if ($q->num_rows() == 1 && $q->fetch()) {
        if (password_verify($password, $user_password)) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_name'] = $user_name;
            $_SESSION['user_email'] = $user_email;
            $_SESSION['user_type'] = $user_type;
            $_SESSION['logged_in'] = true;

            if ($user_type == 1) {
                // user
                header('location: account.php?message=zalogowano poprawnie');
            } elseif ($user_type == 2) {
                // admin
                header('location: admin/admin_panel.php');
            } else {
                // Unknown user
                header('location: login.php?error=bledny login lub haslo');
            }
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
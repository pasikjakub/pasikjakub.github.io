<?php

session_start();

include('server/connection.php');

if(isset($_SESSION['logged_in'])){
    header('location: account.php');
    exit;
}

if (isset($_POST['register'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    //czyszczenie emailu
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('location: register.php?error=Niepoprawny email');
        exit;
    }
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
            $q = $db->prepare("INSERT INTO users VALUES (NULL, ?, ?, ?, 1)");
            $passwordHash = password_hash($password, PASSWORD_ARGON2I);
            $q->bind_param('sss', $name, $email, $passwordHash);

            $result = $q->execute();

            //jeslii konto zostalo poprawnie utworzone
            if($result){
                $user_id = $q->insert_id;
                $_SESSION['user_id'] = $user_id;
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
}




?>






<?php include('layouts/header.php'); ?>

    <section id="register" class="register" style="min-height: 80vh; margin-top: 150px; position: relative;">
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

    <?php include('layouts/footer.php'); ?>
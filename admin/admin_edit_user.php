<?php
session_start();

include('admin_check_userTypeMod.php');
include('../server/connection.php');
$errors = [];

if (isset($_POST['edit_user'])) {
$email = $_POST['email'];
$name = $_POST['name'];
$password = $_POST['password'];



    //sprawdzenie czy jest juz taki email czy nie
    $statement1 = $db->prepare("SELECT count(*) FROM users WHERE user_email = ?");
    $statement1->bind_param('s', $email);
    $statement1->execute();
    $statement1->bind_result($num_rows);
    $statement1->store_result();
    $statement1->fetch();

    //jesli jest juz uzytkownik z takim mailem
   

            //update uzytkownika
            $q = $db->prepare("UPDATE users SET user_name = ?, user_password = ? WHERE user_email = ?");
            $passwordHash = password_hash($password, PASSWORD_ARGON2I);
            $q->bind_param('sss', $name, $passwordHash, $email);

            $result = $q->execute();

            if ($result) {
                header('location: admin_search_user.php');

                // nie zostalo utworzone
            } else {
                header('location: admin_search_user.php?error=Coś poszło nie tak');
            }
        //jesli nie ma
   
        }

    



?>

<?php include('../layouts/sidebar.php'); ?>

<div class="col py-3">
    <h2 style="margin-bottom: 50px">Edytuj użytkownika</h2>
    <form id="register-form" method="POST" action="admin_edit_user.php">
            <p style="color: red;">
                <?php if (isset($_GET['error'])) {
                    echo $_GET['error'];
                } ?>
            </p>
            <div class="form-group">
                <label>Email</label>
                <input type="text" class="form-control" id="admin_edit-email" name="email" placeholder="Email" required />
            </div>
            <div class="form-group">
                <label>Imię</label>
                <input type="text" class="form-control" id="admin_edit-name" name="name" placeholder="Imię" required />
            </div>
            <div class="form-group">
                <label>Hasło</label>
                <input type="password" class="form-control" id="admin_edit-password" name="password" placeholder="Hasło"
                    required />
            </div>

            <div class="form-group register-btn-container">
                <input type="submit" class="btn" id="register-btn" name="edit_user" value="Edytuj" />
            </div>
        </form>
</div>

<?php include('../layouts/admin_footer.php') ?>
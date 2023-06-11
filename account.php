<?php

session_start();
include('server/connection.php');

if(!isset($_SESSION['logged_in'])){
    header('location: login.php');
    exit;
}

if(isset($_GET['logout'])){
    if(isset($_SESSION['logged_in'])){
        unset($_SESSION['logged_in']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_type']);
        header('location: login.php');
        exit;
    }
}


if (isset($_POST['change_password'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $new_password_confirm = $_POST['new_passwordConfirm'];

    
    

    
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


//pobranie zamowien
if(isset($_SESSION['logged_in'])){
    $stmt = $db->prepare("SELECT * FROM orders WHERE user_id=? ");

    $user_id = $_SESSION['user_id'];
    $stmt->bind_param('i', $user_id);

    $stmt->execute();
    
    $orders = $stmt->get_result();
}


?>


<?php include('layouts/header.php'); ?>


    <section id="account" class="acccount-info-section" style="min-height: 50vh; margin-top: 150px; position: relative;">
        <div class="container">
            <h1 style="text-align: center;">Twój profil</h1>
            <div class="product-line"></div>
            <div class="info-row">
                <div class="account-info">
                    
                    
                    <p>Imię: <span><?php if(isset($_SESSION['user_name'])) { echo $_SESSION['user_name']; } ?></span></p>
                    <p>Email: <?php if(isset($_SESSION['user_email'])) { echo $_SESSION['user_email']; } ?></p>
                    <a href="#orders" id="account-orders">Twoje zamówienia</a>
                    <a href="account.php?logout=1" name="logout" id="logout-btn">Wyloguj się</a>
                </div>
                <div class="user-password-change">
                    <h2 style="text-align: center;">Zmiana hasła</h2>
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
        <h3 style="text-align: center;">Zamówienia</h3>
            <div class="product-line"></div>
            <table class="mt-5 pt-5">
                <tr class="xd">
                    <th>ID Zamówienia</th>
                    <th>Koszt zamówienia</th>
                    <th>Status zamówienia</th>
                    <th>Data zamówienia</th>
                </tr>
                <?php while($row = $orders->fetch_assoc()) { ?>
                <tr>
                    <td>
                        <div class="product-cart-info">
                            <!-- <img src="" /> -->
                            <div>
                                <p class="mt-3"><?php echo $row['order_id']; ?></p>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span><?php echo $row['order_cost']; ?></span>
                    </td>
                    <td>
                        <span><?php echo $row['order_status']; ?></span>
                    </td>
                    <td>
                        <span><?php echo $row['order_date']; ?></span>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>

    </section>



    <?php include('layouts/footer.php'); ?>
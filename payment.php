<?php 

session_start();



?>



<?php include('layouts/header.php'); ?>

    <section id="checkout" class="checkout paynow" style="min-height: 60vh; margin-top: 150px; position: relative;">
        <div class="container">
        <h1 style="margin-bottom: 5rem;">Zapłać</h1>
        <p><?php if(isset($_GET['order_status'])) { echo $_GET['order_status']; } ?></p>
        <p>Do zapłaty: <?php echo $_SESSION['total'] ?>zł</p>
        <input class="btn-pay" type="submit" value="Pay now" />

        </div>

    </section>

    <?php include('layouts/footer.php'); ?>
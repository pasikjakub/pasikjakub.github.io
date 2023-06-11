<?php 

session_start();

if(!empty($_SESSION['cart']) && isset($_POST['checkout'])){
    
} //wyslanie znowu na index
else {
    header('location: index.php');
}

?>


<?php include('layouts/header.php'); ?>



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


    <?php include('layouts/footer.php'); ?>
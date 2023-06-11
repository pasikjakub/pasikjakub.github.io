<?php
session_start();

// Check if the user is logged in and is an admin
// if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
//     header('Location: login.php');
//     exit;
// }

// Include the necessary files and initialize the database connection
include('server/connection.php');

// Handle form submissions

if (isset($_POST['edit_product'])) {
    // Process and validate the form input for editing a product
    // Retrieve and sanitize the input values
    $productId = $_POST['product_id'];
    $productName = $_POST['product_name'];
    $category = $_POST['product_category'];
    $description = $_POST['product_description'];
    $price = $_POST['product_price'];

    // Perform necessary validations on the input values

    // Update the product in the database
    $query = $db->prepare("UPDATE products SET product_name = ?, product_category = ?, product_description = ?, product_price = ? WHERE product_id = ?");
    $query->bind_param("sssdi", $productName, $category, $description, $price, $productId);
    $query->execute();
    $query->close();

    // Redirect back to the admin panel page after editing the product
    header('Location: admin_panel.php');
    exit;
}

if (isset($_POST['remove_product'])) {
    // Process the form input for removing a product
    $productId = $_POST['product_id'];

    // Delete the product from the database
    $query = $db->prepare("DELETE FROM products WHERE product_id = ?");
    $query->bind_param("i", $productId);
    $query->execute();
    $query->close();

    // Redirect back to the admin panel page after removing the product
    header('Location: admin_panel.php');
    exit;
}

?>

<?php include('layouts/sidebar.php'); ?>
            <div class="col py-3">
              

            </div>



    <script src="assets/js/main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>
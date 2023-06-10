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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel administratora</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/line-awesome.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/admin_panel.css">

</head>


<body>

<nav class="navbar navbar-expand-sm navbar-dark admin-navbar-style">
        <div class="container-fluid nav-container">
            <a class="navbar-brand" href="admin_panel.php">Główny panel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarID"
                aria-controls="navbarID" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarID" style="flex-grow: 0;">
                <div class="navbar-nav navbar-functions">
                    <a class="nav-link active userFunctions" aria-current="page" href="admin_add_product.php">
                        Dodawanie
                    </a>
                    <a class="nav-link active userFunctions" aria-current="page" href="admin_edit_product.php">
                        Edycja
                    </a>
                    <a class="nav-link active userFunctions" aria-current="page" href="admin_users_edit.php">
                        Użytkownicy
                    </a>
                </div>
            </div>
        </div>
    </nav>




<script src="assets/js/main.js"></script>
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>
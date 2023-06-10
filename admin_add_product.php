<?php
session_start();

// Check if the user is logged in and is an admin
// if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
//     header('Location: login.php');
//     exit();
// }

// Include the necessary files and establish a database connection
include('server/connection.php');

// Define an empty array to store any potential error messages
$errors = [];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    $product_name = $_POST['product_name'];
    $product_category = $_POST['product_category'];
    $product_description = $_POST['product_description'];
    $product_price = $_POST['product_price'];

    // Validate the form data (perform necessary validation checks)

    // If validation passes, proceed to insert the product into the database
    if (empty($errors)) {
        // Process the uploaded images
        $product_image = moveAndInsertImage($_FILES['product_image']);
        $product_image2 = moveAndInsertImage($_FILES['product_image2']);
        $product_image3 = moveAndInsertImage($_FILES['product_image3']);
        $product_image4 = moveAndInsertImage($_FILES['product_image4']);

        // Prepare the SQL statement to insert a new product
        $stmt = $db->prepare("INSERT INTO products (product_name, product_category, product_description, product_image, product_image2, product_image3, product_image4, product_price) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssd", $product_name, $product_category, $product_description, $product_image, $product_image2, $product_image3, $product_image4, $product_price);

        // Execute the statement
        if ($stmt->execute()) {
            // Product inserted successfully
            header('Location: add_product.php');
            exit();
        } else {
            // Failed to insert the product
            $errors[] = "Failed to add the product. Please try again.";
        }

        // Close the statement
        $stmt->close();
    }
}

// Function to move the uploaded image to the assets/images directory and return the filename with extension
function moveAndInsertImage($file)
{
    $targetDirectory = 'assets/images/';
    $targetFile = $targetDirectory . basename($file['name']);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Generate a unique filename to prevent conflicts
    $filename = uniqid() . '.' . $imageFileType;

    // Move the uploaded file to the target directory
    if (move_uploaded_file($file['tmp_name'], $targetDirectory . $filename)) {
        return $filename;
    }

    return ''; // Return an empty string if there was an error moving the file
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
    <!-- Add Product Form -->
<section id="add-product" class="admin-section">
    <div class="container">
        <?php if (!empty($errors)): ?>
        <div class="error-message">
            <?php foreach ($errors as $error): ?>
            <p><?php echo $error; ?></p>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <form id="add-product-form" method="POST" enctype="multipart/form-data" style="min-height: 50vh; margin-top: 150px; position: relative;">
            <div class="form-group">
                <label for="product_name">Nazwa produktu</label>
                <input type="text" class="form-control" id="product_name" name="product_name" required>
            </div>
            <div class="form-group">
                <label for="product_category">Kategoria produktu</label>
                <input type="text" class="form-control" id="product_category" name="product_category" required>
            </div>
            <div class="form-group">
                <label for="product_description">Opis produktu</label>
                <textarea class="form-control" id="product_description" name="product_description" required></textarea>
            </div>
            <div class="form-group">
                <label for="product_price">Cena produktu</label>
                <input type="number" class="form-control" id="product_price" name="product_price" required>
            </div>
            <div class="form-group">
                <label for="product_image">Obrazek głowny produktu</label>
                <input type="file" class="form-control" id="product_image" name="product_image" required>
            </div>
            <div class="form-group">
                <label for="product_image2">Obrazek 2 produktu</label>
                <input type="file" class="form-control" id="product_image2" name="product_image2">
            </div>
            <div class="form-group">
                <label for="product_image3">Obrazek 3 produktu</label>
                <input type="file" class="form-control" id="product_image3" name="product_image3">
            </div>
            <div class="form-group">
                <label for="product_image4">Obrazek 4 produktu</label>
                <input type="file" class="form-control" id="product_image4" name="product_image4">
            </div>
            <div class="form-group add-btn-container">
            <button type="submit" class="btn btn-primary">Dodaj produkt</button>
            </div>
            
        </form>
    </div>
</section>



    <script src="assets/js/main.js"></script>
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>
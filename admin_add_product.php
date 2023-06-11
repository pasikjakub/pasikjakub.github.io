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
    <title>Dodaj produkt</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/admin_panel.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
</head>

<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
            <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                <a href="/" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                    <span class="fs-5 d-none d-sm-inline">Admin panel</span>
                </a>
                <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                <li class="nav-item">
                        <a href="admin_panel.php" class="nav-link align-middle px-0">
                            <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Home</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link px-0 align-middle">
                            <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Zamówienia</span></a>
                    </li>

                    <li>
                        <a href="#submenu3" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                            <i class="fs-4 bi-grid"></i> <span class="ms-1 d-none d-sm-inline">Produkty</span> </a>
                            <ul class="collapse nav flex-column ms-1" id="submenu3" data-bs-parent="#menu">
                            <li class="w-100">
                                <a href="admin_add_product.php" class="nav-link px-0"> <span class="d-none d-sm-inline">Dodaj</span></a>
                            </li>
                            <li>
                                <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Edycja</span></a>
                            </li>
                            <li>
                                <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Usuwanie</span></a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" class="nav-link px-0 align-middle">
                            <i class="fs-4 bi-people"></i> <span class="ms-1 d-none d-sm-inline">Użytkownicy</span></a>
                    </li>
                </ul>
                <hr>
                

                <div class="dropdown pb-4">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://avatars.githubusercontent.com/u/98429622?v=4" alt="hugenerd" width="30" height="30" class="rounded-circle">
                            <span class="d-none d-sm-inline mx-1">Admin</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                            </li>
                            <li><a class="dropdown-item" href="#">Sign out</a></li>
                        </ul>
                    </div>
            </div>
        </div>
        <div class="col py-3">
        <?php if (!empty($errors)): ?>
        <div class="error-message">
            <?php foreach ($errors as $error): ?>
            <p><?php echo $error; ?></p>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <form id="add-product-form" method="POST" enctype="multipart/form-data" style="min-height: 50vh; margin-top: 100px; position: relative;">
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
    </div>
</div>




    <script src="assets/js/main.js"></script>
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>
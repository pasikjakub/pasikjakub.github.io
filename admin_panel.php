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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/admin_panel.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
</head>


<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                    <a href="/"
                        class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <span class="fs-5 d-none d-sm-inline">Admin panel</span>
                    </a>
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start"
                        id="menu">
                        <li class="nav-item">
                            <a href="admin_panel.php" class="nav-link align-middle px-0">
                                <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Home</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi-table"></i> <span
                                    class="ms-1 d-none d-sm-inline">Zamówienia</span></a>
                        </li>

                        <li>
                            <a href="#submenu3" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi-grid"></i> <span class="ms-1 d-none d-sm-inline">Produkty</span> </a>
                            <ul class="collapse nav flex-column ms-1" id="submenu3" data-bs-parent="#menu">
                                <li class="w-100">
                                    <a href="admin_add_product.php" class="nav-link px-0"> <span
                                            class="d-none d-sm-inline">Dodaj</span></a>
                                </li>
                                <li>
                                    <a href="#" class="nav-link px-0"> <span
                                            class="d-none d-sm-inline">Edycja</span></a>
                                </li>
                                <li>
                                    <a href="#" class="nav-link px-0"> <span
                                            class="d-none d-sm-inline">Usuwanie</span></a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi-people"></i> <span
                                    class="ms-1 d-none d-sm-inline">Użytkownicy</span></a>
                        </li>
                    </ul>
                    <hr>


                    <div class="dropdown pb-4">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                            id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://avatars.githubusercontent.com/u/98429622?v=4" alt="hugenerd" width="30"
                                height="30" class="rounded-circle">
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
              

            </div>
        </div>
    </div>


    <script src="assets/js/main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>
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
                    <a class="nav-link active userFunctions" aria-current="page" href="#">
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
    <section id="edit-product" class="admin-section" style="min-height: 50vh; margin-top: 150px; position: relative;">
        <div class="container">
            <table>
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Product Category</th>
                        <th>Product Description</th>
                        <th>Product Image</th>
                        <th>Product Image 2</th>
                        <th>Product Image 3</th>
                        <th>Product Image 4</th>
                        <th>Product Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch products from the database
                    $query = $db->query("SELECT * FROM products");
                    while ($row = $query->fetch_assoc()) {
                        $productID = $row['product_id'];
                        $productName = $row['product_name'];
                        $productCategory = $row['product_category'];
                        $productDescription = $row['product_description'];
                        $productImage = $row['product_image'];
                        $productImage2 = $row['product_image2'];
                        $productImage3 = $row['product_image3'];
                        $productImage4 = $row['product_image4'];
                        $productPrice = $row['product_price'];
                        ?>
                        <tr>
                            <td>
                                <?php echo $productName; ?>
                            </td>
                            <td>
                                <?php echo $productCategory; ?>
                            </td>
                            <td>
                                <?php echo $productDescription; ?>
                            </td>
                            <td>
                                <?php
                                $imagePath = 'assets/images/' . basename($productImage);
                                if (!file_exists($imagePath)) {
                                    copy($productImage, $imagePath);
                                }
                                ?>
                                <img src="<?php echo $imagePath; ?>" alt="<?php echo $productName; ?>" width="100">
                            </td>
                            <td>
                                <?php
                                $imagePath2 = 'assets/images/' . basename($productImage2);
                                if (!file_exists($imagePath2)) {
                                    copy($productImage2, $imagePath2);
                                }
                                ?>
                                <img src="<?php echo $imagePath2; ?>" alt="<?php echo $productName; ?>" width="100">
                            </td>
                            <td>
                                <?php
                                $imagePath3 = 'assets/images/' . basename($productImage3);
                                if (!file_exists($imagePath3)) {
                                    copy($productImage3, $imagePath3);
                                }
                                ?>
                                <img src="<?php echo $imagePath3; ?>" alt="<?php echo $productName; ?>" width="100">
                            </td>
                            <td>
                                <?php
                                $imagePath4 = 'assets/images/' . basename($productImage4);
                                if (!file_exists($imagePath4)) {
                                    copy($productImage4, $imagePath4);
                                }
                                ?>
                                <img src="<?php echo $imagePath4; ?>" alt="<?php echo $productName; ?>" width="100">
                            </td>
                            <td>
                                <?php echo $productPrice; ?>
                            </td>
                            <td>
                                <!-- Edit button -->
                                <a href="edit_product.php?id=<?php echo $productID; ?>">Edit</a>
                                <!-- Delete button -->
                                <a href="delete_product.php?id=<?php echo $productID; ?>">Delete</a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>



    <script src="assets/js/main.js"></script>
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>
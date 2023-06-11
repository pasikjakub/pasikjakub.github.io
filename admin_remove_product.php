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

if (isset($_GET['id'])) {
    // Process the request for removing a product
    $productId = $_GET['id'];

    // Delete the product from the database
    $query = $db->prepare("DELETE FROM products WHERE product_id = ?");
    $query->bind_param("i", $productId);
    $query->execute();
    $query->close();

    // Redirect back to the admin panel page after removing the product
    header('Location: admin_remove_product.php');
    exit;
}
?>

<?php include('layouts/sidebar.php'); ?>
<div class="col py-3">
    <table>
        <thead>
            <tr class="table-header">
                <th>Product Name</th>
                <th>Product Category</th>
                <th>Product Image</th>
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
                        <?php
                        $imagePath = 'assets/images/' . basename($productImage);
                        if (!file_exists($imagePath)) {
                            copy($productImage, $imagePath);
                        }
                        ?>
                        <img src="<?php echo $imagePath; ?>" alt="<?php echo $productName; ?>" width="100">
                    </td>
                    <td>
                        <?php echo $productPrice; ?>
                    </td>
                    <td>
                        <a href="admin_remove_product.php?id=<?php echo $productID; ?>">Delete</a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>

<script src="assets/js/main.js"></script>
<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
session_start();

include('admin_check_userType.php');

include('../server/connection.php');

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $product_name = $_POST['product_name'];
    $product_category = $_POST['product_category'];
    $product_description = $_POST['product_description'];
    $product_price = $_POST['product_price'];



    // if validation pass wstaw
    if (empty($errors)) {
        
        $product_image = moveAndInsertImage($_FILES['product_image']);
        $product_image2 = moveAndInsertImage($_FILES['product_image2']);
        $product_image3 = moveAndInsertImage($_FILES['product_image3']);
        $product_image4 = moveAndInsertImage($_FILES['product_image4']);


        $stmt = $db->prepare("INSERT INTO products (product_name, product_category, product_description, product_image, product_image2, product_image3, product_image4, product_price) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssd", $product_name, $product_category, $product_description, $product_image, $product_image2, $product_image3, $product_image4, $product_price);


        if ($stmt->execute()) {

            header('Location: admin_remove_product.php');
            exit();
        } else {

            $errors[] = "Failed to add the product. Please try again.";
        }


        $stmt->close();
    }
}

// przenoszenie zdjecia do folderu z assetami
function moveAndInsertImage($file)
{
    $targetDirectory = '../assets/images/';
    $targetFile = $targetDirectory . basename($file['name']);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // unikalna nazwa
    $filename = uniqid() . '.' . $imageFileType;


    if (move_uploaded_file($file['tmp_name'], $targetDirectory . $filename)) {
        return $filename;
    }

    return ''; //pusty string jesli error
}


?>

<?php include('../layouts/sidebar.php'); ?>

<div class="col py-3">
    <?php if (!empty($errors)): ?>
        <div class="error-message">
            <?php foreach ($errors as $error): ?>
                <p>
                    <?php echo $error; ?>
                </p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <form id="add-product-form" method="POST" enctype="multipart/form-data"
        style="min-height: 50vh; margin-top: 100px; position: relative;">
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





<?php include('../layouts/admin_footer.php') ?>
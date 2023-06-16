<?php
session_start();

include('admin_check_userType.php');

include('../server/connection.php');

$errors = [];

$productNamesQuery = $db->query("SELECT product_name FROM products");
$productNames = [];
while ($row = $productNamesQuery->fetch_assoc()) {
    $productNames[] = $row['product_name'];
    
}

include('move_images.php');


if (isset($_POST['edit_product'])) {
    $productName = $_POST['product_name'];
    $fieldToEdit = $_POST['field_to_edit'];
    
    if ($fieldToEdit === 'product_image' || $fieldToEdit === 'product_image2' || $fieldToEdit === 'product_image3' || $fieldToEdit === 'product_image4') {
        
        $file = $_FILES['new_value'];
        
        
        if ($file['error'] === UPLOAD_ERR_OK) {
            $newValue = moveAndInsertImage($file);
            
            if (!empty($newValue)) {
                
                $updateQuery = $db->prepare("UPDATE products SET $fieldToEdit = ? WHERE product_name = ?");
                $updateQuery->bind_param("ss", $newValue, $productName);
                $updateQuery->execute();
                $updateQuery->close();
                
                header('location: admin_panel.php');
                exit;
            } else {
                
                header('location: admin_panel.php?error=Failed to process the file');
                exit;
            }
        } else {
            
            header('location: admin_panel.php?error=' . $file['error']);
            exit;
        }
    } else {
        
        $newValue = $_POST['new_value'];

        
        $updateQuery = $db->prepare("UPDATE products SET $fieldToEdit = ? WHERE product_name = ?");
        $updateQuery->bind_param("ss", $newValue, $productName);
        $updateQuery->execute();
        $updateQuery->close();

        header('location: admin_panel.php');
        exit;
    }
}

?>



<?php include('../layouts/sidebar.php'); ?>


<form id="edit-product-form" method="post" action="" enctype="multipart/form-data" style="max-width: 700px">
    <label for="product_name">Wybierz produkt:</label>
    <select name="product_name" id="product_name">
        <?php foreach ($productNames as $productName) { ?>
            <option value="<?php echo $productName; ?>"><?php echo $productName; ?></option>
        <?php } ?>
    </select>

    

    <label for="field_to_edit">Wybierz co chcesz edytować:</label>
    <select name="field_to_edit" id="field_to_edit">
        <?php
        
        $columnsQuery = $db->query("SHOW COLUMNS FROM products");
        $columns = [];
        while ($row = $columnsQuery->fetch_assoc()) {
            $columnName = $row['Field'];
            if ($columnName != 'product_name') {
                $columns[] = $columnName;
            }
        }

        foreach ($columns as $column) { ?>
            <option value="<?php echo $column; ?>"><?php echo $column; ?></option>
        <?php } ?>
    </select>

    

    <label for="new_value">Wprowadź nową wartość:</label>
    <div id="new_value_container">
        <input type="text" name="new_value" id="new_value">
    </div>

   <br></br>

    <button class="btn btn-primary" type="submit" name="edit_product" value="Edit Product">Edytuj</button>
</form>

<script>
    // Update input type based on the selected field
    $(document).ready(function() {
        let newValueContainer = $('#new_value_container');
        let newValueInput = $('#new_value');
        let defaultInputType = newValueInput.prop('tagName').toLowerCase();

        $('#field_to_edit').change(function() {
            var selectedField = $(this).val();

            if (selectedField === 'product_description') {
                // Change input type to "textarea" for product_description field
                newValueContainer.html('<textarea name="new_value" id="new_value"></textarea>');
            } else if (selectedField === 'product_image' || selectedField === 'product_image2' || selectedField === 'product_image3' || selectedField === 'product_image4') {
                // Change input type to "file" for product_image fields
                newValueContainer.html('<input type="file" name="new_value" id="new_value">');
            } else {
                // Change input type to "text" for other fields
                newValueContainer.html('<input type="' + defaultInputType + '" name="new_value" id="new_value">');
            }
        });
    });
</script>

<?php include('../layouts/admin_footer.php') ?>
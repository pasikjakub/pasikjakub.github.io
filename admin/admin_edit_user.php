<?php
session_start();

include('admin_check_userType.php');
include('../server/connection.php');
$errors = [];

$userEmailsQuery = $db->query("SELECT user_email FROM users");
$userEmails = [];
while ($row = $userEmailsQuery->fetch_assoc()) {
    $userEmails[] = $row['user_email'];
}

if (isset($_POST['edit_user'])) {
    $userEmail = $_POST['user_email'];
    $fieldToEdit = $_POST['field_to_edit'];

    $newValue = $_POST['new_value'];

    $updateQuery = $db->prepare("UPDATE users SET $fieldToEdit = ? WHERE user_email = ?");
    $updateQuery->bind_param("ss", $newValue, $userEmail);
    $updateQuery->execute();
    $updateQuery->close();

    header('location: admin_search_user.php?message=Poprawno zmieniono dane');
    exit;
}



if (isset($_POST['user_edit_password'])) {
    $userEmail = $_POST['user_email'];
    $password = $_POST['password'];
    
    
    
        
        $statement1 = $db->prepare("SELECT count(*) FROM users WHERE user_email = ?");
        $statement1->bind_param('s', $userEmail);
        $statement1->execute();
        $statement1->bind_result($num_rows);
        $statement1->store_result();
        $statement1->fetch();
    
    
                //update uzytkownika
                $q = $db->prepare("UPDATE users SET user_password = ? WHERE user_email = ?");
                $passwordHash = password_hash($password, PASSWORD_ARGON2I);
                $q->bind_param('ss', $passwordHash, $userEmail);
    
                $result = $q->execute();
    
                if ($result) {
                    header('location: admin_search_user.php?message=Hasło zostało zmienione');
                    exit;
                    // nie zostalo zmienione
                } else {
                    header('location: admin_search_user.php?error=Coś poszło nie tak');
                    exit;
                }
            
       
            }
    


?>

<?php include('../layouts/sidebar.php'); ?>

<div class="col py-3">
    <h2 style="margin-bottom: 50px">Edytuj użytkownika</h2>
    <form id="edit-product-form" method="post" action="" style="max-width: 700px">
        <label for="user_email">Wybierz użytkownika:</label>
        <select name="user_email" id="user_email">
            <?php foreach ($userEmails as $userEmail) { ?>
                <option value="<?php echo $userEmail; ?>"><?php echo $userEmail; ?></option>
            <?php } ?>
        </select>

        <label for="field_to_edit">Wybierz co chcesz edytować:</label>
        <select name="field_to_edit" id="field_to_edit">
            <?php
            $columnsQuery = $db->query("SHOW COLUMNS FROM users");
            $columns = [];
            while ($row = $columnsQuery->fetch_assoc()) {
                $columnName = $row['Field'];
                if ($columnName != 'user_password' && $columnName != 'user_token' && $columnName != 'is_active' ) {
                    $columns[] = $columnName;
                }
            }

            foreach ($columns as $column) { ?>
                <option value="<?php echo $column; ?>"><?php echo $column; ?></option>
            <?php } ?>
        </select>

        <label for="new_value">Wprowadź nową wartość:</label>
        <input type="text" name="new_value" id="new_value">

        <br></br>

        <button class="btn btn-primary" type="submit" name="edit_user" value="Edit User">Edytuj</button>
    </form>

    <h3 style="margin-top: 50px">Edytuj hasło użytkownika</h3>
    <form id="edit-user-form" method="POST" action="admin_edit_user.php">
            <p style="color: red;">
                <?php if (isset($_GET['error'])) {
                    echo $_GET['error'];
                } ?>
            </p>
            <label for="user_email">Wybierz użytkownika:</label>
        <select name="user_email" id="user_email">
            <?php foreach ($userEmails as $userEmail) { ?>
                <option value="<?php echo $userEmail; ?>"><?php echo $userEmail; ?></option>
            <?php } ?>
        </select>
            <div class="form-group">
                <label style="margin-top: 10px">Hasło</label>
                <input type="text" class="form-control" id="admin_edit-password" name="password" placeholder="Hasło"
                    required />
            </div>

            <div class="form-group register-btn-container" style="margin-top: 30px;">
                <button style="width: 100%" type="submit" class="btn btn-primary" id="user_edit_password" name="user_edit_password" value="Edytuj" >Edytuj</button>
            </div>
</div>

<?php include('../layouts/admin_footer.php') ?>
<?php
session_start();

include('admin_check_userType.php');


include('../server/connection.php');


if (isset($_POST['search'])) {
    $searchEmail = $_POST['search_email'];
    $searchEmail = '%' . $searchEmail . '%';

    
    $stmt = $db->prepare("SELECT user_id, user_name, user_email FROM users WHERE user_email LIKE ?");
    $stmt->bind_param("s", $searchEmail);
    $stmt->execute();
    $result = $stmt->get_result();

    
    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
} else {
    
    $result = $db->query("SELECT user_id, user_name, user_email FROM users");

    
    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}


if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];

    
    $stmt = $db->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $deleteId);
    $stmt->execute();


    header('Location: admin_search_user.php?message=Poprawnie usunięto użytkownika');
    exit;
}
?>

<?php include('../layouts/sidebar.php'); ?>
<div class="col py-3">
    <h2>Lista użytkowników</h2>
    <form method="POST" action="" style="margin-top: 50px;">
        <label for="search_email">Szukaj po emailu:</label>
        <input type="email" id="search_email" name="search_email" required>
        <button class="btn btn-primary" type="submit" name="search">Szukaj</button>
    </form>
    <p <?php if (isset($_GET['error'])) {
        echo 'style="color: red"';
    }else {
        echo 'style="color: green"';
    } ?>>
                    <?php if (isset($_GET['error'])) {
                        echo $_GET['error'];
                    }else if(isset($_GET['message'])){
                        echo $_GET['message'];
                    } ?>
                </p>
    <table style="margin-top: 50px;">
        <thead>
            <tr>
                <th>User_ID</th>
                <th>User_Name</th>
                <th>User_Email</th>
                <th>Usuwanie</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user) { ?>
                <tr>
                    <td><?php echo $user['user_id']; ?></td>
                    <td><?php echo $user['user_name']; ?></td>
                    <td><?php echo $user['user_email']; ?></td>
                    <td>
                        <a href="?delete_id=<?php echo $user['user_id']; ?>">Usuń</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php include('../layouts/admin_footer.php'); ?>
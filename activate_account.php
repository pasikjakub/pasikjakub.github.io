<?php
session_start();

include('server/connection.php');

if(isset($_SESSION['logged_in'])){
    header('location: account.php');
    exit;
}

if(isset($_GET['token'])){
    $token = $_GET['token'];

    // Wyszukaj konto o podanym tokenie w bazie danych
    $statement = $db->prepare("SELECT * FROM users WHERE user_token = ?");
    $statement->bind_param('s', $token);
    $statement->execute();
    $result = $statement->get_result();

    if($result->num_rows === 1){
        // Aktywuj konto
        $row = $result->fetch_assoc();
        $user_id = $row['user_id'];
        $q = $db->prepare("UPDATE users SET is_active = 1 WHERE user_id = ?");
        $q->bind_param('i', $user_id);
        $q->execute();

        // Wyświetl komunikat o pomyślnej aktywacji konta
        header('location: login.php?message=Twoje konto zostało aktywowane');
    } else {
        // Wyświetl komunikat o błędzie lub nieprawidłowym tokenie
        echo "Wystąpił błąd podczas aktywacji konta. Sprawdź poprawność linku aktywacyjnego.";
    }
} else {
    // Wyświetl komunikat o nieprawidłowym żądaniu
    echo "Nieprawidłowe żądanie.";
}
?>
<?php
session_start();
if (isset($_SESSION['autenticato']) && $_SESSION['autenticato'] === true) {
    $username = $_COOKIE['username'];
} else {
    header("Location: ../login/login.php");
    exit;
}

require_once '../config.php';

$connection = @mysqli_connect(host, username, password, db_name);
if (!$connection) {
    die("Connessione al database fallita: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];

    $eliminaUtente = "DELETE FROM utenti WHERE username = '$username'";
    print_r($eliminaUtente);
    if (mysqli_query($connection, $eliminaUtente)) {
        
        header('Location: utenti.php');

    } else {
        ?>
        <h4>Errore, impossibile eseguire l'eliminazionne.</h4>
        <?php
    }
}
mysqli_close($connection);

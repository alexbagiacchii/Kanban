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
    $id = $_POST["idTask"];
    $titolo = $_POST["nuovoTitolo"];
    $descrizione = $_POST["nuovaDescrizione"];
    $data = $_POST["nuovaData"];
    $priorita = $_POST["nuovaPriorita"];

    $aggiornaTask = "UPDATE task SET titolo ='$titolo', descrizione = '$descrizione', data_inizio = '$data', priorita = '$priorita' WHERE id = '$id'";
    print_r($aggiornaTask);
    if (mysqli_query($connection, $aggiornaTask)) {
        header('Location: home.php');
    } else {
        ?>
        <h4>Errore, impossibile eseguire la modifica.</h4>
        <?php
    }
}
mysqli_close($connection);

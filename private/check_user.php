<?php
require_once 'config.php';
header('Content-Type: application/json; charset=utf-8');

// Connessione al database
$connection = @mysqli_connect(host, username, password, db_name);
if (!$connection) {
    die("Connessione al database fallita: " . mysqli_connect_error());
}

// Ottenere il nome utente dalla richiesta GET
$username = $_GET['username'];

// Query per controllare se l'utente esiste
$controlloUtente = "SELECT * FROM utenti WHERE username = '$username'";
$risultatoUtente = mysqli_query($connection, $controlloUtente);

// Verifica se l'utente esiste e restituisci una risposta JSON
if (mysqli_num_rows($risultatoUtente) > 0) {
    // L'utente esiste
    echo json_encode(array("userExists" => true));
} else {
    // L'utente non esiste
    echo json_encode(array("userExists" => false));
}
?>

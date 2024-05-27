<?php
require_once '../config.php';
header('Content-Type: application/json; charset=utf-8');

$connection = @mysqli_connect(host, username, password, db_name);
if (!$connection) {
    die("Connessione al database fallita: " . mysqli_connect_error());
}

$username = $_GET['username'];

$controlloUtente = "SELECT * FROM utenti WHERE username = '$username'";
$risultatoUtente = mysqli_query($connection, $controlloUtente);

if (mysqli_num_rows($risultatoUtente) > 0) {
    echo json_encode(array("esisteUtente" => true));
} else {
    echo json_encode(array("esisteUtente" => false));
}

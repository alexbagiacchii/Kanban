<?php
require_once 'config.php';
header('Content-Type: application/json; charset=utf-8');

// Connessione al database
$connection = @mysqli_connect(host, username, password, db_name);
if (!$connection) {
    die("Connessione al database fallita: " . mysqli_connect_error());
}

// Query per ottenere l'elenco delle attività
$queryTask = "SELECT * FROM task";
$risultatoTask = mysqli_query($connection, $queryTask);

// Verifica se ci sono attività e restituisci una risposta JSON
if (!$risultatoTask) {
    die("Errore: impossibile caricare le informazioni richieste: " . mysqli_error($connection));
}

$tasks = array();
while ($row = mysqli_fetch_assoc($risultatoTask)) {
    $tasks[] = $row;
}

echo json_encode($tasks);
?>

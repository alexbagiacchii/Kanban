<?php
header('Content-Type: application/json; charset=utf-8');
require_once '../config.php';

$connection = @mysqli_connect(host, username, password, db_name);
if (!$connection) {
    die();
}

$datetime = date('Y-m-d H:i:s');
$idTask = $_POST['idTask'];
$nuovoStato = $_POST['nuovoStato']; 
$username = $_POST['username']; 

$aggiornaStato = "INSERT INTO modifica (tag, data, fk_id, fk_stato, fk_username) VALUES ('$datetime', '$idTask', '$nuovoStato', '$username')";
print_r($aggiornaStato);
$risultato = mysqli_query($connection, $aggiornaStato);

if ($risultato) {
    echo json_encode(array('success' => true, 'message' => 'Stato della task aggiornato con successo.'));
} else {
    echo json_encode(array('success' => false, 'message' => 'Si è verificato un errore durante l\'aggiornamento dello stato della task.'));
}
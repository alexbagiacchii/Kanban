<?php
// Connessione al database (assumendo che tu abbia già un file di configurazione con le credenziali)
require_once '../private/config.php';

// Esegui la query per ottenere le task
$query = "SELECT * FROM task, modifica, utenti, stato WHERE utenti.username = modifica.fk_username AND stato.stato = modifica.fk_stato AND task.id = modifica.fk_id";
$result = $pdo->query($query);

// Controlla se ci sono risultati
if ($result) {
    $tasks = $result->fetchAll(PDO::FETCH_ASSOC);
    // Restituisci i risultati come JSON
    header('Content-Type: application/json');
    echo json_encode($tasks);
} else {
    // Se c'è stato un errore nella query, restituisci un messaggio di errore
    echo json_encode(array('error' => 'Errore durante il recupero delle task'));
}
?>

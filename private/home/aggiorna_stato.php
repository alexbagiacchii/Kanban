<?php

// Connessione al database o inclusione del file di configurazione del database
include '../config.php';

// Controlla se la richiesta è una richiesta POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Controlla se tutti i parametri necessari sono presenti nella richiesta
    if (isset($_POST['taskId']) && isset($_POST['status'])) {
        // Sanitizza e valida i dati ricevuti
        $taskId = $_POST['taskId'];
        $status = $_POST['status'];

        // Esegui l'aggiornamento dello stato della task nel database
        $sql = "UPDATE moodifica SET fk_stato = '$status' WHERE id = '$taskId'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $status, $taskId);

        // Esegui la query preparata
        if ($stmt->execute()) {
            // Invia una risposta JSON di successo
            echo json_encode(array("success" => true, "message" => "Stato della task aggiornato con successo."));
        } else {
            // Invia una risposta JSON in caso di errore durante l'esecuzione della query
            echo json_encode(array("success" => false, "message" => "Errore durante l'aggiornamento dello stato della task."));
        }
    } else {
        // Invia una risposta JSON in caso di parametri mancanti nella richiesta
        echo json_encode(array("success" => false, "message" => "Parametri mancanti nella richiesta."));
    }
} else {
    // Invia una risposta JSON in caso di metodo di richiesta non consentito
    echo json_encode(array("success" => false, "message" => "Metodo di richiesta non consentito."));
}

?>

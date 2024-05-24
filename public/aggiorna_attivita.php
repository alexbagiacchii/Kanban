<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["taskId"]) && isset($_POST["newState"])) {
        $taskId = $_POST["taskId"];
        $newState = $_POST["newState"];

        require_once '../config.php';

        $connection = @mysqli_connect(host, username, password, db_name);
        if (!$connection) {
            die(json_encode(array("success" => false, "message" => "Connessione al database fallita: " . mysqli_connect_error())));
        }

        $query = "UPDATE elenco_attivita SET stato = '$newState' WHERE id = '$taskId'";

        if (mysqli_query($connection, $query)) {
            echo json_encode(array("success" => true, "message" => "Stato dell'attività aggiornato con successo."));
        } else {
            echo json_encode(array("success" => false, "message" => "Errore durante l'aggiornamento dello stato dell'attività: " . mysqli_error($connection)));
        }

        mysqli_close($connection);
    } else {
        echo json_encode(array("success" => false, "message" => "Parametri mancanti."));
    }
} else {
    echo json_encode(array("success" => false, "message" => "Metodo di richiesta non valido."));
}
?>

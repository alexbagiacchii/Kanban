<?php
require_once '../../private/config.php';

header('Content-Type: application/json; charset=utf-8');

$connection = @mysqli_connect(host, username, password, db_name);
if (!$connection) {
    die("Connessione al database fallita: " . mysqli_connect_error());
}

$username = $_GET['username'];

try {
    $eliminaUtente = "DELETE FROM utenti WHERE username = '$username'";
    if (mysqli_query($connection, $eliminaUtente)) {
        echo json_encode(array("eliminaUtente" => true));
    } else {
        if (mysqli_errno($connection) == 1451) {
            echo json_encode(array("eliminaUtente" => false, "error" => "Impossibile eliminare l'utente. È associato a una o più attività."));
        } else {
            echo json_encode(array("eliminaUtente" => false, "error" => "Errore durante l'eliminazione dell'utente."));
        }
    }
} catch (mysqli_sql_exception $exception) {
    echo json_encode(array("eliminaUtente" => false, "error" => $exception->getMessage()));
}
?>
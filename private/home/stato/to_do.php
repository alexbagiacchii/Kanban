<?php
header('Content-Type: application/json; charset=utf-8');
require_once '../../config.php';

$connection = @mysqli_connect(host, username, password, db_name);
if (!$connection) {
    die();
}

$query = "SELECT * FROM task, modifica, utenti, stato WHERE modifica.fk_stato = 'To-Do' AND utenti.username = modifica.fk_username AND stato.stato = modifica.fk_stato AND task.id = modifica.fk_id ORDER BY modifica.tag DESC LIMIT 1";
$risultatoQuery = mysqli_query($connection, $query);
$array = array();
while ($row = mysqli_fetch_assoc($risultatoQuery)) {
    array_push($array, $row);
}

echo json_encode($array);
?>

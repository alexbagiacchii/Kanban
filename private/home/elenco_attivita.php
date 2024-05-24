<?php
header('Content-Type: application/json; charset=utf-8');
require_once '../config.php';

$connection = @mysqli_connect(host, username, password, db_name);
if (!$connection) {
    die();
}

$query = "SELECT * FROM modifica, stato, task WHERE modifica.fk_id = task.id AND modifica.fk_stato = stato.stato AND (fk_id, tag) IN (SELECT fk_id, MAX(tag) FROM modifica GROUP BY fk_id);";
$risultatoQuery = mysqli_query($connection, $query);
$array = array();
while ($row = mysqli_fetch_assoc($risultatoQuery)) {
    array_push($array, $row);
}

echo json_encode($array);


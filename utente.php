<?php
$user = $_GET['user'];
$conn = mysqli_connect("10.1.0.52", "5i1", "5i1", "5i1_dylanbagiacchi");
if($conn){
    die("Failed to connect to db!");
}
$query = "select id, nomeTask, descrizione, tipoTask, dataInizio from task, utente, modifica where task.id = modifica.fk_task and modifica.fk_utente = utente.nomeUtente and utente.nomeUtente = '$user';"


?>
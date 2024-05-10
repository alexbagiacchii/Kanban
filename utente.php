<?php
    header('Content-Type: application/json; charset=utf-8');
    $user = $_GET['user'];
    echo $user;
    $conn = mysqli_connect("10.1.0.52", "5i1", "5i1", "5i1_bagiacchidylan");
    if(!$conn){
        die("Failed to connect to db!");
    }
    $query = "select id, nomeTask, descrizione, tipoTask, dataInizio from task, utente, modifica where task.id = modifica.fk_task and modifica.fk_utente = utente.nomeUtente and utente.nomeUtente = '$user'";
    $result = mysqli_query($conn, $query);
    $array = Array();
    while($row=mysqli_fetch_assoc($result)){
        array_push($array, $row);
    }
    echo (json_encode($array));

?>
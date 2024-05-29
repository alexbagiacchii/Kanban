<?php
require_once '../config.php';

$connection = mysqli_connect(host, username, password, db_name);
if (!$connection) {
  die("Connessione al database fallita: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['idTask'], $_POST['nuovoStato'], $_POST['username'])) {
  $idTask = $_POST['idTask'];
  $nuovoStato = $_POST['nuovoStato'];
  $username = $_POST['username'];

  $aggiornaTask = "INSERT INTO modifica (data, fk_id, fk_stato, fk_username) VALUES (NOW(), '$idTask', '$nuovoStato', '$username')";

  if (mysqli_query($connection, $aggiornaTask)) {
    echo "Task aggiornato con successo";
  } else {
    echo "Errore nell'esecuzione della query: " . mysqli_error($connection);
  }
}


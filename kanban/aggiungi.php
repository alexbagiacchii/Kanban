<?php
session_start();
if (isset($_SESSION['autenticato']) && $_SESSION['autenticato'] === true) {
  $username = $_COOKIE['username'];
} else {
  header("Location: ../login/login.php");
  exit;
}

require_once '../config.php';

$connection = @mysqli_connect(host, username, password, db_name);
if (!$connection) {
  die("Connessione al database fallita: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $titolo = $_POST["titolo"];
  $descrizione = $_POST["descrizione"];
  $data = $_POST["data"];
  $priorita = $_POST["priorita"];

  $inserisciTask = "INSERT INTO task (titolo, descrizione, data_inizio, priorita) VALUES ('$titolo', '$descrizione', '$data', '$priorita')";

  if (mysqli_query($connection, $inserisciTask)) {
    $id = mysqli_insert_id($connection);

    $inserisciModifica = "INSERT INTO `modifica`(data, fk_id, fk_stato, fk_username) VALUES (NOW(),'$id','to-do','$username')";
    if (mysqli_query($connection, $inserisciModifica)) {
      header('Location: home.php');
    } else {
      ?>
      <h4>C'è stato un problema durante l'inserimento della task.</h4>
      <?php
    }
  }
}

mysqli_close($connection);

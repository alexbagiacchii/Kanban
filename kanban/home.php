<?php
session_start();
if (isset($_SESSION['autenticato']) && $_SESSION['autenticato'] === true) {
  $username = $_COOKIE['username'];
} else {
  header("Location: ../login.php");
  exit;
}

require_once '../config.php';

$connection = mysqli_connect(host, username, password, db_name);
if (!$connection) {
  die("Connessione al database fallita: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['idTask'], $_POST['nuovoStato'])) {
  $idTask = mysqli_real_escape_string($connection, $_POST['idTask']);
  $nuovoStato = mysqli_real_escape_string($connection, $_POST['nuovoStato']);
  $aggiornaTask = "INSERT INTO modifica (data, fk_id, fk_stato, fk_username) VALUES (NOW(), '$idTask', '$nuovoStato', '$username')";

  // Esegui la query nel database
  if (mysqli_query($connection, $aggiornaTask)) {
    echo "Task aggiornato con successo";
  } else {
    echo "Errore nell'esecuzione della query: " . mysqli_error($connection);
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>KanBoard - Home</title>
  <link rel="stylesheet" href="kanban.css" />
  <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
  <link rel="icon" href="img/logo.png">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
</head>

<body onload="carica()">
  <section>
    <div id="todo" class="dropzone">
      <h2>To-Do</h2>
      <div></div>
    </div>
    <div id="doing" class="dropzone">
      <h2>Doing</h2>
      <div></div>
    </div>
    <div id="done" class="dropzone">
      <h2>Done</h2>
      <div></div>
    </div>
    <div id="archived" class="dropzone">
      <h2>Archived</h2>
      <div></div>
    </div>
  </section>
  <script>
    async function carica() {
      const risposta = await fetch("elencoTask.php");
      const dati = await risposta.json();
      console.log(dati);

      ['To-Do', 'Doing', 'Done', 'Archived'].forEach(stato => inserisciTask(dati.filter(task => task.stato === stato), stato.toLowerCase()));
    }

    function inserisciTask(tasks, idStato) {
      tasks.forEach(task => {
        const elementoTask = document.createElement("div");
        elementoTask.textContent = task.titolo;
        elementoTask.dataset.id = task.id;
        elementoTask.draggable = true;
        elementoTask.addEventListener('dragstart', handleDragStart);
        document.querySelector(`#${idStato} > div`).appendChild(elementoTask);
      });
    }

    function handleDragStart(event) {
      event.dataTransfer.setData('text/plain', event.target.dataset.id);
    }

    document.querySelectorAll('.dropzone').forEach(dropZone => {
      dropZone.addEventListener('dragover', event => event.preventDefault());
      dropZone.addEventListener('drop', async event => {
        event.preventDefault();
        const taskId = event.dataTransfer.getData('text/plain');
        const newState = event.currentTarget.id;
        const response = await fetch('home.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: `idTask=${taskId}&nuovoStato=${newState}`
        });
        if (response.ok) {
          window.location.reload();
        } else {
          console.error('Errore');
        }
      });
    });
  </script>
  <script src="../js/home.js"></script>
</body>

</html>
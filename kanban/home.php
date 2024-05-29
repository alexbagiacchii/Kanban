<?php
session_start();
if (isset($_SESSION['autenticato']) && $_SESSION['autenticato'] === true) {
  $username = $_COOKIE['username'];
} else {
  header("Location: ../login.php");
  exit;
}

?>
<!DOCTYPE html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>KanBoard - Home</title>
  <link rel="stylesheet" href="../css/home.css" />
  <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
  <link rel="icon" href="img/logo.png">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
</head>

<body onload="carica()">
  <div class="sidebar" id="mySidebar">
    <a href="home.php">Home</a>
    <a href="utenti.php">Utenti</a>
    <a href="cronologia.php">Cronologia</a>
    <a href="logout.php">Logout</a>
  </div>

  <div class="content" id="main">
    <button class="openbtn" onclick="toggleSidebar()">☰ Menu</button>
    <section>
      <div id="to-do" class="dropzone">
        <h2>To-Do</h2>
        <div></div>
        <button onclick="aggiungiTask()">+</button>
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
  </div>

  <script>
    async function carica() {
      const risposta = await fetch("elencoTask.php");
      const dati = await risposta.json();
      console.log(dati);

      inserisciTask(dati.filter(function(task) { return task.stato === 'to-do'; }), 'to-do');
      inserisciTask(dati.filter(function(task) { return task.stato === 'doing'; }), 'doing');
      inserisciTask(dati.filter(function(task) { return task.stato === 'done'; }), 'done');
      inserisciTask(dati.filter(function(task) { return task.stato === 'archived'; }), 'archived');
    }

    function inserisciTask(tasks, idStato) {
      tasks.forEach(function(task) {
        const elementoTask = document.createElement("div");
        elementoTask.textContent = task.titolo;
        elementoTask.dataset.id = task.id;
        elementoTask.draggable = true;
        elementoTask.style.backgroundColor = coloreTask(task.priorita);
        elementoTask.addEventListener('dragstart', handleDragStart);
        document.querySelector('#' + idStato + ' > div').appendChild(elementoTask);
      });
    }

    function coloreTask(priorita) {
      switch (priorita.toLowerCase()) {
        case 'alta':
          return '#FF6347';
        case 'media':
          return '#FFD700';
        case 'bassa':
          return '#00FF00';
        default:
          return '#f9f9f9';
      }
    }

    function handleDragStart(event) {
      event.dataTransfer.setData('text/plain', event.target.dataset.id);
    }

    async function aggiungiTask() {
      const username = "<?php echo $username; ?>";
      const response = await fetch('aggiungiTask.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'username=' + username
      });
      if (response.ok) {
        window.location.reload();
      } else {
        console.error('Errore, inserimento fallito.');
      }
    }

    document.querySelectorAll('.dropzone').forEach(function(dropZone) {
      dropZone.addEventListener('dragover', function(event) {
        event.preventDefault();
      });
      dropZone.addEventListener('drop', async function(event) {
        event.preventDefault();
        const taskId = event.dataTransfer.getData('text/plain');
        const newState = event.currentTarget.id;
        const username = "<?php echo $username; ?>";
        const response = await fetch('aggiornaTask.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: 'idTask=' + taskId + '&nuovoStato=' + newState + '&username=' + username
        });
        if (response.ok) {
          window.location.reload();
        } else {
          console.error('Errore, inserimento fallito.');
        }
      });
    });

    function toggleSidebar() {
      var sidebar = document.getElementById("mySidebar");
      if (sidebar.style.width === '250px') {
        sidebar.style.width = '0';
        document.getElementById("main").style.marginLeft = "0";
      } else {
        sidebar.style.width = '250px';
        document.getElementById("main").style.marginLeft = "250px";
      }
    }
  </script>
</body>

</html>

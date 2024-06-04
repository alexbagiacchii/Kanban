<?php
session_start();
if (isset($_SESSION['autenticato']) && $_SESSION['autenticato'] === true) {
  $username = $_COOKIE['username'];
} else {
  header("Location: ../login/login.php");
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
  <link rel="icon" href="../img/logo.png">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
</head>

<body onload="carica()">
  <h1 class="titolo">KANBAN</h1>

  <div id="inserisciTask" class="inserisciTask">
    <div class="inserisciTask-contenuto">
      <span class="chiudi" onclick="chiudiInserisci()">&times;</span>
      <form action="aggiungi.php" method="POST">
        <input type="text" name="titolo" placeholder="Titolo" required>
        <input type="text" name="descrizione" placeholder="Descrizione" required>
        <input type="datetime-local" name="data" placeholder="Data inizio" required>
        <select name="priorita" required>
          <option value="bassa">Bassa</option>
          <option value="media">Media</option>
          <option value="alta">Alta</option>
        </select>
        <button type="submit">Inserisci</button>
      </form>
    </div>
  </div>

  <div class="menu" id="menu">
    <a href="home.php">Home</a>
    <a href="utenti.php">Utenti</a>
    <a href="cronologia.php">Cronologia</a>
    <a href="logout.php">Logout</a>
  </div>

  <div class="content" id="main">
    <button class="openbtn" onclick="toggleSidebar()">☰ Menu</button>
        <ul>
          <li class="priorita-alta">Urgente</li>
          <li class="priorita-media">Media</li>
          <li class="priorita-bassa">Bassa</li>
        </ul>
    <section>
      <div id="to-do" class="dropzone">
        <h2>To-Do</h2>
        <div></div>
        <button onclick="apriInserisci()">+</button>
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

  <div id="dettagliTask" class="dettagliTask">
    <div class="dettagliTask-contenuto">
      <span class="chiudi" onclick="chiudiDettagli()">&times;</span>
      <h2 id="titolo"></h2>
      <p id="descrizione"></p>
      <p id="utente"></p>
      <p id="stato"></p>
      <p id="priorita"></p>
      <p id="data_inizio"></p>
      <p id="data"></p>
      <button id="apriModifica">Modifica</button>
    </div>
  </div>

  <div id="modificaTask" class="modificaTask">
    <div class="modificaTask-contenuto">
      <span class="chiudi" onclick="chiudiModifica()">&times;</span>
      <form action="modificaTask.php" method="POST">
        <input type="text" name="idTask" required hidden>
        <input type="text" name="nuovoTitolo" placeholder="Titolo" required value="ciao" id="nuovoTitolo">
        <input type="text" name="nuovaDescrizione" placeholder="Descrizione" required>
        <select name="nuovaPriorita">
          <option value="alta">Alta</option>
          <option value="media">Bassa</option>
          <option value="bassa">Media</option>
        </select>
        <p id="prova"></p>
        <input type="datetime-local" name="nuovaData" placeholder="Data inizio" required>
        <button type="submit">Aggiorna</button>
      </form>
    </div>
  </div>

  <script>
    async function carica() {
      const risposta = await fetch("elencoTask.php");
      const dati = await risposta.json();
      console.log(dati);

      inserisciTask(dati.filter(function (task) { return task.stato === 'to-do'; }), 'to-do');
      inserisciTask(dati.filter(function (task) { return task.stato === 'doing'; }), 'doing');
      inserisciTask(dati.filter(function (task) { return task.stato === 'done'; }), 'done');
      inserisciTask(dati.filter(function (task) { return task.stato === 'archived'; }), 'archived');
    }

    function inserisciTask(tasks, idStato) {
      tasks.forEach(function (task) {
        const elementoTask = document.createElement("div");
        elementoTask.textContent = task.titolo;
        elementoTask.dataset.id = task.id;
        elementoTask.draggable = true;
        elementoTask.style.backgroundColor = coloreTask(task.priorita);

        elementoTask.addEventListener('click', function () {
          apriDettagli(task.id, task.titolo, task.descrizione, task.fk_username, task.fk_stato, task.priorita, task.data_inizio, task.data);
        });

        elementoTask.addEventListener('dragstart', handleDragStart);
        document.querySelector('#' + idStato + ' > div').appendChild(elementoTask);
      });
    }

    function coloreTask(priorita) {
      switch (priorita.toLowerCase()) {
        case 'alta':
          return '#fb5607';
        case 'media':
          return '#ffbe0b';
        case 'bassa':
          return '#3a86ff';
        default:
          return '#f9f9f9';
      }
    }

    function handleDragStart(event) {
      event.dataTransfer.setData('text/plain', event.target.dataset.id);
    }

    async function aggiungiTask() {
      const username = "<?php echo $username; ?>";
      const response = await fetch('aggiornaTask.php', {
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

    document.querySelectorAll('.dropzone').forEach(function (dropZone) {
      dropZone.addEventListener('dragover', function (event) {
        event.preventDefault();
      });
      dropZone.addEventListener('drop', async function (event) {
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
      var menu = document.getElementById("menu");
      if (menu.style.width === '250px') {
        menu.style.width = '0';
        document.getElementById("main").style.marginLeft = "0";
      } else {
        menu.style.width = '250px';
        document.getElementById("main").style.marginLeft = "250px";
      }
    }

    function apriInserisci() {
      var scheda = document.getElementById("inserisciTask");
      scheda.style.display = "block";
      document.body.style.overflow = "hidden";
    }

    function chiudiInserisci() {
      var scheda = document.getElementById("inserisciTask");
      scheda.style.display = "none";
      document.body.style.overflow = "auto";
    }

    function apriDettagli(id, titolo, descrizione, utente, stato, priorita, data_inizio, data) {
      document.getElementById('titolo').textContent = titolo;
      document.getElementById('descrizione').textContent = "Descrizione: " + descrizione;
      document.getElementById('utente').textContent = "Utente: " + utente;
      document.getElementById('stato').textContent = "Stato: " + stato;
      document.getElementById('priorita').textContent = "Priorità: " + priorita;
      document.getElementById('data_inizio').textContent = "Data inizio: " + data_inizio;
      document.getElementById('data').textContent = "Ultima modifica: " + data;
      let b = document.getElementById('apriModifica');
      b.addEventListener('click', function () {
        apriModifica(id, titolo, descrizione, priorita, data_inizio);
      });
      var scheda = document.getElementById("dettagliTask");
      scheda.style.display = "block";
    }

    function chiudiDettagli() {
      var scheda = document.getElementById("dettagliTask");
      scheda.style.display = "none";
    }

    function apriModifica(id, titolo, descrizione, priorita, data_inizio) {
      document.getElementsByName('idTask')[0].value = id;
      document.getElementsByName('nuovoTitolo')[0].value = titolo;
      document.getElementsByName('nuovaDescrizione')[0].value = descrizione;
      document.getElementsByName('nuovaPriorita')[0].value = priorita;
      document.getElementsByName('nuovaData')[0].value = data_inizio;

      var scheda = document.getElementById("modificaTask");
      scheda.style.display = "block";
      document.body.style.overflow = "hidden";
    }

    function chiudiModifica() {
      var scheda = document.getElementById("modificaTask");
      scheda.style.display = "none";
    }
  </script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>KanBoard - Home</title>
  <link rel="stylesheet" href="../css/kanban.css" />
  <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
  <link rel="icon" href="img/logo.png">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
</head>

<body onload="carica()">
  <?php
  session_start();
  if (isset($_SESSION['autenticato']) && $_SESSION['autenticato'] === true) {
    $username = $_COOKIE['username'];
  } else {
    header("Location: ../login/loginForm.php");
    exit;
  }
  ?>
  <section>
    <div id="todo">
      <h2>To-Do</h2>
      <div></div>
    </div>
    <div id="doing">
      <h2>Doing</h2>
      <div></div>
    </div>
    <div id="done">
      <h2>Done</h2>
      <div></div>
    </div>
    <div id="archived">
      <h2>Archived</h2>
      <div></div>
    </div>
  </section>
  <script>
    async function carica() {
      const risposta = await fetch("elencoTask.php");
      const dati = await risposta.json();
      console.log(dati);

      const taskToDo = dati.filter(function (task) {
        return task.stato === "To-Do";
      });
      const taskDoing = dati.filter(function (task) {
        return task.stato === "Doing";
      });
      const taskDone = dati.filter(function (task) {
        return task.stato === "Done";
      });
      const taskArchived = dati.filter(function (task) {
        return task.stato === "Archived";
      });

      inserisciTask(taskToDo, "todo");
      inserisciTask(taskDoing, "doing");
      inserisciTask(taskDone, "done");
      inserisciTask(taskArchived, "archived");
    }

    function inserisciTask(tasks, idStato) {
      const scheda = document.querySelector("#" + idStato + " > div");
      tasks.forEach(function (task) {
        const elementoTask = document.createElement("div");
        elementoTask.textContent = task.titolo;
        elementoTask.setAttribute('data-id', task.id);
        scheda.appendChild(elementoTask);
      });

      new Sortable(scheda, {
        group: 'tasks', 
        animation: 150,
        onEnd: function (evt) {
          const taskID = evt.item.getAttribute('data-id');
          const newState = idStato;
          const username = "admin";
          fetch('aggiornaTask.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify({
              taskId: taskID,
              newState: newState
            }),
          })
            .then(response => response.json())
            .then(data => {
              if (data.success) {
                console.log("Stato della task aggiornato con successo.");
              } else {
                console.error("Si è verificato un errore durante l'aggiornamento dello stato della task.");
              }
            })
            .catch(error => {
              console.error("Si è verificato un errore durante la richiesta AJAX:", error);
            });
          console.log("Task", taskID, "spostata a", newState);
        }
      });
    }
  </script>
  <script src="../js/home.js"></script>
</body>

</html>
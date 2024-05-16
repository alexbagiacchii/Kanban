<!DOCTYPE html>
<!-- Website - www.codingnepalweb.com -->
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8" />
  <title>KanBoard - Home</title>
  <link rel="stylesheet" href="home.css" />
  <!-- Boxicons CDN Link -->
  <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body>
  <?php
  session_start();
  // Controlla se l'utente è autenticato
  if (isset($_SESSION['autenticato']) && $_SESSION['autenticato'] === true) {
    $username = $_COOKIE['username'];

  } else {
    header("Location: login.php");
    exit;
  }

  ?>
  <div class="sidebar">
    <div class="logo-details">
      <div class="logo_name">KanBoard</div>
      <i class="bx bx-menu" id="btn"></i>
    </div>
    <ul class="nav-list">
      <li>
        <a href="#">
          <i class="bx bx-grid-alt"></i>
          <span class="links_name">Dashboard</span>
        </a>
        <span class="tooltip">Dashboard</span>
      </li>
      <li>
        <a href="#">
          <i class="bx bx-user"></i>
          <span class="links_name">Utenti</span>
        </a>
        <span class="tooltip">User</span>
      </li>
      <li>
        <a href="#">
          <i class="bx bx-calendar-plus"></i>
          <span class="links_name">Aggiungi</span>
        </a>
        <span class="tooltip">Messages</span>
      </li>
      <li>
        <a href="#">
          <i class="bx bx-calendar-minus"></i>
          <span class="links_name">Elimina</span>
        </a>
        <span class="tooltip">Analytics</span>
      </li>
      <li>
        <a href="#">
          <i class="bx bx-data"></i>
          <span class="links_name">Elenco attività</span>
        </a>
        <span class="tooltip">Files</span>
      </li>
      <li class="profile">
        <div class="profile-details">
          <img src="img/avatar.svg" alt="profileImg" />
          <div class="name_job">
            <div class="name"> <span><?php echo $username; ?></span></div>
            <div class="job"></div>
          </div>
        </div>
        <a href="../private/logout.php" id="log_out">
          <i class="bx bx-log-out" id="log_out"></i>
        </a>
      </li>
    </ul>
  </div>
  <section class="home-section">
      <div class="text">Dashboard</div>
      <div class="container">
           <section class="dashboard">
        <div id="todo" class="tab">
          <h2>To-Do</h2>
          <div id="todoTasks" class="tasks"></div>
        </div>
        <div id="doing" class="tab">
          <h2>Doing</h2>
          <div id="doingTasks" class="tasks"></div>
        </div>
        <div id="done" class="tab">
          <h2>Done</h2>
          <div id="doneTasks" class="tasks"></div>
        </div>
        <div id="archived" class="tab">
          <h2>Archived</h2>
          <div id="archivedTasks" class="tasks"></div>
        </div>
      </div>

      <script>
        async function carica() {
          try {
            await Promise.all([
              fetchAndPopulate('to_do.php', 'todoTasks'),
              fetchAndPopulate('doing.php', 'doingTasks'),
              fetchAndPopulate('done.php', 'doneTasks'),
              fetchAndPopulate('archived.php', 'archivedTasks')
            ]);
          } catch (error) {
            console.error(error);
          }
        }

        async function fetchAndPopulate(script, targetId) {
          const response = await fetch("../private/home/stato/" + script);
          if (!response.ok) {
            throw new Error('Errore durante il recupero delle task');
          }
          const tasks = await response.json();
          const targetElement = document.getElementById(targetId);
          tasks.forEach(task => {
            const taskElement = document.createElement('div');
            taskElement.classList.add('task');
            taskElement.textContent = task.titolo;
            targetElement.appendChild(taskElement);
          });
        }

        window.onload = carica;
      </script>
    </section>
  </section>

  <script src="../private/home.js"></script>
</body>

</html>
<!DOCTYPE html>

<head>
  <meta charset="UTF-8" />
  <title>KanBoard - Home</title>
  <link rel="stylesheet" href="css/home.css" />
  <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" href="img/logo.png">

</head>

<body onload="carica()">
  <?php
  session_start();
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
        <a href="home.php">
          <i class="bx bx-grid-alt"></i>
          <span class="links_name">Dashboard</span>
        </a>
      </li>
      <li>
        <a href="dashboard/utenti.php">
          <i class="bx bx-user"></i>
          <span class="links_name">Utenti</span>
        </a>
      </li>
      <li>
        <a href="dashboard/aggiungi.php">
          <i class="bx bx-calendar-plus"></i>
          <span class="links_name">Aggiungi</span>
        </a>
      </li>
      <li>
        <a href="dashboard/cronologia.php">
          <i class="bx bx-data"></i>
          <span class="links_name">Elenco attività</span>
        </a>
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
      <script>
        async function carica() {
            const response = await fetch("../private/home/elenco_attivita.php");
            const data = await response.json();
            console.log(data);

          }
      </script>
    </section>
    <script src="../private/home.js"></script>
</body>

</html>
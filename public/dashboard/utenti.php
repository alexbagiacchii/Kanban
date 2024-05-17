<!DOCTYPE html>

<head>
  <meta charset="UTF-8" />
  <title>KanBoard - Utenti</title>
  <link rel="stylesheet" href="../home.css" />
  <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" href="../img/logo.png">

</head>

<sec>
  <?php
  session_start();
  if (isset($_SESSION['autenticato']) && $_SESSION['autenticato'] === true) {
    $username = $_COOKIE['username'];

  } else {
    header("Location: ../login.php");
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
        <a href="../home.php">
          <i class="bx bx-grid-alt"></i>
          <span class="links_name">Dashboard</span>
        </a>
      </li>
      <li>
        <a href="utenti.php">
          <i class="bx bx-user"></i>
          <span class="links_name">Utenti</span>
        </a>
      </li>
      <li>
        <a href="aggiungi.php">
          <i class="bx bx-calendar-plus"></i>
          <span class="links_name">Aggiungi</span>
        </a>
      </li>
      <li>
        <a href="elimina.php">
          <i class="bx bx-calendar-minus"></i>
          <span class="links_name">Elimina</span>
        </a>
      </li>
      <li>
        <a href="#">
          <i class="bx bx-data"></i>
          <span class="links_name">Elenco attività</span>
        </a>
      </li>
      <li class="profile">
        <div class="profile-details">
          <img src="../img/avatar.svg" alt="profileImg" />
          <div class="name_job">
            <div class="name"> <span><?php echo $username; ?></span></div>
            <div class="job"></div>
          </div>
        </div>
        <a href="../../private/logout.php" id="log_out">
          <i class="bx bx-log-out" id="log_out"></i>
        </a>
      </li>
    </ul>
  </div>
  <section class="home-section">
    <div class="text">Utenti</div>
    <div class="container">
    <section class="dashboard">
      <table class="styled-table">
        <thead>
          <tr>
            <th>Username</th>
            <th>Nome</th>
            <th>Cognome</th>
            <th>Ruolo</th>
          </tr>
        </thead>
        <tbody>

          <?php
          require_once '../../private/config.php';

          $connection = @mysqli_connect(host, username, password, db_name);
          if (!$connection) {
            die("Connessione al database fallita: " . mysqli_connect_error());
          }

          $elencoUtenti = "SELECT * FROM utenti";
          $risultatoUtenti = mysqli_query($connection, $elencoUtenti);

          if (mysqli_num_rows($risultatoUtenti) > 0) {
            while ($row = mysqli_fetch_assoc($risultatoUtenti)) {
              echo "<tr>";
              echo "<td>" . $row['username'] . "</td>";
              echo "<td>" . $row['nome'] . "</td>";
              echo "<td>" . $row['cognome'] . "</td>";
              echo "<td>" . $row['ruolo'] . "</td>";
              echo "</tr>";
            }
          }
          ?>
        </tbody>

      </table>
    </div>
  </section>
  </section>
  <script src="../../private/home.js"></script>
</body>

</html>
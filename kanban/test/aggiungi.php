<!DOCTYPE html>

<head>
  <meta charset="UTF-8" />
  <title>KanBoard - Utenti</title>
  <link rel="stylesheet" href="../css/utenti.css" />
  <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" href="../img/logo.png">

</head>

<section>
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
        <a href="cronologia.php">
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
    <div class="text">Aggiungi Task</div>
    <section class="dashboard">
      <div class="glass-card-inserisci">
        <form action="" method="POST">
          <h2>Inserisci una task</h2>
          <?php
          require_once '../../private/config.php';

          $connection = @mysqli_connect(host, username, password, db_name);
          if (!$connection) {
            die("Connessione al database fallita: " . mysqli_connect_error());
          }

          if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $titolo = $_POST["titolo"];
            $descrizione = $_POST["descrizione"];
            $data_inizio = $_POST["data_inizio"];
            $priorita = $_POST["priorita"];

            $inserisciTask = "INSERT INTO task (titolo, descrizione, data_inizio, priorita) VALUES ('$titolo', '$descrizione', '$data_inizio', '$priorita')";

            $inserisciModifica = "INSERT INTO modifica (data, fk_id, fk_stato, fk_username) VALUES ('$data_inizio', LAST_INSERT_ID(), 'To-Do', '$username')";

            if (mysqli_query($connection, $inserisciTask) && mysqli_query($connection, $inserisciModifica)) {
              ?>
              <h4 class="success">Task inserita con successo.</h4>
              <?php
            } else {
              ?>
              <h4 class="error">C'è stato un problema durante l'inserimento della task.</h4>
              <?php
            }
          }

          mysqli_close($connection);
          ?>

          <input type="text" name="titolo" placeholder="Titolo" required>
          <input type="text" name="descrizione" placeholder="Descrizione" required>
          <input type="datetime-local" name="data_inizio" placeholder="Data inizio" required>
          <select name="priorita" required>
            <option value="bassa">Bassa</option>
            <option value="media">Media</option>
            <option value="alta">Alta</option>
          </select>
          <button type="submit" class="button-aggiungi">Aggiungi task</button>
        </form>
      </div>
    </section>
  </section>
  <script src="../../private/home.js"></script>
  </body>

  </html>
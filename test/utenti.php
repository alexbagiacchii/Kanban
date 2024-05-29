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
    <div class="text">Utenti</div>
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
      <div class="glass-card">
        <form action="" method="POST">
          <h4>Inserisci nuovo utente</h4>
          <?php
          require_once '../../private/config.php';

          $connection = @mysqli_connect(host, username, password, db_name);
          if (!$connection) {
            die("Connessione al database fallita: " . mysqli_connect_error());
          }

          if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST["username"];
            $nome = $_POST["nome"];
            $cognome = $_POST["cognome"];
            $password = $_POST["password"];
            $ruolo = $_POST["ruolo"];

            $controlloDuplicati = "SELECT username FROM utenti WHERE username = '$username'";
            $risultatoDuplicati = mysqli_query($connection, $controlloDuplicati);

            if (mysqli_num_rows($risultatoDuplicati) > 0) {
              while ($row = mysqli_fetch_assoc($risultatoDuplicati)) {
                ?>
                <h4 class="error">Username già esistente.</h4>
                <?php
              }
            } else {
              $registraUtente = "INSERT INTO utenti (username, nome, cognome, password, ruolo) VALUES ('$username', '$nome', '$cognome', '$password', '$ruolo')";

              if (mysqli_query($connection, $registraUtente)) {
                ?>
                <h4 class="success">Registrazione completata.</h4>
                <?php
              } else {
                ?>
                <h4 class="error">C'è stato un problema durante la registrazione.</h4>
                <?php
              }
            }
          }
          mysqli_close($connection);
          ?>
          <input type="text" name="username" placeholder="Username" required>
          <input type="text" name="nome" placeholder="Nome" required>
          <input type="text" name="cognome" placeholder="Cognome" required>
          <input type="password" name="password" placeholder="Password" required>
          <select name="ruolo" required>
            <option value="user">Utente</option>
            <option value="admin">Admin</option>
            <option value="readonly">Read-Only</option>
          </select>
          <button type="submit" class="button-aggiungi">Aggiungi utente</button>
        </form>
        <h4 class="h2-elimina">Elimina Utente</h4>
        <h4 class="success" style="display: none;" id="successoEliminazione">Eliminazione completata.</h4>
        <h4 class="error" style="display: none;" id="erroreEliminazione">L'utente è legato ad una o più task.</h4>
        <select name="user" id="username" required>
          <?php
          require_once '../../private/config.php';

          $connection = @mysqli_connect(host, username, password, db_name);
          if (!$connection) {
            die("Connessione al database fallita: " . mysqli_connect_error());
          }

          $elencoUtenti = "SELECT username FROM utenti";
          $risultatoUtenti = mysqli_query($connection, $elencoUtenti);

          if (mysqli_num_rows($risultatoUtenti) > 0) {
            while ($row = mysqli_fetch_assoc($risultatoUtenti)) {
              echo "<option value='" . $row['username'] . "'>" . $row['username'] . "</option>";
            }
          }
          ?>
        </select>
        <button type="button" onclick="eliminaUtente()" class="button-elimina">Elimina Utente</button>
        <script>
          async function eliminaUtente() {
            var username = document.querySelector("select[name='user']").value;
            const response = await fetch("../../private/home/elimina_utente.php?username=" + username);
            const data = await response.json();
            if (data.eliminaUtente) {
              document.getElementById("successoEliminazione").style.display = "block";
              document.getElementById("erroreEliminazione").style.display = "none";
            } else {
              document.getElementById("erroreEliminazione").style.display = "block";
              document.getElementById("successoEliminazione").style.display = "none";
            }
          }
        </script>
      </div>
    </section>
  </section>
  <script src="../../private/home.js"></script>
  </body>
</html>

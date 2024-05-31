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
  <link rel="icon" href="img/logo.png">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
</head>

<h1 class="titolo">KANBAN</h1>

<body onload="carica()">
  <div class="menu" id="menu">
    <a href="home.php">Home</a>
    <a href="utenti.php">Utenti</a>
    <a href="cronologia.php">Cronologia</a>
    <a href="logout.php">Logout</a>
  </div>

  <div class="content" id="main">
    <button class="openbtn" onclick="toggleSidebar()">☰ Menu</button>
    <section>
      <table>
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
          require_once '../config.php';

          $connection = @mysqli_connect(host, username, password, db_name);
          if (!$connection) {
            die("Connessione al database fallita: " . mysqli_connect_error());
          }

          $elencoUtenti = "SELECT * FROM utenti";
          $risultatoUtenti = mysqli_query($connection, $elencoUtenti);

          while ($row = mysqli_fetch_assoc($risultatoUtenti)) {
            echo "<tr";
            if ($row['username'] === $username) {
              echo " class='utente'";
            }
            echo ">";
            echo "<td>" . $row['username'] . "</td>";
            echo "<td>" . $row['nome'] . "</td>";
            echo "<td>" . $row['cognome'] . "</td>";
            echo "<td>" . $row['ruolo'] . "</td>";
            echo "</tr>";
          }
          ?>
        </tbody>
      </table>
      <div class="inserisci">
      <form action="" method="POST">
          <h4>Inserisci nuovo utente</h4>
          <?php
          require_once '../config.php';

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
        </div>
    </section>
  </div>

  <script>
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
  </script>
</body>

</html>
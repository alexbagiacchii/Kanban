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

<h1 class="titolo">AGGIUNGI</h1>

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
      <form action="" method="POST">
        <?php
        require_once '../config.php';

        $connection = @mysqli_connect(host, username, password, db_name);
        if (!$connection) {
          die("Connessione al database fallita: " . mysqli_connect_error());
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $titolo = $_POST["titolo"];
          $descrizione = $_POST["descrizione"];
          $data_inizio = $_POST["data"];
          $priorita = $_POST["priorita"];

          $inserisciTask = "INSERT INTO task (titolo, descrizione, data_inizio, priorita) VALUES ('$titolo', '$descrizione', '$data', '$priorita')";

          if (mysqli_query($connection, $inserisciTask)) {
            ?>
            <h4>Task inserita con successo.</h4>
            <?php
          } else {
            ?>
            <h4>C'è stato un problema durante l'inserimento della task.</h4>
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
        <button type="submit">Inserisci</button>
      </form>
    </section>
  </div>

  <script>
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
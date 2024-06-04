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
            <th>Tag</th>
            <th>Data</th>
            <th>Attività</th>
            <th>Stato</th>
            <th>Utente</th>
          </tr>
        </thead>
        <tbody>
          <?php
          require_once '../config.php';

          $connection = @mysqli_connect(host, username, password, db_name);
          if (!$connection) {
            die("Connessione al database fallita: " . mysqli_connect_error());
          }

          $elencoCronologia = "SELECT * FROM modifica, task WHERE modifica.fk_id = task.id";
          $risultatoCronologia = mysqli_query($connection, $elencoCronologia);

          if (mysqli_num_rows($risultatoCronologia) > 0) {
            while ($row = mysqli_fetch_assoc($risultatoCronologia)) {
              echo "<tr>";
              echo "<td>" . $row['tag'] . "</td>";
              echo "<td>" . $row['data'] . "</td>";
              echo "<td>" . $row['titolo'] . "</td>";
              echo "<td>" . $row['fk_stato'] . "</td>";
              echo "<td>" . $row['fk_username'] . "</td>";
              echo "</tr>";
            }
          }
          ?>
        </tbody>
      </table>
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
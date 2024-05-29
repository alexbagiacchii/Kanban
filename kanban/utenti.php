<?php
session_start();
if (isset($_SESSION['autenticato']) && $_SESSION['autenticato'] === true) {
  $username = $_COOKIE['username'];
} else {
  header("Location: ../login.php");
  exit;
}

?>
<!DOCTYPE html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>KanBoard - Home</title>
  <link rel="stylesheet" href="test/kanban.css" />
  <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
  <link rel="icon" href="img/logo.png">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
</head>

<h1 class="titolo">KANBAN</h1>

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

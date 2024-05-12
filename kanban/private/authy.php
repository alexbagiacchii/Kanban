<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["username"]) && isset($_POST["password"])) {

        $username = $_POST["username"];
        $password = $_POST["password"];

        require_once 'config.php';

        $connection = mysqli_connect(host, username, password, db_name);
        if (!$connection) {
            die("Connessione al database fallita: " . mysqli_connect_error());
        }

        // Escape dei valori dell'input per evitare SQL injection
        $username = mysqli_real_escape_string($connection, $username);
        $password = mysqli_real_escape_string($connection, $password);

        $controlloUtente = "SELECT username, password FROM utenti WHERE username = '$username'";
        $risultatoUtente = mysqli_query($connection, $controlloUtente);

        if (!$risultatoUtente) {
            die("Query fallita: " . mysqli_error($connection));
        }

        if (mysqli_num_rows($risultatoUtente) == 0) {
            echo "<b>Errore:</b> Nessun utente esistente con questo username: <b>" . htmlspecialchars($username) . "</b>";
        } else {
            $login = "SELECT username, password FROM utenti WHERE username = '$username' AND password = '$password'";
            $risultatoLogin = mysqli_query($connection, $login);

            if (!$risultatoLogin) {
                die("Query fallita: " . mysqli_error($connection));
            }

            if (mysqli_num_rows($risultatoLogin) > 0) {
                $_SESSION["autenticato"] = true;
                $expiry = time() + 3600;
                setcookie("username", $username, $expiry, "/");
                header("Location: ../public/home.php");
                exit();
            } else {
                echo "Credenziali errate. Riprova.";
            }
        }
        mysqli_close($connection);
    } else {
        echo "Errore";
    }
}
?>

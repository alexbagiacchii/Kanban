<?php

require_once 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["username"]) && isset($_POST["password"])) {

        $username = $_POST["username"];
        $password = $_POST["password"];
        $ruolo = $_POST["ruolo"];

        $connection = mysqli_connect(host, username, password, db_name);
        if (!$connection) {
            die("Connessione al database fallita: " . mysqli_connect_error());
        }

        $controlloUtente = "SELECT username, password FROM utenti WHERE username = '$username'";
        $risultatoUtente = mysqli_query($connection, $controlloUtente);

        if (!$risultatoUtente) {
            die("Query fallita: " . mysqli_error($connection));
        }

        if (mysqli_num_rows($risultatoUtente) == 0) {
            echo "<b>Errore:</b> Nessun utente esistente con questo username: <b>" . $username . "</b>";
        } else {
            $login = "SELECT username, password, ruolo FROM utenti WHERE username = '$username' AND password = '$password'";
            $risultatoLogin = mysqli_query($connection, $login);

            if (!$risultatoLogin) {
                die("Query fallita: " . mysqli_error($connection));
            }

            if (mysqli_num_rows($risultatoLogin) > 0) {
                $utente = mysqli_fetch_assoc($risultatoLogin); // Ottieni i dettagli dell'utente
                $_SESSION["autenticato"] = true;
                $expiry = time() + 3600;
                setcookie("username", $username, $expiry, "/");
                setcookie("ruolo", $utente['ruolo'], $expiry, "/"); // Imposta il cookie del ruolo

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
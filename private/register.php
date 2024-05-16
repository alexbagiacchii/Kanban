<?php

require_once 'config.php';

$connection = @mysqli_connect(host, username, password, db_name);
if (!$connection) {
    die("Connessione al database fallita: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $nome = $_POST["nome"];
    $cognome = $_POST["cognome"];
    $password = $_POST["password"];

    $controlloDuplicati = "SELECT username FROM utenti WHERE username = '$username'";
    $risultatoDuplicati = mysqli_query($connection, $controlloDuplicati);

    if (mysqli_num_rows($risultatoDuplicati) > 0) {
        while ($row = mysqli_fetch_assoc($risultatoDuplicati)) {
            echo "<b>Errore:</b> Impossibile completare la registrazione, il nome utente è già presente nel DB: <b>" . $username . "</b>";
        }
    } else {
        $registraUtente = "INSERT INTO utenti (username, nome, cognome, password, ruolo) VALUES ('$username', '$nome', '$cognome', '$password', 'user')";

        if (mysqli_query($connection, $registraUtente)) {
            echo "Registrazione effettuata con successo. <a href='../public/login.html'>Accedi</a>";
        } else {
            echo "Errore durante la registrazione: " .mysqli_error($connection);
        }
    }
}

$connection->close();
?>
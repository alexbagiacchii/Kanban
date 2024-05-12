<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kanban</title>

</head>

<body>
    <div id="container">
        <h1>KANBAN - to do list</h1>
        <div id="buttons">
            <button>Aggiungi</button>
            <button>Utenti</button>
            <button>Storico</button>
            <button>Cerca</button>
        </div>
        <?php
        require_once '../private/config.php';
        $connection = @mysqli_connect(host, username, password, db_name);
        if (!$connection) {
            die("Connessione al database fallita: " . mysqli_connect_error());
        }

        //Elenco task
        $queryTask = "SELECT * FROM task";
        $risultatoTask = mysqli_query($connection, $queryTask);
        if (!$risultatoTask) {
            die("Errore: impossibile caricare le informazioni richieste: " . mysqli_error($conn));
        }

        if (mysqli_num_rows($risultatoTask) > 0) {
            echo "<h1>Elenco Task:</h1>";
            echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Titolo</th>
                <th>Descrizione</th>
                <th>Inizio</th>
                <th>Priorità</th>
            </tr>";
            while ($row = mysqli_fetch_assoc($risultatoTask)) {
                echo "<tr>
                <td>" . $row["id"] . "</td>
                <td>" . $row["titolo"] . "</td>
                <td>" . $row["descrizione"] . "</td>
                <td>" . $row["data_inizio"] . "</td>
                <td>" . $row["priorita"] . "</td>
              </tr>";
            }
            echo "</table>";
        } else {
            echo "Errore: nessun dato esistente nel DB.";
        }

        //Inserisci TASK
        ?>
        <form action="inserimento/nuovaTask.php" method="post">
            <h3>Inserisci task</h3>
            <p>Titolo:</p><input type="text" name="titolo" required>
            <p>Descrizione:</p><input type="text" name="descrizione" required>
            <p>Data:</p><input type="datetime-local" name="dataInizio" required>
            <p>Priorità:</p><select name='priorita'>
                <option value="Bassa">Bassa</option>
                <option value="Intermedia">Intermedia</option>
                <option value="Alta">Alta</option>
                <input type="submit" value="Inserisci">
        </form>
        <script>
            async function leggi() {
                let url = ("url");
                let risposta = await fetch(url);
                if (risposta.ok) {
                    let dati = await risposta.json();
                }
            }
        </script>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kanban</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Verdana, sans-serif;
        }

        table,
        td,
        th {
            border: 1px solid black;
            border-collapse: collapse;
        }

        td,
        th {
            padding: 0.5em;
        }

        #container {
            width: 50em;
            margin-left: auto;
            margin-right: auto;
            background-color: rgba(0, 227, 235, 0.3);
            border-radius: 0.5em;
            padding: 1em;
        }

        #buttons {
            display: flex;
            justify-content: center;
        }

        #buttons button {
            margin: 0 10px;
            width: 7em;
            border-radius: 0.5em;
            margin-bottom: 1em;
            background-color: white;
            padding: 0.2em;
        }

        #buttons button:hover {
            background-color: #bfbfbf;
        }

        table {
            margin-left: auto;
            margin-right: auto;
            background-color: white;
            border-radius: 0.5em;
        }
    </style>
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
        $connection = @mysqli_connect("10.1.0.52", "5i1", "5i1", "5i1_bagiacchidylan");
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
                <th>Nome</th>
                <th>Tipo</th>
                <th>Inizio</th>
                <th>Descrizione</th>
            </tr>";
            while ($row = mysqli_fetch_assoc($risultatoTask)) {
                echo "<tr>
                <td>" . $row["id"] . "</td>
                <td>" . $row["nomeTask"] . "</td>
                <td>" . $row["tipoTask"] . "</td>
                <td>" . $row["dataInizio"] . "</td>
                <td>" . $row["descrizione"] . "</td>
              </tr>";
            }
            echo "</table>";
        } else {
            echo "Errore: nessun dato esistente nel DB.";
        }
        ?>
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
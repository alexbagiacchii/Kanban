<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home-page Libreria</title>
</head>

<body>
    <?php
    $connection = @mysqli_connect("localhost", "root", "", "libreria");
    if (!$connection) {
        die("Connessione al database fallita: " . mysqli_connect_error());
    }

    $queryLibri = "SELECT * FROM libri, autori, categorie WHERE libri.fk_categoria = categorie.nome AND libri.fk_autore = autori.cf";
    $risultatoQueryLibri = mysqli_query($connection, $queryLibri);
    if (!$risultatoQueryLibri) {
        die("Errore: impossibile caricare le informazioni richieste: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($risultatoQueryLibri) > 0) {
        echo "<h1>Elenco libri DB: RICORDATI ELIMINAZIONE</h1>";
        echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Titolo</th>
                <th>Data</th>
                <th>CF Autore</th>
                <th>Categoria</th>
            </tr>";
        while ($row = mysqli_fetch_assoc($risultatoQueryLibri)) {
            echo "<tr>
                <td>" . $row["id"] . "</td>
                <td>" . $row["titolo"] . "</td>
                <td>" . $row["data"] . "</td>
                <td>" . $row["fk_autore"] . "</td>
                <td>" . $row["nome"] . "</td>
              </tr>";
        }
        echo "</table>";
    } else {
        echo "Errore: nessun dato esistente nel DB.";
    }
    ?>
    <form action="inserimento/queryLibro.php" method="post">
        <h3>Inserisci una libro, oppure usa un <a href="uploadCSV.html">CSV.</a></h3>
        <input type="text" name="nomeLibro">
        <input type="date" name="dataLibro">
        <?php
        //Select Autori
        $querySelectAutori = "SELECT * FROM autori";
        $risultatoQuerySelectAutori = mysqli_query($connection, $querySelectAutori);
        if (!$risultatoQuerySelectAutori) {
            die("Errore: impossibile caricare le informazioni richieste: " . mysqli_error($connection));
        }

        if (mysqli_num_rows($risultatoQuerySelectAutori) > 0) {
            echo " <select name='cfAutore'>";
            while ($row = mysqli_fetch_assoc($risultatoQuerySelectAutori)) {
                echo "<option value=" . $row["cf"] . ">" . $row["nome"] . "-" . $row["cognome"] . "</option>";
            }
        } else {
            echo "Errore: nessun dato esistente nel DB.";
        }
        ?>
        </select>
        <?php
        //Select Categoria
        $querySelectCategoria = "SELECT nome FROM categorie";
        $risultatoQuerySelectCategoria = mysqli_query($connection, $querySelectCategoria);
        if (!$risultatoQuerySelectCategoria) {
            die("Errore: impossibile caricare le informazioni richieste: " . mysqli_error($connection));
        }

        if (mysqli_num_rows($risultatoQuerySelectCategoria) > 0) {
            echo " <select name='nomeCategoria'>";
            while ($row = mysqli_fetch_assoc($risultatoQuerySelectCategoria)) {
                echo "<option value=" . $row["nome"] . ">" . $row["nome"] . "</option>";
            }
        } else {
            echo "Errore: nessun dato esistente nel DB.";
        }
        ?>
        </select>
        <input type="submit" value="Carica">
    </form>
    <?php

    $queryAutori = "SELECT * FROM autori";
    $risultatoQueryAutori = mysqli_query($connection, $queryAutori);
    if (!$risultatoQueryAutori) {
        die("Errore: impossibile caricare le informazioni richieste: " . mysqli_error($connection));
    }

    if (mysqli_num_rows($risultatoQueryAutori) > 0) {
        echo "<h1>Elenco autori DB:</h1>";
        echo "<table border='1'>
            <tr>
                <th>Nome</th>
                <th>Cognome</th>
                <th>Codice Fiscale</th>
            </tr>";
        while ($row = mysqli_fetch_assoc($risultatoQueryAutori)) {
            echo "<tr>
                <td>" . $row["nome"] . "</td>
                <td>" . $row["cognome"] . "</td>
                <td>" . $row["cf"] . "</td>
            </tr>";
        }
        echo "
        </table>";
    } else {
        echo "Errore: nessun dato esistente nel DB.";
    }
    //Inserisci autore
    ?>
    <form action="inserimento/queryAutore.php" method="post">
        <h3>Inserisci una autore, oppure usa un <a href="uploadCSV.html">CSV.</a></h3>
        <p>Nome:</p><input required type="text" name="nomeAutore">
        <p>Cognome:</p><input required type="text" name="cognomeAutore">
        <p>Codice Fiscale:</p><input required type="text" name="cfAutore" maxlength="16">
        <input type="submit" value="Carica">
    </form>
    <?php

    $queryCategorie = "SELECT * FROM categorie";
    $risultatoQueryCategorie = mysqli_query($connection, $queryCategorie);
    if (!$risultatoQueryCategorie) {
        die("Errore: impossibile caricare le informazioni richieste: " . mysqli_error($connection));
    }

    if (mysqli_num_rows($risultatoQueryCategorie) > 0) {
        echo "<h1>Elenco categorie DB:</h1>";
        echo "<table border='1'>
            <tr>
                <th>Categoria</th>
                <th>Descrizione</th>
            </tr>";
        while ($row = mysqli_fetch_assoc($risultatoQueryCategorie)) {
            echo "<tr>
                <td>" . $row["nome"] . "</td>
                <td>" . $row["descrizione"] . "</td>
            </tr>";
        }
        echo "
        </table>";
    } else {
        echo "Errore: nessun dato esistente nel DB.";
    }
    //Inserisci categoria
    ?>
    <form action="inserimento/queryCategoria.php" method="post">
        <h3>Inserisci una categoria, oppure usa un <a href="uploadCSV.html">CSV.</a></h3>
        <p>Nome:</p><input required type="text" name="nomeCategoria">
        <p>Descrizione:</p><input required type="text" name="descrizioneCategoria">

        <input type="submit" value="Carica">
    </form>
    <?php

    mysqli_close($connection);
    ?>

</body>

</html>
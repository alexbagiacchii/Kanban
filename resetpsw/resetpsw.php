<html>

<head>
    <title>KanBoard - Reset</title>
    <link rel="stylesheet" type="text/css" href="../css/form.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
    <img class="wave" src="../img/sfondo.png">
    <div class="container">
        <div class="img">
            <img src="../img/bg.svg">
        </div>
        <div class="login-content">
            <div class="reset">
                <img src="../img/avatar.svg">
                <?php
                require_once '../config.php';

                $connection = @mysqli_connect(host, username, password, db_name);
                if (!$connection) {
                    die("Connessione al database fallita: " . mysqli_connect_error());
                }

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $username = $_POST["username"];
                    $password = $_POST["password"];

                    $controlloPassword = "SELECT * FROM utenti WHERE username = '$username' AND password = '$password'";
                    $risultatoControllo = mysqli_query($connection, $controlloPassword);

                    if (mysqli_num_rows($risultatoControllo) > 0) {
                        ?>
                        <h2 class="title">Errore</h2>
                        <h3 class="error">Password inserita è uguale a quella vecchia.</h3>
                        <input type="button" id="registerButton" class="btn" value="Accedi">
                        <script>
                            document.getElementById("registerButton").addEventListener("click", function () {
                                window.location.href = "../login/loginForm.php";
                            });
                        </script>
                        <?php
                    } else {
                        $aggiornaPassword = "UPDATE utenti SET password = '$password' WHERE username = '$username'";
                        if (mysqli_query($connection, $aggiornaPassword)) {
                            ?>
                            <h2 class="title">Successo</h2>
                            <h3 class="success">La password è stata aggiornata.</h3>
                            <input type="button" id="registerButton" class="btn" value="Accedi">
                            <script>
                                document.getElementById("registerButton").addEventListener("click", function () {
                                    window.location.href = "../login/loginForm.php";
                                });
                            </script>
                            <?php
                        } else {
                            ?>
                            <h2 class="title">Errore</h2>
                            <h5 class="error">La password non è stata aggiornata.</h5>
                            <input type="button" id="registerButton" class="btn" value="Riprova">
                            <script>
                                document.getElementById("registerButton").addEventListener("click", function () {
                                    window.location.href = "resetpswForm.php";
                                });
                            </script>
                            <?php
                        }
                    }
                }

                mysqli_close($connection);
                ?>
            </div>

        </div>
    </div>
    <script type="text/javascript" src="../js/form.js"></script>
</body>

</html>
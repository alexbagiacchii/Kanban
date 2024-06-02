<!DOCTYPE html>
<html>

<head>
    <title>KanBoard - Login</title>
    <link rel="stylesheet" type="text/css" href="../css/form.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../img/logo.png">
</head>

<body>
    <img class="wave" src="../img/sfondo.png">
    <div class="container">
        <div class="img">
            <img src="../img/bg.svg">
        </div>
        <div class="login-content">
            <form action="" method="post" id="registrationForm">
                <img src="../img/avatar.svg">
                <h2 class="title">Registrati</h2>
                <?php

                require_once '../config.php';

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
                            ?>
                            <h4 class="error">Username già esistente.</h4>
                            <?php
                        }
                    } else {
                        $registraUtente = "INSERT INTO utenti (username, nome, cognome, password) VALUES ('$username', '$nome', '$cognome', '$password')";

                        if (mysqli_query($connection, $registraUtente)) {
                            ?>
                            <h4 class="success">Registrazione completata.</h4>
                            <input type="button" id="registerButton" class="btn" value="Accedi">
                            <script>
                                document.getElementById("registerButton").addEventListener("click", function () {
                                    window.location.href = "../login/login.php";
                                });
                            </script>
                            <?php
                            $registrationForm = true;
                        } else {
                            ?>
                            <h4 class="error">C'è stato un problema durante la registrazione.</h4>
                            <?php
                        }
                    }
                }

                mysqli_close($connection);
                ?>
                <div id="formRegistrazione">
                    <div class="input-div one">
                        <div class="i">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="div">
                            <h5>Username</h5>
                            <input type="text" class="input" name="username" required>
                        </div>
                    </div>
                    <div class="input-div">
                        <div class="i">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="div">
                            <h5>Nome</h5>
                            <input type="text" class="input" name="nome" required>
                        </div>
                    </div>
                    <div class="input-div">
                        <div class="i">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="div">
                            <h5>Cognome</h5>
                            <input type="text" class="input" name="cognome" required>
                        </div>
                    </div>
                    <div class="input-div pass">
                        <div class="i">
                            <i class="fas fa-lock"></i>
                        </div>
                        <div class="div">
                            <h5>Password</h5>
                            <input type="password" class="input" name="password" required>
                        </div>
                    </div>
                    <div class="links-container">
                        <a href="../login/login.php">Accedi</a>
                    </div>
                    <input type="submit" class="btn" value="Registrati">
                </div>
        </div>
        </form>
    </div>
    </div>
    <script type="text/javascript" src="../js/form.js"></script>
    <?php
    if ($registrationForm == true) {
        ?>
        <script>
            document.getElementById('formRegistrazione').style.display = "none";
        </script>
        <?php
    }
    ?>
</body>

</html>
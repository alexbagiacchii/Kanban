<!DOCTYPE html>
<html>

<head>
	<title>KanBoard - Login</title>
	<link rel="stylesheet" type="text/css" href="css/form.css">
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
	<img class="wave" src="img/wave.png">
	<div class="container">
		<div class="img">
			<img src="img/bg.svg">
		</div>
		<div class="login-content">
			<form action="index.html">
				<img src="img/avatar.svg">
				<h2 class="title">Ciao</h2>
				<div class="input-div one">
					<div class="i">
						<i class="fas fa-user"></i>
					</div>
					<div class="div">
						<h5>Username</h5>
						<input type="text" class="input">
					</div>
				</div>
				<div class="input-div pass">
					<div class="i">
						<i class="fas fa-lock"></i>
					</div>
					<div class="div">
						<h5>Password</h5>
						<input type="password" class="input">
					</div>
				</div>
				<?php
    require_once '../private/config.php';
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["username"]) && isset($_POST["password"])) {
            $username = $_POST["username"];
            $password = $_POST["password"];

            $connection = @mysqli_connect(host, username, password, db_name);
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
                $login = "SELECT username, password FROM utenti WHERE username = '$username' AND password = '$password'";
                $risultatoLogin = mysqli_query($connection, $login);

                if (!$risultatoLogin) {
                    die("Query fallita: " . mysqli_error($connection));
                }

                if (mysqli_num_rows($risultatoLogin) > 0) {
                    $_SESSION["autenticato"] = true;
                    $scadenza = time() + 3600;
                    setcookie("username", $username, $scadenza, "/");
                    header("Location: ../public/home.php");
                    exit();
                } else {
                    echo "Credenziali errate. Riprova.";
                }
            }
            mysqli_close($connection);
        } else {
            echo "Errore: Inserire sia username che password.";
        }
    }
    ?>
				<div class="links-container">
					<a href="register.html">Registrati</a>
					<a href="#">Password dimenticata?</a>
				</div>
				<input type="submit" class="btn" value="Login">
			</form>
		</div>
	</div>
	<script type="text/javascript" src="../private/login.js"></script>
</body>

</html>
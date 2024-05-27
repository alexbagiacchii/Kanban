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
			<form action="" method="post">
				<img src="../img/avatar.svg">
				<h2 class="title">Ciao</h2>
				<?php
				require_once '../config.php';
				session_start();

				if ($_SERVER["REQUEST_METHOD"] == "POST") {
					if (isset($_POST["username"]) && isset($_POST["password"])) {
						$username = $_POST["username"];
						$password = $_POST["password"];

						$connection = @mysqli_connect(host, username, password, db_name);
						if (!$connection) {
							die("Connessione al database fallita: " . mysqli_connect_error());
						}
						$login = "SELECT username, password FROM utenti WHERE username = '$username' AND password = '$password'";
						$risultatoLogin = mysqli_query($connection, $login);

						if (mysqli_num_rows($risultatoLogin) > 0) {
							$_SESSION["autenticato"] = true;
							$scadenza = time() + 3600;
							setcookie("username", $username, $scadenza, "/");
							header("Location: ../kanban/home.php");
							exit();
						} else {
							?>
							<h4 class="error">Username e/o Password errati.</h4>
							<?php
						}
					}
					mysqli_close($connection);
				}
				?>
				<div class="input-div one">
					<div class="i">
						<i class="fas fa-user"></i>
					</div>
					<div class="div">
						<h5>Username</h5>
						<input type="text" class="input" name="username" required>
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
					<a href="../register/registerForm.php">Registrati</a>
					<a href="../resetpsw/resetpswForm.php">Password dimenticata?</a>
				</div>
				<input type="submit" class="btn" value="Login">
			</form>
		</div>
	</div>
	<script type="text/javascript" src="../js/form.js"></script>
</body>

</html>
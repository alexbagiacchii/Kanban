<!DOCTYPE html>
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
			<form id="reset-form">
				<img src="../img/avatar.svg">
				<h2 class="title">Reimposta</h2>
				<p id="error-message" style="display: none; color: red; padding-bottom: 15px;">Username inesistente</p>
				<div id="username-section">
					<div class="input-div one">
						<div class="i">
							<i class="fas fa-user"></i>
						</div>
						<div class="div">
							<h5>Username</h5>
							<input type="text" class="input" id="username" name="username">
						</div>
					</div>
				</div>
				<div id="password-section" style="display: none;">
					<div class="input-div pass">
						<div class="i">
							<i class="fas fa-lock"></i>
						</div>
						<div class="div">
							<h5>Nuova Password</h5>
							<input type="password" class="input" id="password" name="password">
						</div>
					</div>
				</div>
				<div class="links-container">
					<a href="../login/loginForm.php">Accedi</a>
					<a href="../register/registerForm.php">Registrati</a>
				</div>
				<div id="btnUsername">
					<button type="button" onclick="esisteUtente()" class="btn">Cerca</button>
				</div>
				<div id="btnPassword" style="display: none;">
					<button type="button" onclick="resetPassword()" class="btn">Reset</button>
				</div>
			</form>
		</div>
	</div>
	<script>
		async function esisteUtente() {
			var username = document.getElementById("username").value;
			const risposta = await fetch("check_user.php?username=" + username);
			const dati = await risposta.json();

			if (dati.esisteUtente) {
				document.getElementById("btnPassword").style.display = "block";
				document.getElementById("username-section").style.display = "none";
				document.getElementById("error-message").style.display = "none";
				document.getElementById("btnUsername").style.display = "none";
				document.getElementById("password-section").style.display = "block";
			} else {
				document.getElementById("error-message").style.display = "block";
				document.getElementById("password-section").style.display = "none";
			}
		}

		async function resetPassword() {
			var username = document.getElementById("username").value;
			var password = document.getElementById("password").value;

			if (!password) {
				alert("Inserire una password valida");
				return;
			}

			const form = document.getElementById("reset-form");
			form.setAttribute("method", "post");
			form.setAttribute("action", "resetpsw.php");

			const inputUsername = document.createElement("input");
			inputUsername.setAttribute("type", "hidden");
			inputUsername.setAttribute("name", "username");
			inputUsername.setAttribute("value", username);
			form.appendChild(inputUsername);

			const inputPassword = document.createElement("input");
			inputPassword.setAttribute("type", "hidden");
			inputPassword.setAttribute("name", "password");
			inputPassword.setAttribute("value", password);
			form.appendChild(inputPassword);

			form.submit();
		}
	</script>
	<script type="text/javascript" src="../js/form.js"></script>
</body>

</html>
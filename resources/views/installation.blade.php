<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Stallingrad - Installation</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->	
		<link rel="icon" type="image/png" href="/Installation/images/icons/favicon.ico"/>
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="/Installation/vendor/bootstrap/css/bootstrap.min.css">
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="/Installation/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="/Installation/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="/Installation/vendor/animate/animate.css">
	<!--===============================================================================================-->	
		<link rel="stylesheet" type="text/css" href="/Installation/vendor/css-hamburgers/hamburgers.min.css">
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="/Installation/vendor/select2/select2.min.css">
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="/Installation/css/util.css">
		<link rel="stylesheet" type="text/css" href="/Installation/css/main.css">
	<!--===============================================================================================-->
	</head>
	<body>
		<div class="limiter">
			<div class="container-login100">
				<div class="wrap-login100 p-t-190 p-b-30">
					<form id="form" class="login100-form validate-form" action="/setenv" method="POST">
						{{ csrf_field() }}
						<div class="login100-form-avatar">
							<img class="gameAvatarInstallation" src="/images/avatar2.jpg" alt="AVATAR" >
						</div>

						<span class="login100-form-title p-t-20 p-b-45">
							Installation du jeu
						</span>

						<div class="wrap-input100 validate-input m-b-10" data-validate = "Username is required">
							<input class="input100" type="text" name="username" placeholder="Nom d'administrateur de la base de données">
							<span class="focus-input100"></span>
							<span class="symbol-input100">
								<i class="fa fa-user"></i>
							</span>
						</div>

						<div class="wrap-input100 validate-input m-b-10" data-validate = "Password is required">
							<input class="input100" type="password" name="password" placeholder="Mot de passe de la base de données">
							<span class="focus-input100"></span>
							<span class="symbol-input100">
								<i class="fa fa-lock"></i>
							</span>
						</div>

						<div class="wrap-input100 validate-input m-b-10" data-validate = "This field is required">
							<input class="input100" type="text" name="name" placeholder="Nom de la base de données">
							<span class="focus-input100"></span>
							<span class="symbol-input100">
								<i class="fa fa-lock"></i>
							</span>
						</div>

						<div class="wrap-input100 validate-input m-b-10" data-validate = "This field is required">
							<input class="input100" type="text" name="prefix" placeholder="Préfixe">
							<span class="focus-input100"></span>
							<span class="symbol-input100">
								<i class="fa fa-lock"></i>
							</span>
						</div>

						<div class="container-login100-form-btn p-t-10">
							<button class="login100-form-btn" onclick="sendForm(); return false;">
								Installer
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		
	<!--===============================================================================================-->	
		<script src="/Installation/vendor/jquery/jquery-3.2.1.min.js"></script>
	<!--===============================================================================================-->
		<script src="/Installation/vendor/bootstrap/js/popper.js"></script>
		<script src="/Installation/vendor/bootstrap/js/bootstrap.min.js"></script>
	<!--===============================================================================================-->
		<script src="/Installation/vendor/select2/select2.min.js"></script>
	<!--===============================================================================================-->
		<script src="/Installation/js/main.js"></script>

		<script type="text/javascript">
			function sendForm() {
				document.getElementById("form").submit();
			}
		</script>

	</body>
</html>
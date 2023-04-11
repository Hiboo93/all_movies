
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body style="background-image: url('<?= URL ?>/public/Assets/images/backgroundimage.jpg')">
<img class="logo-allmovie" src="<?= URL ?>/public/Assets/images/allmovies.png"  alt="logo">

	<div class="container">
		<section>
			<div id="login-body">
				<h1>Login Administrateur</h1>
				<?php 
					if(!empty($_SESSION['alert'])) {
						foreach($_SESSION['alert'] as $alert){
							echo "<p class='alert ".$alert['type'] ."'role='alert'>
								".$alert['message']."
							</p>";
						}
						unset($_SESSION['alert']);
					}
                ?> 
				 
				<?php 
				if (!empty($_POST['login']) && !empty($_POST['password'])) {
					$login = htmlspecialchars($_POST['login']);
					$password = htmlspecialchars($_POST['password']);
				}
				?> 

				<form method="POST" action="<?= URL ?>validation_login_administrateur">
					<input id="login" type="text" name="login" placeholder="Votre login" required />
					<input type="password" name="password" placeholder="Mot de passe" required />
					<button type="submit">Connexion</button>
				</form>

				<p class="grey">Retour sur page login utilisateur ? <a id="creer" href="<?= URL ?>login">Cliquer ici</a></p>
				
			</div>
		</section>
	</div>
</body>
</html>
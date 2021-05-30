<?php

session_start();

if( isset($_SESSION['user_id']) ){
	header("Location: /projet/accueil.php");
}

require 'database.php';

if(!empty($_POST['email']) && !empty($_POST['password'])):
	
	$records = $conn->prepare('SELECT id,email,password FROM users WHERE email = :email');
	$records->bindParam(':email', $_POST['email']);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);

	$message = '';

	if(count($results) > 0 && password_verify($_POST['password'], $results['password']) ){

		$_SESSION['user_id'] = $results['id'];
		header("Location: /projet/accueil.php");

	} else {
		$message = 'Veuillez vérifiez vos identifiants';
	}

endif;

?>

<!DOCTYPE html>
<html>
<head>
	<title>Login Below</title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link href='http://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'>
</head>
<body>

	<div class="header">
		<a href="/projet/index.php">Spectacles Advisor</a>
	</div>

	<?php if(!empty($message)): ?>
		<p><?= $message ?></p>
	<?php endif; ?>

	<h1>Connexion</h1>
	<span><a href="register.php"> Vous n'avez pas encore de compte ?</a></span>

	<form action="login.php" method="POST">
		
		<input type="text" placeholder="Email" name="email">
		<input type="password" placeholder="Mot de passe" name="password">

		<input type="submit">

	</form>

</body>
</html>
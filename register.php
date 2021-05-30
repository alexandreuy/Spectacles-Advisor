<?php

session_start();

if(isset($_SESSION['user_id']) ){
	header("Location: /Projet/accueil.php");
}

require 'database.php';

$message = '';

if(!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['pseudo'])):
	

	$sql = "INSERT INTO users (email, password, pseudonym) VALUES (:email, :password, :pseudonym)";
	$stmt = $conn->prepare($sql);

	$stmt->bindParam(':email', $_POST['email']);
	$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
	$stmt->bindParam(':password', $password );
	$stmt->bindParam(':pseudonym', $_POST['pseudo'] );
 
	if( $stmt->execute() ):
		$message = 'Compte créé avec succès';
		$url ="http://localhost/Projet/accueil.php"; //here you set the url
		$time_out = 3; //here you set how many seconds to untill refresh
		header("refresh: $time_out; url=$url");
	else:
		$message = 'Il y a eu un problème avec la création de votre compte, réessayez.';
	endif;

endif;

?>

<!DOCTYPE html>
<html>
<head>
	<title>Register Below</title>
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

	<h1>Création de compte</h1>
	<span><a href="login.php">Vous avez déjà un compte ?</a></span>

	<form action="register.php" method="POST">
		
		<input type="text" placeholder="Email" name="email">
		<input type="text" placeholder="Pseudo" name="pseudo">
		<input type="password" placeholder="Mot de passe" name="password">
		<input type="password" placeholder="Confirmation de mot de passe" name="confirm_password">
		<input type="submit">

	</form>

</body>
</html>
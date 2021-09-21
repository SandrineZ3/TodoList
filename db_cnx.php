<?php 
// Connexion à la BDD
$mysqli = new mysqli("localhost", "root", "", "todolistdb");

// Vérifie la connexion
if ($mysqli->connect_errno) {
	echo "Impossible de se connecter à MySQL: " . $mysqli->connect_error;
	exit();
}
?>
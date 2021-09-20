<?php
// Initialise la variable $errors
$errors = "";

// Connexion à la BDD
$mysqli = new mysqli("localhost", "root", "", "todolistdb");

// Vérifie la connexion
if ($mysqli->connect_errno) {
	echo "Impossible de se connecter à MySQL: " . $mysqli->connect_error;
	exit();
}

// Ajoute des quotes à la tâche ajoutée -> Sécurité contre faille XSS
if (isset($_POST['submit'])) {
	if (empty($_POST['task'])) {
		$errors = "Ce champ ne peut pas être vide !";
	} else {
		$task = $_POST['task'];
		$addTask = "INSERT INTO tasks (task) VALUES ('$task')";
		$mysqli->query($addTask);
		header('location: index.php');
	}
}

// Supprime les tâches
if (isset($_GET['del_task'])) {
	$id = $_GET['del_task'];

	$deleteTask = "DELETE FROM tasks WHERE id=".$id;
	$mysqli->query($deleteTask);
	header('location: index.php');
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Todo-List en PHP</title>
</head>

<body>
	<div class="heading">
		<h1>Todo-List en PHP</h1>
	</div>
	<form method="post" action="index.php" class="form_input">

	<!-- Si le formulaire est vide, on affiche l'erreur -->
		<?php if (isset($errors)) { ?>
			<p><?php echo $errors; ?></p>
		<?php } ?>

		<input type="text" name="task" class="task_input">
		<button type="submit" name="submit" id="addTask" class="addTask">Ajouter une nouvelle tâche</button>
	</form>
	
	<!-- Tableau qui affiche toutes les tâches enregistrées en BDD -->
	<table>
	<thead>
		<tr>
			<th>Id</th>
			<th>Tâches</th>
			<th>Modifier/supprimer</th>
		</tr>
	</thead>

	<tbody>
		<?php 
		$showTasks = "SELECT * FROM tasks";
		$result = $mysqli->query($showTasks);

		$i = 1; 
		// Indique quel type de tableau sera retourné (num + string)
		while ($row = $result->fetch_array(MYSQLI_BOTH)) { ?>
			<tr>
				<td> <?php echo $i; ?> </td>
				<td class="task"> <?php echo $row['task']; ?> </td>
				<!-- Bouton "supprimer" -->
				<td class="delete"> 
					<a href="index.php?del_task=<?php echo $row['id'] ?>">Supprimer</a> 
				</td>
			</tr>
		<?php $i++; } ?>	
	</tbody>
</table>

</body>
</html>
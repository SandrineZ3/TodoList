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

	$deleteTask = "DELETE FROM tasks WHERE id=" . $id;
	$mysqli->query($deleteTask);
	header('location: index.php');
}

// en cours / ok
if (isset($_GET['updateState_task'])) {
	$id = $_GET['updateState_task'];

	$updateStateTask = "UPDATE tasks SET is_done = '1' WHERE id=" . $id;
	$mysqli->query($updateStateTask);
	header('location: index.php');
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="style.css" />
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Architects+Daughter&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
	<title>Todo-List en PHP</title>
</head>

<body>
	<div id="container">
		<h1>Todo-List en PHP</h1>
		<form method="post" action="index.php" id="form">

			<!-- Si le formulaire est vide, on affiche l'erreur -->
			<?php if (isset($errors)) { ?>
				<p><?php echo $errors; ?></p>
			<?php } ?>

			<p>Ajouter une nouvelle tâche :</p>
			<div id="inputArea">
				<input type="text" name="task" id="inputText" size="40">
				<button type="submit" name="submit" id="addTask">Ajouter !</button>
			</div>
		</form>
		<!-- Tableau qui affiche toutes les tâches enregistrées en BDD -->
		<table>
			<thead>
				<tr>
					<th>Statut</th>
					<th>Tâches</th>
					<th>Actions</th>
				</tr>
			</thead>

			<tbody>
				<?php
				$showTasks = "SELECT * FROM tasks";
				$result = $mysqli->query($showTasks);

				// Indique quel type de tableau sera retourné (num + string)
				while ($row = $result->fetch_array(MYSQLI_BOTH)) { ?>
					<tr>
						<!-- TODO : Faire les statuts en JS ??? -->
						<!-- Bouton "en cours / OK" -->
						<td class="actionButton">
							<a href="index.php?updateState_task=<?php echo $row['id'] ?>">
								<i class="fas fa-check-circle"></i>
								<i class="fas fa-times-circle"></i>
							</a>
						</td>

						<!-- Libellé de la tâche -->
						<td class="tasks"> <?php echo $row['task']; ?> </td>

						<!-- Bouton "supprimer" -->
						<td class="actionButton">
							<a href="index.php?del_task=<?php echo $row['id'] ?>">
								<i class="fas fa-trash-alt"></i>
							</a>

							<!-- TODO : Faire la fonctionnalité "modifier" -->
						<!-- Bouton "modifier" -->
						<i class="fas fa-edit"></i>
						
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
</body>

</html>
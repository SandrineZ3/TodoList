<?php
// Initialise la variable $errors
$errors = "";

// Si le formulaire a été soumis : vérification qu'il soit bien rempli
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
if (isset($_GET['delete_task'])) {
	$id = $_GET['delete_task'];

	$deleteTask = "DELETE FROM tasks WHERE id=" . $id;
	$mysqli->query($deleteTask);
	header('location: index.php');
}

// Change le statut de la tâche ("en cours" / "ok")
if (isset($_GET['updateState_task'])) {
	$id = $_GET['updateState_task'];

	$updateStateTask = "UPDATE tasks SET is_done = '1' WHERE id=" . $id;
	$mysqli->query($updateStateTask);
	header('location: index.php');
}
?>
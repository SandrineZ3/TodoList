<?php require_once './db_cnx.php'; ?>

<?php require './queries.php'; ?>

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
	<title>Todo-List simple en PHP</title>
</head>

<body>
	<div id="container">

		<h1>Todo-List en PHP</h1>

		<form method="post" action="index.php" id="form">
			<h2>Ajouter une nouvelle tâche :</h2>
			<div id="inputArea">
				<input type="text" name="task" id="inputText" size="40" maxlength="45">
				<button type="submit" name="submit" id="addTask">Ajouter !</button>
			</div>
			<!-- Si le formulaire est vide, on affiche l'erreur -->
			<?php if (isset($errors)) { ?>
				<p id="error"><?php echo $errors; ?></p>
			<?php } ?>
		</form>

		<!-- Tableau qui affiche toutes les tâches enregistrées en BDD -->
		<table>
			<thead>
				<tr>
					<th>Statut</th>
					<th>Tâches</th>
					<th>Supprimer</th>
				</tr>
			</thead>

			<tbody>
				<?php
				$showTasks = "SELECT * FROM tasks";
				$result = $mysqli->query($showTasks);
				// On boucle sur les résultats récupérés par SELECT
				// MYSQLI_BOTH indique quel type de tableau sera retourné (num + string)
				while ($row = $result->fetch_array(MYSQLI_BOTH)) { ?>
					<tr>

						<!-- Bouton unidirectionnel "en cours" / "OK" -->
						<td class="actionButton">
							<a href="index.php?updateState_task=<?php echo $row['id'] ?>">
								<?php
								if ($row['is_done']) {
									echo "<i class='fas fa-check-circle'></i>";
								} else {
									echo "<i class='fas fa-times-circle'></i>";
								}
								?>
							</a>
						</td>

						<!-- Libellé de la tâche -->
						<td class="tasks"> 
							<?php echo $row['task']; ?> 
						</td>

						<!-- Bouton "supprimer" -->
						<td class="actionButton">
							<a href="index.php?delete_task=<?php echo $row['id'] ?>" title="Supprimer la tâche">
								<i class="fas fa-trash-alt"></i>
							</a>
						</td>
					</tr>
				<!-- Fermeture de la boucle -->
				<?php } ?>
			</tbody>
		</table>
</body>
</html>
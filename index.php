<?php
$index = true; 

// Inclusion de fluxbb
ini_set('display_errors','Off');
define('PUN_ROOT', '../home/');
require PUN_ROOT.'include/common.php';


// Récupération et traitement des données
  // Configuration et connexion MySql
  require 'config.php';
  
  // Définition des variables
  $donnees = array();
  
  // Récupération des désignation
  $noms = $connexion->query("SELECT users.id,
	users.username,
	competences_categories.nom AS categorie,
	competences_designation.designation,
	competences_users.note,
	competences_users.commentaire
	FROM `competences_users`
	RIGHT JOIN `users` ON users.id=competences_users.users_id
	LEFT JOIN `competences_designation` ON competences_designation.id=competences_users.designation_id
	LEFT JOIN `competences_categories` ON competences_categories.id=competences_designation.categories_id
	WHERE users.id != 1
	ORDER BY users.id,competences_categories.nom ASC"); // Récupération des infos
  $noms->setFetchMode(PDO::FETCH_OBJ); // Transformation en objet
  $donnees = $noms->fetchAll(); // Traitement de l'objet
  $noms->closeCursor(); // Fermeture
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<title>Compétences</title>
<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="js/jquery.dataTables.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.2.custom.min.js"></script>
<link rel="stylesheet" href="css/hot-sneaks/jquery-ui-1.8.2.custom.css" type="text/css" media="screen" />
<style type="text/css" media="screen">
table {
	width: 100%;
}
tr.odd {
	background-color: #E2E4FF;
}
</style>
</head>
<body>
<div id="container">
	<ul>
		<? if ($pun_user['is_guest']): ?>
			<li><a href="login.php" title="Connexion">Connectez-vous pour ajouter ou modifier vos compétences.<a></li>
		<? endif; ?>
		<? if ($pun_user['group_id'] == 1 || $pun_user['group_id'] == 2 || $pun_user['group_id'] == 11): ?>
			<li><a href="categorie.php" title="Catégories">Gérer les catégories</a></li>
			<li><a href="designation.php" title="Désignations">Gérer les désignations</a></li>
		<? endif; ?>
	</ul>
<table id="competences">
	<thead>
		<tr>
			<th>Username</th>
			<th>Catégorie</th>
			<th>Désignation</th>
			<th>Note</th>
			<th>Commentaire</th>
		</tr>
	</thead>
	<tbody>
	<? foreach ($donnees as $i) : ?>
		<tr>
			<td><?= $i->username ?></td>
			<td><?= $i->categorie ?></td>
			<td><?= $i->designation ?></td>
			<td><?= $i->note ?></td>
			<td><?= $i->commentaire ?></td>
		</tr>
	<? endforeach; ?>
	</tbody>
</table>
</div>
<script type="text/javascript">
	$(document).ready( function() {
		$('#competences').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"oLanguage": {
				"sUrl": "js/french.txt"
			}
		});
	});
</script>
</body>
</html>

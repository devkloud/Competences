<?php
// Redéfinition des variables
$donnees = array();
$cat_indent = 0;

// Récupération et traitement des données
$index = true;
require_once ('data.php');
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
<table id="competences">
	<thead>
		<tr>
			<th>ID</th>
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
			<td><?= $i->id ?></td>
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

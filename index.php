<?php
// Redéfinition des variables
$donnees = array();
$cat_indent	 = 0;

// Récupération et traitement des données
$index = true;
require_once ('data.php');
?>
 <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <title>Compétences</title>
    </head>
    <body>
        <div id="container">
        	<table>
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
        			<?= foreach ($donnees as $i) : ?>
        			<tr>
        				<td><?= $i->id ?></td>
        				<td><?= $i->username ?></td>
        				<td><?= $i->categorie ?></td>
        				<td><?= $i->designation ?></td>
        				<td><?= $i->note ?></td>
        				<td><?= $i->commentaire ?></td>
        			</tr>
        			<?= endforeach; ?>
        		</tbody>
        	</table>
        </div>
    </body>
</html>

<?php
$index = true;

// Inclusion de fluxbb
define('PUN_ROOT', '../home/');
require PUN_ROOT.'include/common.php';

if ($pun_user['is_guest'] == 1) { // L'utilisateur n'est pas connecté
	header('Location: login.php');
} else {
	// Configuration et connexion MySql
	require_once('config.php');
	
	// Définition des variables
	$donnees = array();
	
	// Récupération des compétences de l'utilisateur
	$noms = $connexion->query("SELECT competences_categories.nom AS categorie,
	competences_designation.designation,
	competences_users.note,
	competences_users.commentaire
	FROM competences_users
	RIGHT JOIN users ON users.id=competences_users.users_id
	LEFT JOIN competences_designation ON competences_designation.id=competences_users.designation_id
	LEFT JOIN competences_categories ON competences_categories.id=competences_designation.categories_id
	WHERE users.id = ".$connexion->quote($pun_user['id'], PDO::PARAM_INT)."
	ORDER BY competences_categories.nom, competences_designation.designation ASC"); // Récupération des infos
	$noms->setFetchMode(PDO::FETCH_OBJ); // Transformation en objet
	$donnees = $noms->fetchAll(); // Traitement de l'objet
	$noms->closeCursor(); // Fermeture
?>
 <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <title>Gestion des compétences</title>
    </head>
    <body>
        <div id="container">
        	<pre><?php print_r($donnees); ?></pre>
        </div>
    </body>
</html>
<?php } ?>

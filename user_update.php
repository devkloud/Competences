<?php
$index = true;

// Inclusion de fluxbb
define('PUN_ROOT', '../home/');
require PUN_ROOT.'include/common.php';

if ($pun_user['is_guest'] == 1) { // L'utilisateur n'est pas connecté
    header('Location: login.php');
} elseif (isset($_POST['submit'])) {
    // Configuration et connexion MySql
    require_once ('config.php');

	// Définition des variables
	$donnees = array();
	
	// Récupération des désignation
	$noms = $connexion->query("SELECT competences_categories.nom AS categorie,
	competences_designation.designation,
	competences_users.note,
	competences_users.commentaire
	FROM `competences_users`
	LEFT JOIN `competences_designation` ON competences_designation.id=competences_users.designation_id
	LEFT JOIN `competences_categories` ON competences_categories.id=competences_designation.categories_id"); // Récupération des infos
	$noms->setFetchMode(PDO::FETCH_OBJ); // Transformation en objet
	$donnees = $noms->fetchAll(); // Traitement de l'objet
	$noms->closeCursor(); // Fermeture
?>
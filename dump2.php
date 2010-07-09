<?php

// Configuration et connexion MySql
$index = true;
require_once('config.php');

// Définition des variables
$donnees = array();

// Récupération des désignation
$noms = $connexion->query("SELECT users.id,
	users.username,
	competences_categories.nom AS categorie,
	competences_designation.designation,
	competences_users.note,
	competences_users.commentaire
	FROM competences_users
	RIGHT JOIN users ON users.id=competences_users.users_id
	LEFT JOIN competences_designation ON competences_designation.id=competences_users.designation_id
	LEFT JOIN competences_categories ON competences_categories.id=competences_designation.categories_id
	ORDER BY users.id,competences_categories.nom ASC
"); // Récupération des infos
$noms->setFetchMode(PDO::FETCH_OBJ); // Transformation en objet
$donnees = $noms->fetchAll(); // Traitement de l'objet
$noms->closeCursor(); // Fermeture

// Dump
echo '<pre>';
print_r($donnees);
echo '</pre>';
?>
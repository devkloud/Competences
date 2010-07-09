<?php
// Pas d'accès direct
if (!isset($index)) {
	die();
} else {
	// Configuration et connexion MySql
	require_once('config.php');
	
	// Définition des variables
	$designation = array();
	$categorie   = array();
	$valeur		 = array();
	$user		 = array();
	$nbr_des	 = 0;
	
	// Récupération des désignations et leur nombre
	$noms = $connexion->query("SELECT * FROM competences_designation ORDER BY id ASC"); // Récupération des infos
	$noms->setFetchMode(PDO::FETCH_OBJ); // Transformation en objet
	while($ligne = $noms->fetch()) // Traitement de l'objet
	{
	        $designation[$ligne->id] = array('categories_id' => $ligne->categories_id,
											 'designation'   => $ligne->designation
											 );
			$nbr_des++;
	}
	$noms->closeCursor(); // Fermeture
	
	// Récupération des catégories
	$noms = $connexion->query("SELECT * FROM competences_categories ORDER BY id ASC"); // Récupération des infos
	$noms->setFetchMode(PDO::FETCH_OBJ); // Transformation en objet
	while($ligne = $noms->fetch()) // Traitement de l'objet
	{
	        $categorie[$ligne->id] = array('nom' => $ligne->nom);
	}
	$noms->closeCursor(); // Fermeture
	
	// Récupération des valeurs
	$noms = $connexion->query("SELECT * FROM competences_users ORDER BY users_id ASC"); // Récupération des infos
	$noms->setFetchMode(PDO::FETCH_OBJ); // Transformation en objet
	while($ligne = $noms->fetch()) // Traitement de l'objet
	{
	        $valeur[$ligne->id] = array('users_id' => $ligne->users_id,
										'designation_id' => $ligne->designation_id,
										'note' => $ligne->note,
										'commentaire' => $ligne->commentaire
										);
	}
	$noms->closeCursor(); // Fermeture
	
	// Récupération des users
	$noms = $connexion->query("SELECT * FROM users ORDER BY id ASC"); // Récupération des infos
	$noms->setFetchMode(PDO::FETCH_OBJ); // Transformation en objet
	while($ligne = $noms->fetch()) // Traitement de l'objet
	{
	        $user[$ligne->id] = array('username' => $ligne->username);
	}
	$noms->closeCursor(); // Fermeture
}
?>
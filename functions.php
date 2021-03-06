<?php
/**
 * Vérifie si il y a un commentaire pour la désignation spécifiée dans les données utilisateur
 * @param string $designation
 * @return string $commentaire
 */
function commentaire($des) {
    global $user;
    foreach ($user as $d) {
        if ($d->designation == $des && $d->commentaire != FALSE) {
            return ($d->commentaire);
        }
    }
}

/**
 * Vérifie si il y a une note pour la désignation spécifiée dans les données utilisateur
 * @param string $designation
 * @return string $note
 */
function note($des) {
    global $user;
    foreach ($user as $d) {
        if ($d->designation == $des && $d->note != FALSE) {
            return ($d->note);
        }
    }
}

/**
 * Envoi des données utilisateur en base de données
 * @param array $donnees
 */
function update_user($donnees) {
    global $connexion;
    foreach ($donnees as $d) {
    	$sql="SELECT COUNT(*) FROM `competences_users` 
			  WHERE users_id=".$connexion->quote($d['user'], PDO::PARAM_INT)." 
			  AND designation_id=".$connexion->quote($d['designation'], PDO::PARAM_INT);
		$array=$connexion->query($sql)->fetch();
		if ($array[0] > 0) {
			if ($d['note'] == 0) {
				$sql="DELETE FROM `competences_users` WHERE users_id=".$connexion->quote($d['user'], PDO::PARAM_INT)." AND designation_id=".$connexion->quote($d['designation'], PDO::PARAM_INT);
				$connexion->exec($sql);
			} else {
	    		$sql="UPDATE `competences_users` SET note=".$connexion->quote($d['note'], PDO::PARAM_INT).", commentaire=".$connexion->quote($d['commentaire'], PDO::PARAM_STR)." WHERE users_id=".$connexion->quote($d['user'], PDO::PARAM_INT)." AND designation_id=".$connexion->quote($d['designation'], PDO::PARAM_INT);
				$connexion->query($sql);
			}
		} else {
			if ($d['note'] > 0) {
				$sql="INSERT INTO `competences_users`(users_id, designation_id, note, commentaire) VALUES(".$connexion->quote($d['user'], PDO::PARAM_INT).", ".$connexion->quote($d['designation'], PDO::PARAM_INT).", ".$connexion->quote($d['note'], PDO::PARAM_INT).", ".$connexion->quote($d['commentaire'], PDO::PARAM_STR).")";
				$connexion->exec($sql);
			}
        }
    }
}
?>

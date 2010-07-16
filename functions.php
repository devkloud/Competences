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
 * @return array $errors
 */
function update_user($donnees) {
    global $connexion;
    $errors = array();
    foreach ($donnees as $d) {
        try {
            $update = $connexion->exec("UPDATE `competences_users`(users_id, designation_id, note, commentaire) 
										VALUES(".$connexion->quote($d['user'], PDO::PARAM_INT).", 
										".$connexion->quote($d['designation'], PDO::PARAM_INT).", 
										".$connexion->quote($d['note'], PDO::PARAM_INT).", 
										'".$connexion->quote($d['commentaire'], PDO::PARAM_STR)."'
										)");
        }
        catch(Exception $e) {
            $errors[] = array($e->getMessage()=>$e->getCode());
        }
        if ($update == 0) {
            try {
                $create = $connexion->exec("INSERT INTO `competences_users`(users_id, designation_id, note, commentaire) 
											VALUES(".$connexion->quote($d['user'], PDO::PARAM_INT).", 
											".$connexion->quote($d['designation'], PDO::PARAM_INT).", 
											".$connexion->quote($d['note'], PDO::PARAM_INT).", 
											'".$connexion->quote($d['commentaire'], PDO::PARAM_STR)."'
											)");
            }
            catch(Exception $e) {
                $errors[] = array($e->getMessage()=>$e->getCode());
            }
        }
    }
    return ($errors);
}
?>

<?php
/**
 * Vérifie si il y a un commentaire pour la désignation spécifiée dans les données utilisateur
 * @param string $designation
 * @param array $donnees
 * @return string $commentaire
 */
function commentaire($des, $donnees) {
    foreach ($donnees as $d) {
        if ($d->designation == $des && $d->commentaire != FALSE) {
            return ($d->commentaire);
        }
    }
}

/**
 * Vérifie si il y a une note pour la désignation spécifiée dans les données utilisateur
 * @param string $designation
 * @param array $donnees
 * @return string $note
 */
function note($des, $donnees) {
    foreach ($donnees as $d) {
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
        $update = $connexion->prepare("UPDATE `competences_users`(users_id, designation_id, note, commentaire) VALUES(':user', ':designation', ':note', ':commentaire')");
        $update->bindParam(':user', $d['user'], PDO::PARAM_INT);
        $update->bindParam(':designation', $d['designation'], PDO::PARAM_INT);
        $update->bindParam(':note', $d['note'], PDO::PARAM_INT);
        $update->bindParam(':commentaire', $d['commentaire'], PDO::PARAM_STR);
        if ($update->execute()) {
            $update->closeCursor();
        } else {
            $update->closeCursor();
            $create = $connexion->prepare("INSERT INTO `competences_users`(users_id, designation_id, note, commentaire) VALUES(':user', ':designation', ':note', ':commentaire')");
            $create->bindParam(':user', $d['user'], PDO::PARAM_INT);
            $create->bindParam(':designation', $d['designation'], PDO::PARAM_INT);
            $create->bindParam(':note', $d['note'], PDO::PARAM_INT);
            $create->bindParam(':commentaire', $d['commentaire'], PDO::PARAM_STR);
            $create->execute();
            $create->closeCursor();
        }
    }
}
?>

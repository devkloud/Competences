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
			return($d->commentaire);
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
			return($d->note);
		}
	}
}
?>
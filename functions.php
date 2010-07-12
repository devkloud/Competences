<?php

/**
 * Vérifie si il y a un commentaire pour la désignation spécifiée dans les données utilisateur
 * @param string $des
 * @param array $donnees
 * @return string $commentaire
 */
function commentaire($des, $donnees) {
	foreach ($donnees as $d) {
		if ($d->designation == $des) {
			return($commentaire);
		}
	}
}
?>
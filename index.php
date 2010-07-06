<?php
// Redéfinition des variables
$designation = array();
$categorie 	 = array();
$valeur 	 = array();
$user 		 = array();
$nbr_des 	 = 0;

// Récupération et traitement des données
$index = true;
require_once ('data.php');
?>
 <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <title>Compétences</title>
<!-- Plugin Star rating pour un meilleur rendu visuel -->
        <script src="http://jquery.com/src/jquery-latest.js">
        </script>
        <script src='http://jquery-star-rating-plugin.googlecode.com/svn/trunk/jquery.rating.js' type="text/javascript" language="javascript">
        </script>
        <link href='http://jquery-star-rating-plugin.googlecode.com/svn/trunk/jquery.rating.css' type="text/css" rel="stylesheet"/>
<!-- End Star rating -->
    </head>
    <body>
        <div id="container">
            <?php
            // Début de la boucle de listing des catégories
            for ($nbr = 0; $nbr <= $nbr_des; $nbr++) {
                if ($categorie[$nbr]) { // Si la catégorie existe
                	if ($nbr !=0) { // si ce n'est pas la première affichée ...
                		echo '</fieldset>'; // on ferme le fieldset précédemment ouvert
					}
                    echo '<h1>'.$categorie[$nbr]['nom'].'</h1>'; // Titre de la catégorie
                    foreach ($valeur as $v) { // Listing des notes
                        if ($designation[$v['designation_id']]['categories_id'] == $nbr) { // Si la catégorie contenant la désignation est la bonne
                            if ($designation[$v['designation_id']]['designation'] != $prec) { // La désignation n'est plus la même
                                echo '</fieldset><fieldset title="'.$designation[$v['designation_id']]['designation'].'"><legend>'.$designation[$v['designation_id']]['designation'].'</legend>'; // Donc on commence un nouveau fieldset
                            }
                            echo '<label>'.$user[$v['users_id']]['username']; // Affichge du nom de l'utilisateur correspondant à la note et la désignation
                            for ($note = 1; $note < 6; $note++) { // Boucle d'affichage de la note
                                if ($note == $v['note']) { // Si on a atteint la note donnée on met checked
                                    echo '<input name="'.$user[$v['users_id']]['username'].'.'.$designation[$v['designation_id']]['designation'].'" type="radio" value="'.$note.'" class="star" disabled="disabled" checked="checked" />';
                                } else { // sinon on le met pas
                                    echo '<input name="'.$user[$v['users_id']]['username'].'.'.$designation[$v['designation_id']]['designation'].'" type="radio" value="'.$note.'" class="star" disabled="disabled" />';
                                }
                            }
                            if ($v['commentaire'] != NULL) { // Si un commentaire est défini on l'affiche
                                echo ' ('.$v['commentaire'].')';
                            }
                            echo '</label><br />'; // On referme le label de l'utilisateur
                        }
                        $prec = $designation[$v['designation_id']]['designation']; // on définit la vraible prec pour savoir quand on aura changé
                    }
                }
            }
            ?>
        </div>
    </body>
</html>

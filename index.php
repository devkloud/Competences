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
        <script src="http://jquery.com/src/jquery-latest.js">
        </script>
        <script src='http://jquery-star-rating-plugin.googlecode.com/svn/trunk/jquery.rating.js' type="text/javascript" language="javascript">
        </script>
        <link href='http://jquery-star-rating-plugin.googlecode.com/svn/trunk/jquery.rating.css' type="text/css" rel="stylesheet"/>
    </head>
    <body>
        <div id="container">
            <?php
            for ($nbr = 0; $nbr <= $nbr_des; $nbr++) {
                if ($categorie[$nbr]) {
                	if ($nbr !=0) {
                		echo '</fieldset>';
					}
                    echo '<h1>'.$categorie[$nbr]['nom'].'</h1>';
                    foreach ($valeur as $v) {
                        if ($designation[$v['designation_id']]['categories_id'] == $nbr) {
                            if ($designation[$v['designation_id']]['designation'] != $prec) {
                                echo '</fieldset><fieldset title="'.$designation[$v['designation_id']]['designation'].'"><legend>'.$designation[$v['designation_id']]['designation'].'</legend>';
                            }
                            echo '<label>'.$user[$v['users_id']]['username'];
                            for ($note = 1; $note < 6; $note++) {
                                if ($note == $v['note']) {
                                    echo '<input name="'.$user[$v['users_id']]['username'].'.'.$designation[$v['designation_id']]['designation'].'" type="radio" value="'.$note.'" class="star" disabled="disabled" checked="checked" />';
                                } else {
                                    echo '<input name="'.$user[$v['users_id']]['username'].'.'.$designation[$v['designation_id']]['designation'].'" type="radio" value="'.$note.'" class="star" disabled="disabled" />';
                                }
                            }
                            if ($v['commentaire'] != NULL) {
                                echo ' ('.$v['commentaire'].')';
                            }
                            echo '</label><br />';
                        }
                        $prec = $designation[$v['designation_id']]['designation'];
                    }
                }
            }
            ?>
        </div>
    </body>
</html>

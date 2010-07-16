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
    $user = array();
    
    // Récupération des compétences de l'utilisateur
    $noms = $connexion->query("SELECT users.id,
	competences_categories.nom AS categorie,
	competences_designation.designation,
	competences_users.note,
	competences_users.commentaire
	FROM `competences_users`
	RIGHT JOIN `users` ON users.id=competences_users.users_id
	LEFT JOIN `competences_designation` ON competences_designation.id=competences_users.designation_id
	LEFT JOIN `competences_categories` ON competences_categories.id=competences_designation.categories_id
	WHERE users.id = ".$connexion->quote($pun_user['id'], PDO::PARAM_INT)."
	ORDER BY competences_categories.nom, competences_designation.designation ASC"); // Récupération des infos de l'utilisateur
    $noms->setFetchMode(PDO::FETCH_OBJ); // Transformation en objet
    $user = $noms->fetchAll(); // Traitement de l'objet
    $noms->closeCursor(); // Fermeture
    
    // Récupération des désignations/catégories
    $noms = $connexion->query("SELECT competences_categories.nom AS categorie,
	competences_designation.designation
	FROM `competences_designation`
	LEFT JOIN `competences_categories` ON competences_categories.id=competences_designation.categories_id
	ORDER BY competences_categories.nom, competences_designation.designation ASC"); // Récupération des infos
    $noms->setFetchMode(PDO::FETCH_OBJ); // Transformation en objet
    $donnees = $noms->fetchAll(); // Traitement de l'objet
    $noms->closeCursor(); // Fermeture
    
    // Récupération des désignation
    $noms = $connexion->query("SELECT competences_designation.id,
	competences_designation.designation
	FROM `competences_designation`
	ORDER BY competences_designation.id ASC"); // Récupération des infos
    $noms->setFetchMode(PDO::FETCH_OBJ); // Transformation en objet
    $designations = $noms->fetchAll(); // Traitement de l'objet
    $noms->closeCursor(); // Fermeture
    
    require ('functions.php');
    
    // Création du tableau des donnees
    $post = array();
    foreach ($designations as $d) {
        if (isset($_POST[$d->designation])) {
            $post[] = array('user'=>$pun_user['id'], 'designation'=>$d->id, 'note'=>$_POST[$d->designation], 'commentaire'=>$_POST[$d->designation.'_commentaire']);
        } else {
            $post[] = array('user'=>$pun_user['id'], 'designation'=>$d->id, 'note'=>0, 'commentaire'=>$_POST[$d->designation.'_commentaire']);
        }
    }
    
    // Envoi en bdd et récupération du nombre d'erreurs
    $prb = update_user($post);
    
?>
 <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <title>Gestion des compétences</title>
        <script src='js/jquery-1.4.2.min.js' type="text/javascript" language="javascript">
        </script>
        <script src='js/jquery.rating.js' type="text/javascript" language="javascript">
        </script>
        <link href='css/jquery.rating.css' type="text/css" rel="stylesheet"/>
    </head>
    <body>
        <div id="container">
			<pre><?= print_r($prb) ?></pre>
			<pre><?= print_r($post) ?></pre>
			<? foreach ($donnees as $d): ?>
	        <? if (isset($cat) && $cat != $d->categorie): //Gestion des catégories ?>
	        	</table>
			</fieldset>
			<fieldset>
				<legend>
	            <?= $d->categorie?>
			    </legend>
	        	<table>
	            <? elseif (!isset($cat)): ?>
			<fieldset>
				<legend>
	                    <?= $d->categorie?>
	       		</legend>
	       		<table>
			<?endif ; //endGestion des catégories ?>
					<tr>
                        <td>
                            <?= $d->designation?>
                        </td>
                        <td>
                            <? for ($i = 1; $i < 6; $i++): ?>
                            <input type="radio" name="<?= $d->designation ?>" value="<?= $i ?>" class="star" disabled="true"
                            <? if ($i == $_POST[$d->designation]): ?>
 checked="checked"
                            <? endif; ?>
                            />
                            <? endfor; ?>
                        </td>
                        <td>
                            <input type="text" name="<?= $d->designation.'.commentaire' ?>" disabled="true"
                            <? if ($_POST[$d->designation.'_commentaire']): ?>
 value="<?= $_POST[$d->designation.'_commentaire'] ?>"
                            <? endif; ?>
                            />
                        </td>
					</tr>
                    <? $cat = $d->categorie; ?>
			<? endforeach; ?>
                </table>
            </fieldset>
		</div>
	</body>
</html>
<?php } ?>

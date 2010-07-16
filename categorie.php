<?php
if (isset($_GET['a'])) {
    $action = $_GET['a'];
} else {
	$action='index';
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
$index = true;

// Inclusion de fluxbb
define('PUN_ROOT', '../home/');
require PUN_ROOT.'include/common.php';

require 'functions.php';

if ($pun_user['is_guest'] == 1) { // L'utilisateur n'est pas connecté
    header('Location: login.php');
    exit();
} elseif ($pun_user['group_id'] == 1 || $pun_user['group_id'] == 2 || $pun_user['group_id'] == 11) {
    // Configuration et connexion MySql
    require_once ('config.php');
    
    $sql = "SELECT * FROM competences_categories ORDER BY competences_categories.nom ASC";
    $query = $connexion->query($sql);
    $categories = $query->fetchAll(PDO::FETCH_OBJ);
    $query->closeCursor();
	
/* Création d'une catégorie */
if ($action == 'new' && isset($_POST['submit']) && isset($_POST['cat'])) {
	$cat=$connexion->quote($_POST['cat'], PDO::PARAM_STR);
	$sql = "INSERT INTO `competences_categories` (nom) VALUES(".$cat.")";
	if ($connexion->exec($sql)) {
		$created = TRUE;
	} else {
		$created = FALSE;
	}
}

/* Suppresion d'une catégorie */
if ($action == 'delete' && isset($id)) {
	$id=$connexion->quote($id, PDO::PARAM_INT);
	$sql="SELECT * FROM competences_categories WHERE id=".$id." ORDER BY competences_categories.nom ASC";
	$query=$connexion->query($sql);
	$cat=$query->fetchAll(PDO::FETCH_ASSOC);
	if (isset($cat[0])) {
		$sql = "DELETE FROM `competences_categories` WHERE id=".$id;
		if ($connexion->exec($sql)) {
			$deleted = TRUE;
		} else {
			$deleted = FALSE;
		}
	} else {
		$deleted = FALSE;
	}
}

?>
 <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <title>Gestion des catégories</title>
    </head>
    <body>
        <div id="container">
            <? if ($action == 'index'): ?>
            <a href="?a=new">Nouvelle catégorie</a>
            <table id="categories">
                <thead>
                    <tr>
                        <th>
                            Catégorie
                        </th>
                        <th>
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <? foreach ($categories as $cat): ?>
                    <tr>
                        <td>
                            <?= $cat->nom?>
                        </td>
                        <td>
                            <a href="?a=delete&id=<?= $cat->id ?>">Delete</a>&nbsp;<a href="?a=edit&id=<?= $cat->id ?>">Edit</a>
                        </td>
                    </tr>
                    <? endforeach; ?>
                </tbody>
            </table>
            <? elseif ($action == 'delete' && isset($deleted)): ?>
				<? if($deleted == TRUE): ?>
				<p>La catégorie <?= $cat[0]['nom'] ?> à bien été supprimée !</p>
				<? else: ?>
				<p>La catégorie n'a pas été supprimée !</p>
				<? endif; ?>
            <? elseif ($action == 'new'): ?>
				<? if (isset($created) && $created==TRUE):?>
				<p>La catégorie <?= $cat ?> à bien été crée !</p>
				<? else: ?>
				<p>La catégorie <?= $cat ?> n'a pas été crée !</p>
				<? endif; ?>
			<form id="new" method="post">
				<fieldset>
					<legend>Nouvelle catégorie</legend>
					<input type="text" name="cat" />
					<input type="submit" name="submit" value="Créer" />
				</fieldset>
			</form>
			<a href="?a=index">Retour aux catégories</a>
            <? endif; ?>
        </div>
    </body>
</html>
<?php
}
else {
    exit('Vous n\'êtes pas autorisés à venir ici !');
}
?>

<?php
if (isset($_GET['a'])) {
    $action = $_GET['a'];
} else {
    $action = 'index';
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
    
    $sql = "SELECT competences_designation.id, 
			competences_designation.designation, 
			competences_designation.categories_id, 
			competences_categories.nom 
			FROM `competences_designation` 
			RIGHT JOIN `competences_categories` ON competences_categories.id=competences_designation.categories_id 
			ORDER BY competences_categories.nom ASC";
    $query = $connexion->query($sql);
    $designations = $query->fetchAll(PDO::FETCH_OBJ);
    $query->closeCursor();
    
    /* Création d'une désignation */
    if ($action == 'new' && isset($_POST['submit']) && isset($_POST['des']) && isset($_POST['cat'])) {
        $des = $connexion->quote($_POST['des'], PDO::PARAM_STR);
        $cat = $connexion->quote($_POST['cat'], PDO::PARAM_STR);
        $query = $connexion->query("SELECT id FROM `competences_categories` WHERE nom=".$cat);
        $id = $query->fetch();
        $query->closeCursor();
        $cid = $id[0];
        $sql = "INSERT INTO `competences_designation` (designation, categories_id) VALUES(".$des.", ".$cid.")";
        if ($connexion->exec($sql)) {
            $created = TRUE;
        } else {
            $created = FALSE;
        }
    } elseif ($action == 'new' && !isset($_POST['submit']) && !isset($_POST['des'])) {
        $sql = "SELECT nom FROM `competences_categories`";
        $query = $connexion->query($sql);
        $categories = $query->fetchAll(PDO::FETCH_ASSOC);
        $query->closeCursor();
    }
    
    /* Suppresion d'une désignation */
    if ($action == 'delete' && isset($id)) {
        $id = $connexion->quote($id, PDO::PARAM_INT);
        $sql = "SELECT * FROM competences_designation WHERE id=".$id;
        $query = $connexion->query($sql);
        $array = $query->fetchAll(PDO::FETCH_ASSOC);
        if (isset($array[0])) {
            $sql = "DELETE FROM `competences_designation` WHERE id=".$id;
            if ($connexion->exec($sql)) {
                $deleted = TRUE;
            } else {
                $deleted = FALSE;
            }
        } else {
            $deleted = FALSE;
        }
        $query->closeCursor();
    }
    
    /* Edition d'une désignation */
    if ($action == 'edit' && isset($id) && isset($_POST['submit']) && isset($_POST['des']) && isset($_POST['cat'])) {
        $des = $connexion->quote($_POST['des'], PDO::PARAM_STR);
        $did = $connexion->quote($id, PDO::PARAM_INT);
        
        $cat = $connexion->quote($_POST['cat'], PDO::PARAM_STR);
        $query = $connexion->query("SELECT id FROM `competences_categories` WHERE nom=".$cat);
        $id = $query->fetch();
        $query->closeCursor();
        $cid = $id[0];
        
        $sql = "SELECT * FROM `competences_designation` WHERE id=".$did;
        $query = $connexion->query($sql);
        $array = $query->fetchAll(PDO::FETCH_ASSOC);
        if (isset($array[0])) {
            $sql = "UPDATE `competences_designation` SET designation=".$des.", categories_id=".$cid." WHERE id=".$did;
            if ($connexion->query($sql)) {
                $edited = TRUE;
            } else {
                $edited = FALSE;
            }
        } else {
            $edited = FALSE;
        }
        $query->closeCursor();
    } elseif ($action == 'edit' && isset($id) && !isset($_POST['submit']) && !isset($_POST['des'])) {
        $did = $connexion->quote($id, PDO::PARAM_INT);
        $sql = "SELECT competences_designation.designation FROM `competences_designation` WHERE competences_designation.id=".$did;
        $query = $connexion->query($sql);
        $nom = $query->fetch();
        $query->closeCursor();
        
        $sql = "SELECT nom FROM `competences_categories`";
        $query = $connexion->query($sql);
        $categories = $query->fetchAll(PDO::FETCH_ASSOC);
        $query->closeCursor();
        
        foreach ($designations as $des) {
            if ($des->designation == $nom[0]) {
                $current = $des->nom;
            }
        }
    }
    
?>
 <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <title>Gestion des désignations</title>
    </head>
    <body>
        <div id="container">
            <? if ($action == 'index'): /* Liste des désignations */?>
            <a href="?a=new">Nouvelle désignation</a>
            <table id="designations">
                <thead>
                    <tr>
                        <th>
                            Désignation
                        </th>
                        <th>
                            Catégorie
                        </th>
                        <th>
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <? foreach ($designations as $des): ?>
                    <tr>
                        <td>
                            <?= $des->designation?>
                        </td>
                        <td>
                            <?= $des->nom?>
                        </td>
                        <td>
                            <a href="?a=delete&id=<?= $des->id ?>">Delete</a>&nbsp;<a href="?a=edit&id=<?= $des->id ?>">Edit</a>
                        </td>
                    </tr>
                    <? endforeach; ?>
                </tbody>
            </table>
            <? elseif ($action == 'delete' && isset($deleted)): /* Suppression d'une désignation */?>
            <? if ($deleted == TRUE): ?>
            <p>
                La désignation 
                <?= $des[0]['nom']?>
                à bien été supprimée !
            </p>
            <? else : ?>
            <p>
                La désignation n'a pas été supprimée !
            </p>
            <? endif; ?>
            <a href="?a=index">Retour aux désignations</a>
            <? elseif ($action == 'new'): /* Création d'une désignation */?>
            <? if (isset($created) && $created == TRUE): ?>
            <p>
                La désignation 
                <?= $des?>
                à bien été crée !
            </p>
            <? elseif (isset($created) && $created == FALSE): ?>
            <p>
                La désignation 
                <?= $des?>
                n'a pas été crée !
            </p>
            <? endif; ?>
            <form id="new" method="post">
                <fieldset>
                    <legend>
                        Nouvelle désignation
                    </legend>
                    <input type="text" name="des" />
                    <select name="cat">
                        <? foreach ($categories as $cat): ?>
                        <option value="<?= $cat['nom'] ?>">
                            <?= $cat['nom']?>
                        </option>
                        <? endforeach; ?>
                    </select>
                    <input type="submit" name="submit" value="Créer" />
                </fieldset>
            </form><a href="?a=index">Retour aux désignations</a>
            <? elseif ($action == 'edit' && isset($id)): /* Edition d'une désignation */?>
            <? if (isset($edited) && $edited == TRUE): ?>
            <p>
                La désignation 
                <?= $des?>
                à bien été éditée !
            </p>
            <? elseif (isset($edited) && $edited == FALSE): ?>
            <p>
                La désignation 
                <?= $des?>
                n'a pas été éditée !
            </p>
            <? endif; ?>
            <form id="edit" method="post">
                <fieldset>
                    <legend>
                        Edition de désignation
                    </legend>
                    <input type="text" name="des" value="<?= $nom[0] ?>" />
                    <select name="cat">
                        <? foreach ($categories as $cat): ?>
                        <? if ($current == $cat['nom']): ?>
                        <option value="<?= $cat['nom'] ?>" selected="selected">
                            <?= $cat['nom']?>
                        </option>
                        <? else : ?>
                        <option value="<?= $cat['nom'] ?>">
                            <?= $cat['nom']?>
                        </option>
                        <? endif; ?>
                        <? endforeach; ?>
                    </select>
                    <input type="submit" name="submit" value="Editer" />
                </fieldset>
            </form><a href="?a=index">Retour aux désignations</a>
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

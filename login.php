<?php
// Inclusion de fluxbb
define('PUN_ROOT', '../home/');
require PUN_ROOT.'include/common.php';

if ($pun_user['is_guest'] != 1) { // L'utilisateur est déjà connecté
    header('Location: user.php');
	exit;
} elseif (isset($_POST['user']) && isset($_POST['pass'])) { // Forumlaire correctement envoyé, on passe à la suite
    // Authentification
    $username = pun_trim($_POST['user']);
    $password = pun_trim($_POST['pass']);
    authenticate_user($username, $password);
    
    // Définition du cookie
    $now = get_microtime();
    $expire = $now + 1209600;
    pun_setcookie($pun_user['id'], $pun_user['password'], $expire);
}
?>
 <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <title>Connexion</title>
    </head>
    <body>
        <div id="container">
            <?php if ($pun_user['is_guest'] == 1) { // Utilisateur guest, premier affichage ?>
            <fieldset>
                <legend>
                    Connexion 
                </legend>
                <p>
                    Vous pouvez vous connecter ici avec vos identifiants utilisés lors de 
                    l'inscription sur le <a href="../home/index.php">forum</a>.
                </p>
                <form name="login" method="post">
                    <label>
                        Nom d'utilisateur :<input name="user" type="text" />
                    </label>
                    <label>
                        Mot de passe :<input name="pass" type="password" />
                    </label><input type="submit" name="submit" value="Connexion" />
                </form>
            </fieldset>
            <?php } else { // Confirmation de connexion ?>
            <p>
                Vous êtes bien connectés avec le nom <?= $pun_user['username'] ?>!
				<a href="user.php">Ajouter vos compétences ?</a>
            </p>
            <?php } ?>
        </div>
    </body>
</html>

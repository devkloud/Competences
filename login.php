<?php
define('PUN_ROOT', '../home/');
require PUN_ROOT.'include/common.php';

if ($pun_user['is_guest'] != 1) {
	die ('Vous êtes déja connectés sous le nom de '.$pun_user['username'].' !');
} elseif (isset($_POST['user']) && isset($_POST['pass'])) {
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
        	<?php if ($pun_user['is_guest'] == 1) { ?>
            <fieldset>
                <legend>
                    Connexion
                </legend>
                <p>
                    Vous pouvez vous connecter ici avec vos identifiants utilisés lors de l'inscription sur le <a href="../home/index.php">forum</a>.
                </p>
                <form name="login" method="post">
                    <label>
                        Nom d'utilisateur :<input name="user" type="text">
                        </input>
                    </label>
                    <label>
                        Mot de passe :<input name="pass" type="password">
                        </input>
                    </label>
					<input type="submit" name="submit" value="Connexion" />
                </form>
            </fieldset>
			<?php } else { ?>
				<p>Vous êtes bien connectés avec le nom <?php echo $pun_user['username']; ?>!</p>
			<?php } ?>
        </div>
    </body>
</html>
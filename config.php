<?php
// Pas d'accès direct
if (!isset($index)) {
    die();
} else { 
	// Création de la variable
	$config = array();
	
	/* 
	 * Réglages Mysql
	 */
	$config['distant'] = array('host'=>'localhost', 
		'port'=>3306, 
		'user'=>'root', 
		'pass'=>'root', 
		'db'=>'devkloud_forum'
		);
	
	$config['local'] = array('host'=>'localhost', 
		'port'=>3306, 
		'user'=>'web', 
		'pass'=>'kloudweb', 
		'db'=>'fbb_home'
		);
	/*
	 * Connexion Mysql
	 */
	
	$cfg = 'local'; // Paramètres à utiliser
	
	try {
	    $connexion = new PDO('mysql:host='.$config[$cfg]['host'].';
							  port='.$config[$cfg]['port'].';
						 	  dbname='.$config[$cfg]['db'], 
							  $config[$cfg]['user'], 
							  $config[$cfg]['pass']
							  );
		$connexion->exec("SET CHARACTER SET utf8");
	}
	
	catch(Exception $e) {
	    echo 'Erreur : '.$e->getMessage().'<br />';
	    echo 'N° : '.$e->getCode();
	    die();
	}
}
?>

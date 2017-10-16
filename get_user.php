<?php

	include('pdo.php');

	$_GET['identifier']

	$whitelist = $db->query('SELECT * FROM whitelist INNER JOIN users ON whitelist.identifier = users.identifier');

	// nom_rp identifier last_connexion ban_reason ban_until

	while ($result = $whitelist->fetch())
	{
	    echo $result['nom_rp'] . '<br />';
	    echo $result['identifier'] . '<br />';
	    echo $result['last_connexion'] . '<br />';
	    echo $result['ban_reason'] . '<br />';
	    echo $result['ban_until'] . '<br />';
	    echo $result['group'] . '<br />';
	    echo '<hr>';
	}

	$whitelist->closeCursor();
?>
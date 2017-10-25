<?php

	include('pdo.php');

	$whitelist = $db->query('SELECT * FROM whitelist');

	// nom_rp identifier last_connexion ban_reason ban_until

	while ($result = $whitelist->fetch())
	{
	    echo $result['firstname'] . '<br />';
	    echo $result['lastname'] . '<br />';
	    echo $result['identifier'] . '<br />';
	    echo $result['last_connexion'] . '<br />';
	    echo $result['ban_reason'] . '<br />';
	    echo $result['ban_until'] . '<br />';
	    echo '<hr>';
	}

	$whitelist->closeCursor();
?>
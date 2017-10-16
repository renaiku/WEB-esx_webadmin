<?php

	include('../config/config.php');

	try
	{
		$db = new PDO('mysql:host='.$db_adress.';dbname='.$db_name.';charset=utf8', $db_user, $db_password,
		array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}
	catch (Exception $e)
	{
		die('Erreur : ' . $e->getMessage());
	}
?>
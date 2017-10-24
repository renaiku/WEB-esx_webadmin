<?php

	if (isset($_GET['return'])) {
		include_once('../config/config.php');
	} else {		
		include_once('config/config.php');	}

	try
	{
		$db = new PDO('mysql:host='.DB_ADDRESS.';dbname='.DB_NAME.';charset=utf8', DB_USER, DB_PASSWORD,
		array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}
	catch (Exception $e)
	{
		die('Error : ' . $e->getMessage());
	}
?>
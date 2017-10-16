<?php

	include('config/config.php');

	try
	{
		$db = new PDO('mysql:host='.$db_adress.';dbname='.$db_name.';charset=utf8', $db_user, $db_password);
	}
	catch (Exception $e)
	{
		die('Error : ' . $e->getMessage());
	}
?>
<?php

	include('pdo.php');

	$user = $db->prepare('SELECT * FROM whitelist w INNER JOIN users u ON w.identifier = :identifier WHERE u.identifier = :identifier');
	$user->execute(array('identifier' => $_GET['identifier']));

	$result = $user->fetch();

	$arr = array(
		'identifier' 		=> $result['identifier'],
		'firstname' 		=> $result['firstname'],
		'lastname' 			=> $result['lastname'],
		'last_connexion' 	=> $result['last_connexion'],
		'ban_reason' 		=> $result['ban_reason'],
		'ban_until' 		=> $result['ban_until'],
		'license' 			=> $result['license'],
		'group' 			=> $result['group'],
		'permission_level' 	=> $result['permission_level'],
		'money' 			=> $result['money'],
		'steam_name' 		=> $result['name'],
		'job' 				=> $result['job'],
		'job_grade' 		=> $result['job_grade'],
		'loadout' 			=> $result['loadout'],
		'position' 			=> $result['position'],
		'phone_number' 		=> $result['phone_number'],
		'bank' 				=> $result['bank'],
		'status' 			=> $result['status']
	);

	echo json_encode($arr);

	$user->closeCursor();
?>
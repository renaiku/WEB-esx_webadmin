<?php
include_once('config/config.php');

echo '<br /><br />[USERS] '. count_users() . '<br />';
echo '[USER - money] '. get_user_info($_SESSION['steamidhex'], 'money') . '<br />';
echo '[USER - bank] '. get_user_info($_SESSION['steamidhex'], 'bank') . '<br />';
echo '[USER - phone_number] '. get_user_info($_SESSION['steamidhex'], 'phone_number') . '<br />';
$job = get_user_info($_SESSION['steamidhex'], 'job');
echo '[USER - job] ' . json_encode(get_job($job)) . '<br />';
$grade = get_user_info($_SESSION['steamidhex'], 'job_grade');
echo '[USER - job_grade] ' . json_encode(get_job_grade($job, $grade)) . '<br />';
echo '[USER - group] '. get_user_info($_SESSION['steamidhex'], 'group') . '<br />';

// returns the amount of players created in the users table
function count_users() {
	include('pdo.php');
	$count = $db->query('SELECT COUNT(`identifier`) FROM users');
	$result = $count->fetch();
	$count->closeCursor();
	return $result[0];
}

// $user should be steamhex64
function get_user_info($user, $field){
	include('pdo.php');
	$userData = $db->prepare('SELECT `' . $field . '` FROM users WHERE identifier = :identifier');
	$userData->execute(array('identifier' => $user));
	$result = $userData->fetch();
	$userData->closeCursor();
	return $result[$field];
}

function get_job($job){
	include('pdo.php');
	$userData = $db->prepare('SELECT * FROM jobs WHERE name = :job_name');
	$userData->execute(array('job_name' => $job));
	$result = $userData->fetch();
	$userData->closeCursor();
	return array(
		'name' => $result['name'],
		'label' => $result['label'],
		'whitelisted' => $result['whitelisted']
	);
}

function get_job_grade($job, $grade){
	include('pdo.php');
	$userData = $db->prepare('SELECT * FROM job_grades WHERE job_name = :job_name AND grade = :grade');
	$userData->execute(array('job_name' => $job, 'grade' => $grade));
	$result = $userData->fetch();
	$userData->closeCursor();
	return array(
		'job_name' => $result['job_name'],
		'grade' => $result['grade'],
		'name' => $result['name'],
		'label' => $result['label'],
		'salary' => $result['salary']
	);
}

?>
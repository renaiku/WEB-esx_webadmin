<?php

if (isset($_GET['return'])) {
	include_once('../config/config.php');
	$result = NULL;

	switch ($_GET['return']) {
	    case 'get_user':
	        $result = get_user();
	        break;
	    case 'count_users':
	        $result = count_users();
	        break;
	    case 'get_whitelist':
	        $result = get_whitelist();
	        break;
	    case 'get_user_info':
	        $result = get_user_info($_GET['user'], $_GET['field']);
	        break;
	    case 'get_job':
	        $result = get_job($_GET['job']);
	        break;
	   	case 'get_job_grade':
	        $result = get_job_grade($_GET['job'], $_GET['grade']);
	        break;
	}
    
    if ($result != NULL) {
        return $result;   
    } else {
    	return "Function doesn't exist or is not in the switch case: ".$_GET['return'];
    }

} elseif (isset($_POST['execute'])) {
	include_once('../config/config.php');

	switch ($_POST['execute']) {
	    case 'add_to_whitelist':
	        add_to_whitelist(htmlspecialchars($_POST['firstname']), htmlspecialchars($_POST['lastname']), htmlspecialchars($_POST['identifier']));
	        break;
	}

} else {
	include_once('config/config.php');
}

function bc_base_convert($value,$quellformat,$zielformat)
{
	$vorrat = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	if(max($quellformat,$zielformat) > strlen($vorrat))
		trigger_error('Bad Format max: '.strlen($vorrat),E_USER_ERROR);
	if(min($quellformat,$zielformat) < 2)
		trigger_error('Bad Format min: 2',E_USER_ERROR);
	$dezi   = '0';
	$level  = 0;
	$result = '';
	$value  = trim((string)$value,"\r\n\t +");
	$vorzeichen = '-' === $value{0}?'-':'';
	$value  = ltrim($value,"-0");
	$len    = strlen($value);
	for($i=0;$i<$len;$i++)
	{
		$wert = strpos($vorrat,$value{$len-1-$i});
		if(FALSE === $wert) trigger_error('Bad Char in input 1',E_USER_ERROR);
		if($wert >= $quellformat) trigger_error('Bad Char in input 2',E_USER_ERROR);
		$dezi = bcadd($dezi,bcmul(bcpow($quellformat,$i),$wert));
	}
	if(10 == $zielformat) return $vorzeichen.$dezi; // abkürzung
	while(1 !== bccomp(bcpow($zielformat,$level++),$dezi));
	for($i=$level-2;$i>=0;$i--)
	{
		$factor  = bcpow($zielformat,$i);
		$zahl    = bcdiv($dezi,$factor,0);
		$dezi    = bcmod($dezi,$factor);
		$result .= $vorrat{$zahl};
	}
	$result = empty($result)?'0':$result;
   
	return $vorzeichen.$result ;
}
    
function get_user($identifier, $mode) {
	include_once('steamauth/userInfo.php'); //To access the $steamprofile array
    include('pdo.php');
    if (USE_WHITELIST) {
    	$u = $db->prepare('SELECT * FROM whitelist w RIGHT JOIN users u ON w.identifier = :identifier WHERE u.identifier = :identifier');
    } else {
    	$u = $db->prepare('SELECT * FROM users WHERE identifier = :identifier');
    }
	$u->execute(array('identifier' => $identifier));
	$result = $u->fetch();
	$u->closeCursor();
	$job = json_decode(get_job_grade($result['job'], $result['job_grade'], 'return'), true);
	$arr = json_encode(array(
		'name' => $result['name'],
		'identifier' => $result['identifier'],
		'permission_level' => $result['permission_level'],
		'group' => $result['group'],
		'job_name' => $job['job_name'],
		'job_grade' => $job['job_grade'],
		'job_grade_name' => $job['job_grade_name'],
		'job_grade_label' => $job['job_grade_label'],
		'job_grade_salary' => $job['job_grade_salary']
	));

	if ($mode == 'return') {
		return $arr;
	} else {
		echo $arr;
	}	
}

// returns the amount of players created in the users table
function count_users() {
	include('pdo.php');
	$count = $db->query('SELECT COUNT(`identifier`) FROM users');
	$result = $count->fetch();
	$count->closeCursor();
	echo json_encode($result[0]);
}

// returns whitelist
function get_whitelist() {
	include('pdo.php');
	$bdd = $db->query('SELECT * FROM whitelist');
	$result = $bdd->fetchall();
	$bdd->closeCursor();
	echo json_encode($result);
}

// $user should be steamhex64
function get_user_info($user, $field){
	include('pdo.php');
	$userData = $db->prepare('SELECT `' . $field . '` FROM users WHERE identifier = :identifier');
	$userData->execute(array('identifier' => $user));
	$result = $userData->fetch();
	$userData->closeCursor();
	echo json_encode($result[$field]);
}

function get_job($job){
	include('pdo.php');
	$userData = $db->prepare('SELECT * FROM jobs WHERE name = :job_name');
	$userData->execute(array('job_name' => $job));
	$result = $userData->fetch();
	$userData->closeCursor();
	echo json_encode(array(
		'name' => $result['name'],
		'label' => $result['label'],
		'whitelisted' => $result['whitelisted']
	));
}

function get_job_grade($job, $grade, $mode){
	include('pdo.php');
	$userData = $db->prepare('SELECT * FROM job_grades WHERE job_name = :job_name AND grade = :grade');
	$userData->execute(array('job_name' => $job, 'grade' => $grade));
	$result = $userData->fetch();
	$userData->closeCursor();
	$arr = json_encode(array(
		'job_name' => $result['job_name'],
		'job_grade' => $result['grade'],
		'job_grade_name' => $result['name'],
		'job_grade_label' => $result['label'],
		'job_grade_salary' => $result['salary']
	));

	if ($mode == 'return') {
		return $arr;
	} else {
		echo $arr;
	}	
}

function add_to_whitelist($firstname, $lastname, $identifier){
	include('pdo.php');
	$req = $db->prepare('INSERT INTO whitelist(firstname, lastname, identifier) VALUES(:firstname, :lastname, :identifier)');
	if ($req->execute(array('firstname' => $firstname, 'lastname' => $lastname, 'identifier' => $identifier))) {
		$message = $firstname.' '.$lastname.' has been successfully added to whitelist.';
		echo json_encode(array(
			'success' => true,
			'message' => $message
		));
	} else {
		$message = '[ERROR] '.$firstname.' '.$lastname.' has not been added to whitelist.';
		echo json_encode(array(
			'success' => false,
			'message' => $message
		));
	}
}

?>
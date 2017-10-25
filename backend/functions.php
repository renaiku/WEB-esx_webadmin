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
	        add_to_whitelist(htmlspecialchars($_GET['firstname']), htmlspecialchars($_GET['lastname']), htmlspecialchars($_GET['identifier']));
	        break;
	}

} else {
	include_once('config/config.php');
}




if(isset($_SESSION['steamid']) and DEBUG) {
	echo '<br /><br />[USERS] '. count_users() . '<br />';
	echo '[USER - money] '. get_user_info($_SESSION['steamidhex'], 'money') . '<br />';
	echo '[USER - bank] '. get_user_info($_SESSION['steamidhex'], 'bank') . '<br />';
	echo '[USER - phone_number] '. get_user_info($_SESSION['steamidhex'], 'phone_number') . '<br />';
	$job = get_user_info($_SESSION['steamidhex'], 'job');
	echo '[USER - job] ' . json_encode(get_job($job)) . '<br />';
	$grade = get_user_info($_SESSION['steamidhex'], 'job_grade');
	echo '[USER - job_grade] ' . json_encode(get_job_grade($job, $grade)) . '<br />';
	echo '[USER - group] '. get_user_info($_SESSION['steamidhex'], 'group') . '<br />';
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
    
function get_user() {
	include_once('steamauth/userInfo.php'); //To access the $steamprofile array
    include('pdo.php');
    if(USE_WHITELIST) {
    $u = $db->prepare('SELECT * FROM whitelist w RIGHT JOIN users u ON w.identifier = :identifier WHERE u.identifier = :identifier');
    }else{
    	$u = $db->prepare('SELECT * FROM users WHERE identifier = :identifier');
    }
	$u->execute(array('identifier' => $_SESSION['steamidhex']));
	$result = $u->fetch();
	$u->closeCursor();
	echo json_encode($result);
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

function get_job_grade($job, $grade){
	include('pdo.php');
	$userData = $db->prepare('SELECT * FROM job_grades WHERE job_name = :job_name AND grade = :grade');
	$userData->execute(array('job_name' => $job, 'grade' => $grade));
	$result = $userData->fetch();
	$userData->closeCursor();
	echo json_encode(array(
		'job_name' => $result['job_name'],
		'grade' => $result['grade'],
		'name' => $result['name'],
		'label' => $result['label'],
		'salary' => $result['salary']
	));
}

function add_to_whitelist($firstname, $lastname, $identifier){
	include('pdo.php');
	$req = $db->prepare('INSERT INTO whitelist(firstname, lastname, identifier) VALUES(:firstname, :lastname, :identifier)');
	$req->execute(array(
		'firstname' => $firstname,
		'lastname' => $lastname,
		'identifier' => $identifier
	));
}

?>
<?php
	require('../steamauth/steamauth.php');

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
 
    // 110000102154be4
    

	if(!isset($_SESSION['steamid'])) {

	    loginbutton(); //login button

	}  else {

	    include ('../steamauth/userInfo.php'); //To access the $steamprofile array
	    include('pdo.php');

	    $hexid = 'steam:'.bc_base_convert($_SESSION['steamid'], 10, 16 );

		$user = $db->prepare('SELECT * FROM whitelist w INNER JOIN users u ON w.identifier = :identifier WHERE u.identifier = :identifier');
		$user->execute(array('identifier' => $hexid));

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

	    logoutbutton(); //Logout Button
	}
?>
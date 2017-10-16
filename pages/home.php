<?php
	if(!isset($_SESSION['steamid'])) {

	    loginbutton(); //login button

	}  else {

	    include_once ('/steamauth/userInfo.php'); //To access the $steamprofile array
	    //Protected content

	    logoutbutton(); //Logout Button
	}
?>
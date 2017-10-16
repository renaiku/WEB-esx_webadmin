<?php
	require '/steamauth/steamauth.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>ESX WebAdmin</title>
    </head>

    <body>
    	<?php
			if(!isset($_SESSION['steamid'])) {

			    loginbutton(); //login button

			}  else {

			    include ('/steamauth/userInfo.php'); //To access the $steamprofile array
			    //Protected content

			    logoutbutton(); //Logout Button
			}
		?>
    </body>
</html>
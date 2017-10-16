<?php
	require_once 'steamauth/steamauth.php';
?>

<!DOCTYPE html>
<html>
    <?php
    	include_once('frontend/modules/head.mod.php');
    ?>

	<body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<?php
				include_once('frontend/includes/nav.inc.php')
			?>

		    <!-- Content Wrapper. Contains page content -->
		    <div class="content-wrapper">
	    	<?php
				if(!isset($_SESSION['steamid'])) {

				    loginbutton(); //login button

				}  else {

				    include_once ('/steamauth/userInfo.php'); //To access the $steamprofile array
				    //Protected content

				    logoutbutton(); //Logout Button
				}
			?>
			</div>
		</div>
	    <?php
	    	include_once('frontend/modules/foot.mod.php');
	    ?>
    </body>
</html>
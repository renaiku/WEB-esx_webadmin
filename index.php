<?php
	require_once 'steamauth/steamauth.php';

	if(isset($_GET['p']) && !empty($_GET['p'])) {

		if(file_exists('pages/'.$_GET['p'].'.php')) {
			$page = 'pages/'.$_GET['p'].'.php';
		}else{
			$page = 'pages/home.php';
		}

	}else{

		$page = 'pages/home.php';

	}

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

		    		include_once($page);

		    	?>
			</div>
		</div>
	    <?php
	    	include_once('frontend/modules/foot.mod.php');
	    ?>
    </body>
</html>
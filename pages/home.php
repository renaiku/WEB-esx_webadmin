<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Dashboard
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Dashboard</li>
  </ol>
</section>


    <!-- Main content -->
<section class="content">
	<div class="row">
	<?php
		if(!isset($_SESSION['steamid'])) {

		    loginbutton('rectangle'); //login button

		}  else {

		    include_once ('steamauth/userInfo.php'); //To access the $steamprofile array
		    //Protected content

		    logoutbutton(); //Logout Button
		}
	?>
	</div>
</section>
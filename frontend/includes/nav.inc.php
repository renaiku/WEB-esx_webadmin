<header class="main-header">

	<!-- Logo -->
	<a href="index.php" class="logo">
		<!-- mini logo for sidebar mini 50x50 pixels -->
		<span class="logo-mini"><b>E</b>WA</span>
		<!-- logo for regular state and mobile devices -->
		<span class="logo-lg"><b>ESX</b>WebAdmin</span>
	</a>

	<!-- Header Navbar: style can be found in header.less -->
	<nav class="navbar navbar-static-top">

		<!-- Sidebar toggle button-->
		<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
			<span class="sr-only">Toggle navigation</span>
		</a>

		<div class="navbar-custom-menu">
			<?php
				if(!isset($_SESSION['steamid'])) {
					echo '<div style="padding: 7px 15px;">';
						loginbutton('rectangle'); //login button
					echo '</div>';
				} else {
			?>
			
			<div class="pull-left">
				<a href="#" class="btn btn-default btn-flat">Profile</a>
			</div>

			<div class="pull-right">
				<?php
					logoutbutton(); //Logout Button
				?>
			</div>
				
			<?php
				}
			?>
		</div>
	</nav>
</header>

<?php
if(isset($_SESSION['steamid'])) {
	include('sidebar.inc.php');
}
?>
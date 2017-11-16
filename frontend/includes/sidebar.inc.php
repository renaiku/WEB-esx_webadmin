<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
	  <!-- Sidebar user panel -->
	  <div class="user-panel">
	    <div class="pull-left image">
	      <img src="<?=$_SESSION['steam_avatarfull']?>" class="img-circle" alt="User Image">
	    </div>
	    <div class="pull-left info">
	      <p><?=$user['name']?></p>
	      <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
	    </div>
	  </div>
	  <!-- search form -->
	  <form action="#" method="get" class="sidebar-form">
	    <div class="input-group">
	      <input type="text" name="q" class="form-control" placeholder="Search...">
	      <span class="input-group-btn">
	            <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
	            </button>
	          </span>
	    </div>
	  </form>
	  <!-- /.search form -->
	  <!-- sidebar menu: : style can be found in sidebar.less -->
	  <ul class="sidebar-menu" data-widget="tree">
	    <li class="header"><?php echo SERVER_NAME; ?></li>
	    <!-- ADMIN -->
	    <?php
		    if($user['group'] == 'superadmin') {
			    echo '<li class="treeview">
			      <a href="#">
			        <i class="fa fa-files-o"></i> <span>Administration</span>			        
			        <span class="pull-right-container">
			          <i class="fa fa-angle-left pull-right"></i>
			        </span>
			      </a>
			      <ul class="treeview-menu">
			        <li><a href="?p=whitelist"><i class="fa fa-circle-o"></i> Whitelist</a></li>
			        <li><a href="pages/layout/boxed.html"><i class="fa fa-circle-o"></i> Settings</a></li>
			      </ul>
			    </li>';
		    }
	    ?>
	    <!-- SOCIETY BOSS -->
	    <?php
		    if($user['job_grade_name'] == 'boss') {
			    echo '<li class="treeview">
			      <a href="#">
			        <i class="fa fa-files-o"></i> <span>My Society</span>
			      </a>
			      <ul class="treeview-menu">
			        <li><a href="pages/layout/top-nav.html"><i class="fa fa-circle-o"></i> Whitelist</a></li>
			        <li><a href="pages/layout/boxed.html"><i class="fa fa-circle-o"></i> Boxed</a></li>
			        <li><a href="pages/layout/fixed.html"><i class="fa fa-circle-o"></i> Fixed</a></li>
			        <li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-circle-o"></i> Collapsed Sidebar</a></li>
			      </ul>
			    </li>';
			}
		?>

	    <li class="treeview">
	      <a href="#">
	        <i class="fa fa-files-o"></i>
	        <span>My Character</span>
	      </a>
	    </li>

	    <li><a href="https://adminlte.io/docs"><i class="fa fa-book"></i> <span>Documentation</span></a></li>
	  </ul>
	</section>
<!-- /.sidebar -->
</aside>
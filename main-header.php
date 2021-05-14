<?php
	if (!isset($con)){
		exit;
	}
?>
        <!-- Logo -->
        <a href="index.php" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>I</b>C</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Inventory </b>Control</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
             
              
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="dist/img/admin.png" class="user-image" alt="User Image">
                  <span class="hidden-xs"><?php echo $_SESSION['full_name'];  ?></span>
                </a>
                <ul class="dropdown-menu">
				
                  <!-- User image -->
                  <li class="user-header">
                    <img src="dist/img/admin.png" class="img-circle" alt="User Image">
                    <p>
						<?php echo $_SESSION['full_name']; ?>		
                      <small>Usuario</small>
                    </p>
                  </li>
                 
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      
                    </div>
                    <div class="pull-right">
                      <a href="login.php?logout" class="btn btn-danger btn-flat"><i class='fa fa-power-off'></i> Salir</a>
                    </div>
                  </li>
                </ul>
              </li>
              
            </ul>
          </div>
        </nav>
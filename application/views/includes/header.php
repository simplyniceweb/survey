<div class="navbar navbar-default navbar-static-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <?php if($session['user_level'] == 99 || $this->uri->segment(1) == "admin" || $this->uri->segment(1) == "studentnumber"): ?>
            <a class="navbar-brand" href="admin">Admin</a>
          <?php else: ?>
            <a class="navbar-brand" href="#">Homepage</a>
          <?php endif; ?>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a href="javascript: void(0);" class="dropdown-toggle" data-toggle="dropdown">
                <?php if( !empty($session['profile_picture']) ): ?>
                <img src="assets/images/<?php echo $session['profile_picture']; ?>" class="img-circle" width="25" height="25"/>
                <?php else: ?>
                <span class="glyphicon glyphicon-user"></span>
				<?php endif; ?>
                <?php echo $session['user_name']; ?> <b class="caret"></b>
                    <ul class="dropdown-menu" role="menu">
                    <?php if($session['user_level'] == 99): ?>
                        <li><a href=""><i class="glyphicon glyphicon-home"></i> Homepage</a></li>
                        <li><a href="admin"><i class="glyphicon glyphicon-globe"></i> Admin</a></li>
                        <li class="divider"></li>
                    <?php endif; ?>
                        <li><a href="settings"><i class="glyphicon glyphicon-wrench"></i> Settings</a></li>
                        <li><a href="logout"><i class="glyphicon glyphicon-off"></i> Logout</a></li>
                    </ul>
                </a>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

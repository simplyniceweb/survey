<div class="container">
    <div class="row">
        <nav class="navbar navbar-default" role="navigation">
            <div class="navbar-header">
            <?php if($session['user_level'] == 99 || $this->uri->segment(1) == "admin" || $this->uri->segment(1) == "studentnumber"): ?>
            <a class="navbar-brand" href="admin">Admin</a>
            <?php else: ?>
            <a class="navbar-brand" href="#">Homepage</a>
            <?php endif; ?>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                <a href="javascript: void(0);" class="dropdown-toggle" data-toggle="dropdown">
                <?php if( !empty($session['profile_picture']) ): ?>
                <img src="assets/images/<?php echo $session['profile_picture']; ?>" class="img-circle" width="25" height="25"/>
                <?php else: ?>
                <span class="glyphicon glyphicon-user"></span>
				<?php endif; ?>
                <?php echo $session['user_name']; ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu" role="menu">
                    <?php if($session['user_level'] == 99): ?>
                        <li><a href="">Homepage</a></li>
                        <li><a href="admin">Admin</a></li>
                        <li class="divider"></li>
                    <?php endif; ?>
                        <li><a href="settings">Settings</a></li>
                        <li><a href="logout">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>
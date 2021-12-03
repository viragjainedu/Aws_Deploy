<div class="navbar-custom">
    <ul class="list-unstyled topnav-menu float-right mb-0">

        <li class="d-none d-sm-block">
            <form class="app-search">
                <div class="app-search-box">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search...">
                        <div class="input-group-append">
                            <button class="btn" type="submit">
                                <i class="fe-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </li>



        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <img src="assets/images/users/profile.png" alt="user-image" class="rounded-circle">
                <span class="pro-user-name ml-1">
                    <?php echo $_SESSION['username']; ?> <i class="mdi mdi-chevron-down"></i>
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                <!-- item-->


                <!-- item-->
                <!-- <a href="profile.php" class="dropdown-item notify-item">
                    <i class="fe-user"></i>
                    <span>My Account</span>
                </a> -->
                <!-- item-->
                <a href="Logout.php" class="dropdown-item notify-item">
                    <i class="fe-log-out"></i>
                    <span>Logout</span>
                </a>

            </div>
        </li>




    </ul>

    <!-- LOGO -->
    <div class="logo-box">
        <a href="index.php" class="logo logo-dark text-center">
            <span class="logo-lg">
                <img src="assets/images/logo.png" alt="" height="16">
            </span>
            <span class="logo-sm">
                <img src="assets/images/logo-sm.png" alt="" height="24">
            </span>
        </a>
        <a href="index.php" class="logo logo-light text-center">
            <span class="logo-lg">
                <img src="assets/images/logo-light.png" alt="" height="16">
            </span>
            <span class="logo-sm">
                <img src="assets/images/logo-sm.png" alt="" height="24">
            </span>
        </a>
    </div>

    <ul class="list-unstyled topnav-menu topnav-menu-left mb-0">
        <li>
            <button class="button-menu-mobile disable-btn waves-effect">
                <i class="fe-menu"></i>
            </button>
        </li>

        <li>
            <h4 class="page-title-main">Dashboard</h4>
        </li>

    </ul>

</div>
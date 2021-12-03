<?php
session_start();
?>
<div class="left-side-menu">

    <div class="slimscroll-menu">

        <!-- User box -->
        <div class="user-box text-center">

            <img src="assets/images/users/profile.png" alt="user-img" title="Mat Helme" class="rounded-circle img-thumbnail avatar-md" style="width:75px; height:75px;">
            <p class="my-2"><b><?php echo $_SESSION['username']; ?></b></p>
            <p class="text-muted"><?php echo $_SESSION['role']; ?></p>

        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul class="metismenu" id="side-menu">


                <li>
                    <a href="index.php">
                        <i class="mdi mdi-view-dashboard"></i>
                        <span> <strong>Dashboard</strong> </span>
                    </a>
                </li>


                <?php if (in_array('Add_Video', $_SESSION['access']) || in_array('Videos_List', $_SESSION['access'])) { ?>
                    <li>
                        <a href="javascript: void(0);">
                            <i class="mdi mdi-invert-colors"></i>
                            <span><strong>Videos</strong></span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">

                            <?php if (in_array('Videos_List', $_SESSION['access'])) { ?>
                                <li><a href="ListVideos.php">Videos</a></li>
                            <?php } ?>

                            <?php if (in_array('Add_Video', $_SESSION['access'])) { ?>
                                <li><a href="addVideo.php">Add Video</a></li>
                            <?php } ?>

                        </ul>
                    </li>
                <?php } ?>

                <?php if (in_array('Add_Series', $_SESSION['access']) || in_array('Series_List', $_SESSION['access'])) { ?>
                    <li>
                        <a href="javascript: void(0);">
                            <i class="mdi mdi-invert-colors"></i>
                            <span> <strong>Series</strong> </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">

                            <?php if (in_array('Series_List', $_SESSION['access'])) { ?>
                                <li><a href="ListSeries.php">Series</a></li>
                            <?php } ?>

                            <?php if (in_array('Add_Series', $_SESSION['access'])) { ?>
                                <li><a href="addSeries.php">Add Series </a></li>
                            <?php } ?>

                        </ul>
                    </li>
                <?php } ?>
                <?php if (in_array('Add_Category', $_SESSION['access']) || in_array('Categories_List', $_SESSION['access'])) { ?>
                    <li>
                        <a href="javascript: void(0);">
                            <i class="mdi mdi-invert-colors"></i>
                            <span> <strong>Category</strong> </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">

                            <?php if (in_array('Categories_List', $_SESSION['access'])) { ?>
                                <li><a href="ListCategories.php">Categories</a></li>
                            <?php } ?>

                            <?php if (in_array('Add_Category', $_SESSION['access'])) { ?>
                                <li><a href="addCategory.php">Add Category</a></li>
                            <?php } ?>

                        </ul>
                    </li>
                <?php } ?>
                <?php if (in_array('Add_Orator', $_SESSION['access']) || in_array('Orators_List', $_SESSION['access'])) { ?>
                    <li>
                        <a href="javascript: void(0);">
                            <i class="mdi mdi-invert-colors"></i>
                            <span> <strong>Orator</strong> </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">

                            <?php if (in_array('Orators_List', $_SESSION['access'])) { ?>
                                <li><a href="ListOrators.php">Orators</a></li>
                            <?php } ?>

                            <?php if (in_array('Add_Orator', $_SESSION['access'])) { ?>
                                <li><a href="addOrator.php">Add Orator </a></li>
                            <?php } ?>

                        </ul>
                    </li>
                <?php } ?>

                <?php if (in_array('Add_Slider', $_SESSION['access']) || in_array('Slider', $_SESSION['access'])) { ?>
                    <li>
                        <a href="javascript: void(0);">
                            <i class="mdi mdi-invert-colors"></i>
                            <span> <strong>Slider</strong> </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">

                            <?php if (in_array('Slider', $_SESSION['access'])) { ?>
                                <li><a href="ListSlider.php">Slider</a></li>
                            <?php } ?>

                            <?php if (in_array('Add_Slider', $_SESSION['access'])) { ?>
                                <li><a href="addSlider.php">Add Slider </a></li>
                            <?php } ?>

                        </ul>
                    </li>
                <?php } ?>

                <?php if (in_array('Create_Roles', $_SESSION['access']) || in_array('Users_List', $_SESSION['access'])) { ?>

                    <li>
                        <a href="javascript: void(0);">
                            <i class="mdi mdi-invert-colors"></i>
                            <span> <strong>Admin Roles</strong> </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">

                            <?php if (in_array('Create_Roles', $_SESSION['access'])) { ?>
                                <li><a href="addRole.php">Create Roles</a></li>
                            <?php } ?>

                            <?php if (in_array('Users_List', $_SESSION['access'])) { ?>
                                <li><a href="ListRoles.php">All Users</a></li>
                            <?php } ?>

                        </ul>
                    </li>
                <?php } ?>

                <?php if (in_array('Add_Advertisement', $_SESSION['access']) || in_array('Advertisements_List', $_SESSION['access'])) { ?>

                    <li>
                        <a href="javascript: void(0);">
                            <i class="mdi mdi-invert-colors"></i>
                            <span> <strong>Advertisement</strong> </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">

                            <?php if (in_array('Advertisements_List', $_SESSION['access'])) { ?>
                                <li><a href="ListAdvertisement.php">Advertisements</a></li>
                            <?php } ?>

                            <?php if (in_array('Add_Advertisement', $_SESSION['access'])) { ?>
                                <li><a href="addAdvertisement.php">Add Advertisement</a></li>
                            <?php } ?>


                        </ul>
                    </li>
                <?php } ?>

                <?php if (in_array('Donations', $_SESSION['access'])) { ?>
                    <li>
                        <a href="ListDonations.php">
                            <i class="mdi mdi-view-dashboard"></i>
                            <span> <strong>Donations</strong> </span>
                        </a>
                    </li>
                <?php } ?>
                <?php if (in_array('About_Us', $_SESSION['access'])) { ?>

                    <li>
                        <a href="AboutUs.php">
                            <i class="mdi mdi-view-dashboard"></i>
                            <span> <strong>About Us</strong> </span>
                        </a>
                    </li>
                <?php } ?>

                <?php if (in_array('Contact_Us', $_SESSION['access'])) { ?>

                    <li>
                        <a href="ContactUs.php">
                            <i class="mdi mdi-view-dashboard"></i>
                            <span> <strong>Contact Us</strong> </span>
                        </a>
                    </li>
                <?php } ?>

                <?php if (in_array('Report', $_SESSION['access'])) { ?>

                    <li>
                        <a href="Report.php">
                            <i class="mdi mdi-view-dashboard"></i>
                            <span> <strong>Report</strong> </span>
                        </a>
                    </li>
                <?php } ?>

                <?php if (in_array('SocialMedia', $_SESSION['access'])) { ?>

                    <li>
                        <a href="SocialMedia.php">
                            <i class="mdi mdi-view-dashboard"></i>
                            <span> <strong>Social Media Links</strong> </span>
                        </a>
                    </li>
                <?php } ?>

                <?php if (in_array('Terms_and_Conditions', $_SESSION['access'])) { ?>

                    <li>
                        <a href="termsandconditions.php">
                            <i class="mdi mdi-view-dashboard"></i>
                            <span> <strong>Terms and conditions</strong> </span>
                        </a>
                    </li>
                <?php } ?>

                <?php if (in_array('Privacy_Policy', $_SESSION['access'])) { ?>

                    <li>
                        <a href="privacypolicy.php">
                            <i class="mdi mdi-view-dashboard"></i>
                            <span> <strong>Privacy policy</strong> </span>
                        </a>
                    </li>
                <?php } ?>



        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
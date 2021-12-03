<?php
session_start();
if (isset($_SESSION['islogin'])) {
    if ($_SESSION['islogin'] == false)
        header("Location: login.php");
} else {
    header("Location: login.php");
}
if (!in_array('Users_List', $_SESSION['access'])) {
    header("Location: index.php");
}
include("dbconn.php");
$roles = array('All_pages', 'Add_Video', 'Videos_List', 'Add_Series', 'Series_List', 'Add_Category', 'Categories_List', 'Add_Orator', 'Orators_List', 'Slider', 'Add_Slider', 'Create_Roles', 'Users_List', 'Add_Advertisement', 'Advertisements_List', 'Donations', 'About_Us', 'Contact_Us', 'Report', 'SocialMedia', 'Terms_and_Conditions', 'Privacy_Policy');

if (isset($_POST['submit'])) {
    $staffRef = $firestore->collection('Admin_Roles')->document($_POST['staffdet'])->snapshot();
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Add Staff</title>
        <?php include('include/head.php') ?>

        <style>
            .column-checkbox {
                column-count: 4;
                column-gap: 30px;
            }
        </style>

    </head>

    <body>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Topbar Start -->
            <?php include('include/header.php') ?>
            <!-- end Topbar -->

            <!-- ========== Left Sidebar Start ========== -->
            <?php include('include/sidebar.php') ?>
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-12">
                                <div class="card-box">
                                    <h4 class="card-title mb-4"><strong>Add Staff</strong></h4>
                                    <hr>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="p-2">
                                                <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="backend/editRoledb.php">
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label for="inputEmail4" class="col-form-label">Staff Name</label>
                                                            <input type="text" value=<?php echo $staffRef['Username'] ?> id="simpleinput" name="staffname" class="form-control" disabled>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="inputEmail4" class="col-form-label">Staff Email</label>
                                                            <input type="email" value=<?php echo $staffRef['EmailId'] ?> id="simpleinput" name="email" class="form-control" disabled>
                                                            <input type="hidden" name="email1" value="<?php echo $staffRef['EmailId'] ?>">
                                                        </div>

                                                    </div>

                                                    <!-- <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="inputPassword4" class="col-form-label">Create New Password</label>
                                                        <input type="password" value=<?php echo $staffRef['Password'] ?> id="simpleinput" name="newpass" class="form-control" required>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="inputAddress" class="col-form-label">Confirm Password</label>
                                                        <input type="password" id="simpleinput" name="conpass" class="form-control" required>
                                                    </div>
                                                </div> -->
                                                    <div class="form-group">
                                                        <label for="inputEmail4" class="col-form-label">Role</label>
                                                        <input type="text" id="simpleinput" name="role" class="form-control" value="<?php echo $staffRef['Role']; ?>" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="inputAddress" class="col-form-label">Access</label>

                                                        <div class="checkbox checkbox-info column-checkbox">
                                                            <?php foreach ($roles as $det) { ?>
                                                                <input id=<?php echo $det ?> name=<?php echo $det ?> type="checkbox" value=<?php echo $det ?> <?php if (in_array($det, $staffRef['Access'])) {
                                                                                                                                                                    echo "checked";
                                                                                                                                                                } ?>>
                                                                <label for=<?php echo $det ?>><?php echo $det ?></label>
                                                                <?php echo "<br/>"; ?>

                                                            <?php } ?>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="col-md-10">
                                                            <input type="submit" class="btn btn-primary" name="submit" value="Update" style="width:80px;" />
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- end row -->

                                </div> <!-- end card-box -->
                            </div><!-- end col -->
                        </div>
                        <!-- end row -->



                    </div> <!-- container-fluid -->

                </div> <!-- content -->

                <!-- Footer Start -->
                <?php include('include/footer.php') ?>
                <!-- end Footer -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->

        <?php include('include/script.php') ?>

    </body>

    </html>

<?php } ?>
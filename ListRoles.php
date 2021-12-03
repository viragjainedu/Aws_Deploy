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
$usersRef = $firestore->collection('Admin_Roles');
$snapshot = $usersRef->documents();
// $vid = $usersRef->document('CMgqyfa10rg')->snapshot();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Staff List</title>
    <?php include('include/head.php') ?>
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
                            <div class="card-box table-responsive">

                                <div class="row">
                                    <div class="col-md-10">
                                        <h4 class="card-title mb-4"><strong>Staff List</strong></h4>
                                    </div>
                                    <div class="col-md-2">
                                        <form action="addRole.php" method="POST">
                                            <button type="submit" name="submit" class="btn btn-success btn-rounded width-md waves-effect waves-light">Add Staff</button>
                                        </form>
                                    </div>
                                </div>
                                <hr>

                                <table id="responsive-datatable" class="table table-bordered table-bordered dt-responsive nowrap table-striped table-hover" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Staff Name</th>
                                            <th>Staff Email</th>
                                            <th>Role</th>
                                            <th>View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($snapshot as $vid) { ?>
                                            <tr>

                                                <td><?php echo $vid["Username"]; ?></td>

                                                <td><?php echo $vid["EmailId"]; ?></td>

                                                <td>
                                                    <?php echo $vid["Role"]; ?>
                                                </td>

                                                <td>
                                                    <div style="display: flex;">

                                                        <form action="editRole.php" method="POST">
                                                            <input name="staffdet" type="hidden" value="<?php echo $vid["EmailId"] ?>">
                                                            <button type="submit" name="submit" class="btn btn-outline-primary" style="height: 2.5em; width: 2.5em; border: none;"><i class="fa fa-lg fa-edit"></i></button>
                                                        </form>

                                                        <button class="btn btn-outline-danger" data-target="#deleteModal<?php echo $vid["Username"]; ?>" id="<?php echo $vid["Username"]; ?>" style="height: 2.5em; width: 2.5em; border:none;" data-toggle="modal"><i class="fa fa-lg fa-trash"></i></button>
                                                    </div>
                                                </td>

                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>



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
    <?php foreach ($snapshot as $slider) { ?>

        <!-- Delete Modal -->

        <div class="modal fade" id="deleteModal<?php echo $slider["Username"]; ?>" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Delete User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this user?</p>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <form action="backend/deleteRole.php" method="POST">
                            <input name="editStaffId" type="hidden" value="<?php echo $slider->id(); ?>">
                            <button name="submit" type="submit" class="btn btn-danger">Delete</button>
                        </form>
                        <!-- <button type="button" id="" name="confirm" class="confirm btn" style="background-color: #df4b4b; color: #ffffff">Delete Product</button> -->

                    </div>
                </div>
            </div>
        </div>

    <?php } ?>



    <?php include('include/script.php') ?>

</body>

</html>
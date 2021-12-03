<?php
session_start();
if (isset($_SESSION['islogin'])) {
    if ($_SESSION['islogin'] == false)
        header("Location: login.php");
} else {
    header("Location: login.php");
}
if (!in_array('Contact_Us', $_SESSION['access'])) {
    header("Location: index.php");
}
include("dbconn.php");
$usersRef = $firestore->collection('Contact_Us');
$snapshot = $usersRef->documents();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Contact Us Page</title>
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
                                <h4 class="card-title mb-4"><strong>Contact Us</strong></h4>
                                <hr>

                                <table id="responsive-datatable" class="table table-bordered table-bordered dt-responsive nowrap table-striped table-hover" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Subject</th>
                                            <th>Message</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php foreach ($snapshot as $cat) { ?>

                                            <tr>
                                                <td><?php echo $cat["Name"]; ?></td>
                                                <td><?php echo $cat["Email"]; ?></td>
                                                <td><?php echo $cat["Subject"]; ?></td>
                                                <td><?php echo $cat["Message"]; ?></td>

                                                <td>
                                                    <button class="btn btn-outline-danger" data-target="#deleteModal<?php echo $cat->id(); ?>" id="<?php echo $cat->id(); ?>" style="height: 2.5em; width: 2.5em; border:none;" data-toggle="modal"><i class="fa fa-lg fa-trash"></i></button>
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
            <!-- <?php include('include/footer.php') ?> -->
            <!-- end Footer -->

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->


    </div>
    <!-- END wrapper -->

    <?php foreach ($snapshot as $cat) { ?>

        <!-- Delete Modal -->

        <div class="modal fade" id="deleteModal<?php echo $cat->id(); ?>" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Delete Contact</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this?</p>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <form action="backend/deleteContact.php" method="POST">
                            <input name="ContactId" type="hidden" value="<?php echo  $cat->id(); ?>">
                            <button name="submit" type="submit" class="btn btn-danger">Delete</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    <?php } ?>

    <?php include('include/script.php') ?>

</body>

</html>
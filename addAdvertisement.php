<?php
session_start();
if (isset($_SESSION['islogin'])) {
    if ($_SESSION['islogin'] == false)
        header("Location: login.php");
} else {
    header("Location: login.php");
}
if (!in_array('Add_Advertisement', $_SESSION['access'])) {
    header("Location: index.php");
}
include('dbconn.php');
require "backend/addAdvertisementdb.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Add Advertisement</title>
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

                            <?php
                            if ($added == 1) {
                            ?>

                                <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                                    <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                                    </symbol>
                                    <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                                    </symbol>
                                </svg>

                                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center " role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                                        <use xlink:href="#check-circle-fill" />
                                    </svg>
                                    <div>
                                        <strong>Success!</strong> Advertisement has been successfully added.
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>

                            <?php
                            } elseif ($added == 2) {
                            ?>

                                <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">

                                    <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                                    </symbol>
                                </svg>

                                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center " role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                                        <use xlink:href="#exclamation-triangle-fill" />
                                    </svg>
                                    <div>
                                        <strong>Oops!</strong> There was a problem in adding Advertisement.

                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>


                            <?php
                            }
                            ?>

                            <div class="card-box">
                                <h4 class="card-title mb-4"><strong>Add Advertisement</strong></h4>
                                <hr>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="p-2">
                                            <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="inputAddress" class="col-form-label">Advertise Link</label>
                                                        <input type="text" id="simpleinput" name="adlink" class="form-control" value="<?php echo $adlink; ?>" required>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="inputPassword4" class="col-form-label">Priority</label>
                                                        <input class="form-control" type="number" name="priority" id="example-number" value="<?php echo $priority; ?>" required>
                                                        <span style="color:red; "><?php echo $errors['priority']; ?></span>
                                                    </div>
                                                </div>

                                                <div class="form-group">

                                                    <label class="col-form-label" for="simpleinput">Images</label>
                                                    <input type="file" class="dropify" name="thumb" data-height="300" required />
                                                </div>



                                                <div class="form-group row">

                                                    <div class="col-md-10">
                                                        <input type="submit" class="btn btn-primary" name="submit" value="Add" style="width:80px;" />
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
            <!-- <?php include('include/footer.php') ?> -->
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
<?php
session_start();
if (isset($_SESSION['islogin'])) {
    if ($_SESSION['islogin'] == false)
        header("Location: login.php");
} else {
    header("Location: login.php");
}
if (!in_array('Add_Series', $_SESSION['access'])) {
    header("Location: index.php");
}
include("dbconn.php");
$catRef = $firestore->collection('Categories');
$snapshot_cat = $catRef->documents();

$oratorRef = $firestore->collection('Orators');
$snapshot_orators = $oratorRef->documents();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Add Series</title>
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
                            <div class="card-box">
                                <h4 class="card-title mb-4"><strong>Add Series</strong></h4>
                                <hr>



                                <div class="row">
                                    <div class="col-12">
                                        <div class="p-2">
                                            <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="backend/addSeriesdb.php">

                                                <div class="form-row">
                                                    <div class="form-group col-md-6">

                                                        <label for="inputEmail4" class="col-form-label">Series Name</label>
                                                        <input type="text" id="simpleinput" name="seriesname" class="form-control" required>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="inputPassword4" class="col-form-label">Orators</label>
                                                        <select class="select2 select2-multiple form-control" name="orators[]" multiple="multiple" multiple data-placeholder="Choose ..." required>
                                                            <?php
                                                            foreach ($snapshot_orators as $vid) {
                                                            ?>
                                                                <option value="<?php echo $vid['name']; ?>"><?php echo $vid['name']; ?></option>

                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="inputEmail4" class="col-form-label">Date</label>
                                                        <input type="text" id="simpleinput" name="date" class="form-control" required>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="inputPassword4" class="col-form-label">Categories</label>
                                                        <select class="select2 select2-multiple form-control" name="categories[]" multiple="multiple" multiple data-placeholder="Choose ..." required>
                                                            <?php
                                                            foreach ($snapshot_cat as $vid) {
                                                            ?>
                                                                <option value="<?php echo $vid['name']; ?>"><?php echo $vid['name']; ?></option>

                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-row">

                                                    <div class="form-group col-md-6">
                                                        <label for="inputAddress" class="col-form-label">Description</label>
                                                        <textarea class="form-control" required name="Des" rows="7" id="example-textarea"></textarea required>
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label for="inputAddress" class="col-form-label">Video Thumbnail</label>
                                                        <input type="file" class="dropify" name="thumb" data-height="155" required/>
                                                    </div>


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
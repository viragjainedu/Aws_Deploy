<?php
session_start();
if (isset($_SESSION['islogin'])) {
    if ($_SESSION['islogin'] == false)
        header("Location: login.php");
} else {
    header("Location: login.php");
}
if (!in_array('Terms_and_Conditions', $_SESSION['access'])) {
    header("Location: index.php");
}
include('dbconn.php');

$updated = 0;

if (isset($_POST['submit'])) {
    $tc = explode(".", $_POST['Des']);
    $tc_data = array();
    $updated = 1;

    for ($i = 0; $i < count($tc) - 1; $i++) {
        $newline = ltrim($tc[$i], " ");
        array_push($tc_data, $newline);
    }

    try {
        $docRef = $firestore->collection('Terms_and_conditions')->document('Terms_and_conditions');
        $docRef->set([

            'Terms_and_conditions' => $tc_data
        ], ['merge' => true]);
    } catch (Exception $exception) {
        print($exception->getMessage());
    }
}

$aboutRef = $firestore->collection('Terms_and_conditions');
$snapshot_about = $aboutRef->document('Terms_and_conditions')->snapshot();


$original_tc = "";
foreach ($snapshot_about["Terms_and_conditions"] as $line) {
    $original_tc .= $line;
    $original_tc .= ". ";
}
$original_tc = rtrim($original_tc, " ");
$original_tc = str_replace('  ', '', $original_tc);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Terms and conditions</title>
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
                            if ($updated == 1) {

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
                                        <strong>Success!</strong> Successfully updated.
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>

                            <?php

                            }
                            ?>

                            <div class="card-box">

                                <h4 class="card-title mb-4"><strong>Terms and conditions</strong></h4>
                                <hr>

                                <div class="row">
                                    <div class="col-12">


                                        <div class="p-2">
                                            <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                                                <div class="form-group">
                                                    <label for="inputAddress" class="col-form-label">Terms and conditions</label>
                                                    <textarea class="form-control" required name="Des" rows="9" id="example-textarea"><?php echo $original_tc; ?></textarea>
                                                </div>

                                                <div class="form-group row">

                                                    <div class="col-md-10">
                                                        <input type="submit" class="btn btn-primary" name="submit" value="Save" style="width:80px;" />
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
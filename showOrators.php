<?php
session_start();
if (isset($_SESSION['islogin'])) {
    if ($_SESSION['islogin'] == false) {
        header("Location: login.php");
    }
} else {
    header("Location: login.php");
}
if (!in_array('Add_Orator', $_SESSION['access'])) {
    header("Location: index.php");
}
include('dbconn.php');
$orator_id = $_POST['editOratorId'];
$oratordet = $firestore->collection('Orators')->document($orator_id)->snapshot();
$enabledOrators = $firestore->collection('ShowOrators')->document($orator_id)->snapshot();
if ($enabledOrators->exists()) {
    $enabledOrators = $enabledOrators->data()['type'];
} else {
    $enabledOrators = array();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Show Orators</title>
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
                                <h4 class="card-title mb-4"><strong>Orators</strong></h4>
                                <hr>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="p-2">
                                            <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="backend/addShowOrator.php">
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="inputEmail4" class="col-form-label">Orator Name</label>
                                                        <input type="text" id="simpleinput" value="<?php echo $oratordet["name"] ?>" name="orratorname" class="form-control" readonly>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="inputAddress" class="col-form-label">Type</label>
                                                        <div class="checkbox checkbox-info column-checkbox">
                                                            <?php foreach ($oratordet['videoType'] as $det) { ?>

                                                                <input id="<?php echo $det ?>" name="<?php echo str_replace(' ', '', $det) ?>" type="checkbox" value="<?php echo $det ?>" <?php if (in_array($det, $enabledOrators)) {
                                                                                                                                                                                                echo "checked";
                                                                                                                                                                                            } ?>>
                                                                <label for="<?php echo $det ?>"><?php echo $det ?></label>

                                                                <?php echo "<br/>"; ?>
                                                            <?php } ?>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-10">
                                                        <input name="OratorId" type="hidden" value="<?php echo  $orator_id; ?>">
                                                        <input type="submit" class="btn btn-primary" name="submit" id="submit" value="Add" style="width:80px;" />
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
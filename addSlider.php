<?php
session_start();
if (isset($_SESSION['islogin'])) {
    if ($_SESSION['islogin'] == false)
        header("Location: login.php");
} else {
    header("Location: login.php");
}
if (!in_array('Slider', $_SESSION['access'])) {
    header("Location: index.php");
}
include("dbconn.php");
$videos = $firestore->collection('Videos')->documents();
$pri = $firestore->collection('Sliders')->documents();
$arr1 = array();
foreach ($pri as $docs) {
    $temp = $docs->data();
    array_push($arr1, $temp['Priority']);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Add Slider</title>
    <?php include('include/head.php') ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        //isLive change
        $(function() {
            $(document).ready(function() {
                $('#viId').select2();
                $('#submit').click(function(e) {
                    var isValid = true;
                    $('#priority').each(function() {
                        var arr = <?php echo json_encode($arr1) ?>;
                        for (var tem of arr) {
                            if (tem == $(this).val()) {
                                isValid = false;
                                console.log("detected");
                                $(this).css({
                                    "border": "1px solid red",
                                    "background": "#FFCECE"
                                });
                                break;
                            }
                        }
                    });
                    if (isValid == false)
                        e.preventDefault();
                });
            });
        });
    </script>
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
                                <h4 class="card-title mb-4"><strong>Add Slider</strong></h4>
                                <hr>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="p-2">
                                            <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="backend/addSliderdb.php">
                                                <div class="form-group row">
                                                    <div class="form-group col-md-6">
                                                        <label for="inputEmail4" class="col-form-label">Video</label>
                                                        <select name="viId" id="viId" class="form-control" required>
                                                            <option>--Select--</option>
                                                            <?php
                                                            foreach ($videos as $doc) {
                                                                $ref = $doc->data();
                                                            ?>
                                                                <option value=<?php echo $doc->id() ?>><?php echo $ref['Video Name'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label class="col-form-label">Priority</label>
                                                        <input type="number" id="priority" name="priority" class="form-control" required>
                                                    </div>

                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-10">
                                                        <input type="submit" class="btn btn-primary" id="submit" name="submit" value="Add" style="width:80px;" />
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
<?php
session_start();
if (isset($_SESSION['islogin'])) {
    if ($_SESSION['islogin'] == false)
        header("Location: login.php");
} else {
    header("Location: login.php");
}
if (!in_array('Series_List', $_SESSION['access'])) {
    header("Location: index.php");
}
include("dbconn.php");
$usersRef = $firestore->collection('Series');
$snapshot = $usersRef->documents();
// $vid = $usersRef->document('CMgqyfa10rg')->snapshot();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Series List</title>
    <?php include('include/head.php') ?>

    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(function() {
            $(document).on('change', '.isLive', function() {
                var id = $(this).attr('id');
                var val = $(this).val();
                console.log(val);
                console.log(id);

                var posting = $.post('backend/enableSeries.php', {
                    isLive: val,
                    id: id,
                    action: 'makeLive'
                });


            });
        });
    </script> -->
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
                                <h4 class="card-title mb-4"><strong>Series List</strong></h4>
                                <hr>

                                <table id="responsive-datatable" class="table table-bordered table-bordered dt-responsive nowrap table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Series Name</th>
                                            <th>Description</th>
                                            <th>Categories</th>
                                            <th>View</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach ($snapshot as $vid) { ?>
                                            <tr>
                                                <td><?php echo $vid["Series Name"]; ?></td>
                                                <td><?php echo $vid["Description"]; ?></td>
                                                <td>
                                                    <?php
                                                    $cats = "";
                                                    foreach ($vid["Categories"] as $cat) {
                                                        $cats .= $cat;
                                                        $cats .= ", ";
                                                    }
                                                    $cats = rtrim($cats, " ");
                                                    $cats = rtrim($cats, ",");
                                                    echo $cats;

                                                    ?>
                                                </td>
                                                <td>
                                                    <div style="display: flex;">
                                                        <form action="SeriesDetails.php" method="POST">
                                                            <input name="seriesdet" type="hidden" value="<?php echo  $vid->id(); ?>">
                                                            <button style="height: 2.5em; width: 3.5em;" type="submit" name="submit"> <i>View</i> </button>
                                                        </form>
                                                        <form action="editSeries.php" method="POST">
                                                            <input name="seriesdet" type="hidden" value="<?php echo  $vid->id(); ?>">
                                                            <button type="submit" name="submit1" class="btn btn-outline-primary" style="height: 2.5em; width: 2.5em; border: none;"><i class="fa fa-lg fa-edit"></i></button>
                                                        </form>
                                                        <button class="btn btn-outline-danger" data-target="#deleteModal<?php echo $vid->id(); ?>" id="<?php echo $vid->id(); ?>" style="height: 2.5em; width: 2.5em; border:none;" data-toggle="modal"><i class="fa fa-lg fa-trash"></i></button>

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
            <!-- <?php include('include/footer.php') ?> -->
            <!-- end Footer -->

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->


    </div>
    <!-- END wrapper -->
    <?php foreach ($snapshot as $ser) { ?>

        <!-- Delete Modal -->

        <div class="modal fade" id="deleteModal<?php echo $ser->id(); ?>" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Delete Series</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this Series?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <form action="backend/deleteSeries.php" method="POST">
                            <input name="editSeriesId" type="hidden" value="<?php echo  $ser->id(); ?>">
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
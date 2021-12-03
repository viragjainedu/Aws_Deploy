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
$usersRef = $firestore->collection('Sliders');
$snapshot = $usersRef->documents();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Slider</title>
    <?php include('include/head.php') ?>

    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        //isLive change
        $(function() {
            $(document).on('change', '.isLive', function() {
                var id = $(this).attr('id');
                var val = $(this).val();

                console.log(val);
                console.log(id);

                var posting = $.post('backend/enableSlider.php', {
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
            <div class="row">
                <div class="col-12">
                    <div class="card-box table-responsive">
                        <!-- <h4 class="card-title mb-4"><strong>Preview</strong></h4> -->
                        <!-- <div class="row">
                            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                </ol>
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img class="d-block w-100 h-50" src="https://storage.googleapis.com/sdi-ott.appspot.com/Sliders/Naat Sharif/PWOlJKnwFHM/PG-4.png" alt="First slide">
                                    </div>
                                    <div class="carousel-item">
                                        <img class="d-block w-100 h-50" src="https://storage.googleapis.com/sdi-ott.appspot.com/Sliders/Short Clip/eMxYPpbvy_A/PG-5.png" alt="Second slide">
                                    </div>
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div> -->
                        <div class="row">
                            <div class="col-md-10">
                                <h4 class="card-title mb-4"><strong>Sliders List</strong></h4>
                            </div>
                            <div class="col-md-2">
                                <form action="addSlider.php" method="POST">
                                    <button type="submit" name="submit" class="btn btn-success btn-rounded width-md waves-effect waves-light">Add Slider</button>
                                </form>
                            </div>
                        </div>

                        <hr>

                        <table id="responsive-datatable" class="table table-bordered table-bordered dt-responsive nowrap table-striped table-hover" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Video ID</th>
                                    <th>Video Type</th>
                                    <th>IsLive</th>
                                    <th>Edit/Delete</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($snapshot as $slider) { ?>

                                    <tr>
                                        <td>
                                            <?php echo $slider["Video ID"]; ?>
                                        </td>

                                        <td>
                                            <?php
                                            echo $slider["Video Type"];
                                            ?>
                                        </td>

                                        <td>
                                            <?php echo $slider['Is Live'] ? "Yes" : "No" ?>
                                        </td>
                                        <td>

                                            <div style="display: flex;">

                                                <form action="editSlider.php" method="POST">
                                                    <input name="editSliderId" type="hidden" value="<?php echo  $slider->id(); ?>">
                                                    <button name="submit1" type="submit" class="btn btn-outline-primary" style="height: 2.5em; width: 2.5em; border: none;"><i class="fa fa-lg fa-edit"></i></button>
                                                    </button>


                                                </form>

                                                <button class="btn btn-outline-danger" data-target="#deleteModal<?php echo $slider->id(); ?>" id="<?php echo $slider->id(); ?>" style="height: 2.5em; width: 2.5em; border:none;" data-toggle="modal"><i class="fa fa-lg fa-trash"></i></button>


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

    <?php foreach ($snapshot as $slider) { ?>

        <!-- Delete Modal -->

        <div class="modal fade" id="deleteModal<?php echo $slider->id(); ?>" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Delete Slider</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this Slider?</p>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <form action="backend/deleteSlider.php" method="POST">
                            <input name="editSliderId" type="hidden" value="<?php echo  $slider->id(); ?>">
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
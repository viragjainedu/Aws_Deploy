<?php
session_start();
if (isset($_SESSION['islogin'])) {
    if ($_SESSION['islogin'] == false)
        header("Location: login.php");
} else {
    header("Location: login.php");
}
if (!in_array('Add_Video', $_SESSION['access'])) {
    header("Location: index.php");
}
include('dbconn.php');
require "backend/addVideodb.php";

$catRef = $firestore->collection('Categories');
$snapshot_cat = $catRef->documents();

$oratorsRef = $firestore->collection('Orators');
$snapshot_orators = $oratorsRef->documents();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Add Video</title>
    <?php include('include/head.php') ?>

    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>

    <!-- <script>
        function getCat(vid_type) {
            // alert(vid_type); 
            $.ajax({
                url: 'getdata.php',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    vid_type: vid_type
                },
                success: function(res) {
                    txt = '';
                    $.each(res, function(i, categories) {
                        txt += '<option value="' + categories.name + '">' + categories.name + '</option>';
                    });
                    $('#categories_id').html(txt);
                }
            });
        }
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
                                        <strong>Success!</strong> Video has been successfully added.
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>

                            <?php
                            }
                            ?>

                            <div class="card-box">
                                <h4 class="card-title mb-4"><strong>Add Video</strong></h4>
                                <hr>



                                <div class="row">
                                    <div class="col-12">
                                        <div class="p-2">
                                            <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                                                <div class="form-group">
                                                    <label for="inputAddress" class="col-form-label">Video Link</label>
                                                    <input type="text" id="simpleinput" name="videolink" class="form-control" required>
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="inputEmail4" class="col-form-label">Video Name</label>
                                                        <input type="text" id="simpleinput" name="videoname" class="form-control" required>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="inputPassword4" class="col-form-label">Video Type</label>
                                                        <!-- <select name="vitype" id="vitype_id" class="form-control" required onChange="getCat(this.value)"> -->
                                                        <select name="vitype" id="vitype_id" class="form-control" required>
                                                            <option value="">--Select--</option>
                                                            <option value="Naat Sharif">Naat Sharif</option>
                                                            <option value="Bayan">Bayan</option>
                                                            <option value="Short Clip">Short Clip</option>
                                                        </select>

                                                    </div>
                                                </div>

                                                <div class="form-row">
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
                                                    <div class="form-group col-md-6">
                                                        <label for="inputPassword4" class="col-form-label">Categories</label>

                                                        <select class="select2 select2-multiple form-control categories_list" name="categories[]" id="categories_id" multiple="multiple" multiple data-placeholder="Choose ...">
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

                                                <div class="form-group">
                                                    <label for="inputAddress" class="col-form-label">Description</label>
                                                    <textarea class="form-control" required name="Des" rows="5" id="example-textarea"></textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-form-label" for="simpleinput">Video Thumbnail</label>
                                                    <input type="file" class="dropify" name="thumb" data-height="300" data-default-file="assets/images/defaultVideoThumbnail.jpeg" />
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="inputEmail4" class="col-form-label">Location</label>
                                                        <input type="text" id="simpleinput" name="loc" class="form-control" required>
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label for="inputEmail4" class="col-form-label">Date</label>
                                                        <input type="text" id="simpleinput" name="date" class="form-control" required>
                                                    </div>

                                                </div>



                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="inputEmail4" class="col-form-label">Is Live</label>
                                                        <div style="display:flex;">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="customRadio1" value="Yes" name="customRadio" class="custom-control-input">
                                                                <label class="custom-control-label" for="customRadio1">Yes</label>
                                                            </div>
                                                            <div class="custom-control custom-radio mx-4">
                                                                <input type="radio" id="customRadio2" value="No" name="customRadio" class="custom-control-input" checked>
                                                                <label class="custom-control-label" for="customRadio2">No</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="inputPassword4" class="col-form-label">Tags</label>
                                                        <select multiple data-role="tagsinput" name="tags[]">

                                                        </select>
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
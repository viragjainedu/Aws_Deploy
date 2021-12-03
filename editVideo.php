<?php
session_start();
if (isset($_SESSION['islogin'])) {
    if ($_SESSION['islogin'] == false)
        header("Location: login.php");
} else {
    header("Location: login.php");
}
if (!in_array('Videos_List', $_SESSION['access'])) {
    header("Location: index.php");
}
include('dbconn.php');
require "backend/editVideodb.php";

$catRef = $firestore->collection('Categories');
$snapshot_cat = $catRef->documents();

$oratorsRef = $firestore->collection('Orators');
$snapshot_orators = $oratorsRef->documents();

?>

<?php
if (isset($_POST['submitChanges'])) {
    $video_id = $_POST['editVideoId'];
    $usersRef = $firestore->collection('Videos');
    // $snapshot = $usersRef->documents();
    $videoDet = $usersRef->document($video_id)->snapshot();
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Edit Video</title>
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



                                    <div class="row">
                                        <div class="col-12">
                                            <div class="p-2">
                                                <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                                                    <div class="form-group">
                                                        <label for="inputAddress" class="col-form-label">Video Link</label>
                                                        <input type="text" id="simpleinput" name="videolink" class="form-control" value="<?php echo $videoDet['Video Link']; ?>" readonly>
                                                    </div>

                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label for="inputEmail4" class="col-form-label">Video Name</label>
                                                            <input type="text" id="simpleinput" name="videoname" class="form-control" value="<?php echo $videoDet['Video Name']; ?>" required>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="inputPassword4" class="col-form-label">Video Type</label>
                                                            <select name="vitype" class="form-control" required>
                                                                <option>--Select--</option>
                                                                <option value="Naat Sharif" <?php if ($videoDet['Type'] == 'Naat Sharif') echo 'selected'; ?>>Naat Sharif</option>
                                                                <option value="Bayan" <?php if ($videoDet['Type'] == 'Bayan') echo 'selected'; ?>>Bayan</option>
                                                                <option value="Short Clip" <?php if ($videoDet['Type'] == 'Short Clip') echo 'selected'; ?>>Short Clip</option>
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
                                                                    <option value="<?php echo $vid['name']; ?>" <?php if (in_array($vid['name'], $videoDet['Orator Name'])) {
                                                                                                                    echo "selected";
                                                                                                                };
                                                                                                                ?>>
                                                                        <?php echo $vid['name']; ?>
                                                                    </option>

                                                                <?php
                                                                }
                                                                ?>
                                                            </select>

                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="inputPassword4" class="col-form-label">Categories</label>

                                                            <select class="select2 select2-multiple form-control" name="categories[]" multiple="multiple" multiple data-placeholder="Choose ...">

                                                                <?php
                                                                foreach ($snapshot_cat as $vid) {
                                                                ?>
                                                                    <option value="<?php echo $vid['name']; ?>" <?php if (in_array($vid['name'], $videoDet['Categories'])) {
                                                                                                                    echo "selected";
                                                                                                                };
                                                                                                                ?>>
                                                                        <?php echo $vid['name']; ?>
                                                                    </option>

                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="inputAddress" class="col-form-label">Description</label>

                                                        <textarea class="form-control" required name="Des" rows="5" id="example-textarea" required><?php echo $videoDet['Description']; ?>

                                                </textarea>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label class="col-form-label" for="simpleinput">Video Thumbnail</label><br />
                                                            <img src="<?php echo $videoDet['Video Thumbnail']; ?>" width="100%" height="315px">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label class="col-form-label" for="simpleinput">Change Thumbnail</label>
                                                            <input type="file" class="dropify" name="thumb" data-height="300" />
                                                        </div>
                                                    </div>

                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label for="inputEmail4" class="col-form-label">Location</label>
                                                            <input type="text" id="simpleinput" name="loc" class="form-control" value="<?php echo $videoDet['Location']; ?>" required>
                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <label for="inputEmail4" class="col-form-label">Date</label>
                                                            <input type="text" id="simpleinput" name="date" class="form-control" value="<?php echo $videoDet['Date']; ?>" required>
                                                        </div>

                                                    </div>



                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label for="inputEmail4" class="col-form-label">Is Live</label>

                                                            <div style="display:flex;">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio" id="customRadio1" value="Yes" name="customRadio" class="custom-control-input" <?php
                                                                                                                                                                        if ($videoDet['Is Live']) echo "checked";
                                                                                                                                                                        ?>>
                                                                    <label class="custom-control-label" for="customRadio1">Yes</label>
                                                                </div>
                                                                <div class="custom-control custom-radio mx-4">
                                                                    <input type="radio" id="customRadio2" value="No" name="customRadio" class="custom-control-input" <?php
                                                                                                                                                                        if (!$videoDet['Is Live']) echo "checked";
                                                                                                                                                                        ?>>
                                                                    <label class="custom-control-label" for="customRadio2">No</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="inputPassword4" class="col-form-label">Tags</label>
                                                            <select multiple data-role="tagsinput" name="tags[]">
                                                                <?php
                                                                foreach ($videoDet['Tags'] as $videoTag) {
                                                                ?>
                                                                    <option value="<?php echo $videoTag; ?>"><?php echo $videoTag; ?></option>

                                                                <?php
                                                                }
                                                                ?>

                                                            </select>
                                                        </div>
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

<?php } ?>
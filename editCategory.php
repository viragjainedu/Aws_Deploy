<?php
session_start();
if (isset($_SESSION['islogin'])) {
    if ($_SESSION['islogin'] == false)
        header("Location: login.php");
} else {
    header("Location: login.php");
}
if (!in_array('Categories_List', $_SESSION['access'])) {
    header("Location: index.php");
}
include('dbconn.php');
require "backend/editCategorydb.php";

if (isset($_POST['submitChanges'])) {
    $cat_id = $_POST['editCatId'];
    $_SESSION['editCatId'] = $cat_id;

    $usersRef = $firestore->collection('Categories');
    $catDet = $usersRef->document($cat_id)->snapshot();

    $category = $catDet['name'];
    $priority = $catDet['priority'];
    $cat_type = $catDet['Type'];

    $original_color = "#" . substr($catDet['color'], 4);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Category</title>
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
                            if ($added == 2) {
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
                                        <strong>Oops!</strong> There was a problem in updating category.
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php
                            }
                            ?>

                            <div class="card-box">

                                <h4 class="card-title mb-4"><strong>Edit Category</strong></h4>
                                <hr>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="p-2">
                                            <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="inputEmail4" class="col-form-label">Category Name</label>
                                                        <input type="text" id="simpleinput" name="catName" class="form-control" value="<?php echo $category; ?>" disabled>
                                                        <input type="hidden" name="catName" value="<?php echo $category; ?>">
                                                        <input type="hidden" name="categoryedit" value="<?php echo str_replace(' ', '', $category); ?>">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="inputPassword4" class="col-form-label">Video Type</label>
                                                        <select name="vitype" class="form-control" required>
                                                            <option value="Naat Sharif" <?php if ($cat_type == 'Naat Sharif') echo 'selected'; ?>>Naat Sharif</option>
                                                            <option value="Bayan" <?php if ($cat_type == 'Bayan') echo 'selected'; ?>>Bayan</option>
                                                            <option value="Short Clip" <?php if ($cat_type == 'Short Clip') echo 'selected'; ?>>Short Clip</option>
                                                        </select>
                                                    </div>

                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="inputPassword4" class="col-form-label">Priority</label>
                                                        <input class="form-control" type="number" name="priority" id="example-number" value="<?php echo $priority; ?>" required>
                                                        <span style="color:red; "><?php echo $errors['priority']; ?></span>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="inputPassword4" class="col-form-label">Color</label>
                                                        <input class="form-control" type="color" name="color" value="<?php echo $original_color; ?>" id="example-color">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <input type="hidden" name="cat_id" value="<?php echo $cat_id ?>">
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
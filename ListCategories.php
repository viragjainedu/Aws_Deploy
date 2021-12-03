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
include("dbconn.php");
$usersRef = $firestore->collection('Categories');
$snapshot = $usersRef->documents();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Categories</title>
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

                var posting = $.post('backend/enableCategory.php', {
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

                            <?php
                            if (isset($_SESSION['categoryUpdated'])) {
                                if ($_SESSION['categoryUpdated'] == 'Updated') {
                                    $_SESSION['categoryUpdated'] = 'notUpdated';
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
                                            <strong>Success!</strong> Category has been successfully updated.
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>

                            <?php
                                }
                            }
                            ?>

                            <div class="card-box table-responsive">
                                <h4 class="card-title mb-4"><strong>Categories List</strong></h4>
                                <hr>

                                <table id="responsive-datatable" class="table table-bordered table-bordered dt-responsive nowrap table-striped table-hover" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>Category Name</th>
                                            <th>Type</th>
                                            <th>Priority</th>
                                            <th>Color</th>
                                            <th>Edit/Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php foreach ($snapshot as $cat) { ?>

                                            <tr>
                                                <td><?php echo $cat["name"]; ?></td>
                                                <td><?php echo $cat["Type"]; ?></td>
                                                <td><?php echo $cat["priority"]; ?></td>

                                                <td>
                                                    <div style="background-color: <?php echo "#" . substr($cat['color'], 4); ?> ;">
                                                        &nbsp;
                                                    </div>
                                                </td>
                                                <!-- <td>
                                                    <?php if ($cat['Is Live'] == 'Yes') { ?>
                                                        <select class="isLive" name="isLive" id="<?php echo $cat->id(); ?>">
                                                            <option value="Yes">Yes</option>
                                                            <option value="No">No</option>
                                                        </select>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <select class="isLive" name="isLive" id="<?php echo $cat->id(); ?>">
                                                            <option value="No">No</option>
                                                            <option value="Yes">Yes</option>
                                                        </select>
                                                    <?php
                                                    }
                                                    ?>
                                                </td> -->
                                                <td>

                                                    <div style="display: flex;">

                                                        <form action="editCategory.php" method="POST">
                                                            <input name="editCatId" type="hidden" value="<?php echo  $cat->id(); ?>">
                                                            <button name="submitChanges" type="submit" class="btn btn-outline-primary" style="height: 2.5em; width: 2.5em; border: none;"><i class="fa fa-lg fa-edit"></i></button>
                                                            </button>


                                                        </form>

                                                        <button class="btn btn-outline-danger" data-target="#deleteModal<?php echo $cat->id(); ?>" id="<?php echo $cat->id(); ?>" style="height: 2.5em; width: 2.5em; border:none;" data-toggle="modal"><i class="fa fa-lg fa-trash"></i></button>


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

    <?php foreach ($snapshot as $cat) { ?>

        <!-- Delete Modal -->

        <div class="modal fade" id="deleteModal<?php echo $cat->id(); ?>" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Delete Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this category?</p>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <form action="backend/deleteCategory.php" method="POST">
                            <input name="editCatId" type="hidden" value="<?php echo  $cat->id(); ?>">
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
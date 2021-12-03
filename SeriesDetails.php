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

if (isset($_POST['submit'])) {
    $series_id = $_POST['seriesdet'];
    $usersRef = $firestore->collection('Series')->document($series_id);
    $seriesDet = $usersRef->snapshot();
    $season = $usersRef->collection("Seasons")->documents();
    $temp = 0;
    $arr = array();
    foreach ($season as $document) {
        if ($document->exists()) {
            $temp = $document->data();
            $arr[$document->id()] = array();
            $ref = $usersRef->collection("Seasons")->document($document->id())->collection("Episodes")->documents();
            foreach ($ref as $doc2) {
                $arr[$document->id()][$doc2->id()]['Video ID'] = $doc2->id();
                $arr[$document->id()][$doc2->id()]['Season ID'] = $document->id();
                $arr[$document->id()][$doc2->id()]['Video Name'] = $doc2['Video Name'];
                $arr[$document->id()][$doc2->id()]['Orator Name'] = $doc2['Orator Name'];
                $arr[$document->id()][$doc2->id()]['Episode No'] = $doc2['Episode No'];
                $arr[$document->id()][$doc2->id()]['Categories'] = $doc2['Categories'];
                $arr[$document->id()][$doc2->id()]['Is Live'] = $doc2['Is Live'];
                $arr[$document->id()][$doc2->id()][$doc2->id()] = $document->id();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo $seriesDet['Series Name']; ?></title>
    <?php include('include/head.php') ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
                                <div class="row">
                                    <div class="col-md-10">
                                        <h4 class="card-title mb-4"><strong><?php echo $seriesDet['Series Name'] ?></strong></h4>
                                    </div>
                                    <div class="col-md-2">
                                        <form action="AddSeasons.php" method="POST">
                                            <input name="seriesdet" type="hidden" value="<?php echo  $series_id; ?>">
                                            <button type="submit" name="submit" class="btn btn-success btn-rounded width-md waves-effect waves-light">Add Season</button>
                                        </form>
                                    </div>
                                </div>
                                <hr>
                                <?php
                                if ($temp == 0) {
                                    echo '<h5>Seasons does not exist!</h5>';
                                } else {
                                ?>
                                    <div id="accordion" class="mb-3">
                                        <?php
                                        $te = 0;
                                        foreach ($arr as $x => $xvalue) {
                                            $te++;

                                        ?>
                                            <div class="card mb-1">
                                                <div class="card-header" id="<?php echo $x ?>">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <h5 class="m-0">
                                                                <a class="text-dark" data-toggle="collapse" href=<?php echo '#coll' . str_replace(' ', '', $x) ?> aria-expanded=<?php if ($te <= 1) {
                                                                                                                                                                                echo "true";
                                                                                                                                                                            } else {
                                                                                                                                                                                echo "false";
                                                                                                                                                                            } ?>>
                                                                    <i class="mdi mdi-arrow-down-drop-circle-outline mr-1"></i>
                                                                    <?php echo $x ?>
                                                                </a>
                                                            </h5>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <form action="addEpisode.php" method="POST">
                                                                <input name="epidet" type="hidden" value="<?php echo $x; ?>">
                                                                <input name="serdet" type="hidden" value="<?php echo $series_id; ?>">
                                                                <button type="submit" name="submit1" class="btn btn-success btn-rounded width-md waves-effect waves-light">Add Episode</button>
                                                            </form>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <button type="submit" data-target="#deleteModal<?php echo str_replace(' ', '', $x) ?>" id="<?php echo str_replace(' ', '', $x) ?>" data-toggle="modal" name="submit2" class="btn btn-danger btn-rounded width-md waves-effect waves-light">Delete Season</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id=<?php echo 'coll' . str_replace(' ', '', $x) ?> class=<?php if ($te <= 1) {
                                                                                                                echo "collapse show";
                                                                                                            } else {
                                                                                                                echo "collapse";
                                                                                                            } ?> aria-labelledby="<?php echo $x ?>" data-parent="#accordion">
                                                    <div class="card-body">
                                                        <table id="responsive-datatable" class="table table-bordered table-bordered dt-responsive nowrap table-striped table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th>Episode No</th>
                                                                    <th>Episode Name</th>
                                                                    <th>Orators Name</th>
                                                                    <th>Categories</th>
                                                                    <th>Is Live</th>
                                                                    <th>Edit/Delete</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                foreach ($xvalue as $vid) {
                                                                    if ($vid != null) {
                                                                ?>
                                                                        <tr>
                                                                            <td><?php echo $vid['Episode No']; ?></td>
                                                                            <td><?php echo $vid['Video Name']; ?></td>
                                                                            <td>
                                                                                <?php
                                                                                $orators = "";
                                                                                foreach ($vid["Orator Name"] as $orator) {
                                                                                    $orators .= $orator;
                                                                                    $orators .= ", ";
                                                                                }
                                                                                $orators = rtrim($orators, " ");
                                                                                $orators = rtrim($orators, ",");
                                                                                echo $orators;

                                                                                ?>
                                                                            </td>
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
                                                                                <?php echo $vid['Is Live'] ? "Yes" : "No" ?>
                                                                            </td>
                                                                            <td>
                                                                                <div style="display: flex;">
                                                                                    <form action="editEpisodes.php" method="POST">
                                                                                        <input name="editEpisodeId" type="hidden" value="<?php echo  $vid['Video ID']; ?>">
                                                                                        <input name="epidet" type="hidden" value="<?php echo $vid['Season ID']; ?>">
                                                                                        <input name="serdet" type="hidden" value="<?php echo $series_id; ?>">
                                                                                        <button type="submit" name="submit" class="btn btn-outline-primary" style="height: 2.5em; width: 2.5em; border: none;"><i class="fa fa-lg fa-edit"></i></button>
                                                                                    </form>
                                                                                    <button class="btn btn-outline-danger" data-target="#deleteModal<?php echo $vid['Video ID'] ?>" id="<?php echo $vid['Video ID'] ?>" style="height: 2.5em; width: 2.5em; border:none;" data-toggle="modal"><i class="fa fa-lg fa-trash"></i></button>
                                                                                </div>
                                                                            </td>

                                                                        </tr>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </tbody>
                                                            <?php  ?>

                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        } ?>
                                    </div>
                                <?php }
                                ?>


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
    <?php 
        foreach($season as $sea){
            $episodes = $usersRef->collection('Seasons')->document($sea->id())->collection('Episodes')->documents();
            foreach($episodes as $epi){
                $vid = $epi->data();
    ?>
    <div class="modal fade" id="deleteModal<?php echo $vid['Video ID'] ?>" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Delete Episode</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this Episode?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <form action="backend/deleteEpisode.php" method="POST">
                        <input name="editEpisodeId" type="hidden" value="<?php echo  $vid['Video ID']; ?>">
                        <input name="epidet" type="hidden" value="<?php echo $sea->id(); ?>">
                        <input name="serdet" type="hidden" value="<?php echo $series_id; ?>">
                        <button name="submit" type="su bmit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php }?>
    <div class="modal fade" id="deleteModal<?php echo str_replace(' ', '', $sea->id()) ?>" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Delete Season</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this Season?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <form action="backend/deleteSeason.php" method="POST">
                        <input name="epidet" type="hidden" value="<?php echo $sea->id(); ?>">
                        <input name="serdet" type="hidden" value="<?php echo $series_id; ?>">
                        <button name="submit3" type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php }?>
    <?php include('include/script.php') ?>

</body>

</html>
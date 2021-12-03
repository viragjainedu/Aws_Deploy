<?php
session_start();
if (isset($_SESSION['islogin'])) {
    if ($_SESSION['islogin'] == false)
        header("Location: login.php");
} else {
    header("Location: login.php");
}
if (!in_array('Donations', $_SESSION['access'])) {
    header("Location: index.php");
}
include('dbconn.php');
$usersRef = $firestore->collection('Donations');
$snapshot = $usersRef->documents();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Donation Page</title>
    <?php include('include/head.php') ?>

    <!-- <style>
        .card-title {
            color: white;
            font-weight: bold;
            font-size: 25px;
        }
    </style> -->

    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script type="text/javascript">
        function hideAll() {
            document.getElementById('Offline').style.display = 'none';
            document.getElementById('Online').style.display = 'none';
        }
        window.onload = hideAll;
    </script>

    <script>
        //mode change
        $(function() {
            $('input[name="mode"]').on('change', function() {
                var val = $(this).val();
                console.log(val);

                if (val == 'Online') {
                    document.getElementById('Offline').style.display = 'none';
                    document.getElementById('Online').style.display = 'block';
                } else {
                    document.getElementById('Online').style.display = 'none';
                    document.getElementById('Offline').style.display = 'block';

                }


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
                                <?php
                                $total_donation = $today_donation = $month_donation = $week_donation = 0;
                                $lastYear_donation = $thisYear_donation = $lastMonth_donation = $lastWeek_donation = $lastDay_donation = 0;

                                date_default_timezone_set('Asia/Kolkata');
                                $FirstDay = date("Y-m-d", strtotime('sunday last week'));
                                $LastDay = date("Y-m-d", strtotime('sunday this week'));

                                $startMonth = date("Y-m-d", strtotime('first day of last month'));
                                $endMonth = date("Y-m-d", strtotime('last day of last month'));

                                $startweek = date("Y-m-d", strtotime('monday last week'));
                                $endweek = date("Y-m-d", strtotime('sunday last week'));

                                $startLastYear = date("Y-m-d", strtotime("last year January 1st"));
                                $endLastYear = date("Y-m-d", strtotime("last year December 31st"));

                                $startThisYear = date("Y-m-d", strtotime("this year January 1st"));
                                $endThisYear = date("Y-m-d", strtotime("this year December 31st"));

                                $yesterday = date("Y-m-d", strtotime("yesterday"));

                                foreach ($snapshot as $donor) {

                                    $total_donation = $total_donation + (int)$donor['Amount'];
                                    if (date("Y-m-d", strtotime($donor["DateCreated"])) == date('Y-m-d', time())) {
                                        $today_donation = $today_donation + (int)$donor['Amount'];
                                    }
                                    if (date("Y-m", strtotime($donor["DateCreated"])) == date('Y-m', time())) {
                                        $month_donation = $month_donation + (int)$donor['Amount'];
                                    }

                                    $Date = date("Y-m-d", strtotime($donor["DateCreated"]));

                                    if ($Date > $FirstDay && $Date <= $LastDay) {
                                        $week_donation = $week_donation + (int)$donor['Amount'];
                                    }

                                    if ($Date >= $startMonth && $Date <= $endMonth) {
                                        $lastMonth_donation = $lastMonth_donation + (int)$donor['Amount'];
                                    }

                                    if ($Date >= $startweek && $Date <= $endweek) {
                                        $lastWeek_donation = $lastWeek_donation + (int)$donor['Amount'];
                                    }

                                    if ($Date >= $startLastYear && $Date <= $endLastYear) {
                                        $lastYear_donation = $lastYear_donation + (int)$donor['Amount'];
                                    }

                                    if ($Date >= $startThisYear && $Date <= $endThisYear) {
                                        $thisYear_donation = $thisYear_donation + (int)$donor['Amount'];
                                    }

                                    if ($Date == $yesterday) {
                                        $lastDay_donation = $lastDay_donation + (int)$donor['Amount'];
                                    }
                                }

                                if ($lastYear_donation == 0) {
                                    $lastYear_donation = 1;
                                }

                                if ($thisYear_donation == 0) {
                                    $thisYear_donation = 1;
                                }

                                if ($lastMonth_donation == 0) {
                                    $lastMonth_donation = 1;
                                }

                                if ($lastWeek_donation == 0) {
                                    $lastWeek_donation = 1;
                                }

                                if ($lastDay_donation == 0) {
                                    $lastDay_donation = 1;
                                }

                                $dayStatistics = round($today_donation * 100 / $lastDay_donation);
                                $weekStatistics = round($week_donation * 100 / $lastWeek_donation);
                                $monthStatistics = round($month_donation * 100 / $lastMonth_donation);
                                $yearStatistics = round($thisYear_donation * 100 / $lastYear_donation);

                                ?>

                                <h4 class="card-title mb-4"><strong>Donations</strong></h4>
                                <hr>

                                <div class="row">

                                    <div class="col-xl-3 col-md-6">
                                        <div class="card-box widget-user" style="border: 1px solid; width: 275px; border-radius:20px; ">

                                            <?php
                                            if ($yearStatistics >= 100) {
                                                echo '<h4 class="header-title mt-0 mb-4">Total Donation ( ' . '<text style="color:green";>' . $yearStatistics . '% <b>↑</b></text>)</h4>';
                                            } else {
                                                echo '<h4 class="header-title mt-0 mb-4">Total Donation ( ' . '<text style="color:red";>' . $yearStatistics . '% <b>↓</b></text>)</h4>';
                                            }
                                            ?>

                                            <div class="text-center">
                                                <h2 class="font-weight-normal text-pink" data-plugin="counterup">
                                                    <?php echo $total_donation; ?>
                                                </h2>
                                                <h5> Total Donation</h5>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="card-box widget-user" style="border: 1px solid; width: 275px; border-radius:20px;">

                                            <?php
                                            if ($dayStatistics >= 100) {
                                                echo '<h4 class="header-title mt-0 mb-4">Today Donation ( ' . '<text style="color:green";>' . $dayStatistics . '% <b>↑</b></text>)</h4>';
                                            } else {
                                                echo '<h4 class="header-title mt-0 mb-4">Today Donation ( ' . '<text style="color:red";>' . $dayStatistics . '% <b>↓</b></text>)</h4>';
                                            }
                                            ?>

                                            <div class="text-center">
                                                <h2 class="font-weight-normal text-success" data-plugin="counterup">
                                                    <?php echo $today_donation; ?>
                                                </h2>
                                                <h5> Today Donation</h5>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-xl-3 col-md-6">
                                        <div class="card-box widget-user" style="border: 1px solid; width: 275px; border-radius:20px;">

                                            <?php
                                            if ($weekStatistics >= 100) {
                                                echo '<h4 class="header-title mt-0 mb-4">This Week ( ' . '<text style="color:green";>' . $weekStatistics . '% <b>↑</b></text>)</h4>';
                                            } else {
                                                echo '<h4 class="header-title mt-0 mb-4">This Week ( ' . '<text style="color:red";>' . $weekStatistics . '% <b>↓</b></text>)</h4>';
                                            }
                                            ?>

                                            <div class="text-center">
                                                <h2 class="font-weight-normal text-info" data-plugin="counterup">
                                                    <?php echo $week_donation; ?>
                                                </h2>
                                                <h5>Donations This Week</h5>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="card-box widget-user" style="border: 1px solid; width: 275px; border-radius:20px;">

                                            <?php
                                            if ($monthStatistics >= 100) {
                                                echo '<h4 class="header-title mt-0 mb-4">This Month ( ' . '<text style="color:green";>' . $monthStatistics . '% <b>↑</b></text>)</h4>';
                                            } else {
                                                echo '<h4 class="header-title mt-0 mb-4">This Month ( ' . '<text style="color:red";>' . $monthStatistics . '% <b>↓</b></text>)</h4>';
                                            }
                                            ?>

                                            <div class="text-center">
                                                <h2 class="font-weight-normal text-danger" data-plugin="counterup">
                                                    <?php echo $month_donation; ?>
                                                </h2>
                                                <h5>Donations This Month</h5>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <table id="responsive-datatable" class="table table-bordered table-bordered dt-responsive nowrap table-striped table-hover" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                            <th>Contact No</th>
                                            <th>Mode</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php foreach ($snapshot as $donor) { ?>

                                            <tr>
                                                <td><?php echo $donor["Name"]; ?></td>
                                                <td><?php echo $donor["Amount"]; ?></td>
                                                <td>
                                                    <?php
                                                    echo date("d/m/Y", strtotime($donor["DateCreated"]));
                                                    ?>
                                                </td>
                                                <td><?php echo $donor["Contact No"]; ?></td>
                                                <td><?php echo $donor["Mode"]; ?></td>
                                                <td>

                                                    <button class="btn btn-outline-primary" data-target="#viewModal<?php echo $donor->id(); ?>" id="<?php echo $donor->id(); ?>" style="height: 2.5em; width: 2.5em; border:none;" data-toggle="modal"><i class="dripicons-information" style="font-size: 1.5em; padding-top:0.1em;"></i></button>




                                                </td>

                                            </tr>
                                        <?php } ?>
                                    </tbody>

                                </table>
                            </div>
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

    <?php foreach ($snapshot as $donor) { ?>

        <!-- View Modal -->

        <div class="modal fade" id="viewModal<?php echo $donor->id(); ?>" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Donor Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div style="display: flex;">
                            <div class="col-md-4"><strong>Name: </strong></div>
                            <div class="col-md-4"><?php echo $donor['Name']; ?></div>
                        </div>
                        <div style="display: flex;">
                            <div class="col-md-4"><strong>Contact Number: </strong></div>
                            <div class="col-md-4"><?php echo $donor['Contact No']; ?></div>
                        </div>
                        <div style="display: flex;">
                            <div class="col-md-4"><strong>City: </strong></div>
                            <div class="col-md-4"><?php echo $donor['City']; ?></div>
                        </div>
                        <div style="display: flex;">
                            <div class="col-md-4"><strong>State: </strong></div>
                            <div class="col-md-4"><?php echo $donor['State']; ?></div>
                        </div>
                        <div style="display: flex;">
                            <div class="col-md-4"><strong>Country: </strong></div>
                            <div class="col-md-4"><?php echo $donor['Country']; ?></div>
                        </div>
                        <div style="display: flex;">
                            <div class="col-md-4"><strong>Amount: </strong></div>
                            <div class="col-md-4"><?php echo $donor['Amount']; ?></div>
                        </div>
                        <div style="display: flex;">
                            <div class="col-md-4"><strong>Mode: </strong></div>
                            <div class="col-md-4"><?php echo $donor['Mode']; ?></div>
                        </div>


                    </div>
                </div>
            </div>
        </div>

    <?php } ?>

    <?php include('include/script.php') ?>

</body>

</html>
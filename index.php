<?php
session_start();
if (isset($_SESSION['islogin'])) {
    if ($_SESSION['islogin'] == false) {
        header("Location: login.php");
    }
} else {
    header("Location: login.php");
}
include("dbconn.php");
$videos = $firestore->collection('Videos')->documents();
$sliders = $firestore->collection('Sliders')->orderBy('Priority')->documents();
$series = $firestore->collection('Series')->documents();
$categories = $firestore->collection('Categories')->documents();
$orators = $firestore->collection('Orators')->documents();
$adds = $firestore->collection('Advertisements')->documents();
$vidarr = array();
$slidarr = array();
$serarr = array();
$donarr = array();
$livevideocount = 0;
$videocount = 0;
$oratorcount = 0;
$addcount = 0;
foreach ($adds as $add) {
    $addcount++;
}
foreach ($orators as $ot) {
    $oratorcount++;
}
foreach ($videos as $vid) {
    $videocount++;
    $video_id = $vid->id();
    $video_type = $vid->data()['Type'];
    if (!array_key_exists($video_type, $vidarr)) {
        $vidarr[$video_type] = 0;
    }
    $vidarr[$video_type]++;
    if ($vid->data()['Is Live']) {
        $livevideocount++;
    }
}
foreach ($sliders as $slid) {
    $slidarr[] = $slid->data()['Video Thumbnail'];
}
$sercount = 0;
$epicount = 0;
$catcount = 0;
foreach ($series as $ser) {
    $sercount++;
    $ref = $firestore->collection('Series')->document($ser->id());
    $ref = $ref->collection('Seasons')->documents();
    foreach ($ref as $seas) {
        $ref1 = $firestore->collection('Series')->document($ser->id())->collection('Seasons')->document($seas->id())->collection('Episodes')->documents();

        foreach ($ref1 as $epi) {
            $epicount++;
        }
    }
}
foreach ($categories as $cat)
    $catcount++;
$numarr = array();
$colors = array();
function rand_color()
{
    return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
}
foreach ($vidarr as $key => $value) {
    $numarr[] = array(
        'label' => $key,
        'value' => $value
    );
    $colors[] = rand_color();
}
$numarr = json_encode($numarr);
// $num1arr =array();
// foreach ($serarr as $key => $value) {
//     $n=0;
//     foreach ($value as $key1 => $value1) {   
//         $num1arr[$n][] = array(
//             'label' => $key,
//             'y' => $value1
//         );
//         $n++;
//     }
// }
$usersRef = $firestore->collection('Donations')->documents();
$total_donation = $month_donation = 0;

date_default_timezone_set('Asia/Kolkata');

foreach ($usersRef as $donor) {
    $mode = $donor->data()['Mode'];
    if (!array_key_exists($mode, $donarr)) {
        $donarr[$mode] = 0;
    }
    $donarr[$mode]++;
    $total_donation = $total_donation + (int)$donor['Amount'];

    if (date("Y-m", strtotime($donor["DateCreated"])) == date('Y-m', time())) {
        $month_donation = $month_donation + (int)$donor['Amount'];
    }
}

$num2arr = array();
$num2arr[] = array("Mode", "Count");
foreach ($donarr as $key => $value) {
    $num2arr[] = array($key, $value);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Dashboard </title>
    <?php include('include/head.php') ?>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script>
        window.onload = function() {
            google.charts.load('current', {
                'packages': ['corechart']
            });
            google.charts.setOnLoadCallback(drawChart);

            // Draw the chart and set the chart values
            function drawChart() {
                var data = google.visualization.arrayToDataTable(<?php echo json_encode($num2arr) ?>);

                // Optional; add a title and set the width and height of the chart
                var options = {
                    legend: 'left',
                    is3D: true
                };

                // Display the chart inside the <div> element with id="piechart"
                var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                chart.draw(data, options);
            }
        }
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
                        <div class="col-xl-4">
                            <div class="card-box">

                                <h4 class="header-title mt-0">Videos</h4>

                                <div class="widget-chart text-center">
                                    <div id="donut-example" style="height: 390px; width: 100%;"></div>
                                    <div class="text-center">
                                        <ul class="list-inline chart-detail-list">
                                            <?php
                                            $ky = array_keys($vidarr);
                                            for ($n = 0; $n < count($colors); $n++) { ?>
                                                <li class="list-inline-item">
                                                    <h5 style="color: <?php echo $colors[$n] ?>;"><i class="fa fa-circle mr-1"></i><?php echo $ky[$n] ?></h5>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                    <script type="text/javascript">
                                        Morris.Donut({
                                            element: 'donut-example',
                                            data: <?php echo $numarr ?>,
                                            colors: <?php echo json_encode($colors) ?>,
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-5">
                            <div class="card-box">
                                <!-- <h4 class="header-title mt-0">Donations</h4> -->
                                <div class="widget-chart text-center">
                                    <h4 class="header-title mt-0">Donations</h4>
                                    <div id="piechart" style="height: 430px; width: 100%;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3">
                            <div class="card-box">
                                <div class="text-center">
                                    <div class="widget-chart-1">
                                        <div class="widget-detail-1">
                                            <h2 class="font-weight-normal text-pink" data-plugin="counterup">
                                                <?php echo $livevideocount; ?>
                                            </h2>
                                            <h4 class="header-title mt-0 mb-4">Live Videos</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-box">
                                <div class="text-center">
                                    <div class="widget-chart-1">
                                        <div class="widget-detail-1">
                                            <h2 class="font-weight-normal text-pink" data-plugin="counterup">
                                                <?php echo $month_donation; ?>
                                            </h2>
                                            <h4 class="header-title mt-0 mb-4">This Month Donation</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-box">
                                <div class="text-center">
                                    <div class="widget-chart-1">
                                        <div class="widget-detail-1">
                                            <h2 class="font-weight-normal text-pink" data-plugin="counterup">
                                                <?php echo $total_donation; ?>
                                            </h2>
                                            <h4 class="header-title mt-0 mb-4">Total Donation</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-xl-4 col-md-6">
                            <div class="card-box">
                                <div class="text-center">
                                    <div class="widget-chart-1">
                                        <div class="widget-detail-1">
                                            <h2 class="font-weight-normal text-pink" data-plugin="counterup">
                                                <?php echo $videocount; ?>
                                            </h2>
                                            <h4 class="header-title mt-0 mb-4">Total Videos</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-6">
                            <div class="card-box">
                                <div class="text-center">
                                    <div class="widget-chart-1">
                                        <div class="widget-detail-1">
                                            <h2 class="font-weight-normal text-pink" data-plugin="counterup">
                                                <?php echo $catcount; ?>
                                            </h2>
                                            <h4 class="header-title mt-0 mb-4">Total Categories</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6">
                            <div class="card-box">
                                <div class="text-center">
                                    <div class="widget-chart-1">
                                        <div class="widget-detail-1">
                                            <h2 class="font-weight-normal text-pink" data-plugin="counterup">
                                                <?php echo $oratorcount; ?>
                                            </h2>
                                            <h4 class="header-title mt-0 mb-4">Total Orators</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-xl-4 col-md-6">
                            <div class="card-box">
                                <div class="text-center">
                                    <div class="widget-chart-1">
                                        <div class="widget-detail-1">
                                            <h2 class="font-weight-normal text-pink" data-plugin="counterup">
                                                <?php echo $sercount; ?>
                                            </h2>
                                            <h4 class="header-title mt-0 mb-4">Total Series</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6">
                            <div class="card-box">
                                <div class="text-center">
                                    <div class="widget-chart-1">
                                        <div class="widget-detail-1">
                                            <h2 class="font-weight-normal text-pink" data-plugin="counterup">
                                                <?php echo $epicount; ?>
                                            </h2>
                                            <h4 class="header-title mt-0 mb-4">Total Episodes</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6">
                            <div class="card-box">
                                <div class="text-center">
                                    <div class="widget-chart-1">
                                        <div class="widget-detail-1">
                                            <h2 class="font-weight-normal text-pink" data-plugin="counterup">
                                                <?php echo $addcount; ?>
                                            </h2>
                                            <h4 class="header-title mt-0 mb-4">Total Advertisment</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->


                </div> <!-- container-fluid -->

            </div> <!-- content -->


        </div>

    </div>
    <!-- END wrapper -->
    <?php include('include/script.php') ?>

</body>

</html>
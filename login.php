<?php
session_start();
if (isset($_SESSION['islogin'])) {
    if ($_SESSION['islogin'] == true) {
        header("Location: index.php");
    }
}
?> 

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Log in</title>
    <?php include('include/head.php') ?>
</head>


<body class="authentication-bg">
    <?php

    $isvalid = false;
    if (isset($_POST['login'])) {
        include("dbconn.php");
        $userdet = $firestore->collection('Admin_Roles')->documents();
        $access = array();
        foreach ($userdet as $docs) {
            $temp = $docs->data();
            // print($temp['EmailId']);
            // print($temp['Password']);
            // print($_POST['email']);
            // print($_POST['passw']);
            if (password_verify($_POST['passw'], $temp['Password'])) {
                // print("Valid");
            }
            $isvalid = $_POST['email'] == $temp['EmailId'] ? password_verify($_POST['passw'], $temp['Password']) : false;
            if ($isvalid == true) {
                $access = $temp['Access'];
                // session_start();
                $_SESSION['islogin'] = true;
                $_SESSION['role'] = $temp['Role'];
                $_SESSION['username'] = $temp['Username'];
                $_SESSION['access'] = $access;
                header("Location: index.php");
                break;
            }
        }
    }
    ?>
    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="text-center">
                        <h1 class="page-title">SDI OTT</h1>
                    </div>
                    <div class="card">

                        <div class="card-body p-4">

                            <div class="text-center mb-4">
                                <h4 class="text-uppercase mt-0">Log In</h4>
                            </div>

                            <form action="" method="POST">

                                <div class="form-group mb-3">
                                    <label for="emailaddress">Email Id</label>
                                    <input class="form-control" type="email" name="email" id="email" required="" placeholder="Enter your email Id">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="password">Password</label>
                                    <input class="form-control" type="password" required="" name="passw" id="password" placeholder="Enter your password">
                                </div>

                                <!-- <div class="form-group mb-3">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="checkbox-signin" checked>
                                        <label class="custom-control-label" for="checkbox-signin">Remember me</label>
                                    </div>
                                </div> -->

                                <div class="form-group mb-0 text-center">
                                    <button class="btn btn-primary btn-block" name="login" id="submit" type="submit"> Log In </button>
                                </div>

                            </form>

                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <!-- <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p> <a class="ml-10"><i class="fa fa-lock mr-1"></i>Forgot your password?</a></p>
                        </div> 
                    </div> -->
                    <!-- end row -->

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->


    <?php include('include/script.php') ?>

</body>

</html>

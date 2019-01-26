<?php
session_start();

if (isset($_SESSION["wms_user_id"])) { 
    $wms_user_idStored = $_SESSION["wms_user_id"];
    if ($_SESSION["access_level"]=="1" || $_SESSION["access_level"]=="3" || $_SESSION["access_level"]=="4" || $_SESSION["access_level"]=="5") {
        echo "<script> window.location = '../core/logout'; </script>" ;
    }
} else {
    header("location: ../login");
}

require_once('../core/config.php');
include_once('../core/functions/autolock.php');
include_once('../core/functions/analytics.php');
include_once('../core/functions/global.php');
include_once('../core/functions/dates.php');
include_once('../core/functions/render.php');

?>
<?php
if (isset($_SESSION["personnel_id"])) {
    unset($_SESSION["personnel_id"]);
}

if (isset($_SESSION["form_id"])) {
    unset($_SESSION["form_id"]);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title> BCI WMS | BCI Field </title>
    <!-- HTML5 Shim and Respond.js IE10 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 10]>
    <script src="../https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="../https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Meta -->
    <meta charset="utf-8" <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="BCI WMS">
    <meta name="keywords" content="Admin">
    <meta name="author" content="Hinet Technologies">

    <!-- Favicon icon -->
    <link rel="icon" href="../assets/img/favicon.png" type="image/x-icon">
    <!-- Google font-->
    <link href="../https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="../components/bootstrap/css/bootstrap.min.css">
    <!-- themify-icons line icon -->
    <link rel="stylesheet" type="text/css" href="../assets/icon/themify-icons/themify-icons.css">
    <!-- ico font -->
    <link rel="stylesheet" type="text/css" href="../assets/icon/icofont/css/icofont.css">
    <!-- flag icon framework css -->
    <link rel="stylesheet" type="text/css" href="../assets/pages/flag-icon/flag-icon.min.css">
    <!-- Menu-Search css -->
    <link rel="stylesheet" type="text/css" href="../assets/pages/menu-search/css/component.css">

    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">


    <link rel="stylesheet" type="text/css" href="../assets/css/jquery.mCustomScrollbar.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/pcoded-horizontal.min.css">
</head>
<!-- Menu horizontal fixed layout -->

<body>
    <!-- Pre-loader start -->
    <?php include ('_includes/preloader.php'); ?>
    <!-- Pre-loader end -->

    <div id="pcoded" class="pcoded">

        <div class="pcoded-container">

            <!-- Menu header start -->
            <?php include('_includes/header.php'); ?>
            <!-- Menu header end -->

            <div class="pcoded-main-container">

                <!-- Menu Start -->
                <?php //include('_includes/menu.php'); ?>               
                <!-- Menu End -->

                <div class="pcoded-wrapper">
                    
                    <div class="pcoded-content">
                        <div class="pcoded-inner-content">
                            <!-- Main-body start -->
                            <div class="main-body">
                                <div class="page-wrapper p-t-0">

                                    <!-- Page body start -->
                                    <div class="page-body">

                                        <div class="row">
                                            <div class="col-md-12">
                                                <?php include('../core/controllerPHP/field_indexController.php'); ?>
                                            </div>
                                        </div>

                                        <div class="row">

                                            <!-- Left column start -->
                                            <div class="col-xl-12 col-lg-12 filter-bar">
                                                <!-- <nav class="navbar navbar-light bg-faded m-b-10 p-10">

                                                        <ul class="nav navbar-nav">
                                                            <li class="nav-item active">
                                                                <a class="nav-link" href="../#!"> FILTER: <span class="sr-only">(current)</span></a>
                                                            </li>
                                                            <li class="nav-item dropdown">
                                                                <a class="nav-link dropdown-toggle" href="../#!" id="bydate" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icofont icofont-clock-time"></i> BY DATE </a>
                                                                <div class="dropdown-menu" aria-labelledby="bydate">
                                                                    <a class="dropdown-item" href="../#!">Show all</a>
                                                                    <div class="dropdown-divider"></div>
                                                                    <a class="dropdown-item" href="../#!">This month</a>
                                                                    <a class="dropdown-item" href="../#!">Last month</a>
                                                                    <a class="dropdown-item" href="../#!">This year</a>
                                                                    <a class="dropdown-item" href="../#!">Last year</a>
                                                                </div>
                                                            </li>
                                                            <li class="nav-item dropdown">
                                                                <a class="nav-link dropdown-toggle" href="../#!" id="bystatus" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icofont icofont-chart-histogram-alt"></i> BY STATUS</a>
                                                                <div class="dropdown-menu" aria-labelledby="bystatus">
                                                                    <a class="dropdown-item" href="../#!">Show all</a>
                                                                    <div class="dropdown-divider"></div>
                                                                    <a class="dropdown-item" href="../#!"> In Progress </a>
                                                                    <a class="dropdown-item" href="../#!"> Suspended </a>
                                                                    <a class="dropdown-item" href="../#!"> Completed </a>
                                                                    <a class="dropdown-item" href="../#!"> Cancelled </a>
                                                                </div>
                                                            </li>
                                                            <li class="nav-item">
                                                                <input type="search" class="form-control" name="findstaff" id="findstaff" placeholder="Search">
                                                            </li>
                                                        </ul>

                                                </nav> -->
                                                <!-- Nav Filter tab end -->

                                                <!-- Task board design block start-->
                                                <div class="row">
                                <?php
                                    $r_field_personnels = r_field_personnels($con, $wms_user_idStored);
                                    $r_field_personnels_data = json_decode($r_field_personnels, true);

                                    if (!empty($r_field_personnels_data)) {
                                        foreach ($r_field_personnels_data as $key => $value) {

                                            echo '
                                                <div class="col-md-4">
                                                    <div class="card card-border-warning">
                                                        <div class="card-header">
                                                            <b>'.$value['full_name'].'</b> 
                                                            <span class="label label-default f-right"> '.date("d F, Y", strtotime($value['created_at'])).' </span>
                                                        </div>
                                                        <div class="card-block">
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <p class="task-due"><strong> Phone Number: </strong> '.$value['phone_number'].' </p>
                                                                    <p class="task-due"><strong> Client: </strong> '.fetchUserName($con, $value['client_id']).' </p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="card-footer" style="margin-top: -20px;">
                                                            <div class="task-list-table">
                                                                
                                                            </div>
                                                        
                                                            <div class="task-board">

                                                            <form action="index" method="POST">

                                                                <input type="hidden" name="personnel_id" value="'.$value['id'].'" required>

                                                                <div class="dropdown-secondary dropdown">
                                                                    <button class="btn btn-primary btn-sm dropdown-toggle waves-light b-none txt-muted" type="button" id="dropdown8" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Upload Manual Report </button>
                                                                    <div class="dropdown-menu" aria-labelledby="dropdown8" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">

                                                                        <button type="submit" name="form_id" value="2" class="btn-md dropdown-item waves-light waves-effect">Guarantor </button>
                                                                        <button type="submit" name="form_id" value="3" class="btn-md dropdown-item waves-light waves-effect">Reference </button>
                                                                        <button type="submit" name="form_id" value="4" class="btn-md dropdown-item waves-light waves-effect">Company Assessment</button>

                                                                    </div>

                                                                </div>

                                                            </form>

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>';



                                        }

                                    } else {
                                        echo '
                                            No personnel assigned to you.
                                        ';
                                    }
                                ?>
                                                <!-- <a href="documents?personnel='.$value['id'].'"><i class="icofont icofont-document-folder icofont-3x"></i> </a> -->

                                                </div>
                                                <!-- Task board design block end -->
                                            </div>
                                            <!-- Left column end -->
                                        </div>
                                    </div>
                                    <!-- Page body end -->
                                </div>
                            </div>
                            <!-- Main-body end -->

                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Warning Section Starts -->
    <!-- Older IE warning message -->
    <!--[if lt IE 10]>
<div class="ie-warning">
    <h1>Warning!!</h1>
    <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers
        to access this website.</p>
    <div class="iew-container">
        <ul class="iew-download">
            <li>
                <a href="../http://www.google.com/chrome/">
                    <img src="../assets/images/browser/chrome.png" alt="Chrome">
                    <div>Chrome</div>
                </a>
            </li>
            <li>
                <a href="../https://www.mozilla.org/en-US/firefox/new/">
                    <img src="../assets/images/browser/firefox.png" alt="Firefox">
                    <div>Firefox</div>
                </a>
            </li>
            <li>
                <a href="../http://www.opera.com">
                    <img src="../assets/images/browser/opera.png" alt="Opera">
                    <div>Opera</div>
                </a>
            </li>
            <li>
                <a href="../https://www.apple.com/safari/">
                    <img src="../assets/images/browser/safari.png" alt="Safari">
                    <div>Safari</div>
                </a>
            </li>
            <li>
                <a href="../http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                    <img src="../assets/images/browser/ie.png" alt="">
                    <div>IE (9 & above)</div>
                </a>
            </li>
        </ul>
    </div>
    <p>Sorry for the inconvenience!</p>
</div>
<![endif]-->
    <!-- Warning Section Ends -->
    <!-- Required Jquery -->
    <script type="text/javascript" src="../components/jquery/js/jquery.min.js"></script>
    <script type="text/javascript" src="../components/jquery-ui/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="../components/popper.js/js/popper.min.js"></script>
    <script type="text/javascript" src="../components/bootstrap/js/bootstrap.min.js"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="../components/jquery-slimscroll/js/jquery.slimscroll.js"></script>
    <!-- modernizr js -->
    <script type="text/javascript" src="../components/modernizr/js/modernizr.js"></script>
    <script type="text/javascript" src="../components/modernizr/js/css-scrollbars.js"></script>

    <!-- task board js -->
    <script type="text/javascript" src="../assets/pages/task-board/task-board.js"></script>

    <!-- Custom js -->
    <script src="../assets/js/pcoded.min.js"></script>
    <script src="../assets/js/menu/menu-hori-fixed.js"></script>
    <script src="../assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script type="text/javascript" src="../assets/js/script.js"></script>

</body>

</html>

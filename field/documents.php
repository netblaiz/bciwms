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

    // Check if parameters are met
    if (isset($_SESSION["personnel_id"]) && $_SESSION["personnel_id"]!="") {
        $personnel_idStored = $_SESSION["personnel_id"];
    } else {
        echo "<script> window.location = './index'; </script>" ;
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

    <!-- jquery file upload Frame work -->
    <link href="../components/jquery.filer/css/jquery.filer.css" type="text/css" rel="stylesheet" />
    <link href="../components/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css" type="text/css" rel="stylesheet" />

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
                                            <form action="drive_files" method="POST">
                                                <div class="col-md-12">
                                                    <a href="index" class="btn btn-inverse btn-bg-c-white btn-outline-default btn-round btn-action m-r-10 m-b-10"> <i class="icofont icofont-circled-left"> </i> Home </a>
                                                    
                                                </div>
                                            </form>
                                        </div>

                                        <div class="row">

                                            <div class="col-md-12">
                                                <div class="card card-border-default">
                                                    <div class="card-header">
                                                        <h5> <?php echo fetchPersonnelName($con, $personnel_idGet); ?> </h5>
                                                    </div>
                                                    <div class="card-block marketing-card p-t-0  icon-btn">

                                                        <form>
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <input type="file" name="files[]" id="filer_input2" multiple="multiple">
                                                                </div>
                                                            </div>
                                                        </form>

                                                        <div class="dt-responsive table-responsive">
                                                            <!-- <table id="" class="table table-hover"> -->
                                                            <table id="simpletable" class="table table-hover">
                                                                <!-- <thead>
                                                                    <tr>
                                                                        <th>Name</th>
                                                                        <th></th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead> -->
                                                                <tbody>
                                                                    
                                                                        <tr>
                                                                            <td><i class="icofont icofont-file-pdf icofont-3x"></i>
                                                                                <div class="table-contain">
                                                                                    <h6> Biodata form </h6>
                                                                                    <p class="text-muted"> 950Mb</p>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <button type="submit" name="documents" class="btn btn-primary btn-icon"><i class="icofont icofont-download"></i></button>
                                                                                
                                                                                <button type="submit" name="documents" class="btn btn-md btn-icon btn-danger"> <i class="icofont icofont-ui-delete"></i></button>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><i class="icofont icofont-file-pdf icofont-3x"></i>
                                                                                <div class="table-contain">
                                                                                    <h6> Oluyomi CV </h6>
                                                                                    <p class="text-muted"> 950Mb</p>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <button type="submit" name="documents" class="btn btn-primary btn-icon"><i class="icofont icofont-download"></i></button>

                                                                                <button type="submit" name="documents" class="btn btn-md btn-icon btn-danger"> <i class="icofont icofont-ui-delete"></i></button>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><i class="icofont icofont-file-pdf icofont-3x"></i>
                                                                                <div class="table-contain">
                                                                                    <h6> Activities </h6>
                                                                                    <p class="text-muted"> 950Mb</p>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <button type="submit" name="documents" class="btn btn-primary btn-icon"><i class="icofont icofont-download"></i></button>
                                                                                
                                                                                <button type="submit" name="documents" class="btn btn-md btn-icon btn-danger"> <i class="icofont icofont-ui-delete"></i></button>
                                                                            </td>
                                                                        </tr>
                                                                            
                                                                    
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        <!-- Row End -->

                                        
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


    <!-- jquery file upload js -->
    <script src="../components/jquery.filer/js/jquery.filer.min.js"></script>
    <script src="../components/jquery.filer/dragboxfiler.js" type="text/javascript"></script>
    <script src="../components/jquery.filer/inputboxfiler.js" type="text/javascript"></script>

    <!-- task board js -->
    <script type="text/javascript" src="../assets/pages/task-board/task-board.js"></script>

    <!-- Custom js -->
    <script src="../assets/js/pcoded.min.js"></script>
    <script src="../assets/js/menu/menu-hori-fixed.js"></script>
    <script src="../assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script type="text/javascript" src="../assets/js/script.js"></script>

</body>

</html>

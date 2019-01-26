<?php
session_start();

if (isset($_SESSION["wms_user_id"])) { 
    $wms_user_idStored = $_SESSION["wms_user_id"];
    if ($_SESSION["access_level"]=="1" || $_SESSION["access_level"]=="2") {
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
if (isset($_SESSION["client_id"])) {
    unset($_SESSION["client_id"]);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title> BCI WMS | Clients </title>
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
                                                <?php include('../core/controllerPHP/indexController.php'); ?>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12 filter-bar">
                                                <nav class="navbar navbar-light bg-faded m-b-10 p-10">
                                                    <ul class="nav navbar-nav">
                                                        <li class="nav-item">
                                                            <button type="button" class="btn btn-primary btn-round waves-effect" data-toggle="modal" data-target="#client-Modal"><i class="icofont icofont-ui-folder"></i> New Client </button>
                                                            <a href="users" class="btn btn-primary btn-round waves-effect"><i class="icofont icofont-ui-user"></i> WMS Users </a>

                                                        </li>
                                                    </ul>

                                                    <div class="nav-item nav-grid">
                                                        <ul class="nav navbar-nav">                                                            
                                                            <!-- <li class="nav-item">
                                                                <div class="input-group m-t-5 " style="margin-bottom: 0px;">
                                                                    <input type="text" class="form-control" placeholder="Search for Client">
                                                                    <span class="input-group-addon" id="">
                                                                        <i class="icofont icofont-search-alt-1"></i>
                                                                    </span>
                                                                </div>
                                                            </li> -->
                                                        </ul>
                                                    </div>

                                                </nav>
                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-md-12">
                                                <div class="card card-border-default">
                                                    <div class="card-header">
                                                        <div class="card-header-left">
                                                            <h5 class="text-uppercase"> Clients </h5>
                                                        </div>
                                                        <div class="card-header-right">
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="card-block marketing-card p-t-0">
                                                        <div class="row">

                                                        <?php
                                                            $r_clients = r_clients($con);
                                                            $r_clients_data = json_decode($r_clients, true);

                                                            if (!empty($r_clients_data)) {
                                                                foreach ($r_clients_data as $key => $value) {
                                                                    echo '
                                                                    <div class="col-6 col-sm-3 col-md-2 col-lg-1 text-center">
                                                                        <div class="dropdown-secondary dropdown center-block m-t-10">

                                                                            <button class="btn btn-default btn-mini waves-light b-none txt-muted" type="button" id="dropdown3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: transparent; ">'.clientFolderContentStaus($con, $value['id']).' 
                                                                            </button>
                                                                            <p>'.substr($value['full_name'], 0, 15).'...</p>

                                                                            <form action="index" method="POST">
                                                                                <div class="dropdown-menu" aria-labelledby="dropdown3" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">

                                                                                    <input type="hidden" name="client_id" value="'.$value['id'].'">

                                                                                    <button type="submit" name="openClient" class="dropdown-item waves-light waves-effect btn btn-md"><i class="icofont icofont-folder-open"></i> Open </button>
                                                                                    
                                                                                    <button type="submit" name="deleteClient" class="dropdown-item waves-light waves-effect btn btn-md"><i class="icofont icofont-close"></i> Remove </button>
                                                                                </div>
                                                                            </form>

                                                                        </div>
                                                                    </div>
                                                                    ';
                                                                }
                                                            } else {
                                                                echo '
                                                                    <div class="col-sm-12 col-md-12 col-lg-12 text-center">
                                                                        <p> No Client Added Yet </p>
                                                                    </div>
                                                                ';
                                                            }
                                                        ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
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

    <!-- Modal static-->
    <div class="modal fade" id="client-Modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="border: none;">
                    <h5 class="modal-title"> New Client </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="index" method="POST">
                <div class="modal-body">

                    <div class="form-group row">
                        <div class="col-sm-12">
                            <input type="text" name="client_name" class="form-control" placeholder="Client Name" required="required">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <input type="email" name="email_address" class="form-control" placeholder="Email Address" required="required">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <input type="password" name="password" class="form-control" placeholder="Password" required="required">
                        </div>
                        <div class="col-sm-6">
                            <input type="text" name="phone_number" class="form-control" placeholder="Phone Number" required="required">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12">
                            <button type="submit" name="create_client" id="create_client" class="btn btn-primary btn-round waves-effect waves-light"><i class="icofont icofont-save"></i> Save </button>
                            <button type="button" class="btn btn-default btn-round waves-effect " data-dismiss="modal"><i class="icofont icofont-close"></i>Close</button>
                        </div>
                    </div>

                </div>

                </form>

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

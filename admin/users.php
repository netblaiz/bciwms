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

<!DOCTYPE html>
<html lang="en">

<head>
    <title> BCI WMS | Users </title>
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

    <!-- Data Table Css -->
    <link rel="stylesheet" type="text/css" href="../components/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="../components/pages/data-table/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="../components/pages/data-table/extensions/buttons/css/buttons.dataTables.min.css">

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
                                                <?php include('../core/controllerPHP/usersController.php'); ?>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12 filter-bar">
                                                <!-- Nav Filter tab start -->
                                                <nav class="navbar navbar-light bg-faded m-b-10 p-10">
                                                    <ul class="nav navbar-nav">
                                                        <li class="nav-item">
                                                            <a href="index" class="btn btn-inverse btn-round waves-effect"><i class="icofont icofont-circled-left"></i> Clients </a>

                                                            <button type="button" class="btn btn-primary btn-round waves-effect" data-toggle="modal" data-target="#user-Modal"><i class="icofont icofont-ui-user"></i> <span class="hidden-xs"> New User </span> </button>

                                                        </li>
                                                    </ul>

                                                    <div class="nav-item nav-grid icon-btn">
                                                        <ul class="nav navbar-nav">
                                                            <li class="nav-item">
                                                                <a href="log" class="btn btn-primary btn-icon tooltip-btn" data-toggle="tooltip" data-placement="bottom" title="All Activities"><i class="icofont icofont-listing-box"></i></a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a href="tokens" class="btn btn-primary btn-icon tooltip-btn" data-toggle="tooltip" data-placement="bottom" title="Manage Tokens"><i class="icofont icofont-flash"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>

                                                </nav>
                                                <!-- Nav Filter tab end -->
                                            </div>

                                        </div>


                                        <div class="row">
                                            
                                            <div class="col-md-12">

                                                <!-- HTML5 Export Buttons table start -->
                                                <div class="card">
                                                    <div class="card-header table-card-header">
                                                        <h5 class="text-uppercase"> BCI WMS Users </h5>
                                                    </div>
                                                    <div class="card-block icon-btn">
                                                        <div class="dt-responsive table-responsive">
                                                            <table id="basic-btn" class="table table-striped table-bordered nowrap">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Name</th>
                                                                        <th>Email</th>
                                                                        <th>Phone Number</th>
                                                                        <th>Designation - ID</th>
                                                                        <th>Assess Level</th>
                                                                        <th>Status</th>
                                                                        <th>Options</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                        <?php
                                                            $r_users = r_users($con);
                                                            $r_users_data = json_decode($r_users, true);

                                                            if (!empty($r_users_data)) {
                                                                foreach ($r_users_data as $key => $value) {
                                                                    echo '
                                                                    <tr>
                                                                        <td>'.$value['full_name'].'</td>
                                                                        <td>'.$value['email_address'].'</td>
                                                                        <td>'.$value['phone_number'].'</td>
                                                                        <td>'.$value['designation'].' - '.$value['staff_id'].'</td>
                                                                        <td>'.userAccess($value['access_level']).'</td>
                                                                        <td>'.userStatus($value['user_status']).'</td>
                                                                        <td style="display: flex;">
                                                                            <a href="log?user='.$value['id'].'" class="btn btn-primary btn-icon tooltip-btn" style="width: 30px; height: 30px;" data-toggle="tooltip" data-placement="bottom" title="Activity Log"><i class="icofont icofont-listing-box"></i></a>

                                                                            <form action="users" method="POST" class="m-l-5 m-r-5">

                                                                                <input type="hidden" name="user_id" value="'.$value['id'].'" required>

                                                                                <button type="submit" name="resetpassword" class="btn btn-warning btn-icon tooltip-btn" style="width: 30px; height: 30px;" data-toggle="tooltip" data-placement="bottom" title="Reset Password to bciwms01"><i class="icofont icofont-refresh"></i></button>';

                                                                                if ($value['user_status']=="1") {
                                                                                    echo '
                                                                                        <button type="submit" name="deactivateuser" class="btn btn-danger btn-icon tooltip-btn" style="width: 30px; height: 30px;" data-toggle="tooltip" data-placement="bottom" title="Deactivate User"><i class="icofont icofont-ui-pause"></i></button>';
                                                                                } else {
                                                                                    echo '
                                                                                        <button type="submit" name="activateuser" class="btn btn-success btn-icon tooltip-btn" style="width: 30px; height: 30px;" data-toggle="tooltip" data-placement="bottom" title="Activate User"><i class="icofont icofont-ui-play"></i></button>';
                                                                                }

                                                                                echo'
                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                                    ';
                                                                }

                                                            } else {
                                                                echo '
                                                                    <tr>
                                                                        <td colspan="7">
                                                                            No User Uploaded Yet
                                                                        </td>
                                                                    </tr>
                                                                ';
                                                            }
                                                        ?>

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- HTML5 Export Buttons end -->

                                                
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
    <div class="modal fade" id="user-Modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="border: none;">
                    <h5 class="modal-title"> New User </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="users" method="POST">
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <input type="text" name="full_name" class="form-control" placeholder="Full Name" required="required">
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
                        <div class="col-sm-6">
                            <input type="text" name="designation" class="form-control" placeholder="Designation" required="required">
                        </div>
                        <div class="col-sm-6">
                            <input type="text" name="staff_id" class="form-control" placeholder="Staff ID">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <select name="access_level" id="access_level" class="form-control" required>
                                <option>Access Level</option>
                                <option value="2">Field Staff</option>
                                <option value="3">Operations</option>
                                <option value="4">BDM</option>
                                <option value="5">IT</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12">
                            <button type="submit" name="create_user" id="create_user" class="btn btn-primary btn-round waves-effect waves-light"><i class="icofont icofont-save"></i> Save </button>
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
    <!-- <script type="text/javascript" src="../components/pages/task-board/task-board.js"></script> -->

    <!-- data-table js -->
    <script src="../components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../components/pages/data-table/js/jszip.min.js"></script>
    <script src="../components/pages/data-table/js/pdfmake.min.js"></script>
    <script src="../components/pages/data-table/js/vfs_fonts.js"></script>
    <script src="../components/pages/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
    <script src="../components/pages/data-table/extensions/buttons/js/buttons.flash.min.js"></script>
    <script src="../components/pages/data-table/extensions/buttons/js/jszip.min.js"></script>
    <script src="../components/pages/data-table/extensions/buttons/js/vfs_fonts.js"></script>
    <script src="../components/pages/data-table/extensions/buttons/js/buttons.colVis.min.js"></script>
    <script src="../components/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../components/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../components/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

    <!-- Initialize Data table and EXport-->
    <script src="../components/pages/data-table/extensions/buttons/js/extension-btns-custom.js"></script>


    <!-- Custom js -->
    <script src="../assets/js/pcoded.min.js"></script>
    <script src="../assets/js/menu/menu-hori-fixed.js"></script>
    <script src="../assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script type="text/javascript" src="../assets/js/script.js"></script>


</body>

</html>

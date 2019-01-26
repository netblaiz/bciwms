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
    <title> BCI WMS | Token </title>
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
                                                <?php include('../core/controllerPHP/tokensController.php'); ?>
                                            </div>
                                        </div>
                                        
                                        <div class="row">

                                            <div class="col-md-12">

                                                <a href="users" class="btn btn-inverse btn-round btn-action m-r-10 m-b-10"> <i class="icofont icofont-circled-left"> </i> Users </a>

                                                <div class="card card-border-default">
                                                    <div class="card-header">
                                                        <h5 class="text-uppercase"> Tokens </h5>
                                                    </div>

                                                    <div class="card-block icon-btn">
                                                        <div class="dt-responsive table-responsive">
                                                            <table id="basic-btn" class="table table-striped table-bordered nowrap">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Client</th>
                                                                        <th>Personnel</th>
                                                                        <th>Form</th>
                                                                        <th>Link Validity</th>
                                                                        <th>Token</th>
                                                                        <th>Created At</th>
                                                                        <th>Created By</th>
                                                                        <th>Options</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                        <?php
                                                            $r_tokens = r_tokens($con);
                                                            $r_tokens_data = json_decode($r_tokens, true);

                                                            if (!empty($r_tokens_data)) {
                                                                foreach ($r_tokens_data as $key => $value) {
                                                                    echo '
                                                                    <tr>
                                                                        <td>'.fetchUserName($con, $value['client_id']).'</td>
                                                                        <td>'.fetchPersonnelName($con, $value['personnel_id']).'</td>
                                                                        <td>'.fetchFormName($con, $value['form_id']).'</td>
                                                                        <td>'.$value['link_validity'].' hrs </td>
                                                                        <td>'.$value['token'].'</td>
                                                                        <td>'.date("h:ia d F, Y", strtotime($value['created_at'])).'</td>
                                                                        <td>'.fetchUserName($con, $value['created_by']).'</td>
                                                                        <td style="display: flex;">

                                                                            <form action="tokens" method="POST" class="m-l-5 m-r-5">

                                                                                <input type="hidden" name="token_id" value="'.$value['id'].'" required>';

                                                                                if ($value['token_status']=="1") {
                                                                                    echo '
                                                                                        <button type="submit" name="deactivatetoken" class="btn btn-danger btn-icon tooltip-btn" style="width: 30px; height: 30px;" data-toggle="tooltip" data-placement="bottom" title="Deactivate Token"><i class="icofont icofont-ui-pause"></i></button>';
                                                                                } else {
                                                                                    echo '
                                                                                        <button type="submit" name="activatetoken" class="btn btn-success btn-icon tooltip-btn" style="width: 30px; height: 30px;" data-toggle="tooltip" data-placement="bottom" title="Activate Token"><i class="icofont icofont-ui-play"></i></button>';
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

    <!-- Clip Board -->
    <script src="../components/clipboard/clipboard.min.js"></script>
    <script src="../components/clipboard/clipboard.init.js"></script>


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

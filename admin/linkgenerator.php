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
    $client_idStored = $_SESSION["client_id"];

    // Check if parameters are met
    if (isset($_GET['personnel']) && $_GET['personnel']!="" && isset($_GET['formtype']) && $_GET['formtype']!="") {
        $personnel_idGet = $_GET['personnel'];
        $formtype_idGet = $_GET['formtype'];
    } else {
        echo "<script> window.location = './personnels'; </script>" ;
    }

} else {
    echo "<script> window.location = './index'; </script>" ;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title> BCI WMS | Link Generator </title>
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
                                            <div class="col-md-6 m-auto">

                                                <a href="personnels" class="btn btn-inverse btn-bg-c-white btn-outline-default btn-round btn-action m-r-10 m-b-10"> <i class="icofont icofont-circled-left"> </i> Personnels </a>

                                                <div class="card card-border-default">
                                                    <div class="card-header">
                                                        <h5> Link Generator </h5>
                                                    </div>
                                                    <div class="card-block marketing-card p-t-0">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <ul class="list-unstyled">
                                                                    <li><strong> Client: </strong> <?php echo fetchUserName($con, $client_idStored); ?> </li>
                                                                    <li><strong> Personnel: </strong> <?php echo fetchPersonnelName($con, $personnel_idGet); ?> </li>
                                                                    <li><strong> Type of Form: </strong> <?php echo fetchFormName($con, $formtype_idGet); ?> </li>
                                                                </ul>

                                                                <br>
                                                                <!-- GENERATE LINK WITH AJAX -->
                                                                <form method="POST" id="linkgenerationform">

                                                                    <input type="hidden" name="client_id" class="form-control" placeholder="Client Id" required="required" value="<?php echo $client_idStored; ?>">

                                                                    <input type="hidden" name="personnel_id" class="form-control" placeholder="Personnel Id" required="required" value="<?php echo $personnel_idGet; ?>">

                                                                    <input type="hidden" name="form_id" class="form-control" placeholder="Form Id" required="required" value="<?php echo $formtype_idGet; ?>">

                                                                    <div class="form-group row">
                                                                        <div class="col-xs-12 col-sm-6">
                                                                            <label class="control-label"><b> Select Link Validity </b></label>
                                                                            <select name="link_validity" class="form-control" required >
                                                                                <option value="24"> 1 day </option>
                                                                                <option value="48"> 2 days </option>
                                                                                <option value="72"> 3 days </option>
                                                                                <option value="96"> 4 days </option>
                                                                                <option value="168"> 7 days </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <div class="col-xs-12 col-sm-6">
                                                                            <button type="submit" name="generatelink" id="generatelink" class="generatelink btn btn-primary btn-round waves-effect waves-light"><i class="icofont icofont-flash"></i> Generate Link </button>
                                                                        </div>
                                                                    </div>

                                                                </form>
                                                                <hr>
                                                                <h6><strong> Copy Link </strong></h6>
                                                                <div class="input-group input-group-button m-t-20">
                                                                    <input type="text" id="file_path" class="form-control" placeholder="Form Link for Personnel" readonly="readonly">

                                                                    <button class="input-group-addon btn btn-default copybutton" id="basic-addon10" data-clipboard-action="copy" data-clipboard-target="#file_path">
                                                                        <span class=""><i class="icofont icofont-ui-copy"> </i>  </span>
                                                                    </button>
                                                                </div>

                                                            </div>
                                                                
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
                    <h5 class="modal-title"> New Client Folder </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="index" method="POST">
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <input type="text" name="folder_name" class="form-control" placeholder="Client Name" required="required">
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border: none;">
                    <button type="button" class="btn btn-default btn-sm waves-effect " data-dismiss="modal">Close</button>
                    <button type="submit" name="create_folder" id="create_folder" class="btn btn-primary btn-sm waves-effect waves-light"> Save </button>
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

    <!-- Clip Board -->
    <script src="../components/clipboard/clipboard.min.js"></script>
    <script src="../components/clipboard/clipboard.init.js"></script>

    <!-- Custom js -->
    <script src="../assets/js/pcoded.min.js"></script>
    <script src="../assets/js/menu/menu-hori-fixed.js"></script>
    <script src="../assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script type="text/javascript" src="../assets/js/script.js"></script>

    <!-- AJAX Functions -->
    <script type="text/javascript" src="../core/controllerAjax/linkgeneratorController.js"></script>


</body>

</html>

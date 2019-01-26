<?php
session_start();
// Disable Navbar
$disable0=""; $disable1=""; $disable2=""; $disable3=""; $disable4=""; $disable5=""; $disable6=""; $disable7="disabled";

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

if (isset($_SESSION["personnel_id"]) && $_SESSION["personnel_id"]!="" && isset($_SESSION["form_id"]) && $_SESSION["form_id"]!="") {
    $personnel_idStored = $_SESSION["personnel_id"];
    $form_idStored = $_SESSION["form_id"];
} else {
    echo "<script> window.location = './index'; </script>" ;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title> BCI WMS | Reference Verification Form </title>
    <!-- HTML5 Shim and Respond.js IE10 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 10]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
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
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet">
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

    <!-- Date-time picker css -->
    <link rel="stylesheet" type="text/css" href="../components/pages/advance-elements/css/bootstrap-datetimepicker.css">
    <!-- Date-range picker css  -->
    <link rel="stylesheet" type="text/css" href="../components/bootstrap-daterangepicker/css/daterangepicker.css" />
    <!-- Date-Dropper css -->
    <link rel="stylesheet" type="text/css" href="../components/datedropper/css/datedropper.min.css" />

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
                                            <div class="col-md-8 m-auto">
                                                <a href="index" class="btn btn-inverse btn-bg-c-white btn-outline-default btn-round btn-action m-r-10 m-b-10"> <i class="icofont icofont-circled-left"> </i> Home </a>
                                            </div>
                                        </div>

                                        <div class="row">

                                            <div class="col-md-8 m-auto">
                                                <div class="card card-border-default">
                                                    <div class="card-header">
                                                        <h5 class="text-inverse"> Reference Form: <?php echo fetchPersonnelName($con, $personnel_idStored); ?> </h5>
                                                    </div>
                                                    <div class="card-block icon-btn">
                                                        <form action="reference" method="POST">
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Name of Personnel</label>
                                                                        <input type="text" class="form-control" name="personnel_name" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Referee's Name</label>
                                                                        <input type="text" class="form-control" name="reference_name" required>
                                                                    </div>                                                                    
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Referee's Residential Address </label>
                                                                        <input type="text" class="form-control" name="residential_address" required>
                                                                    </div>                                                                    
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Age</label>
                                                                        <input type="text" class="form-control" name="lga_origin" required/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Gender</label>
                                                                        <select name="gender" id="gender" class="form-control" required>
                                                                            <option value="Male">Male</option>
                                                                            <option value="Female">Female</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Relationship to Personnel</label>
                                                                        <input type="text" class="form-control" name="relationship" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Length of relationship</label>
                                                                        <input type="text" class="form-control" name="relationship_lenght" required>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                 <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Phone Number</label>
                                                                        <input type="text" class="form-control" name="phone_number" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Email Address</label>
                                                                        <input type="email" class="form-control" name="email_address" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                                
                                                            <div class="row">
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Occupation</label>
                                                                        <input type="text" class="form-control" name="occupation" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Designation</label>
                                                                        <input type="text" class="form-control" name="designation" placeholder="">
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label"> Employer </label>
                                                                        <input type="text" class="form-control" name="employer_name">
                                                                    </div>                                                                    
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label"> Office Address </label>
                                                                        <input type="text" class="form-control" name="office_address">
                                                                    </div>                                                                    
                                                                </div>
                                                            </div>

                                                            <div class="row">

                                                            </div>

                                                            <br>
                                                            <h6 class="m-b-20"><strong> Use the following qualities to assess the personnel: </strong></h6>

                                                            <div class="row">
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Honesty</label>
                                                                        <select name="honesty" id="honesty" class="form-control" required>
                                                                            <option></option>
                                                                            <option value="Poor">Poor</option>
                                                                            <option value="Average">Average</option>
                                                                            <option value="Good">Good</option>
                                                                            <option value="Excellent">Excellent</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Trustworthiness</label>
                                                                        <select name="trustworthiness" id="trustworthiness" class="form-control" required>
                                                                            <option></option>
                                                                            <option value="Poor">Poor</option>
                                                                            <option value="Average">Average</option>
                                                                            <option value="Good">Good</option>
                                                                            <option value="Excellent">Excellent</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Reliability</label>
                                                                        <select name="reliability" id="reliability" class="form-control" required>
                                                                            <option></option>
                                                                            <option value="Poor">Poor</option>
                                                                            <option value="Average">Average</option>
                                                                            <option value="Good">Good</option>
                                                                            <option value="Excellent">Excellent</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Conscientiousness</label>
                                                                        <select name="conscientiousness" id="conscientiousness" class="form-control" required>
                                                                            <option></option>
                                                                            <option value="Poor">Poor</option>
                                                                            <option value="Average">Average</option>
                                                                            <option value="Good">Good</option>
                                                                            <option value="Excellent">Excellent</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Integrity</label>
                                                                        <select name="integrity" id="integrity" class="form-control" required>
                                                                            <option></option>
                                                                            <option value="Poor">Poor</option>
                                                                            <option value="Average">Average</option>
                                                                            <option value="Good">Good</option>
                                                                            <option value="Excellent">Excellent</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Dependability</label>
                                                                        <select name="dependability" id="dependability" class="form-control" required>
                                                                            <option></option>
                                                                            <option value="Poor">Poor</option>
                                                                            <option value="Average">Average</option>
                                                                            <option value="Good">Good</option>
                                                                            <option value="Excellent">Excellent</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Relationship with others</label>
                                                                        <select name="relationship_others" id="relationship_others" class="form-control" required>
                                                                            <option></option>
                                                                            <option value="Poor">Poor</option>
                                                                            <option value="Average">Average</option>
                                                                            <option value="Good">Good</option>
                                                                            <option value="Excellent">Excellent</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>

                                                            <br>
                                                            <h6 class="m-b-20"><strong> Comments </strong></h6>
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label"> Overall Comment/Assessment of Personnel </label>
                                                                        <textarea class="form-control" name="comments"/></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label"> What are the Personnel's Weaknesses? </label>
                                                                        <textarea class="form-control" name="weakness"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label"> Recommendations </label>
                                                                        <textarea class="form-control" name="recommendation"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <br>
                                                            <p>Please upload a covering letter affirming to sincerity of the information</p>
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="form-group">
                                                                        <button type="submit" class="btn btn-primary btn-round" name="submit_reference" id="submit_reference"> <i class="icofont icofont-save"></i> Submit </button>

                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </form>
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
                <a href="http://www.google.com/chrome/">
                    <img src="../assets/images/browser/chrome.png" alt="Chrome">
                    <div>Chrome</div>
                </a>
            </li>
            <li>
                <a href="https://www.mozilla.org/en-US/firefox/new/">
                    <img src="../assets/images/browser/firefox.png" alt="Firefox">
                    <div>Firefox</div>
                </a>
            </li>
            <li>
                <a href="http://www.opera.com">
                    <img src="../assets/images/browser/opera.png" alt="Opera">
                    <div>Opera</div>
                </a>
            </li>
            <li>
                <a href="https://www.apple.com/safari/">
                    <img src="../assets/images/browser/safari.png" alt="Safari">
                    <div>Safari</div>
                </a>
            </li>
            <li>
                <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
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


    <!-- Bootstrap date-time-picker js -->
    <script type="text/javascript" src="../components/pages/advance-elements/moment-with-locales.min.js"></script>
    <script type="text/javascript" src="../components/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="../components/pages/advance-elements/bootstrap-datetimepicker.min.js"></script>
    <!-- Date-range picker js -->
    <script type="text/javascript" src="../components/bootstrap-daterangepicker/js/daterangepicker.js"></script>
    <!-- Date-dropper js -->
    <script type="text/javascript" src="../components/datedropper/js/datedropper.min.js"></script>
    <script type="text/javascript" src="../components/pages/advance-elements/custom-picker.js"></script>


    <!-- Custom js -->
    <script src="../assets/js/pcoded.min.js"></script>
    <script src="../assets/js/menu/menu-hori-fixed.js"></script>
    <script src="../assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script type="text/javascript" src="../assets/js/script.js"></script>

</body>

</html>

<?php
session_start();
// Disable Navbar
$disable0=""; $disable1=""; $disable2=""; $disable3=""; $disable4=""; $disable5=""; $disable6=""; $disable7="disabled";

require_once('../core/config.php');
include_once('../core/functions/autolock.php');
include_once('../core/functions/analytics.php');
include_once('../core/functions/global.php');
include_once('../core/functions/dates.php');
include_once('../core/functions/render.php');

$form_id = "4";
if (isset($_GET['token']) && $_GET['token']!="" ) {

    $_SESSION["wms_form_token"] = $_GET['token'];
    $wms_form_tokenStored = $_SESSION["wms_form_token"];

    $token_status = validateToken($con, $wms_form_tokenStored, $form_id);

    if ($token_status=="1") {

        $queryTokenParam = "SELECT * FROM form_tokens WHERE token='$wms_form_tokenStored' AND token_status='1' ";
        $resultTokenParam= mysqli_query($con, $queryTokenParam);

        $contentTokenParam=mysqli_fetch_array($resultTokenParam);

        $id_set = $contentTokenParam['id'];
        $client_id_set = $contentTokenParam['client_id'];
        $personnel_id_set = $contentTokenParam['personnel_id'];
        $token_set = $contentTokenParam['token'];

    } elseif ($token_status=="2") {
        echo "<script> window.location = '../tokenwrong'; </script>" ;
    } elseif ($token_status=="3") {
        echo "<script> window.location = '../tokenexpired'; </script>" ;        
    } elseif ($token_status=="4") {
        echo "<script> window.location = '../tokendead'; </script>" ;
    }

} else {
    echo "<script> window.location = '../tokenexpired'; </script>" ;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title> BCI WMS | Assessment Form </title>
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
    <link rel="icon" href="../../assets/img/favicon.png" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="../../components/bootstrap/css/bootstrap.min.css">
    <!-- themify-icons line icon -->
    <link rel="stylesheet" type="text/css" href="../../assets/icon/themify-icons/themify-icons.css">
    <!-- ico font -->
    <link rel="stylesheet" type="text/css" href="../../assets/icon/icofont/css/icofont.css">
    <!-- flag icon framework css -->
    <link rel="stylesheet" type="text/css" href="../../assets/pages/flag-icon/flag-icon.min.css">
    <!-- Menu-Search css -->
    <link rel="stylesheet" type="text/css" href="../../assets/pages/menu-search/css/component.css">

    <!-- Date-time picker css -->
    <link rel="stylesheet" type="text/css" href="../../components/pages/advance-elements/css/bootstrap-datetimepicker.css">
    <!-- Date-range picker css  -->
    <link rel="stylesheet" type="text/css" href="../../components/bootstrap-daterangepicker/css/daterangepicker.css" />
    <!-- Date-Dropper css -->
    <link rel="stylesheet" type="text/css" href="../../components/datedropper/css/datedropper.min.css" />

    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="../../assets/css/style.css">

    <link rel="stylesheet" type="text/css" href="../../assets/css/jquery.mCustomScrollbar.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/pcoded-horizontal.min.css">
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
                                            <div class="col-md-8 m-auto filter-bar icon-btn">
                                                <?php include('_includes/company_nav.php'); ?>
                                            </div>
                                        </div>

                                        <div class="row">

                                            <div class="col-md-8 m-auto">
                                                <div class="card card-border-default">
                                                    <div class="card-header">
                                                        <h5 class="text-inverse"> Assessment Form: <?php echo fetchPersonnelName($con, $personnel_id_set)." (".fetchUserName($con, $client_id_set).")"; ?> </h5>
                                                    </div>
                                                    <div class="card-block icon-btn">
                                                        <form action="company" method="POST">
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Name of Company</label>
                                                                        <input type="text" class="form-control" name="company_name" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Name of Personnel</label>
                                                                        <input type="text" class="form-control" name="personnel_name" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <label class="control-label"> Date Employed</label>
                                                                        <input type="text" class="form-control" name="start_date" id="dropper-default1" placeholder="dd-mm-yyyy" required/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <label class="control-label"> Exit Date</label>
                                                                        <input type="text" class="form-control" name="end_date" id="dropper-default2" placeholder="dd-mm-yyyy" required/>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Manner of exit</label>
                                                                        <input type="text" class="form-control" name="exit_manner" required>
                                                                    </div>                                                                    
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label"> Personnel's last designation </label>
                                                                        <input type="text" class="form-control" name="last_designation" required>
                                                                    </div>                                                                    
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <label class="control-label">If given the opportunity, will you re-hire personnel?</label>
                                                                        <select name="rehire_status" id="rehire_status" class="form-control" required>
                                                                            <option></option>
                                                                            <option value="Yes">Yes</option>
                                                                            <option value="No">No</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-9">
                                                                    <div class="form-group">
                                                                        <label class="control-label"> Why </label>
                                                                        <textarea class="form-control" name="why_rehire"/></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <br>
                                                            <h6 class="m-b-20"><strong> Use the following qualities to assess the personnel: </strong></h6>

                                                            <div class="row">
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Attitude to work</label>
                                                                        <select name="attitude_to_work" id="attitude_to_work" class="form-control" required>
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
                                                                        <label class="control-label">Punctuality</label>
                                                                        <select name="punctuality" id="punctuality" class="form-control" required>
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
                                                                        <label class="control-label">Technical Skill</label>
                                                                        <select name="technical_skill" id="technical_skill" class="form-control" required>
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
                                                                        <label class="control-label">Productivity</label>
                                                                        <select name="productivity" id="productivity" class="form-control" required>
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
                                                                <div class="col-sm-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Relationship with colleagues</label>
                                                                        <select name="relationship_colleagues" id="relationship_colleagues" class="form-control" required>
                                                                            <option></option>
                                                                            <option value="Poor">Poor</option>
                                                                            <option value="Average">Average</option>
                                                                            <option value="Good">Good</option>
                                                                            <option value="Excellent">Excellent</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Relationship with sub-ordinates</label>
                                                                        <select name="relationship_sub_ordinates" id="relationship_sub_ordinates" class="form-control" required>
                                                                            <option></option>
                                                                            <option value="Poor">Poor</option>
                                                                            <option value="Average">Average</option>
                                                                            <option value="Good">Good</option>
                                                                            <option value="Excellent">Excellent</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Relationship with Superiors</label>
                                                                        <select name="relationship_superiors" id="relationship_superiors" class="form-control" required>
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
                                                                        <label class="control-label">Managerial skill</label>
                                                                        <select name="managerial_skill" id="managerial_skill" class="form-control" required>
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
                                                                        <label class="control-label">Leadership qualities</label>
                                                                        <select name="leadership_qualities" id="leadership_qualities" class="form-control" required>
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
                                                                        <label class="control-label">Overall Performance</label>
                                                                        <select name="overall_performance" id="overall_performance" class="form-control" required>
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
                                                                        <label class="control-label"> What are the Personnel's Weaknesses? </label>
                                                                        <textarea class="form-control" name="weakness"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label"> Overall Assessment of Personnel </label>
                                                                        <textarea class="form-control" name="comments"/></textarea>
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
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Officers' Name</label>
                                                                        <input type="text" class="form-control" name="officer_name" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Designation</label>
                                                                        <input type="text" class="form-control" name="officer_designation" placeholder="">
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <label class="control-label"> Officer's Phone No </label>
                                                                        <input type="text" class="form-control" name="officer_phone_number">
                                                                    </div>                                                                    
                                                                </div>
                                                            </div>
                                                            
                                                            <br>
                                                            <p> We will appreciate it if you can upload a covering letter on your company’s letterhead attesting that the information you supplied is devoid of errors.</p>

                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="form-group">
                                                                        <button type="submit" class="btn btn-primary btn-round" name="submit_company" id="submit_company"> <i class="icofont icofont-save"></i> Submit </button>

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
                    <img src="../../assets/images/browser/chrome.png" alt="Chrome">
                    <div>Chrome</div>
                </a>
            </li>
            <li>
                <a href="https://www.mozilla.org/en-US/firefox/new/">
                    <img src="../../assets/images/browser/firefox.png" alt="Firefox">
                    <div>Firefox</div>
                </a>
            </li>
            <li>
                <a href="http://www.opera.com">
                    <img src="../../assets/images/browser/opera.png" alt="Opera">
                    <div>Opera</div>
                </a>
            </li>
            <li>
                <a href="https://www.apple.com/safari/">
                    <img src="../../assets/images/browser/safari.png" alt="Safari">
                    <div>Safari</div>
                </a>
            </li>
            <li>
                <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                    <img src="../../assets/images/browser/ie.png" alt="">
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
    <script type="text/javascript" src="../../components/jquery/js/jquery.min.js"></script>
    <script type="text/javascript" src="../../components/jquery-ui/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="../../components/popper.js/js/popper.min.js"></script>
    <script type="text/javascript" src="../../components/bootstrap/js/bootstrap.min.js"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="../../components/jquery-slimscroll/js/jquery.slimscroll.js"></script>
    <!-- modernizr js -->
    <script type="text/javascript" src="../../components/modernizr/js/modernizr.js"></script>
    <script type="text/javascript" src="../../components/modernizr/js/css-scrollbars.js"></script>


    <!-- Bootstrap date-time-picker js -->
    <script type="text/javascript" src="../../components/pages/advance-elements/moment-with-locales.min.js"></script>
    <script type="text/javascript" src="../../components/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="../../components/pages/advance-elements/bootstrap-datetimepicker.min.js"></script>
    <!-- Date-range picker js -->
    <script type="text/javascript" src="../../components/bootstrap-daterangepicker/js/daterangepicker.js"></script>
    <!-- Date-dropper js -->
    <script type="text/javascript" src="../../components/datedropper/js/datedropper.min.js"></script>
    <script type="text/javascript" src="../../components/pages/advance-elements/custom-picker.js"></script>


    <!-- Custom js -->
    <script src="../../assets/js/pcoded.min.js"></script>
    <script src="../../assets/js/menu/menu-hori-fixed.js"></script>
    <script src="../../assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script type="text/javascript" src="../../assets/js/script.js"></script>

</body>

</html>

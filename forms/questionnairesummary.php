<?php
session_start();
// Disable Navbar
$disable0=""; $disable1=""; $disable2=""; $disable3=""; $disable4=""; $disable5=""; $disable6=""; $disable7="";

require_once('../core/config.php');
include_once('../core/functions/autolock.php');
include_once('../core/functions/analytics.php');
include_once('../core/functions/global.php');
include_once('../core/functions/dates.php');
include_once('../core/functions/render.php');

$form_id = "1";
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
    <title> BCI WMS | Questionnaire Summary </title>
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

    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="../../assets/css/style.css">

    <!-- jquery file upload Frame work -->
    <link href="../../components/jquery.filer/css/jquery.filer.css" type="text/css" rel="stylesheet" />
    <link href="../../components/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css" type="text/css" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="../../assets/css/jquery.mCustomScrollbar.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/pcoded-horizontal.min.css">

    <style type="text/css">
        .summaryfont {
            font-size: 14px;
            line-height: 8p !important;
        }
    </style>
</head>
<!-- Menu horizontal fixed layout -->

<body>
    <!-- Pre-loader start -->
    <?php //include ('_includes/preloader.php'); ?>
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
                                                <?php include('_includes/questionnaire_nav.php'); ?>
                                            </div>
                                        </div>

                                        <div class="row">

                                            <div class="col-md-8 m-auto">
                                                <div class="card card-border-default">

                                                    <div class="card-header">
                                                        <h5 class="text-inverse"> BCI QUESTIONNAIRE SUMMARY: <?php echo fetchPersonnelName($con, $personnel_id_set)." (".fetchUserName($con, $client_id_set).")"; ?> </h5>
                                                    </div>

                                                    <div class="card-block marketing-card p-30">

                                                        <div class="row">
                                                            <div class="col-md-3 ml-md-auto">
                                                                <img src="../../assets/img/avatar1.png" class="img-responsive" width="100%" height="auto">
                                                            </div>
                                                        </div>
                                                        <br>

                                                        <div class="row m-b-10">
                                                            <div class="col-sm-12 col-xs-12 p-20" style="border: solid 1px #e6e6e6;">
                                                                <h6 class="text-uppercase"><strong> Personal Details</strong></h6>
                                                                <div class="row">
                                                                    <div class="col-sm-6 col-xs-12">
                                                                        <p class="m-0 m-t-10"><strong> Full Name:</strong> Oluyomi, Godwin Temidayo </p>
                                                                        <p class="m-0 m-t-10"><strong> Date of Birth: </strong> 20th Sept, 2016 </p>
                                                                        <p class="m-0 m-t-10"><strong> Place of Birth: </strong> Lorem Ipsum </p>
                                                                        <p class="m-0 m-t-10"><strong> State of Origin: </strong> Lorem Ipsum </p>
                                                                        <p class="m-0 m-t-10"><strong> L.G.A: </strong> Lorem Ipsum </p>
                                                                        <p class="m-0 m-t-10"><strong> Gender: </strong> Male </p>
                                                                    </div>
                                                                    <div class="col-sm-6 col-xs-12">
                                                                        <p class="m-0 m-t-10"><strong> Maiden Name: </strong> Lorem Ipsum </p>
                                                                        <p class="m-0 m-t-10"><strong> Marital Status: </strong> Married </p>
                                                                        <p class="m-0 m-t-10"><strong> Email Address: </strong> Lorem Ipsum </p>
                                                                        <p class="m-0 m-t-10"><strong> Phone Number(s): </strong> 0806608000,006959965 </p>
                                                                        <p class="m-0 m-t-10"><strong> Current Designation: </strong> Lorem Ipsum </p>
                                                                        <p class="m-0 m-t-10"><strong> Residential Address: </strong> Lorem Ipsum </p>
                                                                    </div>
                                                                </div>  
                                                            </div>
                                                        </div>

                                                        <div class="row m-b-10">
                                                            <div class="col-sm-4 col-xs-12 p-20" style="border: solid 1px #e6e6e6;">
                                                                <h6 class="text-uppercase"><strong>  Contact Person </strong></h6>
                                                                <p class="m-0 m-t-10"><strong> Full Name: </strong> Lorem Ipsum </p>
                                                                <p class="m-0 m-t-10"><strong> Phone Number: </strong> Lorem Ipsum </p>
                                                                <p class="m-0 m-t-10"><strong> Address: </strong> Lorem Ipsum </p>
                                                                <p class="m-0 m-t-10"><strong> Relationship: </strong> Lorem Ipsum </p>
                                                            </div>
                                                            <div class="col-sm-8 col-xs-12 p-20" style="border: solid 1px #e6e6e6;">
                                                                <h6 class="text-uppercase"><strong>  Educational Records </strong></h6>
                                                                <div class="row">
                                                                    <div class="col-sm-12 col-xs-12">
                                                                        <p class="m-0 m-t-10"><strong> Name of school: </strong> Lorem Ipsum </p>
                                                                        <p class="m-0 m-t-10"><strong> Matric Number: </strong> Lorem Ipsum </p>
                                                                        <p class="m-0 m-t-10"><strong> Entrance Year - Exit Year: </strong> Lorem Ipsum </p>
                                                                        <p class="m-0 m-t-10"><strong> Certificate Obtained: </strong> Lorem Ipsum </p>
                                                                        <br>
                                                                    </div>
                                                                    <div class="col-sm-12 col-xs-12">
                                                                        <p class="m-0 m-t-10"><strong> Name of school: </strong> Lorem Ipsum </p>
                                                                        <p class="m-0 m-t-10"><strong> Matric Number: </strong> Lorem Ipsum </p>
                                                                        <p class="m-0 m-t-10"><strong> Entrance Year - Exit Year: </strong> Lorem Ipsum </p>
                                                                        <p class="m-0 m-t-10"><strong> Certificate Obtained: </strong> Lorem Ipsum </p>
                                                                        <br>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>

                                                        <div class="row m-b-10">
                                                            <div class="col-sm-12 col-xs-12 p-20" style="border: solid 1px #e6e6e6;">
                                                                <h6 class="text-uppercase"><strong>  Professional Certificates </strong></h6>
                                                                <div class="row">
                                                                    <div class="col-sm-12 col-xs-12">
                                                                        <p class="m-0 m-t-10"><strong> Name of Professional Body: </strong> Lorem Ipsum </p>
                                                                        <p class="m-0 m-t-10"><strong> Membership No: </strong> Lorem Ipsum </p>
                                                                        <p class="m-0 m-t-10"><strong> Membership Status: </strong> Lorem Ipsum </p>
                                                                        <p class="m-0 m-t-10"><strong> Membership Start Date: </strong> Lorem Ipsum </p>
                                                                        <br>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row m-b-10">
                                                            <div class="col-sm-12 col-xs-12 p-20" style="border: solid 1px #e6e6e6;">
                                                                <h6 class="text-uppercase"><strong>  Employment History </strong></h6>
                                                                <div class="row">
                                                                    <div class="col-sm-12 col-xs-12">
                                                                        <p class="m-0 m-t-10"><strong> Name Of Employer: </strong> Lorem Ipsum </p>
                                                                        <p class="m-0 m-t-10"><strong> Type of Business: </strong> Lorem Ipsum </p>
                                                                        <p class="m-0 m-t-10"><strong> Address Of Employer: </strong> Lorem Ipsum </p>
                                                                        <p class="m-0 m-t-10"><strong> Location/Branch: </strong> Lorem Ipsum </p>
                                                                        <p class="m-0 m-t-10"><strong> Starting Designation: </strong> Lorem Ipsum </p>
                                                                        <p class="m-0 m-t-10"><strong> Current/Last Designation: </strong> Lorem Ipsum </p>
                                                                        <p class="m-0 m-t-10"><strong> Date Employed: </strong> Lorem Ipsum </p>
                                                                        <p class="m-0 m-t-10"><strong> Exit Date: </strong> Lorem Ipsum </p>
                                                                        <p class="m-0 m-t-10"><strong> Office Telephone No(s): </strong> Lorem Ipsum </p>
                                                                        <p class="m-0 m-t-10"><strong> Supervisor’ Name: </strong> Lorem Ipsum </p>
                                                                        <p class="m-0 m-t-10"><strong> Supervisor’s Email: </strong> Lorem Ipsum </p>
                                                                        <p class="m-0 m-t-10"><strong> Seconded by An Agency: </strong> Lorem Ipsum </p>
                                                                        <p class="m-0 m-t-10"><strong> Name Of Agency: </strong> Lorem Ipsum </p>
                                                                        <p class="m-0 m-t-10"><strong> Address of Agency: </strong> Lorem Ipsum </p>
                                                                        <br>
                                                                    </div>
                                                                    <div class="col-sm-12 col-xs-12">
                                                                        <p class="m-0 m-t-10"><strong> Name Of Employer: </strong> Lorem Ipsum </p>
                                                                        <p class="m-0 m-t-10"><strong> Type of Business: </strong> Lorem Ipsum </p>
                                                                        <p class="m-0 m-t-10"><strong> Address Of Employer: </strong> Lorem Ipsum </p>
                                                                        <p class="m-0 m-t-10"><strong> Location/Branch: </strong> Lorem Ipsum </p>
                                                                        <p class="m-0 m-t-10"><strong> Starting Designation: </strong> Lorem Ipsum </p>
                                                                        <p class="m-0 m-t-10"><strong> Current/Last Designation: </strong> Lorem Ipsum </p>
                                                                        <p class="m-0 m-t-10"><strong> Date Employed: </strong> Lorem Ipsum </p>
                                                                        <p class="m-0 m-t-10"><strong> Exit Date: </strong> Lorem Ipsum </p>
                                                                        <p class="m-0 m-t-10"><strong> Office Telephone No(s): </strong> Lorem Ipsum </p>
                                                                        <p class="m-0 m-t-10"><strong> Supervisor’ Name: </strong> Lorem Ipsum </p>
                                                                        <p class="m-0 m-t-10"><strong> Supervisor’s Email: </strong> Lorem Ipsum </p>
                                                                        <p class="m-0 m-t-10"><strong> Seconded by An Agency: </strong> Lorem Ipsum </p>
                                                                        <p class="m-0 m-t-10"><strong> Name Of Agency: </strong> Lorem Ipsum </p>
                                                                        <p class="m-0 m-t-10"><strong> Address of Agency: </strong> Lorem Ipsum </p>
                                                                        <br>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row m-b-10">
                                                            <div class="col-sm-12 col-xs-12 p-20" style="border: solid 1px #e6e6e6;">
                                                                <h6 class="text-uppercase"><strong> Guarantors Verification </strong></h6>
                                                                <div class="row">
                                                                    <div class="col-sm-6 col-xs-12">
                                                                        <p class="m-0 m-t-10"><strong> Guarantor's Name: </strong> Lorem Ipsum </p>
                                                                        <p class="m-0 m-t-10"><strong> Phone Number: </strong> Lorem Ipsum </p>
                                                                        <p class="m-0 m-t-10"><strong> Email Address: </strong> Lorem Ipsum </p>
                                                                        <p class="m-0 m-t-10"><strong> Residential Address: </strong> Lorem Ipsum </p>
                                                                        <p class="m-0 m-t-10"><strong> Relationship: </strong> Lorem Ipsum </p>
                                                                        <p class="m-0 m-t-10"><strong> Office Address: </strong> Lorem Ipsum </p>
                                                                        <br>
                                                                    </div>
                                                                    <div class="col-sm-6 col-xs-12">
                                                                        <p class="m-0 m-t-10"><strong> Guarantor's Name: </strong> Lorem Ipsum </p>
                                                                        <p class="m-0 m-t-10"><strong> Phone Number: </strong> Lorem Ipsum </p>
                                                                        <p class="m-0 m-t-10"><strong> Email Address: </strong> Lorem Ipsum </p>
                                                                        <p class="m-0 m-t-10"><strong> Residential Address: </strong> Lorem Ipsum </p>
                                                                        <p class="m-0 m-t-10"><strong> Relationship: </strong> Lorem Ipsum </p>
                                                                        <p class="m-0 m-t-10"><strong> Office Address: </strong> Lorem Ipsum </p>
                                                                        <br>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <h6 class="text-uppercase"><strong> Terms And Condition: </strong></h6>
                                                                <p> By submitting, I hereby acknowledge that the information supplied by me is true to the best of my knowledge. I understand that any misinterpretation or omission may affect my application. I further authorize the company to investigate all the above supplied information. 
                                                                 </p>
                                                            </div>
                                                        </div>

                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="form-group">
                                                                        <button type="submit" class="btn btn-primary btn-round" name="submit_questionnairesummary" id="submit_questionnairesummary"> <i class="icofont icofont-save"></i> Submit </button>

                                                                    </div>
                                                                </div>
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


    <!-- jquery file upload js -->
    <script src="../../components/jquery.filer/js/jquery.filer.min.js"></script>
    <script src="../../components/jquery.filer/dragboxfiler.js" type="text/javascript"></script>
    <script src="../../components/jquery.filer/inputboxfiler.js" type="text/javascript"></script>

    <!-- task board js -->
    <script type="text/javascript" src="../../components/pages/task-board/task-board.js"></script>

    <!-- Custom js -->
    <script src="../../assets/js/pcoded.min.js"></script>
    <script src="../../assets/js/menu/menu-hori-fixed.js"></script>
    <script src="../../assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script type="text/javascript" src="../../assets/js/script.js"></script>

</body>

</html>

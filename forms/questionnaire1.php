<?php
session_start();
// Disable Navbar
$disable0=""; $disable1="disabled"; $disable2=""; $disable3=""; $disable4=""; $disable5=""; $disable6=""; $disable7="disabled";

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
    <title> BCI WMS | Questionnaire Form </title>
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
                                                <?php include('_includes/questionnaire_nav.php'); ?>
                                            </div>
                                        </div>

                                        <div class="row">

                                            <div class="col-md-8 m-auto">
                                                <div class="card card-border-default">
                                                    <div class="card-header">
                                                        <h5 class="text-inverse"> Educational Records: <?php echo fetchPersonnelName($con, $personnel_id_set)." (".fetchUserName($con, $client_id_set).")"; ?> </h5>
                                                    </div>
                                                    <div class="card-block icon-btn">
                                                        <p> You can fill the form below only once. Kindly ensure you are uploading the right information before saving. </p>

                                                         <!-- action="questionnaire1/<?php //echo $wms_form_tokenStored; ?>" -->

                                                        <form method="POST" id="questionnaire1Form">

                                                            <input type="hidden" name="client_id" id="client_id" value="<?php echo $client_id_set; ?>">
                                                            <input type="hidden" name="personnel_id" id="personnel_id" value="<?php echo $personnel_id_set; ?>">
                                                            <input type="hidden" name="token" value="<?php echo $token_set; ?>">

                                                            <div class="row">
                                                                <div class="col-sm-9">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Name & Location of school</label>
                                                                        <input type="text" class="form-control" name="school_name" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Matric Number</label>
                                                                        <input type="text" class="form-control" name="matric_no" required>
                                                                    </div>                                                                    
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Entrance Year</label>
                                                                        <input type="text" class="form-control" name="entrance_year" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Exit Year</label>
                                                                        <input type="text" class="form-control" name="exit_year" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Certificate/Degree Obtained</label>
                                                                        <input type="text" class="form-control" name="certificate_obtained" required>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <br>
                                                            <div class="row">
                                                                 <div class="col-sm-12" id="alertplace">
                                                                     
                                                                 </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="form-group">
                                                                        <button type="submit" class="btn btn-primary btn-round" name="submit_questionnaire1" id="submit_questionnaire1"> <i class="icofont icofont-save"></i> Save </button>
                                                                        
                                                                        <!-- <a href="../questionnaire1/<?php //cho $wms_form_tokenStored; ?>" class="btn btn-success btn-round"> Refresh <i class="icofont icofont-refresh"></i></a> -->

                                                                        <a href="../questionnaire2/<?php echo $wms_form_tokenStored; ?>" class="btn btn-inverse btn-round"> Next Form <i class="icofont icofont-rounded-right"></i></a>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                                

                                                            
                                                            <hr>
                                                            <h6 class="m-b-20"><strong> Saved Educational Records </strong></h6>
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <ol class="basic-list" id="previouscard">
                                                                        
                                                                    </ol>

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

    <script type="text/javascript">
             
        $(document).ready(function(){

            $('form#questionnaire1Form').submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);

                // var formData = $(this).serialize();
                // alert(formData);

                $.ajax({
                    url:"../../core/controllerAjax/questionnaire1Controller.php",
                    method:"POST",
                    data:formData,
                    async:false,
                    success:function(data)
                    {
                        $("#alertplace").html(data);
                        load_previous();
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });

            });

            load_previous();

            function load_previous() {

                $.ajax({
                    url:"../../core/controllerAjax/questionnaire1PullController.php",
                    method:"POST",
                    data: {
                        client_id:$("#client_id").val(),
                        personnel_id:$("#personnel_id").val()
                    },
                    success:function(data)
                    {
                        $("#previouscard").html(data);
                    }
                })
            }

            
        });

    </script>

</body>

</html>

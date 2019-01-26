<?php
session_start();
// Disable Navbar
$disable0="disabled"; $disable1=""; $disable2=""; $disable3=""; $disable4=""; $disable5=""; $disable6=""; $disable7="disabled";

require_once('../core/config.php');
include_once('../core/functions/autolock.php');
include_once('../core/functions/analytics.php');
include_once('../core/functions/global.php');
include_once('../core/functions/dates.php');
include_once('../core/functions/render.php');

$form_id = "1";
if ((isset($_GET['token']) && $_GET['token']!="" ) || isset($_SESSION["wms_form_token"])) {

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
                                                        <h5 class="text-inverse"> Personal Details: <?php echo fetchPersonnelName($con, $personnel_id_set)." (".fetchUserName($con, $client_id_set).")"; ?> </h5>
                                                    </div>
                                                    <div class="card-block icon-btn">
                                                        <p> You can fill the form below only once. Kindly ensure you are uploading the right information before saving. </p>

                                                        <!-- action="<?php //echo $_SERVER['PHP_SELF']; ?>" -->
                                                        <!-- <form action="questionnaire/<?php //echo $wms_form_tokenStored; ?>" method="POST" enctype="multipart/form-data"> -->

                                                        <form id="questionnaireForm" method="POST" enctype="multipart/form-data">

                                                            <input type="hidden" name="client_id" value="<?php echo $client_id_set; ?>">
                                                            <input type="hidden" name="personnel_id" value="<?php echo $personnel_id_set; ?>">
                                                            <input type="hidden" name="token" value="<?php echo $token_set; ?>">

                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Surname</label>
                                                                        <input type="text" class="form-control" name="surname" >
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">First Name</label>
                                                                        <input type="text" class="form-control" name="firstname" >
                                                                    </div>                                                                    
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Other Name(s) </label>
                                                                        <input type="text" class="form-control" name="othernames" >
                                                                    </div>                                                                    
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Date of Birth</label>
                                                                        <input type="text" class="form-control" name="dob" id="dropper-default1" placeholder="dd-mm-yyyy" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Place of Birth</label>
                                                                        <input type="text" class="form-control" name="pob" >
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">State of Origin</label>
                                                                        <input type="text" class="form-control" name="state_origin" >
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <label class="control-label">L.G.A</label>
                                                                        <input type="text" class="form-control" name="lga_origin" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Maiden Name</label>
                                                                        <input type="text" class="form-control" name="maidenname" placeholder="If Applicable">
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Gender</label>
                                                                        <select name="gender" id="gender" class="form-control" >
                                                                            <option value="Male">Male</option>
                                                                            <option value="Female">Female</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Marital Status</label>
                                                                        <select name="marital_status" class="form-control" >
                                                                            <option value="Single">Single</option>
                                                                            <option value="Married">Married</option>
                                                                            <option value="Divorced">Divorced</option>
                                                                            <option value="Separted">Separted</option>
                                                                            <option value="Widowed">Widowed</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Personal Email Address</label>
                                                                        <input type="email" class="form-control" name="email_address" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Phone Number 1</label>
                                                                        <input type="text" class="form-control" name="phone_number1" >
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Phone Number 2</label>
                                                                        <input type="text" class="form-control" name="phone_number2">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label"> Current Designation</label>
                                                                        <input type="text" class="form-control" name="current_designation" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-8">
                                                                    <div class="form-group">
                                                                        <label class="control-label"> Residential Address</label>
                                                                        <input type="text" class="form-control" name="residential_address" >
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <br>
                                                            <h6 class="m-b-10"><strong> Upload Passport</strong></h6>
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <!-- <label class="control-label"> Upload Passport </label> -->
                                                                        <input type="file" class="form-control" name="uploadfile" />
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <br>
                                                            <h6 class="m-b-20"><strong> Contact of person to be notified in case of any emergency </strong></h6>
                                                            <div class="row">
                                                                <div class="col-sm-8">
                                                                    <div class="form-group">
                                                                        <label class="control-label"> Full Name </label>
                                                                        <input type="text" class="form-control" name="ice_name" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label"> Phone Number </label>
                                                                        <input type="text" class="form-control" name="ice_phone_number" >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-8">
                                                                    <div class="form-group">
                                                                        <label class="control-label"> Address</label>
                                                                        <input type="text" class="form-control" name="ice_address" >
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label"> Relationship </label>
                                                                        <select name="ice_relationship" class="form-control" >
                                                                            <option value="Husband"> Husband </option>
                                                                            <option value="Wife"> Wife </option>
                                                                            <option value="Father"> Father </option>
                                                                            <option value="Mother"> Mother </option>
                                                                            <option value="Brother"> Brother </option>
                                                                            <option value="Sister"> Sister </option>
                                                                            <option value="Son"> Son </option>
                                                                            <option value="Daughter"> Daughter </option>
                                                                            <option value="Niece"> Niece </option>
                                                                            <option value="Nephew"> Nephew </option>
                                                                            <option value="Grandfather"> Grandfather </option>
                                                                            <option value="Grandmother"> Grandmother </option>
                                                                            <option value="Grandson"> Grandson </option>
                                                                            <option value="Granddaughter"> Granddaughter </option>
                                                                        </select>
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
                                                                        <button type="submit" class="btn btn-primary btn-round" name="submit_questionnaire" id="submit_questionnaire"> <i class="icofont icofont-save"></i> Save </button>

                                                                        <a href="../questionnaire1/<?php echo $wms_form_tokenStored; ?>" class="btn btn-inverse btn-round"> Next Form <i class="icofont icofont-rounded-right"></i></a>

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

    <script type="text/javascript">
             
        $(document).ready(function(){

            $('form#questionnaireForm').submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);

                // var formData = $(this).serialize();
                // alert(formData);

                $.ajax({
                    url:"../../core/controllerAjax/questionnaireController.php",
                    method:"POST",
                    data:formData,
                    async:false,
                    success:function(data)
                    {
                        // $("#file_path").val(data.formlink);
                        $("#alertplace").html(data)
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });

            });
            
        });

    </script>

</body>

</html>

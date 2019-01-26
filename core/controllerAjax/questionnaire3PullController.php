<?php
session_start();
date_default_timezone_set("Africa/Lagos");

require_once('../config.php');
include_once('../functions/global.php');
include_once('../functions/analytics.php');

if($_POST)
{   
    $client_id = $_POST['client_id'];
    $personnel_id = $_POST['personnel_id'];

	$queryquestionnaire3 = "SELECT * FROM questionnaire3 WHERE client_id='$client_id' AND personnel_id='$personnel_id' ORDER BY id DESC";
    $resultquestionnaire3= mysqli_query($con, $queryquestionnaire3);

    $notification = "";
    while ($contentquestionnaire3 = mysqli_fetch_array($resultquestionnaire3)) {

        $employer_name = $contentquestionnaire3['employer_name'];
        $business_type = $contentquestionnaire3['business_type'];
        $employer_address = $contentquestionnaire3['employer_address'];
        $business_location = $contentquestionnaire3['business_location'];
        $start_designation = $contentquestionnaire3['start_designation'];
        $end_designation = $contentquestionnaire3['end_designation'];
        $start_date = $contentquestionnaire3['start_date'];
        $end_date = $contentquestionnaire3['end_date'];
        $office_phone_number = $contentquestionnaire3['office_phone_number'];
        $supervisor_name = $contentquestionnaire3['supervisor_name'];
        $supervisor_email = $contentquestionnaire3['supervisor_email'];
        $agency_status = $contentquestionnaire3['agency_status'];
        $agency_name = $contentquestionnaire3['agency_name'];
        $agency_address = $contentquestionnaire3['agency_address'];


        $notification .= '<li class=""><p>'.$employer_name.', '.$employer_address.'. '.$end_designation.' ('.$start_date.' - '.$end_date.') </p></li>';
    }

    echo $notification;
}

?>
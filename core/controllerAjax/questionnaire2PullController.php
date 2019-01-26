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

	$queryquestionnaire2 = "SELECT * FROM questionnaire2 WHERE client_id='$client_id' AND personnel_id='$personnel_id' ORDER BY id DESC";
    $resultquestionnaire2= mysqli_query($con, $queryquestionnaire2);

    $notification = "";
    while ($contentquestionnaire2 = mysqli_fetch_array($resultquestionnaire2)) {


        $professsional_body = $contentquestionnaire2['professsional_body'];
        $membership_no = $contentquestionnaire2['membership_no'];
        $membership_status = $contentquestionnaire2['membership_status'];
        $membership_date = $contentquestionnaire2['membership_date'];


        $notification .= '<li class=""><p>'.$professsional_body.'. '.$membership_no.' ('.$membership_date.') - '.$membership_status.' </p></li>';
    }

    echo $notification;
}

?>
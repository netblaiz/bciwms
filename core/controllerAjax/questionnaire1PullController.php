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

	$queryquestionnaire1 = "SELECT * FROM questionnaire1 WHERE client_id='$client_id' AND personnel_id='$personnel_id' ORDER BY id DESC ";
    $resultquestionnaire1= mysqli_query($con, $queryquestionnaire1);

    $notification = "";
    while ($contentquestionnaire1 = mysqli_fetch_array($resultquestionnaire1)) {
    	$id_set = $contentquestionnaire1['id'];
        $school_name = $contentquestionnaire1['school_name'];
        $matric_no = $contentquestionnaire1['matric_no'];
        $entrance_year = $contentquestionnaire1['entrance_year'];
        $exit_year = $contentquestionnaire1['exit_year'];
        $certificate_obtained = $contentquestionnaire1['certificate_obtained'];

        $notification .= '<li class=""><p>'.$school_name.'. '.$certificate_obtained.' ('.$entrance_year.'-'.$exit_year.') </p></li>';
    }

    echo $notification;
}

?>
<?php
session_start();

date_default_timezone_set("Africa/Lagos");

require_once('../config.php');
include_once('../functions/global.php');
include_once('../functions/analytics.php');


if ($_POST) {

    $client_id = $_POST['client_id'];
    $personnel_id = $_POST['personnel_id'];
    $form_id = $_POST['form_id'];
    $link_validity = $_POST['link_validity'];

    $created_by = $_SESSION["wms_user_id"];
    $created_at = date('Y-m-d H:i:s');

    $token = generateLinkToken($created_at, $client_id, $personnel_id, $form_id, $link_validity, $created_by);
    $token_status = "1";

    $formlink = $_SERVER['HTTP_HOST'].'/bciwms/'.fetchFormUrl($con, $form_id).'/'.$token; //localhost
    // $formlink = $_SERVER['HTTP_HOST'].'/'.fetchFormUrl($con, $form_id).'/'.$token;


    // Activity Log
    activitylog($con, $created_by, date('Y-m-d H:i:s'), "generated a ".fetchFormName($con, $form_id)." for ".fetchPersonnelName($con, $personnel_id)." in ".fetchUserName($con, $client_id)." - ", $created_by, "1");

    $queryFormLink=mysqli_prepare($con, "INSERT INTO form_tokens (client_id, personnel_id, form_id, link_validity, token, created_by, created_at, token_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?);");
    mysqli_stmt_bind_param($queryFormLink, 'ssssssss', $client_id, $personnel_id, $form_id, $link_validity, $token, $created_by, $created_at, $token_status);
    $resultFormLink =mysqli_stmt_execute($queryFormLink);

    $data = array(
	    'formlink'  => $formlink
    );

    echo json_encode($data);

}

?>
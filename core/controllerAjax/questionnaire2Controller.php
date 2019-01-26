<?php
session_start();
date_default_timezone_set("Africa/Lagos");

require_once('../config.php');
include_once('../functions/global.php');
include_once('../functions/analytics.php');

if($_POST)
{   

    $client_id = trim(mysqli_escape_string($con, $_POST['client_id']));
    $personnel_id = trim(mysqli_escape_string($con, $_POST['personnel_id']));
    $token = trim(mysqli_escape_string($con, $_POST['token']));

    $professsional_body = trim(mysqli_escape_string($con, $_POST['professsional_body']));
    $membership_no = trim(mysqli_escape_string($con, $_POST['membership_no']));
    $membership_status = trim(mysqli_escape_string($con, $_POST['membership_status']));
    $membership_date = trim(mysqli_escape_string($con, $_POST['membership_date']));

    $created_by = trim(mysqli_escape_string($con, $_POST['personnel_id']));
    $created_at = date('Y-m-d H:i:s');
    $questionnaire1_status = "1";
    
    $querypersonnel = mysqli_prepare($con, "SELECT id FROM questionnaire2 WHERE professsional_body=? AND membership_no=?");
    mysqli_stmt_bind_param($querypersonnel, 'ss', $professsional_body, $membership_no);
    mysqli_stmt_execute($querypersonnel);
    mysqli_stmt_store_result($querypersonnel);

    if (mysqli_stmt_num_rows($querypersonnel)<1) {

        // Insert into Questionnaire Table
        $queryInsertPersonnel=mysqli_prepare($con, "INSERT INTO questionnaire2 (client_id, personnel_id, token, professsional_body, membership_no, membership_status, membership_date, created_by, created_at, questionnaire2_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
        mysqli_stmt_bind_param($queryInsertPersonnel, 'ssssssssss', $client_id, $personnel_id, $token, $professsional_body, $membership_no, $membership_status, $membership_date, $created_by, $created_at, $questionnaire1_status);
        $resultInsertPersonnel =mysqli_stmt_execute($queryInsertPersonnel);

        // Activity log
        activitylog($con, $created_by, $created_at, $personnel_id." submitted the Third questionnaire (Certificates Form) - ", $client_id, "1");
 
        // Response
        $notification = '
            <div class="m-b-10">
                <div class="alert alert-success background-success m-0">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="icofont icofont-close-line-circled text-white"></i>
                    </button>
                    <strong>Success!</strong> Questionnaire submitted successfully.
                </div>
            </div>';


        mysqli_stmt_close($querypersonnel);
        mysqli_stmt_close($queryInsertPersonnel);

    } else {
        
        $notification = '<div class="m-b-10">
                <div class="alert alert-warning background-warning m-0">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="icofont icofont-close-line-circled text-white"></i>
                    </button>
                    <strong>Error!</strong> Cannot submit questionnaire because the data already exists.
                </div>
            </div>';

    }

        
    // $data = array(
    // 'notification'  => $notification
    // );

    // echo json_encode($data);

    echo $notification;
    
}

                


?>
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

    $school_name = trim(mysqli_escape_string($con, $_POST['school_name']));
    $matric_no = trim(mysqli_escape_string($con, $_POST['matric_no']));
    $entrance_year = trim(mysqli_escape_string($con, $_POST['entrance_year']));
    $exit_year = trim(mysqli_escape_string($con, $_POST['exit_year']));
    $certificate_obtained = trim(mysqli_escape_string($con, $_POST['certificate_obtained']));

    $created_by = trim(mysqli_escape_string($con, $_POST['personnel_id']));
    $created_at = date('Y-m-d H:i:s');
    $questionnaire1_status = "1";
    
    $querypersonnel = mysqli_prepare($con, "SELECT id FROM questionnaire1 WHERE matric_no=? AND entrance_year=?");
    mysqli_stmt_bind_param($querypersonnel, 'ss', $matric_no, $entrance_year);
    mysqli_stmt_execute($querypersonnel);
    mysqli_stmt_store_result($querypersonnel);

    if (mysqli_stmt_num_rows($querypersonnel)<1) {

        // Insert into Questionnaire Table
        $queryInsertPersonnel=mysqli_prepare($con, "INSERT INTO questionnaire1 (client_id, personnel_id, token, school_name, matric_no, entrance_year, exit_year, certificate_obtained, created_by, created_at, questionnaire1_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
        mysqli_stmt_bind_param($queryInsertPersonnel, 'sssssssssss', $client_id, $personnel_id, $token, $school_name, $matric_no, $entrance_year, $exit_year, $certificate_obtained, $created_by, $created_at, $questionnaire1_status);
        $resultInsertPersonnel =mysqli_stmt_execute($queryInsertPersonnel);

        // Activity log
        activitylog($con, $created_by, $created_at, $personnel_id." submitted the Second questionnaire (Educational Form) - ", $client_id, "1");
 
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
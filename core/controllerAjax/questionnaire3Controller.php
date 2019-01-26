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

    $employer_name = trim(mysqli_escape_string($con, $_POST['employer_name']));
    $business_type = trim(mysqli_escape_string($con, $_POST['business_type']));
    $employer_address = trim(mysqli_escape_string($con, $_POST['employer_address']));
    $business_location = trim(mysqli_escape_string($con, $_POST['business_location']));
    $start_designation = trim(mysqli_escape_string($con, $_POST['start_designation']));
    $end_designation = trim(mysqli_escape_string($con, $_POST['end_designation']));
    $start_date = trim(mysqli_escape_string($con, $_POST['start_date']));
    $end_date = trim(mysqli_escape_string($con, $_POST['end_date']));
    $office_phone_number = trim(mysqli_escape_string($con, $_POST['office_phone_number']));
    $supervisor_name = trim(mysqli_escape_string($con, $_POST['supervisor_name']));
    $supervisor_email = trim(mysqli_escape_string($con, $_POST['supervisor_email']));
    $agency_status = trim(mysqli_escape_string($con, $_POST['agency_status']));
    $agency_name = trim(mysqli_escape_string($con, $_POST['agency_name']));
    $agency_address = trim(mysqli_escape_string($con, $_POST['agency_address']));

    $created_by = trim(mysqli_escape_string($con, $_POST['personnel_id']));
    $created_at = date('Y-m-d H:i:s');
    $questionnaire1_status = "1";
    
    $querypersonnel = mysqli_prepare($con, "SELECT id FROM questionnaire3 WHERE employer_name=? AND start_date=?");
    mysqli_stmt_bind_param($querypersonnel, 'ss', $employer_name, $start_date);
    mysqli_stmt_execute($querypersonnel);
    mysqli_stmt_store_result($querypersonnel);

    if (mysqli_stmt_num_rows($querypersonnel)<1) {

        // Insert into Questionnaire Table
        $queryInsertPersonnel=mysqli_prepare($con, "INSERT INTO questionnaire3 (client_id, personnel_id, token, employer_name, business_type, employer_address, business_location, start_designation, end_designation, start_date, end_date, office_phone_number, supervisor_name, supervisor_email, agency_status, agency_name, agency_address, created_by, created_at, questionnaire3_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
        mysqli_stmt_bind_param($queryInsertPersonnel, 'ssssssssssssssssssss', $client_id, $personnel_id, $token, $employer_name, $business_type, $employer_address, $business_location, $start_designation, $end_designation, $start_date, $end_date, $office_phone_number, $supervisor_name, $supervisor_email, $agency_status, $agency_name, $agency_address, $created_by, $created_at, $questionnaire3_status);
        $resultInsertPersonnel =mysqli_stmt_execute($queryInsertPersonnel);

        // Activity log
        activitylog($con, $created_by, $created_at, $personnel_id." submitted the Fourth questionnaire (Employment History) - ", $client_id, "1");
 
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
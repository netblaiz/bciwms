<?php
date_default_timezone_set("Africa/Lagos");

if(isset($_POST['create_personnel']))
{   
    $unique_id = rand(1111111, 9999999);
    $client_id = trim(mysqli_escape_string($con, $_POST['client_id']));
    $full_name = trim(mysqli_escape_string($con, $_POST['full_name']));
    $phone_number = trim(mysqli_escape_string($con, $_POST['phone_number']));
    
    $field_staff_id = "0";
    $created_by = $_SESSION["wms_user_id"];
    $created_at = date('Y-m-d H:i:s');
    $questionnaire_status = "0";
    $personnel_status = "0";
    
    $querypersonnel = mysqli_prepare($con, "SELECT phone_number FROM personnels WHERE phone_number=?");
    mysqli_stmt_bind_param($querypersonnel, 's', $phone_number);
    mysqli_stmt_execute($querypersonnel);
    mysqli_stmt_store_result($querypersonnel);

    if (mysqli_stmt_num_rows($querypersonnel)<1) {

        // Insert into Personnel Table
        $queryInsertPersonnel=mysqli_prepare($con, "INSERT INTO personnels (unique_id, client_id, full_name, phone_number, field_staff_id, created_by, created_at, questionnaire_status, personnel_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);");
        mysqli_stmt_bind_param($queryInsertPersonnel, 'sssssssss', $unique_id, $client_id, $full_name, $phone_number, $field_staff_id, $created_by, $created_at, $questionnaire_status, $personnel_status);
        $resultInsertPersonnel =mysqli_stmt_execute($queryInsertPersonnel);

        // Activity log
        activitylog($con, $created_by, $created_at, "added ".$full_name." to ", $client_id, "1");

        // Response
        echo '
            <div class="m-b-10">
                <div class="alert alert-success background-success m-0">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="icofont icofont-close-line-circled text-white"></i>
                    </button>
                    <strong>Success!</strong> Personnel added successfully.
                </div>
            </div>';

        mysqli_stmt_close($querypersonnel);
        mysqli_stmt_close($queryInsertPersonnel);

    } else {
        
        echo '<div class="m-b-10">
                <div class="alert alert-warning background-warning m-0">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="icofont icofont-close-line-circled text-white"></i>
                    </button>
                    <strong>Error!</strong> Cannot add personnel because personnel already exists.
                </div>
            </div>';

    }   
}

if (isset($_POST['filledforms'])) {

    $personnel_idGet = $_POST['personnel_id'];
    $_SESSION["personnel_id"] = $personnel_idGet;

    echo "<script> window.location = '../filled/index'; </script>" ;
}

if (isset($_POST['assignfieldstaff'])) {

    $personnel_idGet = $_POST['personnel_id'];
    $_SESSION["personnel_id"] = $personnel_idGet;

    echo "<script> window.location = './assignstaff'; </script>" ;
}

if(isset($_POST['deactivatepersonnel']))
{
    $personnel_idGet = $_POST['personnel_id'];

    // Activity Log
    $performed_by = $_SESSION["wms_user_id"];
    activitylog($con, $performed_by, date('Y-m-d H:i:s'), "deactivated ".fetchPersonnelName($con, $personnel_idGet)." - ", $performed_by, "1");

    $queryAction = "UPDATE personnels SET personnel_status='0' WHERE id='$personnel_idGet' ";
    $resultAction = mysqli_query($con, $queryAction);

    if (mysqli_affected_rows($con) == 1) {
        echo '
            <div class="m-b-10">
                <div class="alert alert-success background-success m-0">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="icofont icofont-close-line-circled text-white"></i>
                    </button>
                    <strong>Success!</strong> Personnel deactivated successfully.
                </div>
            </div>';

    } else {
        echo '<div class="m-b-10">
                <div class="alert alert-warning background-warning m-0">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="icofont icofont-close-line-circled text-white"></i>
                    </button>
                    <strong>Error!</strong> Could not deactivate personnel.
                </div>
            </div>';
    }
}


if(isset($_POST['activatepersonnel']))
{
    $personnel_idGet = $_POST['personnel_id'];

    // Activity Log
    $performed_by = $_SESSION["wms_user_id"];
    activitylog($con, $performed_by, date('Y-m-d H:i:s'), "activated ".fetchPersonnelName($con, $personnel_idGet)." - ", $performed_by, "1");

    $queryAction = "UPDATE personnels SET personnel_status='1' WHERE id='$personnel_idGet' ";
    $resultAction = mysqli_query($con, $queryAction);

    if (mysqli_affected_rows($con) == 1) {
        echo '
            <div class="m-b-10">
                <div class="alert alert-success background-success m-0">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="icofont icofont-close-line-circled text-white"></i>
                    </button>
                    <strong>Success!</strong> Personnel activated successfully.
                </div>
            </div>';

    } else {
        echo '<div class="m-b-10">
                <div class="alert alert-warning background-warning m-0">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="icofont icofont-close-line-circled text-white"></i>
                    </button>
                    <strong>Error!</strong> Could not activate personnel.
                </div>
            </div>';
    }
}




?>
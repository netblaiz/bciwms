<?php
date_default_timezone_set("Africa/Lagos");

if(isset($_POST['create_client']))
{   
    $email_address = trim(mysqli_escape_string($con, $_POST['email_address']));
    $passwordRaw = trim(mysqli_escape_string($con, $_POST['password']));
    $full_name = trim(mysqli_escape_string($con, $_POST['client_name']));
    $phone_number = trim(mysqli_escape_string($con, $_POST['phone_number']));
    $designation = "Client";
    $access_level = "1";
    $staff_id = "0";
    $picture = NULL;

    $created_by = $_SESSION["wms_user_id"];
    $created_at = date('Y-m-d H:i:s');
    $updated_at = date('Y-m-d H:i:s');

    $updated_login_time = date('Y-m-d H:i:s');
    $updated_logout_time = date('Y-m-d H:i:s');
    $user_status = "1";
    
    // Activity log
    activitylog($con, $created_by, $created_at, "created a new folder for ".$full_name." - ", $created_by, "1");

    $password = password_hash($passwordRaw, PASSWORD_DEFAULT);

    $queryteam = mysqli_prepare($con, "SELECT email_address FROM users WHERE email_address=?");
    mysqli_stmt_bind_param($queryteam, 's', $email_address);
    mysqli_stmt_execute($queryteam);
    mysqli_stmt_store_result($queryteam);

    if (mysqli_stmt_num_rows($queryteam)<1) {

        // Insert into User Admin Table
        $queryInsertTeam=mysqli_prepare($con, "INSERT INTO users (email_address, password, full_name, phone_number, designation, access_level, staff_id, picture, created_by, created_at, updated_at, updated_login_time, updated_logout_time, user_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
        mysqli_stmt_bind_param($queryInsertTeam, 'ssssssssssssss', $email_address, $password, $full_name, $phone_number, $designation, $access_level, $staff_id, $picture, $created_by, $created_at, $updated_at, $updated_login_time, $updated_logout_time, $user_status);
        $resultInsertTeam =mysqli_stmt_execute($queryInsertTeam);

        // Response
        echo '
            <div class="m-b-10">
                <div class="alert alert-success background-success m-0">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="icofont icofont-close-line-circled text-white"></i>
                    </button>
                    <strong>Success!</strong> Client folder created successfully.
                </div>
            </div>';

        mysqli_stmt_close($queryteam);
        mysqli_stmt_close($queryInsertTeam);

    } else {
        
        echo '<div class="m-b-10">
                <div class="alert alert-warning background-warning m-0">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="icofont icofont-close-line-circled text-white"></i>
                    </button>
                    <strong>Error!</strong> Cannot create client folder.
                </div>
            </div>';

    }   
}

if (isset($_POST['openClient'])) {

    $client_idGet = $_POST['client_id'];
    $_SESSION["client_id"] = $client_idGet;

    echo "<script> window.location = './personnels'; </script>" ;
}

if(isset($_POST['deleteClient']))
{
    $client_idGet = $_POST['client_id'];

    // Activity Log
    $performed_by = $_SESSION["wms_user_id"];
    activitylog($con, $performed_by, date('Y-m-d H:i:s'), "deactivated ", $client_idGet, "1");

    $queryAction = "UPDATE users SET user_status='0' WHERE id='$client_idGet' ";
    $resultAction = mysqli_query($con, $queryAction);

    if (mysqli_affected_rows($con) == 1) {
        echo '
            <div class="m-b-10">
                <div class="alert alert-success background-success m-0">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="icofont icofont-close-line-circled text-white"></i>
                    </button>
                    <strong>Success!</strong> Client deactivated successfully.
                </div>
            </div>';

    } else {
        echo '<div class="m-b-10">
                <div class="alert alert-warning background-warning m-0">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="icofont icofont-close-line-circled text-white"></i>
                    </button>
                    <strong>Error!</strong> Could not deactivate client.
                </div>
            </div>';
    }
}

?>
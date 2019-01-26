<?php
date_default_timezone_set("Africa/Lagos");

if(isset($_POST['create_user']))
{   
    $email_address = trim(mysqli_escape_string($con, $_POST['email_address']));
    $passwordRaw = trim(mysqli_escape_string($con, $_POST['password']));
    $full_name = trim(mysqli_escape_string($con, $_POST['full_name']));
    $phone_number = trim(mysqli_escape_string($con, $_POST['phone_number']));
    $designation = trim(mysqli_escape_string($con, $_POST['designation']));
    $access_level = trim(mysqli_escape_string($con, $_POST['access_level']));
    $staff_id = trim(mysqli_escape_string($con, $_POST['staff_id']));
    $picture = NULL;

    $created_by = $_SESSION["wms_user_id"];
    $created_at = date('Y-m-d H:i:s');
    $updated_at = date('Y-m-d H:i:s');

    $updated_login_time = date('Y-m-d H:i:s');
    $updated_logout_time = date('Y-m-d H:i:s');
    $user_status = "1";
    
    // Activity log
    activitylog($con, $created_by, $created_at, "created a new user account for ".$full_name, $created_by, "1");

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
                    <strong>Success!</strong> User account created successfully.
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
                    <strong>Error!</strong> Cannot create user account.
                </div>
            </div>';

    }   
}


if(isset($_POST['resetpassword']))
{
    $user_idGet = $_POST['user_id'];
    $newpassword = "bciwms01";

    $password = password_hash($newpassword, PASSWORD_DEFAULT);

    // Activity Log
    $performed_by = $_SESSION["wms_user_id"];
    activitylog($con, $performed_by, date('Y-m-d H:i:s'), "reset the password to bciwms01 for ", $user_idGet, "1");

    $queryAction = "UPDATE users SET password='$password' WHERE id='$user_idGet' ";
    $resultAction = mysqli_query($con, $queryAction);

    if (mysqli_affected_rows($con) == 1) {
        echo '
            <div class="m-b-10">
                <div class="alert alert-success background-success m-0">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="icofont icofont-close-line-circled text-white"></i>
                    </button>
                    <strong>Success!</strong> User Password Reset to bciwms01.
                </div>
            </div>';
    } else {
        echo '<div class="m-b-10">
                <div class="alert alert-warning background-warning m-0">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="icofont icofont-close-line-circled text-white"></i>
                    </button>
                    <strong>Error!</strong> Could not reset password.
                </div>
            </div>';
    }
}


if(isset($_POST['deactivateuser']))
{
    $user_idGet = $_POST['user_id'];

    // Activity Log
    $performed_by = $_SESSION["wms_user_id"];
    activitylog($con, $performed_by, date('Y-m-d H:i:s'), "deactivated ", $user_idGet, "1");

    $queryAction = "UPDATE users SET user_status='0' WHERE id='$user_idGet' ";
    $resultAction = mysqli_query($con, $queryAction);

    if (mysqli_affected_rows($con) == 1) {
        echo '
            <div class="m-b-10">
                <div class="alert alert-success background-success m-0">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="icofont icofont-close-line-circled text-white"></i>
                    </button>
                    <strong>Success!</strong> User deactivated successfully.
                </div>
            </div>';

    } else {
        echo '<div class="m-b-10">
                <div class="alert alert-warning background-warning m-0">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="icofont icofont-close-line-circled text-white"></i>
                    </button>
                    <strong>Error!</strong> Could not deactivate user.
                </div>
            </div>';
    }
}


if(isset($_POST['activateuser']))
{
    $user_idGet = $_POST['user_id'];

    // Activity Log
    $performed_by = $_SESSION["wms_user_id"];
    activitylog($con, $performed_by, date('Y-m-d H:i:s'), "activated ", $user_idGet, "1");

    $queryAction = "UPDATE users SET user_status='1' WHERE id='$user_idGet' ";
    $resultAction = mysqli_query($con, $queryAction);

    if (mysqli_affected_rows($con) == 1) {
        echo '
            <div class="m-b-10">
                <div class="alert alert-success background-success m-0">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="icofont icofont-close-line-circled text-white"></i>
                    </button>
                    <strong>Success!</strong> User activated successfully.
                </div>
            </div>';

    } else {
        echo '<div class="m-b-10">
                <div class="alert alert-warning background-warning m-0">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="icofont icofont-close-line-circled text-white"></i>
                    </button>
                    <strong>Error!</strong> Could not activate user.
                </div>
            </div>';
    }
}





?>
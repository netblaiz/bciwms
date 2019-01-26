<?php
date_default_timezone_set("Africa/Lagos");

if(isset($_POST['change_password']))
{
    $user_id = $_SESSION["wms_user_id"];
    $full_name = trim(mysqli_escape_string($con, $_POST['full_name']));
    $old_password = trim(mysqli_escape_string($con, $_POST['old_password']));
    $new_password = trim(mysqli_escape_string($con, $_POST['new_password']));

    $queryUser = "SELECT password FROM users WHERE id='$user_id' ";
    $resultUser = mysqli_query($con, $queryUser);

    // Check User
    if (mysqli_num_rows($resultUser) == 1) {

        $contentUser= mysqli_fetch_array($resultUser);
        $hashedpassword = $contentUser['password'];

        // Verrify Old Password
        if (password_verify($old_password, $hashedpassword)) {

            $new_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Activity Log
            activitylog($con, $user_id, date('Y-m-d H:i:s'), "changed his password - ", $user_id, "1");

            $queryAction = "UPDATE users SET password='$new_password' WHERE id='$user_id' ";
            $resultAction = mysqli_query($con, $queryAction);

            if (mysqli_affected_rows($con) == 1) {
                echo '
                    <div class="m-b-10">
                        <div class="alert alert-success background-success m-0">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="icofont icofont-close-line-circled text-white"></i>
                            </button>
                            <strong>Success!</strong> Password changed successfully.
                        </div>
                    </div>';
            } else {
                echo '<div class="m-b-10">
                        <div class="alert alert-warning background-warning m-0">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="icofont icofont-close-line-circled text-white"></i>
                            </button>
                            <strong>Error!</strong> Could not change password.
                        </div>
                    </div>';
            }

        } else {

            echo '<div class="alert alert-danger background-danger m-0">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="icofont icofont-close-line-circled text-white"></i>
                    </button>
                    <strong>Error!</strong> Check your old password.
                </div>';

         }

    } else {

        echo '<div class="alert alert-danger background-danger m-0">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="icofont icofont-close-line-circled text-white"></i>
                </button>
                <strong>Error!</strong> Access Denied.
            </div>';

    } 

}


?>
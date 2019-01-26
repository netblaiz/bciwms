<?php

if(isset($_POST['login']))
{
    $email_address = trim(mysqli_escape_string($con, $_POST['email_address']));
    $password = trim(mysqli_escape_string($con, $_POST['password']));

    $queryUser = "SELECT * FROM users WHERE email_address='$email_address' AND user_status='1' ";
    $resultUser = mysqli_query($con, $queryUser);

    if (mysqli_num_rows($resultUser) == 1) {

        $contentUser= mysqli_fetch_array($resultUser);
        $hashedpassword = $contentUser['password'];

        if (password_verify($password, $hashedpassword)) {

            $_SESSION["wms_user_id"] = $contentUser['id'];
            $_SESSION["access_level"] = $contentUser['access_level'];

            $wms_user_idStored = $_SESSION["wms_user_id"];
            $access_levelStored = $_SESSION["access_level"];

            // Activity Log
            $performed_by = $_SESSION["wms_user_id"];
            activitylog($con, $performed_by, date('Y-m-d H:i:s'), "logged in - ", $performed_by, "1");

            $queryUpdateLogin ="UPDATE users SET updated_login_time=NOW() WHERE id='$wms_user_idStored'";
            mysqli_query($con, $queryUpdateLogin);

            if ($access_levelStored=="1") {
                echo "<script> window.location = './selfservice'; </script>" ;
            } elseif ($access_levelStored=="2") {
                echo "<script> window.location = './field'; </script>" ;
            } else {
                echo "<script> window.location = './admin'; </script>" ;
            }

            mysqli_close($con);
            
         } else {

            echo '<div class="alert alert-danger background-danger m-0">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="icofont icofont-close-line-circled text-white"></i>
                    </button>
                    <strong>Error!</strong> Check your username or password.
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

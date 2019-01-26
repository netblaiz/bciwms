<?php
date_default_timezone_set("Africa/Lagos");

if(isset($_POST['deactivatetoken']))
{
    $token_idGet = $_POST['token_id'];

    // Activity Log
    $performed_by = $_SESSION["wms_user_id"];
    activitylog($con, $performed_by, date('Y-m-d H:i:s'), " deactivated token ".fetchToken($con, $token_idGet)." - ", $performed_by, "1");

    $queryAction = "UPDATE form_tokens SET token_status='0' WHERE id='$token_idGet' ";
    $resultAction = mysqli_query($con, $queryAction);

    if (mysqli_affected_rows($con) == 1) {
        echo '
            <div class="m-b-10">
                <div class="alert alert-success background-success m-0">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="icofont icofont-close-line-circled text-white"></i>
                    </button>
                    <strong>Success!</strong> Token deactivated successfully.
                </div>
            </div>';

    } else {
        echo '<div class="m-b-10">
                <div class="alert alert-warning background-warning m-0">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="icofont icofont-close-line-circled text-white"></i>
                    </button>
                    <strong>Error!</strong> Could not deactivate token.
                </div>
            </div>';
    }
}


if(isset($_POST['activatetoken']))
{
    $token_idGet = $_POST['token_id'];

    // Activity Log
    $performed_by = $_SESSION["wms_user_id"];
    activitylog($con, $performed_by, date('Y-m-d H:i:s'), " activated token ".fetchToken($con, $token_idGet)." - ", $performed_by, "1");

    $queryAction = "UPDATE form_tokens SET token_status='1' WHERE id='$token_idGet' ";
    $resultAction = mysqli_query($con, $queryAction);

    if (mysqli_affected_rows($con) == 1) {
        echo '
            <div class="m-b-10">
                <div class="alert alert-success background-success m-0">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="icofont icofont-close-line-circled text-white"></i>
                    </button>
                    <strong>Success!</strong> Token activated successfully.
                </div>
            </div>';

    } else {
        echo '<div class="m-b-10">
                <div class="alert alert-warning background-warning m-0">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="icofont icofont-close-line-circled text-white"></i>
                    </button>
                    <strong>Error!</strong> Could not activate token.
                </div>
            </div>';
    }
}





?>
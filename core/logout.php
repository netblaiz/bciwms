<?php
session_start();

date_default_timezone_set("Africa/Lagos");
require_once('config.php');
include_once('functions/analytics.php');

if (isset($_SESSION["wms_user_id"])) {
	
	$wms_user_idStored = $_SESSION["wms_user_id"];

	// Activity Log
    $performed_by = $_SESSION["wms_user_id"];
    activitylog($con, $performed_by, date('Y-m-d H:i:s'), "logged out - ", $performed_by, "1");

	$queryUpdateLogout ="UPDATE users SET updated_logout_time=NOW() WHERE id='$wms_user_idStored' ";
    mysqli_query($con, $queryUpdateLogout);

    unset($_SESSION["wms_user_id"]);
    
	header("Location: ../login");

} else {

	session_unset();
	header("Location: ../login");
}

//	header("Location:".$_SERVER["HTTP_REFERER"]);
?>

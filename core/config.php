<?php

// $mysqli_hostname = "localhost";
// $mysqli_user = "hinetgro";
// $mysqli_password = "b78tcQ3wY1";
// $mysqli_database = "hinetgro_website";

$mysqli_hostname = "localhost";
$mysqli_user = "root";
$mysqli_password = "";
$mysqli_database = "bciwms";

$con = mysqli_connect($mysqli_hostname, $mysqli_user, $mysqli_password, $mysqli_database);

if (mysqli_connect_errno())
{
	echo "Failed to connect to database:".
	mysqli_connect_error();
}
//  else {
// 	echo "Connected";
// }

?>
<?php
require_once('track_functions.php');//the file with connection code and functions

	//get the required data

    $webaddress = 'http://'.$_SERVER['HTTP_HOST'];

	$visitor_ip = $_SERVER['REMOTE_ADDR'];
	$visitor_browser = getBrowserType();
	$visited_at = date('Y-m-d H:i:s');
	
    if (isset($_SERVER['HTTP_REFERER'])) {
    	$visitor_refferer = $_SERVER['HTTP_REFERER'];
    } else {
    	$visitor_refferer = 'Organic Link';
    }

	$visitor_page = $_SERVER['REQUEST_URI'];
	$access_token = $_SERVER['REQUEST_URI']."/";

	//write the required data to database
	$queryInsertTrack = "INSERT INTO tracks (visitor_ip, visitor_browser, visitor_refferer, visitor_page, visited_at, access_token) VALUES ('$visitor_ip', '$visitor_browser', '$visitor_refferer', '$visitor_page', '$visited_at', '$access_token');";

	$resultInsertTrack = mysqli_query($con, $queryInsertTrack) or trigger_error(mysqli_error());

?>
<?php

// Setting header to JSON
header('Content-Type: application/json');

session_start();
require_once('../../../config/database.php');
include_once('../../../functions/dates.php');

    // MONTH - NEW VISITORS - OLD VISITORS
    // SELECT newVisitorTable.monthvisited, newVisitorTable.numNewVisitor, oldVisitorTable.numOldVisitor FROM (SELECT COUNT(visitor_ip) as numNewVisitor, MONTHNAME(visited_at) AS monthvisited FROM zo_tracks WHERE visitor_ip NOT IN (SELECT visitor_ip FROM zo_tracks WHERE MONTH(visited_at)!=MONTH(CURRENT_DATE())) AND MONTH(visited_at)=MONTH(CURRENT_DATE())) AS newVisitorTable JOIN (SELECT COUNT(visitor_ip) as numOldVisitor FROM zo_tracks WHERE visitor_ip IN (SELECT visitor_ip FROM zo_tracks WHERE MONTH(visited_at)!=MONTH(CURRENT_DATE())) AND MONTH(visited_at)=MONTH(CURRENT_DATE())) AS oldVisitorTable; 

    $queryTotalVisitors = "SELECT MONTHNAME(visited_at) as monthVariable, COUNT(visitor_ip) AS totalVisitors FROM zo_tracks GROUP BY MONTH(visited_at) ORDER BY MONTH(visited_at) DESC LIMIT 12;";
    // ORDER BY result DESC
    $resultTotalVisitors = mysqli_query($con, $queryTotalVisitors);

    $dataTotalVisitors = array();
    foreach ($resultTotalVisitors as $row) {
        $dataTotalVisitors[] = $row;
        // $dataTotalVisitors[] = $row["username"].$row["result"];
    }

    $resultTotalVisitors->close();

    print json_encode($dataTotalVisitors);
    
?>
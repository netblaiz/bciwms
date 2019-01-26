<?php

// LOG ACTIVITY
function activitylog($con, $performed_by, $performed_at, $activity, $affected_id, $activity_status){

    // Insert into Activities
    $queryInsertActivity=mysqli_prepare($con, "INSERT INTO activities (performed_by, performed_at, activity, affected_id, activity_status) VALUES (?, ?, ?, ?, ?);");
    mysqli_stmt_bind_param($queryInsertActivity, 'sssss', $performed_by, $performed_at, $activity, $affected_id, $activity_status);
    $resultInsertActivity =mysqli_stmt_execute($queryInsertActivity);

    mysqli_stmt_close($queryInsertActivity);
}

// COUNT ROW NUMBER
function countTableRow ($con, $table){         //Display Row Number of entire table

    $querytablerow = "SELECT * FROM $table";     

    if ($resulttablerow = mysqli_query($con, $querytablerow))
    {   
        $foundtablerow = mysqli_num_rows($resulttablerow);
        return ($foundtablerow);
    }
}  

function countRowChangedIn24hours($con, $value, $table, $time) {

    // require('zeta/core/config.php');

    $querytable = "SELECT $value FROM $table WHERE $time > DATE_SUB(NOW(), INTERVAL 1 DAY)";
    
    if ($result = mysqli_query($con, $querytable))
    {
        $found = mysqli_num_rows($result);
        return ($found);
        //mysqli_free_result($result);
    }
}

function countRowOneConstraint($con, $table, $columnone, $value){         //Display Row Number

    $querytable = "SELECT * FROM $table WHERE $columnone = '$value' ";    

    if ($result = mysqli_query($con, $querytable))
    {   
        $found = mysqli_num_rows($result);
        return ($found);
    }
}

function countRowOneNotConstraint ($con, $table, $columnone, $value1){ 

    $querytable = "SELECT * FROM $table WHERE $columnone != '$value1' ";     

    if ($result = mysqli_query($con, $querytable))
    {   
        $found = mysqli_num_rows($result);
        return ($found);
    }
} 

function countRowOneConstraintOneNotConstraint ($con, $table, $columnone, $value1, $columntwo, $value2){ 

    $queryallmessages = "SELECT * FROM $table WHERE $columnone = '$value1' AND $columntwo != '$value2' ";     

    if ($resultallmessages = mysqli_query($con, $queryallmessages))
    {   
        $foundallmessages = mysqli_num_rows($resultallmessages);
        return ($foundallmessages);
    }
} 

function countRowTwoConstraint ($con, $table, $columnone, $value1, $columntwo, $value2){  

    $querymessages = "SELECT * FROM $table WHERE $columnone = '$value1' AND $columntwo = '$value2' "; 

    if ($resultmessages = mysqli_query($con, $querymessages))
    {   
        $foundmessages = mysqli_num_rows($resultmessages);
        return ($foundmessages);
    }
}  

function countRowThreeConstraint ($con, $table, $columnone, $value1, $columntwo, $value2, $columnthree, $value3){        

    $querymessages = "SELECT * FROM $table WHERE $columnone = '$value1' AND $columntwo = '$value2' AND $columnthree = '$value3' "; 

    if ($resultmessages = mysqli_query($con, $querymessages))
    {   
        $foundmessages = mysqli_num_rows($resultmessages);
        return ($foundmessages);
    }
} 

// VISITOR COUNT
function countNewVisitorTracks($con){

    $queryNewVisitors = "SELECT COUNT(visitor_ip) AS numNewVisitor FROM tracks WHERE visitor_ip NOT IN (SELECT visitor_ip FROM tracks WHERE MONTH(visited_at)!=MONTH(CURRENT_DATE())) AND MONTH(visited_at)=MONTH(CURRENT_DATE())";
    $resultNewVisitors = mysqli_query($con, $queryNewVisitors);

    $contentNewVisitors = mysqli_fetch_array($resultNewVisitors);
    $newVisitors = $contentNewVisitors['numNewVisitor'];
    
    return $newVisitors;

}

function countOldVisitorTracks($con){

    $queryOldVisitors = "SELECT COUNT(visitor_ip) AS numOldVisitor FROM tracks WHERE visitor_ip IN (SELECT visitor_ip FROM tracks WHERE MONTH(visited_at)!=MONTH(CURRENT_DATE())) AND MONTH(visited_at)=MONTH(CURRENT_DATE());";
    $resultOldVisitors = mysqli_query($con, $queryOldVisitors);

    $contentOldVisitors = mysqli_fetch_array($resultOldVisitors);
    $OldVisitors = $contentOldVisitors['numOldVisitor'];
    
    return $OldVisitors;

}

function countTodayVisitorTracks($con){

    $queryTodayVisitors = "SELECT COUNT(visitor_ip) AS numTodayVisitor FROM tracks WHERE DATE(visited_at)=DATE(CURRENT_DATE());";
    $resultTodayVisitors = mysqli_query($con, $queryTodayVisitors);

    $contentTodayVisitors = mysqli_fetch_array($resultTodayVisitors);
    $TodayVisitors = $contentTodayVisitors['numTodayVisitor'];
    
    return $TodayVisitors;

}


?>
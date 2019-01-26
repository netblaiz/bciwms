<?php

/////////////////////////////////////////////////////////////////////////////////////////////////////////// USERS
function r_users($con){

    $queryUser = "SELECT * FROM users ORDER BY UNIX_TIMESTAMP(created_at) DESC";
    $resultUser = mysqli_query($con, $queryUser);
    $dataUsers = array();
    foreach ($resultUser as $row) {
        $dataUsers[] = $row;
    }
    $resultUser->close();
    $Users = json_encode($dataUsers);
    return $Users;
}

function r_clients($con){

    $queryClients = "SELECT * FROM users WHERE access_level='1' AND user_status='1' ORDER BY id DESC";
    $resultClient = mysqli_query($con, $queryClients);
    $dataClients = array();
    foreach ($resultClient as $row) {
        $dataClients[] = $row;
    }
    $resultClient->close();
    $Clients = json_encode($dataClients);
    return $Clients;
}

function r_fieldstaff($con){

    $queryFieldStaff = "SELECT * FROM users WHERE access_level='2' AND user_status='1' ORDER BY id DESC";
    $resultFieldStaff = mysqli_query($con, $queryFieldStaff);
    $dataFieldStaff = array();
    foreach ($resultFieldStaff as $row) {
        $dataFieldStaff[] = $row;
    }
    $resultFieldStaff->close();
    $FieldStaff = json_encode($dataFieldStaff);
    return $FieldStaff;
}

function r_client_personnels($con, $client_id){

    $queryPersonnels = "SELECT * FROM personnels WHERE client_id='$client_id' ORDER BY UNIX_TIMESTAMP(created_at) DESC";
    $resultPersonnel = mysqli_query($con, $queryPersonnels);
    $dataPersonnels = array();
    foreach ($resultPersonnel as $row) {
        $dataPersonnels[] = $row;
    }
    $resultPersonnel->close();
    $Personnels = json_encode($dataPersonnels);
    return $Personnels;
}

function r_field_personnels($con, $user_id){

    $queryPersonnels = "SELECT * FROM personnels WHERE field_staff_id='$user_id' AND personnel_status='1' ORDER BY UNIX_TIMESTAMP(created_at) DESC";
    $resultPersonnel = mysqli_query($con, $queryPersonnels);
    $dataPersonnels = array();
    foreach ($resultPersonnel as $row) {
        $dataPersonnels[] = $row;
    }
    $resultPersonnel->close();
    $Personnels = json_encode($dataPersonnels);
    return $Personnels;
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////// ACTIVITY LOG
function r_activityloguser($con, $user_id){

    $queryActivity = "SELECT * FROM activities WHERE performed_by='$user_id' AND activity_status='1' ORDER BY UNIX_TIMESTAMP(performed_at) DESC LIMIT 100 ";
    $resultActivity = mysqli_query($con, $queryActivity);
    $dataActivity = array();
    foreach ($resultActivity as $row) {
        $dataActivity[] = $row;
    }
    $resultActivity->close();
    $activity = json_encode($dataActivity);
    return $activity;
}

function r_activitylog($con){

    $queryActivity = "SELECT * FROM activities WHERE activity_status='1' ORDER BY UNIX_TIMESTAMP(performed_at) DESC LIMIT 100 ";
    $resultActivity = mysqli_query($con, $queryActivity);
    $dataActivity = array();
    foreach ($resultActivity as $row) {
        $dataActivity[] = $row;
    }
    $resultActivity->close();
    $activity = json_encode($dataActivity);
    return $activity;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////// TOKEN
function r_tokens($con){

    $queryTokens = "SELECT * FROM form_tokens ORDER BY UNIX_TIMESTAMP(created_at) DESC";
    $resultTokens = mysqli_query($con, $queryTokens);
    $dataTokens = array();
    foreach ($resultTokens as $row) {
        $dataTokens[] = $row;
    }
    $resultTokens->close();
    $tokens = json_encode($dataTokens);
    return $tokens;
}

?>
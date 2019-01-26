
<?php

date_default_timezone_set("Africa/Lagos");

// =======================================================================================================================================================================================================================================================================================
// SYSTEM FUNCTIONS 

function fetchVariable($con, $value, $table, $columnname, $columnValue){          //Determine CompareCanditate Name from database

    $queryVariable = "SELECT $value FROM $table WHERE $columnname='$columnValue' ";
    $resultVariable = mysqli_query($con, $queryVariable);

    $contentVariable = mysqli_fetch_array($resultVariable);
    $value = $contentVariable[$value];

    return $value;

}

function onlineStatus ($last_login_time, $last_logout_time){          //Determine user category from database
    if (strtotime($last_logout_time) < strtotime($last_login_time)) {
        $onlineStatus = '<span class="fa fa-circle text-primary"> </span>';
        return $onlineStatus;
    } else {
        $onlineStatus = '<span class="fa fa-circle-o"> </span>';
        return $onlineStatus;
    } 
}

function nullavatar($value_image){
    if ($value_image==NULL || $value_image=="") {
        $value_image = "avatar1.jpg";
        return  $value_image;
    } else {
        return  $value_image;
    }
}

function websiteURL() { 
    $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
    $protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s; 
    $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]); 
    return $protocol."://".$_SERVER['SERVER_NAME']; 
    // return $_SERVER['REQUEST_URI']; 
}

function selfURL() { 
    $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
    $protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s; 
    $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]); 
    return $protocol."://".$_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI']; 
    // return $_SERVER['REQUEST_URI']; 
}

function strleft($s1, $s2) { 
    return substr($s1, 0, strpos($s1, $s2)); 
}

function generateLinkToken($created_at, $client_id, $personnel_id, $form_id, $link_validity, $created_by){

    $link_validity_sec = 3600 * $link_validity; //Convert hours to seconds
    $created_timestamp = strtotime($created_at);

    $rawtoken = $created_timestamp."-".$client_id."-".$personnel_id."-".$form_id."-".$link_validity_sec."-".$created_by;
    $formtoken = md5($rawtoken);

    return $formtoken;
}

function validateToken($con, $token, $form_id){

    $current_timestamp = strtotime(date('Y-m-d H:i:s'));

    $queryToken = "SELECT * FROM form_tokens WHERE token='$token' AND token_status='1' ";
    $resultToken = mysqli_query($con, $queryToken);

    if (mysqli_num_rows($resultToken) == 1) {

        $contentToken= mysqli_fetch_array($resultToken);
        $form_id_set = $contentToken['form_id'];
        $link_validity_set = $contentToken['link_validity'];
        $created_at_set = $contentToken['created_at'];

        if ($form_id_set==$form_id) {
            
            $created_timestamp = strtotime($created_at_set);
            $link_validity_sec = 3600 * $link_validity_set;

            $link_exsistence = $current_timestamp - $created_timestamp;

            if ($link_exsistence>=$link_validity_sec) {
                $tokenStatus = "3";     //Expired Link                
            } elseif ($link_exsistence<$link_validity_sec) {
                $tokenStatus = "1";     //Good Link
            } else {
                $tokenStatus = "3";     //Expired Link
            }

        } else {
            $tokenStatus = "2";     //Wrong Form
        }

    } else {
        $tokenStatus = "4";     //Token Does Not Exist
    }

    return $tokenStatus;

}

// generateFilledToken($con, date('Y-m-d H:i:s'), $client_idStored, $value['id'], "1", "1", $wms_user_idStored);

/* function generateFilledToken($con, $created_at, $client_id, $personnel_id, $form_id, $link_validity, $created_by){

    $token = generateLinkToken($created_at, $client_id, $personnel_id, $form_id, $link_validity, $created_by);

    // Activity Log
    activitylog($con, $created_by, date('Y-m-d H:i:s'), "generated a filled token for ".fetchFormName($con, $form_id)." for ".fetchPersonnelName($con, $personnel_id)." in ".fetchUserName($con, $client_id)." - ", $created_by, "1");

    $queryFormLink=mysqli_prepare($con, "INSERT INTO filled_tokens (client_id, personnel_id, form_id, link_validity, token, created_by, created_at, token_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?);");
    mysqli_stmt_bind_param($queryFormLink, 'ssssssss', $client_id, $personnel_id, $form_id, $link_validity, $token, $created_by, $created_at, $token_status);
    $resultFormLink =mysqli_stmt_execute($queryFormLink);

    return $token;

}

function validateFilledToken($con, $token, $form_id){

    $current_timestamp = strtotime(date('Y-m-d H:i:s'));

    $queryToken = "SELECT * FROM filled_tokens WHERE token='$token' AND token_status='1' ";
    $resultToken = mysqli_query($con, $queryToken);

    if (mysqli_num_rows($resultToken) == 1) {

        $contentToken= mysqli_fetch_array($resultToken);
        $form_id_set = $contentToken['form_id'];
        $link_validity_set = $contentToken['link_validity'];
        $created_at_set = $contentToken['created_at'];

        if ($form_id_set==$form_id) {
            
            $created_timestamp = strtotime($created_at_set);
            $link_validity_sec = 3600 * $link_validity_set;

            $link_exsistence = $current_timestamp - $created_timestamp;

            if ($link_exsistence>=$link_validity_sec) {
                $tokenStatus = "3";     //Expired Link                
            } elseif ($link_exsistence<$link_validity_sec) {
                $tokenStatus = "1";     //Good Link
            } else {
                $tokenStatus = "3";     //Expired Link
            }

        } else {
            $tokenStatus = "2";     //Wrong Form
        }

    } else {
        $tokenStatus = "4";     //Token Does Not Exist
    }

    return $tokenStatus;

} */


// =======================================================================================================================================================================================================================================================================================
// USER FUNCTIONS 


function userAccess($access_level){          //Determine user status from database
    if ($access_level=="1") {
        $access_level = "Client";
        return $access_level;
    } elseif ($access_level=="2") {
        $access_level ="Field Staff";
        return $access_level;
    } elseif ($access_level=="3") {
        $access_level ="Operations";
        return $access_level;
    } elseif ($access_level=="4") {
        $access_level ="BDM";
        return $access_level;
    } elseif ($access_level=="5") {
        $access_level ="IT";
        return $access_level;
    } else {
        $access_level ="Anonymous";
        return $access_level;
    }
}

function userStatus($user_status){          //Determine user status from database
    if ($user_status=="1") {
        $user_status = "Active";
        return $user_status;
    } else {
        $user_status ="Deactivated";
        return $user_status;
    } 
}

function fetchUserName($con, $user_id){          //Determine User Name from database

    $queryUser = "SELECT * FROM users WHERE id='$user_id' ";
    $resultUser = mysqli_query($con, $queryUser);

    $contentUser = mysqli_fetch_array($resultUser);
    $full_name = $contentUser['full_name'];

    if ($full_name!=NULL && $full_name!="") {
       return $full_name;
    } else {
        return "Anonymous";
    }
}

function fetchPersonnelName($con, $personnel_id){          //Determine User Name from database

    $queryPersonnel = "SELECT * FROM personnels WHERE id='$personnel_id' ";
    $resultPersonnel = mysqli_query($con, $queryPersonnel);

    $contentPersonnel = mysqli_fetch_array($resultPersonnel);
    $full_name = $contentPersonnel['full_name'];

    if ($full_name!=NULL && $full_name!="") {
       return $full_name;
    } else {
        return "Unknown Personnel";
    }
}

// function fetchAssignedStaff($con, $personnel_id){          //Determine User Name from database

//     $queryAssignedStaff = "SELECT staff_id FROM assignstaff WHERE personnel_id='$personnel_id' ";
//     $resultAssignedStaff = mysqli_query($con, $queryAssignedStaff);

//     if (mysqli_num_rows($resultAssignedStaff)=="1") {

//         $contentAssignedStaff = mysqli_fetch_array($resultAssignedStaff);
//         $staff_id = $contentAssignedStaff['staff_id'];

//         $staff_name = fetchUserName($con, $staff_id);
//         return $staff_name;

//     } else {

//         $staff_name = "Not Assigned";
//         return $staff_name;

//     }


// }

function fetchFormName($con, $form_id){          //Determine User Name from database

    $queryFormType = "SELECT form_name FROM default_forms WHERE id='$form_id' ";
    $resultFormType = mysqli_query($con, $queryFormType);

    $contentFormType = mysqli_fetch_array($resultFormType);
    $form_name = $contentFormType['form_name'];

    if ($form_name!=NULL && $form_name!="") {
       return $form_name;
    } else {
        return "Unknown Form Type";
    }
}

function fetchFormUrl($con, $form_id){          //Determine User Name from database

    $queryFormType = "SELECT form_url FROM default_forms WHERE id='$form_id' ";
    $resultFormType = mysqli_query($con, $queryFormType);

    $contentFormType = mysqli_fetch_array($resultFormType);
    $form_url = $contentFormType['form_url'];

    if ($form_url!=NULL && $form_url!="") {
       return $form_url;
    } else {
        return "index";
    }
}

function fetchToken($con, $token_id){          //Determine User Name from database

    $queryTokens = "SELECT token FROM form_tokens WHERE id='$token_id' ";
    $resultTokens = mysqli_query($con, $queryTokens);

    $contentTokens = mysqli_fetch_array($resultTokens);
    $token = $contentTokens['token'];

    if ($token!=NULL && $token!="") {
       return $token;
    } else {
        return "0000";
    }
}

function clientFolderContentStaus($con, $client_id){
    $personnelCount = countRowOneConstraint($con, "personnels", "client_id", $client_id);

    if ($personnelCount>0) {
        $folderIcon = '<i class="icofont icofont-document-folder icofont-5x"></i>';
        return $folderIcon;
    } else {
        $folderIcon = '<i class="icofont icofont-folder-open icofont-5x"></i>';
        return $folderIcon;
    }
}


?>
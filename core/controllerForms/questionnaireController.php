<?php
date_default_timezone_set("Africa/Lagos");

if(isset($_POST['submit_questionnaire']))
{   

    $client_id = trim(mysqli_escape_string($con, $_POST['client_id']));
    $personnel_id = trim(mysqli_escape_string($con, $_POST['personnel_id']));
    $token = trim(mysqli_escape_string($con, $_POST['token']));

    $surname = trim(mysqli_escape_string($con, $_POST['surname']));
    $firstname = trim(mysqli_escape_string($con, $_POST['firstname']));
    $othernames = trim(mysqli_escape_string($con, $_POST['othernames']));
    $dob = trim(mysqli_escape_string($con, $_POST['dob']));
    $pob = trim(mysqli_escape_string($con, $_POST['pob']));
    $state_origin = trim(mysqli_escape_string($con, $_POST['state_origin']));
    $lga_origin = trim(mysqli_escape_string($con, $_POST['lga_origin']));
    $maidenname = trim(mysqli_escape_string($con, $_POST['maidenname']));
    $gender = trim(mysqli_escape_string($con, $_POST['gender']));
    $marital_status = trim(mysqli_escape_string($con, $_POST['marital_status']));
    $email_address = trim(mysqli_escape_string($con, $_POST['email_address']));
    $phone_number1 = trim(mysqli_escape_string($con, $_POST['phone_number1']));
    $phone_number2 = trim(mysqli_escape_string($con, $_POST['phone_number2']));
    $current_designation = trim(mysqli_escape_string($con, $_POST['current_designation']));
    $residential_address = trim(mysqli_escape_string($con, $_POST['residential_address']));
    $passport = NULL;
    $ice_name = trim(mysqli_escape_string($con, $_POST['ice_name']));
    $ice_phone_number = trim(mysqli_escape_string($con, $_POST['ice_phone_number']));
    $ice_address = trim(mysqli_escape_string($con, $_POST['ice_address']));
    $ice_relationship = trim(mysqli_escape_string($con, $_POST['ice_relationship']));

    $created_by = trim(mysqli_escape_string($con, $_POST['personnel_id']));
    $created_at = date('Y-m-d H:i:s');
    $questionnaire_status = "1";
    
    // START UPLOAD CODE
    $ds = DIRECTORY_SEPARATOR;  //1
 
    $storeFolder = '../../drive/passports';   //2

            
    if (isset($_FILES['uploadfile']['name']) && $_FILES['uploadfile']['size'] > 0) {
        
        $tempFile = $_FILES['uploadfile']['tmp_name'];          //3             
        $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds;  //4
        
        $File_Name = ucfirst(strtolower($_FILES['uploadfile']['name']));
        $File_Ext = substr($File_Name, strrpos($File_Name, '.')); //get file extention
        $RenameSeed = $client_id.'-'.$personnel_id."-".rand(11, 99); 
        //$NewFileName = $File_Name.$RenameSeed.$File_Ext; //new file name
        $NewFileName = $RenameSeed.$File_Ext; //new file name

        if(move_uploaded_file($tempFile, $targetPath.$NewFileName ))
        {

            $querypersonnel = mysqli_prepare($con, "SELECT email_address FROM questionnaire WHERE email_address=?");
            mysqli_stmt_bind_param($querypersonnel, 's', $email_address);
            mysqli_stmt_execute($querypersonnel);
            mysqli_stmt_store_result($querypersonnel);

            if (mysqli_stmt_num_rows($querypersonnel)<1) {

                // Insert into Questionnaire Table
                $queryInsertPersonnel=mysqli_prepare($con, "INSERT INTO questionnaire (client_id, personnel_id, token, surname, firstname, othernames, dob, pob, state_origin, lga_origin, maidenname, gender, marital_status, email_address, phone_number1, phone_number2, current_designation, residential_address, passport, ice_name, ice_phone_number, ice_address, ice_relationship, created_by, created_at, questionnaire_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
                mysqli_stmt_bind_param($queryInsertPersonnel, 'ssssssssssssssssssssssssss', $client_id, $personnel_id, $token, $surname, $firstname, $othernames, $dob, $pob, $state_origin, $lga_origin, $maidenname, $gender, $marital_status, $email_address, $phone_number1, $phone_number2, $current_designation, $residential_address, $passport, $ice_name, $ice_phone_number, $ice_address, $ice_relationship, $created_by, $created_at, $questionnaire_status);
                $resultInsertPersonnel =mysqli_stmt_execute($queryInsertPersonnel);

                // Activity log
                activitylog($con, $created_by, $created_at, $surname." ".$firstname." submitted the first questionnaire (Biodata) - ", $client_id, "1");
         
                // Response
                echo '
                    <div class="m-b-10">
                        <div class="alert alert-success background-success m-0">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="icofont icofont-close-line-circled text-white"></i>
                            </button>
                            <strong>Success!</strong> Questionnaire submitted successfully.
                        </div>
                    </div>';

                mysqli_stmt_close($querypersonnel);
                mysqli_stmt_close($queryInsertPersonnel);

            } else {
                
                echo '<div class="m-b-10">
                        <div class="alert alert-warning background-warning m-0">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="icofont icofont-close-line-circled text-white"></i>
                            </button>
                            <strong>Error!</strong> Cannot submit questionnaire because personnel already exists.
                        </div>
                    </div>';

            }

        } else {

            echo '
            <div class="m-b-10">
                <div class="alert alert-warning background-warning m-0">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="icofont icofont-close-line-circled text-white"></i>
                    </button>
                    <strong>Error!</strong> Could not upload passport.
                </div>
            </div>';
            // die('error uploading File!');
        }

    } else {
        // Files were not uploaded, Only text Question

        echo '
            <div class="m-b-10">
                <div class="alert alert-warning background-warning m-0">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="icofont icofont-close-line-circled text-white"></i>
                    </button>
                    <strong>Error!</strong> Could not submit passport.
                </div>
            </div>';
        // die('error uploading File!');
    }
        
    
}

                


?>
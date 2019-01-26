<?php
date_default_timezone_set("Africa/Lagos");

if(isset($_POST['assignstaff']))
{   
    $client_id = trim(mysqli_escape_string($con, $_POST['client_id']));
    $personnel_id = trim(mysqli_escape_string($con, $_POST['personnel_id']));
    $field_staff_id = trim(mysqli_escape_string($con, $_POST['field_staff_id']));

    $created_by = $_SESSION["wms_user_id"];
    $created_at = date('Y-m-d H:i:s');
    $assign_status = "1";

    // Activity Log
    activitylog($con, $created_by, date('Y-m-d H:i:s'), "assigned ".fetchPersonnelName($con, $personnel_id)." to ".fetchUserName($con, $field_staff_id)." - ", $created_by, "1");

    $queryAssignedStaff = mysqli_prepare($con, "SELECT id FROM personnels WHERE id=?");
    mysqli_stmt_bind_param($queryAssignedStaff, 's', $personnel_id);
    mysqli_stmt_execute($queryAssignedStaff);
    mysqli_stmt_store_result($queryAssignedStaff);

    if (mysqli_stmt_num_rows($queryAssignedStaff)==1) {

		// Update Existing Assign Staff
	    $queryAction = "UPDATE personnels SET field_staff_id='$field_staff_id' WHERE id='$personnel_id' ";
	    $resultAction = mysqli_query($con, $queryAction);

	    if (mysqli_affected_rows($con) == 1) {
	        echo '
	            <div class="m-b-10">
	                <div class="alert alert-success background-success m-0">
	                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	                        <i class="icofont icofont-close-line-circled text-white"></i>
	                    </button>
	                    <strong>Success!</strong> Personnel assigned to field staff successfully.
	                </div>
	            </div>';

	    } else {
	        echo '<div class="m-b-10">
	                <div class="alert alert-warning background-warning m-0">
	                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	                        <i class="icofont icofont-close-line-circled text-white"></i>
	                    </button>
	                    <strong>Error!</strong> Could not assign personnel to field staff.
	                </div>
	            </div>';
	    }

        mysqli_stmt_close($queryAssignedStaff);

    } else {

        echo '<div class="m-b-10">
                <div class="alert alert-warning background-warning m-0">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="icofont icofont-close-line-circled text-white"></i>
                    </button>
                    <strong>Error!</strong> Check that the personnel exists before assigning field staff.
                </div>
            </div>';
    }

	    
}

?>
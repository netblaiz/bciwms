<?php


if (isset($_POST['form_id'])) {

    $personnel_idGet = $_POST['personnel_id'];
    $form_idGet = $_POST['form_id'];

    $_SESSION["personnel_id"] = $personnel_idGet;
    $_SESSION["form_id"] = $form_idGet;

    if ($form_idGet=="2") {
	    echo "<script> window.location = './guarantor'; </script>" ;  	
    } elseif ($form_idGet=="3") {
	    echo "<script> window.location = './reference'; </script>" ;
    } elseif ($form_idGet=="4") {
	    echo "<script> window.location = './company'; </script>" ;
    } else {
	    echo "<script> window.location = './index'; </script>" ;
   
    }

}


?>
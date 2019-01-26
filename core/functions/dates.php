
<?php

date_default_timezone_set("Africa/Lagos");

// DATE FUNCTIONS 

function convertDatePickerTimePickerToTimeStamp($datepicker_value, $timepicker_value) {
    $dayvalue = substr($datepicker_value, 3,2); 
    $monthvalue = substr($datepicker_value, 0,2); 
    $yearvalue = substr($datepicker_value, 6, 4);

    $hourvalue = substr($timepicker_value, 0,2);
    $minutevalue = substr($timepicker_value, 3,2);
    $meridianvalue = substr($timepicker_value, 6,2);

    if ($meridianvalue=="AM" && $hourvalue=="12") {
        $hourvalue = '00';
    } elseif ($meridianvalue=="PM" && $hourvalue=="12") {
        $hourvalue = $hourvalue;
    } elseif ($meridianvalue=="AM" && $hourvalue!="12") {
        $hourvalue = $hourvalue;
    } elseif ($meridianvalue=="PM" && $hourvalue!="12") {
        $hourvalue = $hourvalue + 12;
    }

    // 2018-01-12 03:45:04 
    $timestampvalue = $yearvalue.'-'.$monthvalue.'-'.$dayvalue.' '.$hourvalue.':'.$minutevalue.':00';
    return $timestampvalue;
}

function convert24hrsTo12hrs ($timevalue) {
    $hourvalue = substr($timevalue, 0,2);
    $minutevalue = substr($timevalue, 3,2);

    if ($hourvalue == "12") {
        $newtimevalue = $hourvalue.":".$minutevalue." pm";
        return $newtimevalue;
    } elseif ($hourvalue > "12") {
        $hourvalue = $hourvalue - 12;
        $newtimevalue = $hourvalue.":".$minutevalue." pm";
        return $newtimevalue;
    } else {
        $newtimevalue = $hourvalue.":".$minutevalue." am";
        return $newtimevalue;
    }
}

function rearrangeDatepicker($date_value) {
    $dayvalue = substr($date_value, 3,2); 
    $monthvalue = substr($date_value, 0,2); 
    $yearvalue = substr($date_value, 6, 4);
    return $dayvalue.'-'.$monthvalue.'-'.$yearvalue;
}

function rearrangeDatepickerMonth($date_value) {
    $dayvalue = substr($date_value, 3,2); 
    $monthvalue = substr($date_value, 0,2); 
    $yearvalue = substr($date_value, 6, 4);
    return fetchMonth($monthvalue).', '.$yearvalue;
}

function rearrangeDatepickerDate($date_value) {
    $dayvalue = substr($date_value, 3,2); 
    $monthvalue = substr($date_value, 0,2); 
    $yearvalue = substr($date_value, 6, 4);
    return $dayvalue.' '.fetchMonth($monthvalue).', '.$yearvalue;
}

function rearrangeDatepickerDateMonth($date_value) {
    $dayvalue = substr($date_value, 3,2); 
    $monthvalue = substr($date_value, 0,2); 
    $yearvalue = substr($date_value, 6, 4);
    return $dayvalue.' '.fetchMonth($monthvalue).', '.$yearvalue;
}

function rearrangeTimestampDate ($datetime_value) {
    $timevalue = substr($datetime_value, 11, 5); 
    $dayvalue = substr($datetime_value, 8,2);
    $monthvalue = substr($datetime_value, 5,2); 
    $yearvalue = substr($datetime_value, 0, 4);

    return $dayvalue.'-'.$monthvalue.'-'.$yearvalue;
}

function rearrangeTimestampDateMonth ($datetime_value) {
    $timevalue = substr($datetime_value, 11, 5); 
    $dayvalue = substr($datetime_value, 8,2);
    $monthvalue = substr($datetime_value, 5,2); 
    $yearvalue = substr($datetime_value, 0, 4);

    return $dayvalue.' '.fetchMonth($monthvalue).', '.$yearvalue;
}

function rearrangeTimestampTime ($datetime_value) {
    $timevalue = substr($datetime_value, 11, 5); 
    $dayvalue = substr($datetime_value, 8,2);
    $monthvalue = substr($datetime_value, 5,2); 
    $yearvalue = substr($datetime_value, 0, 4);

    return $timevalue;
}

function rearrangeTimestampDateTime ($datetime_value) {
    $timevalue = substr($datetime_value, 11, 5); 
    $dayvalue = substr($datetime_value, 8,2);
    $monthvalue = substr($datetime_value, 5,2); 
    $yearvalue = substr($datetime_value, 0, 4);

    return $timevalue.' '.$dayvalue.'-'.$monthvalue.'-'.$yearvalue;
}

function rearrangeTimestampDateTimeMonth ($datetime_value) {
    $timevalue = substr($datetime_value, 11, 5); 
    $dayvalue = substr($datetime_value, 8,2);
    $monthvalue = substr($datetime_value, 5,2); 
    $yearvalue = substr($datetime_value, 0, 4);

    return convert24hrsTo12hrs ($timevalue).', '.$dayvalue.' '.fetchMonth($monthvalue);
}

function rearrangeTimestampDateTimeMonthYear ($datetime_value) {
    $timevalue = substr($datetime_value, 11, 5); 
    $dayvalue = substr($datetime_value, 8,2);
    $monthvalue = substr($datetime_value, 5,2); 
    $yearvalue = substr($datetime_value, 0, 4);

    return convert24hrsTo12hrs ($timevalue).' '.fetchMonth($monthvalue).' '.$dayvalue.', '.$yearvalue;
}

function fetchMonth ($monthvalue) {
    if ($monthvalue=="01") {
        $monthvalue = "Jan";
        return $monthvalue;

    } elseif ($monthvalue=="02") {
        $monthvalue ="Feb";
        return $monthvalue;

    } elseif ($monthvalue=="03") {
        $monthvalue ="Mar";
        return $monthvalue;

    } elseif ($monthvalue=="04") {
        $monthvalue ="Apr";
        return $monthvalue;

    } elseif ($monthvalue=="05") {
        $monthvalue ="May";
        return $monthvalue;

    } elseif ($monthvalue=="06") {
        $monthvalue ="Jun";
        return $monthvalue;

    } elseif ($monthvalue=="07") {
        $monthvalue ="July";
        return $monthvalue;

    } elseif ($monthvalue=="08") {
        $monthvalue ="Aug";
        return $monthvalue;

    } elseif ($monthvalue=="09") {
        $monthvalue ="Sep";
        return $monthvalue;

    } elseif ($monthvalue=="10") {
        $monthvalue ="Oct";
        return $monthvalue;

    } elseif ($monthvalue=="11") {
        $monthvalue ="Nov";
        return $monthvalue;

    } elseif ($monthvalue=="12") {
        $monthvalue ="Dec";
        return $monthvalue;

    }
}


?>
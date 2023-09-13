<?php

    session_start();
    if (!$_SESSION['missionSignedIn']) {
        header("HTTP/1.1 500 Internal Server Error");
        die('[[error]]');
    }
    require_once('../sql_tools.php');

    $date_and_time = date('Y-m-d H:i:s');

    if (writeSQL($_SESSION['missionInfo']->mykey, "INSERT INTO `all_referrals` (`Date and Time`) VALUES ('".$date_and_time."')")) {
        $_SESSION['sucess_status'] = true;
        echo('Saved!');
    } else {
        $_SESSION['sucess_status'] = false;
        http_response_code(500);
        echo('Error updating table. Check format');
    }
    
?>
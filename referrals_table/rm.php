<?php

    session_start();
    if (!$_SESSION['missionSignedIn']) {
        header("HTTP/1.1 500 Internal Server Error");
        die('[[error]]');
    }
    require_once('../sql_tools.php');
    $pk = addslashes($_GET["pk"]);

    if (writeSQL($_SESSION['missionInfo']->mykey, "DELETE FROM `all_referrals` WHERE `id`=".$pk)) {
        echo('Saved!');
        $_SESSION['sucess_status'] = true;
    } else {
        $_SESSION['sucess_status'] = false;
        http_response_code(500);
        echo('Error updating table. Check format');
    }
    
?>
<?php

    session_start();
    if (!$_SESSION['missionSignedIn']) {
        die('[[error]]');
    }
    require_once('../sql_tools.php');

    if (writeSQL($_SESSION['missionInfo']->mykey, "UPDATE `all_referrals` SET `".$_POST["name"]."` = '".$_POST["value"]."' WHERE `id` = '".$_POST["pk"]."'")) {
        echo('Saved!');
    } else {
        header("HTTP/1.1 500 Internal Server Error");
        echo('Error updating table.');
    }
    
?>
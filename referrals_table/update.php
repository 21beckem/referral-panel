<?php

    session_start();
    if (!$_SESSION['missionSignedIn']) {
        die('[[error]]');
    }
    require_once('../sql_tools.php');

    writeSQL($_SESSION['missionInfo']->mykey, "UPDATE `all_referrals` SET ".$_POST["name"]." = '".$_POST["value"]."' WHERE id = '".$_POST["pk"]."'")
    
?>
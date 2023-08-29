<?php

    session_start();
    if (!$_SESSION['missionSignedIn']) {
        die('[[error]]');
    }
    require_once('../sql_tools.php');

    echo(json_encode( readSQL($_SESSION['missionInfo']->mykey, 'SELECT * FROM `all_referrals` WHERE 1 LIMIT 5') ));
?>
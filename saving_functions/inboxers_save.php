<?php

    session_start();
    if (!$_SESSION['missionSignedIn']) {
        header('location: ../login.php');
    }
    require_once('../sql_tools.php');

    if (!isset($_POST['saveIt'])) {
        header('location: ../index.php');
    }
    $arr = json_decode($_POST['saveIt']);
    //var_dump($arr);
    //echo('<br>');
    

    if(updateTableRowFromArray($_SESSION['missionInfo']->mykey, 'teams', '`id`='.$arr[0], $arr, true)) {
        header('location: ../inboxers.php');
    } else {
        echo('Oj! Something went wrong. Click <a href="../schedule.php">here</a> to go back.');
        echo('<br><br>');
        echo('Your supplied data: '.$_POST['saveIt']);
    }
?>
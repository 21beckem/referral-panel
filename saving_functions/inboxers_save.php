<?php

    session_start();
    if (!$_SESSION['missionSignedIn']) {
        header('location: ../login.php');
    }
    require_once('../sql_tools.php');

    if (!isset($_POST)) {
        header('location: ../index.php');
    }

    if(updateTableRowFromObject($_SESSION['missionInfo']->mykey, 'teams', '`id`='.$_POST['id'], $_POST, true)) {
        header('location: ../inboxers.php');
    } else {
        echo('Oj! Something went wrong. Click <a href="../schedule.php">here</a> to go back.');
        echo('<br><br>');
        echo('Your supplied data: '.$_POST['saveIt']);
    }
?>
<?php

    session_start();
    if (!$_SESSION['missionSignedIn']) {
        header('location: ../login.php');
    }
    require_once('../sql_tools.php');

    if (!isset($_POST['saveIt'])) {
        header('location: ../index.php');
    }
    
    if(writeSQL($_SESSION['missionInfo']->mykey, 'UPDATE `schedule` SET `json`="'.addslashes($_POST['saveIt']).'" WHERE 1')) {
        $_SESSION['sucess_status'] = true;
        header('location: ../schedule.php');
    } else {
        $_SESSION['sucess_status'] = false;
        echo('Oj! Something went wrong. Click <a href="../schedule.php">here</a> to go back.');
        echo('<br><br>');
        echo('Your supplied data: '.$_POST['saveIt']);
    }
?>
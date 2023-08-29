<?php

    session_start();
    if (!$_SESSION['missionSignedIn']) {
        header('location: ../login.php');
    }
    require_once('../sql_tools.php');

    if (!isset($_POST['saveIt'])) {
        header('location: ../index.php');
    }
    

    if(writeSQL($_SESSION['missionInfo']->mykey, 'DELETE FROM `teams` WHERE `id`='.$_POST['id'])) {
        $_SESSION['sucess_status'] = true;
        header('location: ../inboxers.php');
    } else {
        $_SESSION['sucess_status'] = false;
        echo('Oj! Something went wrong. Click <a href="'.$_SESSION['lastURL'].'">here</a> to go back.');
        echo('<br><br>');
        echo('Your supplied data: '.$_POST['saveIt']);
    }
?>
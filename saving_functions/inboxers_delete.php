<?php

    session_start();
    if (!$_SESSION['missionSignedIn']) {
        header('location: ../login.php');
    }
    require_once('../sql_tools.php');

    if (!isset($_POST['saveIt'])) {
        header('location: ../index.php');
    }
    $tmId = $_POST['id'];
    

    if(writeSQL($_SESSION['missionInfo']->mykey, 'DELETE FROM `teams` WHERE `id`='.$tmId)) {
        header('location: '.$_SESSION['lastURL']);
    } else {
        echo('Oj! Something went wrong. Click <a href="'.$_SESSION['lastURL'].'">here</a> to go back.');
        echo('<br><br>');
        echo('Your supplied data: '.$_POST['saveIt']);
    }
?>
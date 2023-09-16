<?php

    session_start();
    if (!$_SESSION['missionSignedIn']) {
        header('location: ../login.php');
    }
    require_once('../sql_tools.php');

    if (!isset($_POST)) {
        header('location: ../index.php');
    }
    $id = addslashes($_POST['id']);
    $txt = addslashes($_POST['txt']);

    if(writeSQL($_SESSION['missionInfo']->mykey, 'UPDATE `templates` SET `text`="'.$txt.'" WHERE `id`='.$id)) {
        $_SESSION['sucess_status'] = true;
        header('location: '.$_SESSION['lastURL']);
    } else {
        $_SESSION['sucess_status'] = false;
        echo('Oj! Something went wrong. Click <a href="'.$_SESSION['lastURL'].'">here</a> to go back.');
        echo('<br><br>');
        echo('Your supplied data: <br>');
        var_dump($_POST);
    }
?>
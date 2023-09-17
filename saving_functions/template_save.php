<?php

    session_start();
    if (!$_SESSION['missionSignedIn']) {
        header('location: ../login.php');
    }
    require_once('../sql_tools.php');

    if (!isset($_POST)) {
        header('location: ../index.php');
    }
    $setting = $_POST['setting'];

    if ($setting == 'update') {
        $id = addslashes($_POST['id']);
        $txt = addslashes($_POST['txt']);
        $q = 'UPDATE `templates` SET `text`="'.$txt.'" WHERE `id`='.$id;
    }
    else if ($setting == 'new') {
        $refTyp = addslashes($_POST['refTyp']);
        $contactTyp = addslashes($_POST['contactTyp']);
        $q = 'INSERT INTO `templates`(`Referral Type`, `type`) VALUES ("'.$refTyp.'","'.$contactTyp.'")';
    }
    else if ($setting == 'delete') {
        $id = addslashes($_POST['id']);
        $q = 'DELETE FROM `templates` WHERE `id`='.$id;
    }
    else {
        $_SESSION['sucess_status'] = false;
        header('location: '.$_SESSION['lastURL']);
    }


    if(writeSQL($_SESSION['missionInfo']->mykey, $q)) {
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
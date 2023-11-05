<?php

    session_start();
    if (!$_SESSION['missionSignedIn']) {
        header('location: ../login.php');
    }
    if (!isset($_POST)) {
        header('location: ../index.php');
    }
    require_once('../sql_tools.php');

    $id = addslashes($_POST['id']);
    $value = addslashes($_POST['value']);
    $PMGappConnection = addslashes($_POST['PMGappConnection']);
    $delete = addslashes($_POST['delete']);
    if ($id == 'new') {
        $q = 'INSERT INTO `referral_types`(`name`) VALUES ("'.$value.'")';
    } else if (intval($delete) == 1) {
        $q = 'DELETE FROM `referral_types` WHERE `id`='.$id;
    } else {
        $q = 'UPDATE `referral_types` SET `name`="'.$value.'", `PMG app connection`="'.$PMGappConnection.'" WHERE `id`='.$id;
    }
    echo($q);

    if (writeSQL($_SESSION['missionInfo']->mykey, $q)) {
        $_SESSION['sucess_status'] = true;
        header('location: '.$_SESSION['lastURL']);
    } else {
        $_SESSION['sucess_status'] = false;
        //header('location: '.$_SESSION['lastURL']);
        echo('Oj! Something went wrong. Click <a href="'.$_SESSION['lastURL'].'">here</a> to go back.');
        echo('<br><br>');
        echo('Your supplied data: '.$_POST['saveIt']);
    }
?>
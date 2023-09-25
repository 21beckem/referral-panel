<?php

    session_start();
    if (!$_SESSION['missionSignedIn']) {
        header("HTTP/1.1 500 Internal Server Error");
        die('Internal server error. Try signing in again');
    }
    require_once('../sql_tools.php');
    
    $typ = $_POST["typ"];
    $pk = $_POST["pk"];
    $key = $_POST["key"];
    
    // die($typ.', '.$pk.', '.$key);
    $json = json_decode(readSQL($_SESSION['missionInfo']->mykey, "SELECT * FROM `settings` WHERE `id` = '".$pk."'")[0][6], true);

    if ($typ == 'del') { // if deleting key
        echo('del,');
        unset($json[$key]);
    } else if ($typ == 'add') { // if adding key
        echo('add,');
        $json[''] = '';
    } else {
        die('Oh no! Missing arguments!');
    }

    if (writeSQL($_SESSION['missionInfo']->mykey, "UPDATE `settings` SET `value` = '".addslashes(json_encode($json))."' WHERE `id` = '".$pk."'")) {
        $_SESSION['sucess_status'] = true;
        echo('success');
    } else {
        $_SESSION['sucess_status'] = false;
        http_response_code(500);
        echo('Error updating table. Check format');
    }
    
?>
<?php

    session_start();
    if (!$_SESSION['missionSignedIn']) {
        header("HTTP/1.1 500 Internal Server Error");
        die('[[error]]');
    }
    require_once('../sql_tools.php');
    $name = addslashes($_POST["name"]);
    $val = addslashes($_POST["value"]);
    $pk = addslashes($_POST["pk"]);

    $colInfo = readTableColumnInfo($_SESSION['missionInfo']->mykey, 'all_referrals', $name);
    if ($val=='' && $colInfo[0][5]=='YES') {
        $val = 'null';
    } else {
        $val = "'".$val."'";
    }

    if (writeSQL($_SESSION['missionInfo']->mykey, "UPDATE `all_referrals` SET `".$name."` = ".$val." WHERE `id` = '".$pk."'")) {
        echo('Saved!');
    } else {
        http_response_code(500);
        echo('Error updating table. Check format');
    }
    
?>
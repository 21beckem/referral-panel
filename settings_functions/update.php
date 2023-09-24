<?php

    session_start();
    if (!$_SESSION['missionSignedIn']) {
        header("HTTP/1.1 500 Internal Server Error");
        die('Internal server error. Try signing in again');
    }
    require_once('../sql_tools.php');
    $name = addslashes($_POST["name"]);
    $val = addslashes($_POST["value"]);
    $pk = addslashes($_POST["pk"]);
    
    // http_response_code(500);
    // die($name.', '.$val.', '.$pk);


    if ($name == 'text') { // if setting a text value

        if (writeSQL($_SESSION['missionInfo']->mykey, "UPDATE `settings` SET `value` = '".$val."' WHERE `id` = '".$pk."'")) {
            echo('Saved!');
        } else {
            http_response_code(500);
            echo('Error updating table. Check format');
        }

    } else { // must be setting a JSON value
        
        $json = json_decode(readSQL($_SESSION['missionInfo']->mykey, "SELECT * FROM `settings` WHERE `id` = '".$pk."'")[0][6], true);
        $valInfo = (explode(',', $name));
        
        // http_response_code(500);
        // die($valInfo[0]);

        if ($valInfo[1]=='key') // change key name
        {
            $json = replace_key($json, $valInfo[0], $val);
        }
        else // change value
        {
            $json[$valInfo[0]] = $val;
        }

        if (writeSQL($_SESSION['missionInfo']->mykey, "UPDATE `settings` SET `value` = '".addslashes(json_encode($json))."' WHERE `id` = '".$pk."'")) {
            echo('Saved!');
        } else {
            http_response_code(500);
            echo('Error updating table. Check format');
            echo("UPDATE `settings` SET `value` = '".addslashes(json_encode($json))."' WHERE `id` = '".$pk."'");
        }
    }

    function replace_key($arr, $oldkey, $newkey) {
        if(array_key_exists( $oldkey, $arr)) {
            $keys = array_keys($arr);
            $keys[array_search($oldkey, $keys)] = $newkey;
            return array_combine($keys, $arr);	
        }
        return $arr;    
    }
    
?>
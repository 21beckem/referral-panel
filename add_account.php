<?php
require_once('sql_tools.php');
session_start();

// verify credentials exist
if ( !(isset($_POST['username']) || isset($_POST['password'])) ) {
    header('location: signup.html');
    die('missing info');
}
$username = addslashes($_POST['username']);
$password = addslashes(password_hash(addslashes($_POST['password']), PASSWORD_DEFAULT));

echo($username.'<br>');
echo($password.'<br>');

// check if username already exists
if (count(readSQL('Referral_Suite_General', 'SELECT * FROM `mission_users` WHERE `name`="'.$username.'"')) > 0) {
    die('Mission name alreaady exists. Click <a href="signup.html">here to try again</a>');
}

// make mykey
$mykey =  uniqid($_POST['username']);
echo($mykey.'<br>');

// create new row
$sql = 'INSERT INTO `mission_users` (`name`, `pass`, `mykey`) VALUES ("'.$username.'","'.$password.'","'.$mykey.'")';
echo($sql.'<br>');
if (!writeSQL('Referral_Suite_General', $sql)) {
    die('An error occurred. Please <a href="signup.html">try again</a>');
} else {
    $_SESSION['missionSignedIn'] = true;
    $_SESSION['missionInfo'] = (object) [
        "name" => $_POST['username'],
        "mykey" => $mykey
    ];
}

// create database and tables



header('location: index.php');
?>
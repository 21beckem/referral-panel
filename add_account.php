<?php
require_once('sql_tools.php');
session_start();

function carefulWriteSQL($db, $sqlStr) {
    if (!writeSQL($db, $sqlStr)) { die('Error in writing SQL'); }
    return true;
}

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

// create database
carefulWriteSQL('Referral_Suite_General', 'CREATE DATABASE '.$mykey.';');

// create all_referrals
$makeLargeTableSQL = <<<HEREA
CREATE TABLE `all_referrals` (
`Referral Type` text NOT NULL DEFAULT '',
`id` int(11) NOT NULL,
`Date and Time` datetime DEFAULT NULL,
`Referral Sent` text NOT NULL DEFAULT 'Not sent',
`Claimed` text NOT NULL DEFAULT 'Unclaimed',
`Teaching Area` text NOT NULL DEFAULT '',
`AB Status` text NOT NULL DEFAULT 'Yellow',
`Full Name` text NOT NULL DEFAULT '',
`First Name` text NOT NULL DEFAULT '',
`Last Name` text NOT NULL DEFAULT '',
`Phonenumber` text NOT NULL DEFAULT '',
`Email` text NOT NULL DEFAULT '',
`Street` text NOT NULL DEFAULT '',
`City` text NOT NULL DEFAULT '',
`Zip` text NOT NULL DEFAULT '',
`Språk` text NOT NULL DEFAULT '',
`Platform` text NOT NULL DEFAULT '',
`Ad Name` text NOT NULL DEFAULT '',
`Next Follow Up` datetime DEFAULT NULL,
`Follow Up Status` int(11) DEFAULT NULL,
`Follow Up Count` int(11) NOT NULL DEFAULT 0,
`Sent Date` datetime DEFAULT NULL,
`NI Reason` text NOT NULL DEFAULT '',
`Attempt Log` text NOT NULL DEFAULT '',
`Help Request` text NOT NULL DEFAULT '',
`Level of Knowledge` text NOT NULL DEFAULT '',
`Ad ID` text NOT NULL DEFAULT '',
`Form ID` text NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
HEREA;
carefulWriteSQL($mykey, $makeLargeTableSQL);

// create config table
carefulWriteSQL($mykey, 'CREATE TABLE `'.$mykey.'`.`config` (`json` TEXT NULL DEFAULT NULL ) ENGINE = InnoDB;');
$json_template = file_get_contents('config-template.json');
$json_str = json_encode(json_decode($json_template));
echo('<br>'.'INSERT INTO `config`(`json`) VALUES ("'.addslashes($json_str).'")');
carefulWriteSQL($mykey, 'INSERT INTO `config`(`json`) VALUES ("'.addslashes($json_str).'")');

// create teams
carefulWriteSQL($mykey, "CREATE TABLE `".$mykey."`.`teams` (`id` INT NOT NULL AUTO_INCREMENT , `name` TEXT NOT NULL DEFAULT '' , `email` TEXT NOT NULL DEFAULT '' , `color` TEXT NOT NULL DEFAULT '' , `fox_data` TEXT NOT NULL DEFAULT '' , PRIMARY KEY (`id`)) ENGINE = InnoDB;");

// create schedule
carefulWriteSQL($mykey, 'CREATE TABLE `'.$mykey.'`.`schedule` (`json` TEXT NULL DEFAULT NULL ) ENGINE = InnoDB;');
carefulWriteSQL($mykey, "INSERT INTO `schedule`(`json`) VALUES ('[\"\",\"\",\"\",\"\"]')");

// redirect
header('location: index.php');
?>
<?php
require_once('sql_tools.php');
session_start();

function carefulWriteSQL($db, $sqlStr) {
    if (!writeSQL($db, $sqlStr)) { die('Error in writing SQL'); }
    return true;
}

// verify credentials exist
if ( !(isset($_POST['username']) || !isset($_POST['email']) || !isset($_POST['password'])) ) {
    header('location: signup.html');
    die('missing info');
}
$username = addslashes($_POST['username']);
$email = addslashes(strtolower($_POST['email']));
$password = addslashes(password_hash(addslashes($_POST['password']), PASSWORD_DEFAULT));

echo($username.'<br>');
echo($email.'<br>');
echo($password.'<br>');

// check if username already exists
if (count(readSQL('Referral_Suite_General', 'SELECT * FROM `mission_users` WHERE `name`="'.$username.'"')) > 0) {
    die('This Mission Name is alreaady in use. Click <a href="signup.html">here to try again</a>');
}

// check if email already exists
if (count(readSQL('Referral_Suite_General', 'SELECT * FROM `mission_users` WHERE `email`="'.$email.'"')) > 0) {
    die('This Email is alreaady in use. Click <a href="signup.html">here to try again</a>');
}

// make mykey
$mykey =  uniqid($_POST['username']);
echo($mykey.'<br>');

// create new row
$sql = 'INSERT INTO `mission_users` (`name`, `email`, `pass`, `mykey`) VALUES ("'.$username.'","'.$email.'","'.$password.'","'.$mykey.'")';
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
`id` INT NOT NULL AUTO_INCREMENT,
`Date and Time` datetime DEFAULT NULL,
`Referral Sent` text NOT NULL DEFAULT 'Not sent',
`Claimed` text NOT NULL DEFAULT 'Unclaimed',
`Teaching Area` text NOT NULL DEFAULT '',
`AB Status` text NOT NULL DEFAULT 'Yellow',
`First Name` text NOT NULL DEFAULT '',
`Last Name` text NOT NULL DEFAULT '',
`Phonenumber` text NOT NULL DEFAULT '',
`Email` text NOT NULL DEFAULT '',
`Street` text NOT NULL DEFAULT '',
`City` text NOT NULL DEFAULT '',
`Zip` text NOT NULL DEFAULT '',
`Lang` text NOT NULL DEFAULT '',
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
`timeline` JSON NOT NULL DEFAULT '[]',
`Ad ID` text NOT NULL DEFAULT '',
`Form ID` text NOT NULL DEFAULT '',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
HEREA;
carefulWriteSQL($mykey, $makeLargeTableSQL);

// create settings table
$settingsTableQ1 = <<<HERA
CREATE TABLE `settings` (
    `id` int(11) NOT NULL,
    `sort_order` float NOT NULL,
    `header` text NOT NULL,
    `data_type` text NOT NULL DEFAULT 'text',
    `modifiable` tinyint(1) NOT NULL DEFAULT 0,
    `name` text NOT NULL,
    `value` text NOT NULL DEFAULT '',
    `help_comment` text NOT NULL DEFAULT '\'\''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
HERA;
$settingsTableQ2 = <<<HERA
INSERT INTO `settings` (`id`, `sort_order`, `header`, `data_type`, `modifiable`, `name`, `value`, `help_comment`) VALUES
(1, 9.01, 'Stop Contacting', 'json', 1, 'reasons', '{\"doesn\'t remember\":\"🤔 Doesn\'t remember the ad\",\"not interested anymore\":\"🙅 Not interested anymore\",\"wrong person\":\"🥸 Wasn\'t the person we thought\",\"pranked\":\"😡 It was a prank\",\"sent. want no contact\":\"📨 Item sent. They don\'t want contact\",\"can\'t contact\":\"📵 Can\'t get in contact with them\"}', 'List of possible reasons for why to stop contacting people. Left column is what would be placed in the referrals table, and right column is the text for the dropdown option that the team member clicks on'),
(2, 3.02, 'Home Page', 'text', 0, 'book of mormon delivery form link', '', 'Link to a form to have a Book of Mormon delivered to a person if applicable'),
(3, 3.03, 'Home Page', 'text', 0, 'ad deck link', '', 'Link to a presentation you\'ve made with all of your ads so the teams know what people clicked on'),
(4, 3.04, 'Home Page', 'text', 0, 'business suite guidance link', '', 'Link to a presentation you\'ve made on helping your teams with Business Suite'),
(5, 1.01, 'General', 'text', 0, 'login password', 'defualt', 'Password that teams will use to login to your mission\'s Referral Suite'),
(6, 1.02, 'General', 'number', 0, 'pin code', '1022', 'The code that everyone will have to enter to open the Referral Suite app every time. Numbers only'),
(7, 1.03, 'General', 'bool', 0, 'show attempt log', '1', "Select true to show the 7 day attempt log on each dot's contact page"),
(8, 1.04, 'General', 'bool', 0, 'enable timeline page', '1', "Select true to make the a link to timeline page viewable on each dot's contact page"),
(9, 2.01, 'Dot Creation', 'text', 0, 'finding source', 'Media ⇒ Local Social Media ⇒ Facebook - Mission Ad', 'The finding source that you would like these referrals to be marked as. (This is written instruction for the person creating the dot)'),
(10, 2.02, 'Dot Creation', 'text', 0, 'most common language in mission', 'English', 'Most commonly spoken language in the mission'),
(11, 2.03, 'Dot Creation', 'textarea', 0, 'message', 'This is a new referral! Go contact them :)', 'Message that will teams can copy and paste while sending referrals'),
(12, 3.01, 'Home Page', 'json', 1, 'tutorials', '{\"Welcome to Referral Suite\":\"https:\\/\\/google.com\\/link_to_video\"}', 'Tutorials on how to use Referral Suite/be part of the team'),
(13, 4.02, 'Follow Ups', 'number', 0, 'initial delay after sent', '7', 'The number of days after a referral is sent before it appears again as a Follow-Up'),
(14, 4.01, 'Follow Ups', 'bool', 0, 'enable', '1', 'Enable the functionality of having referrals show up again after sent for the referral team to follow up with the teaching area missionaries on how the referral is doing'),
(15, 4.03, 'Follow Ups', 'json', 1, 'status delays', '{\"😭 Can\'t get in contact\":\"Grey\",\"😥 Not interested in contact\":\"Grey\",\"😫 Hasn\'t been contacted\":3,\"🤔 Hasn\'t responded\":5,\"😀 Currently in contact\":7,\"🤩 Appointment is set up!\":\"Green\"}', 'Right column is the text that will show up for the referral team to click on. Right column is the amount of days before the referral will show up again.\n\nIf the right column is not a number, that value will be saved to the referrals Area Book Status. Refer to help videos and defualt values. This will also turn off the follow-up process on this referral. AKA, this referral won\'t show up again for a follow-up');
HERA;
$settingsTableQ3 = 'ALTER TABLE `settings` ADD PRIMARY KEY (`id`);';
$settingsTableQ4 = 'ALTER TABLE `settings` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;';

carefulWriteSQL($mykey, $settingsTableQ1);
carefulWriteSQL($mykey, $settingsTableQ2);
carefulWriteSQL($mykey, $settingsTableQ3);
carefulWriteSQL($mykey, $settingsTableQ4);

// create subscription tokens table
carefulWriteSQL($mykey, "CREATE TABLE `".$mykey."`.`tokens` (`id` INT NOT NULL AUTO_INCREMENT , `teamId` INT NOT NULL , `token` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;");


// create teams
carefulWriteSQL($mykey, "CREATE TABLE `".$mykey."`.`teams` (`id` INT NOT NULL AUTO_INCREMENT , `name` TEXT NOT NULL DEFAULT '' , `email` TEXT NOT NULL DEFAULT '' , `color` TEXT NOT NULL DEFAULT '' , PRIMARY KEY (`id`)) ENGINE = InnoDB;");

// create schedule
carefulWriteSQL($mykey, 'CREATE TABLE `'.$mykey.'`.`schedule` (`json` TEXT NULL DEFAULT NULL ) ENGINE = InnoDB;');
carefulWriteSQL($mykey, 'INSERT INTO `schedule`(`json`) VALUES (\'[["", "", "2002-10-22"], ["10:00", "11:00", ""]]\')');

// create list of referral types
carefulWriteSQL($mykey, 'CREATE TABLE `'.$mykey.'`.`referral_types` (`id` INT NOT NULL AUTO_INCREMENT , `name` TEXT NOT NULL DEFAULT \'\' , `PMG app connection` TEXT NOT NULL DEFAULT \'automatic\' , PRIMARY KEY (`id`)) ENGINE = InnoDB;');

// create table for template messages
carefulWriteSQL($mykey, "CREATE TABLE `".$mykey."`.`templates` (`id` INT NOT NULL AUTO_INCREMENT , `type` TEXT NOT NULL , `text` TEXT NOT NULL DEFAULT '' , PRIMARY KEY (`id`)) ENGINE = InnoDB;");

// create table for mission area list
carefulWriteSQL($mykey, "CREATE TABLE `".$mykey."`.`mission_areas` (`id` INT NOT NULL AUTO_INCREMENT , `name` TEXT NOT NULL DEFAULT '' , `phone` TEXT NOT NULL DEFAULT '' , PRIMARY KEY (`id`)) ENGINE = InnoDB;");

// redirect
header('location: index.php');
?>
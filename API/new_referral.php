<?php

require_once('../sql_tools.php');
require_once('../notif_tools.php');

$dieMsg = "Nice try. Why are you bad? WHY?\n<br>\n<br>\nError: ";

// if there is no data provided, just die
if (empty($_POST)) {
    http_response_code(500);
	echo($dieMsg);
    die('POST');
}

// also if the mykey doesn't exist or is bad, just die
if (!isset($_POST['mykey'])) {
    http_response_code(500);
    echo($dieMsg);
    die('MISSING POST KEY');
}
$mykey = $_POST['mykey'];
if (count(readSQL('Referral_Suite_General', 'SELECT `name` FROM `mission_users` WHERE `mykey`="'.$mykey.'"')) == 0) {
    http_response_code(500);
    echo($dieMsg);
    die('BAD KEY');
}

// Get all the input data from zapier
$date_and_time = date('Y-m-d H:i:s', strtotime( $_POST['date'] ));
$type = addslashes($_POST['type']);
$fname = addslashes($_POST['fname']);
$lname = addslashes($_POST['lname']);
$phone = addslashes($_POST['phone']);
$email = addslashes($_POST['email']);
$street = addslashes($_POST['street']);
$city = addslashes($_POST['city']);
$zip = addslashes($_POST['zip']);
$lang = addslashes($_POST['lang']); 
$platform = addslashes($_POST['platform']);
$ad_name = addslashes($_POST['ad_name']);
$helpRequest = addslashes($_POST['helpRequest']);
$knowledgeLevel = addslashes($_POST['knowledgeLevel']);
$ad_id = addslashes($_POST['ad_id']);
$form_id = addslashes($_POST['form_id']);

$q = "INSERT INTO `all_referrals` (`Referral Type`, `Date and Time`, `First Name`, `Last Name`, `Phonenumber`, `Email`, `Street`, `City`, `Zip`, `Lang`, `Platform`, `Ad Name`, `Help Request`, `Level of Knowledge`, `Ad ID`, `Form ID`) VALUES ('$type', '$date_and_time', '$fname', '$lname', '$phone', '$email', '$street', '$city', '$zip', '$lang', '$platform', '$ad_name', '$helpRequest', '$knowledgeLevel', '$ad_id', '$form_id')";
if (writeSQL($mykey, $q)) {
    echo('success');
} else {
    http_response_code(500);
    echo("Something went wrong with creating this person in Referral Suite :/\n<br>\nAttempted Query: ");
    die($q);
}

$currentTeam = getCurrentReferralTeam($mykey);
notifyTeam($mykey, $currentTeam);

?>
<?php
session_start();

unset($_SESSION['missionSignedIn']);
unset($_SESSION['missionInfo']);

header('location: login.php');
?>
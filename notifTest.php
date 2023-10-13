<?php

require_once('notif_tools.php');

$currentTeam = getCurrentReferralTeam('SSM64f4c72792c37');

notifyTeam('SSM64f4c72792c37', $currentTeam);

//echo($currentTeam);

?>
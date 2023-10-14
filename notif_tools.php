<?php

require_once('sql_tools.php');

function sendFCMNotification($deviceToken, $title, $body, $image) {
    $url = 'https://fcm.googleapis.com/fcm/send';
    $data = [
        'to' => $deviceToken,
        'notification' => [
            'body' => $body,
            'title' => $title,
            'image' => $image
        ]
    ];
    $options = array(
        CURLOPT_URL => $url,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => array(
            "Authorization: key=AAAAjdtjTaQ:APA91bGYIyTdoqKCX0RwqwJBky84CsdJXf-pE_zUcoHHuR0Di6WAQs_1yoZqIHWJncYkyrsQh1tcd3SmXcdNtit9vHb4_40qX3p-PKQfSgaJMQ4k5hSYdtBb7c-xy-K5INsWE8tE9v0U",
            "Content-Type: application/json",
        ),
        CURLOPT_POSTFIELDS => json_encode($data),
    );
    $curl = curl_init();
    curl_setopt_array($curl, $options);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    return json_decode($response);
}

function getCurrentReferralTeam($mykey) {
    // get schedule
    $sched = json_decode( readSQL($mykey, "SELECT * FROM `schedule` WHERE 1")[0][0] );
    
    // find todays schedule
    $currentDayDate = date('Y-m-d');
    $todaysI = array_search($currentDayDate, $sched[0]);
    $transposed = array_map(null, ...$sched);
    $todayArr = $transposed[$todaysI];
    //var_dump($todayArr);

    // find nows shift
    $current_time = date('H:i');
    for ($i=1; $i < count($todayArr); $i++) {
        $start = $transposed[0][$i];
        $end = $transposed[1][$i];
        $date1 = DateTime::createFromFormat('H:i', $current_time);
        $date2 = DateTime::createFromFormat('H:i', $start);
        $date3 = DateTime::createFromFormat('H:i', $end);
        if ($date1 > $date2 && $date1 < $date3) {
            return $todayArr[$i];
        }
    }
    return '-1';
}


function notifyTeam($mykey, $tmId) {
    // get all device tokens for this team
    $tmId = strval($tmId);
    $rowsWithId = readSQL($mykey, 'SELECT * FROM `tokens` WHERE `teamId`="'.$tmId.'"');

    // get team info
    $teamInfo = readSQL($mykey, 'SELECT * FROM `teams` WHERE `id`="'.$tmId.'"')[0];

    for ($i=0; $i < count($rowsWithId); $i++) { 
        $row = $rowsWithId[$i];

        // send notification
        $result = sendFCMNotification($row[2],
            'Referral Received',
            getFoxSaying(),
            'img/fox_profile_pics/'.$teamInfo[3].'.svg'
        );
        if (!$result->success) {
            // delete token if fail
            writeSQL($mykey, 'DELETE FROM `tokens` WHERE `id`='.$row[0]);
        }
    }
}
function getFoxSaying() {
    $ops = array(
        "You have a new referral! You can claim it and get to contacting!",
        "Quick, we have a new referral! Get it claimed and get it contacted!",
        "Oh look, a new referral! Time to claim and contact them!",
        "That's the new referral alarm! Quick, claim them and start contacting!",
        "AAH! NEW REFERRAL! DON'T PANIC! Just claim and contact!",
        "A new referral came in! Don't worry, claim and contact!",
        "New referral! Remember your training! Get to contacting!",
        "What are you doing?!? We have a new referral here! Hurry and contact them!",
        "Oh cool, a new referral! Be sure to claim and contact them quick!"
    );
    return $ops[ array_rand($ops) ];
}


?>
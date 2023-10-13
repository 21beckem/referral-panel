<?php

require_once('sql_tools.php');

function sendFCMNotification($deviceToken) {
    $url = 'https://fcm.googleapis.com/fcm/send';
    $data = [
        'to' => $deviceToken,
        'notification' => [
            'body' => 'Yo! New Referral!',
            'title' => 'Referral Received',
            'image' => 'img/fox_profile_pics/red.svg'
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
    $tmId = strval($tmId);
    $rowsWithId = readSQL($mykey, 'SELECT * FROM `tokens` WHERE `teamId`="'.$tmId.'"');

    for ($i=0; $i < count($rowsWithId); $i++) { 
        $row = $rowsWithId[$i];

        // send notification
        $result = sendFCMNotification($row[2]);
        if (!$result->success) {
            // delete token if fail
            writeSQL($mykey, 'DELETE FROM `tokens` WHERE `id`='.$row[0]);
        }
    }
}


?>
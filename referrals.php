<?php
    session_start();
    if (!$_SESSION['missionSignedIn']) {
        header('location: login.php');
    }
    require_once('panel_maker.php');
    require_once('sql_tools.php');
    require_once('overall_vars.php');

    makeHTMLtop('Referrals');

    // get teams info
    $teamInfos = readSQL($_SESSION['missionInfo']->mykey, 'SELECT * FROM `teams` WHERE 1');

    // get table cols
    $tableCols = readTableColumns($_SESSION['missionInfo']->mykey, 'all_referrals');

    // get referrals list
    $referralList = readSQL($_SESSION['missionInfo']->mykey, 'SELECT * FROM `all_referrals` LIMIT 5');
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript" src="saving_functions/jquery.tabledit.min.js"></script>
<style>
table {
    width: 100%;
    border-spacing: 0 0px;
}
table td {
    padding: 0px 10px;
}
table tr:nth-child(even) {
    background-color: #fee4ff;
}
</style>
<div class="top">
    <i class="fa-solid fa-bars sidebar-toggle"></i>
    <h2>Referral Panel</h2>
    <img src="img/logo.png" alt="">
</div>
<div class="dash-content">
<table id="data_table">
    <tr>
        <?php
            foreach ($tableCols as $key => $value) {
                echo('<td>'.$value.'</td>');
            }
        ?>
    </tr>
<?php
for ($i=0; $i < count($referralList); $i++) { 
    $ref = $referralList[$i];
    echo('<tr id="tableRowId_'.$ref[1].'">');
    for ($j=0; $j < count($ref); $j++) { 
        $refVal = $ref[$j];
        echo('<td>'.$refVal.'</td>');
    }
    echo('</tr>');
}
?>
</table>
</div>
<script>
    
$('#data_table').Tabledit({
    url: 'example.php',
    eventType: 'dblclick',
    editButton: false,
    columns: {
        identifier: [0, 'id'],
        editable: [
            [0, 'Type']
            [1, 'Id']
            [2, 'Date']
            [3, 'Referral Sent']
            [4, 'Claimed']
            [5, 'Teaching Area']
            [6, 'AB Status']
            [7, 'First Name']
            [8, 'Last Name']
            [9, 'Number']
            [10, 'Email']
            [11, 'Street']
            [12, 'City']
            [13, 'Zip']
            [14, 'Lang']
            [15, 'Platform']
            [16, 'Ad Name']
            [17, 'Next Follow Up']
            [18, 'Follow Up Status']
            [19, 'Follow Up Count']
            [20, 'Sent Date']
            [21, 'NI Reason']
            [22, 'Attempt Log']
            [23, 'Help Request']
            [24, 'Level of Knowledge']
            [25, 'Ad ID']
            [26, 'Form ID']
        ]
    }
});

</script>
</div>

<?php makeHTMLbottom() ?>
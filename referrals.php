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
        <td>Type</td>
        <td>Id</td>
        <td>Date</td>
        <td>Referral Sent</td>
        <td>Claimed</td>
        <td>Teaching Area</td>
        <td>AB Status</td>
        <td>First Name</td>
        <td>Last Name</td>
        <td>Number</td>
        <td>Email</td>
        <td>Street</td>
        <td>City</td>
        <td>Zip</td>
        <td>Lang</td>
        <td>Platform</td>
        <td>Ad Name</td>
        <td>Next Follow Up</td>
        <td>Follow Up Status</td>
        <td>Follow Up Count</td>
        <td>Sent Date</td>
        <td>NI Reason</td>
        <td>Attempt Log</td>
        <td>Help Request</td>
        <td>Level of Knowledge</td>
        <td>Ad ID</td>
        <td>Form ID</td>
    </tr>
<?php
for ($i=0; $i < count($referralList); $i++) { 
    $ref = $referralList[$i];
?>
    <tr id="<?php echo $ref[1]; ?>">
        <td><?php echo $ref[0]; ?></td>
        <td><?php echo $ref[1]; ?></td>
        <td><?php echo $ref[2]; ?></td>
        <td><?php echo $ref[3]; ?></td>
        <td><?php echo $ref[4]; ?></td>
        <td><?php echo $ref[5]; ?></td>
        <td><?php echo $ref[6]; ?></td>
        <td><?php echo $ref[7]; ?></td>
        <td><?php echo $ref[8]; ?></td>
        <td><?php echo $ref[9]; ?></td>
        <td><?php echo $ref[10]; ?></td>
        <td><?php echo $ref[11]; ?></td>
        <td><?php echo $ref[12]; ?></td>
        <td><?php echo $ref[13]; ?></td>
        <td><?php echo $ref[14]; ?></td>
        <td><?php echo $ref[15]; ?></td>
        <td><?php echo $ref[16]; ?></td>
        <td><?php echo $ref[17]; ?></td>
        <td><?php echo $ref[18]; ?></td>
        <td><?php echo $ref[19]; ?></td>
        <td><?php echo $ref[20]; ?></td>
        <td><?php echo $ref[21]; ?></td>
        <td><?php echo $ref[22]; ?></td>
        <td><?php echo $ref[23]; ?></td>
        <td><?php echo $ref[24]; ?></td>
        <td><?php echo $ref[25]; ?></td>
        <td><?php echo $ref[26]; ?></td>
    </tr>
<?php } ?>
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
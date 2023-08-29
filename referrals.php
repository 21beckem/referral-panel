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
?>
<link href="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
<script src="http://code.jquery.com/jquery-2.0.3.min.js"></script> 
<script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/bootstrap3-editable/js/bootstrap-editable.js"></script>
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
table tr.header {
    position: sticky;
    top: 80px;
    box-shadow: 1px 2px 10px -7px rgba(0, 0, 0, 0.5);
}
</style>
<div class="top">
    <i class="fa-solid fa-bars sidebar-toggle"></i>
    <h2>Referral Panel</h2>
    <img src="img/logo.png" alt="">
</div>
<div class="dash-content">
<table id="data_table" class="table table-bordered table-striped">
    <tr class="header">
        <?php
            foreach ($tableCols as $key => $value) {
                echo('<td>'.$value.'</td>');
            }
        ?>
    </tr>
    <tbody id="employee_data">
    </tbody>
<?php
/*for ($i=0; $i < count($referralList); $i++) { 
    $ref = $referralList[$i];
    echo('<tr id="tableRowId_'.$ref[1].'">');
    for ($j=0; $j < count($ref); $j++) { 
        $refVal = $ref[$j];
        echo('<td>'.$refVal.'</td>');
    }
    echo('</tr>');
}*/
?>
</table>
</div>
<script>
const tableCols = <?php echo(json_encode($tableCols)); ?>;
let teamInfos = <?php echo(json_encode($teamInfos)); ?>;
let teamLookup = Array();
for (let i = 0; i < teamInfos.length; i++) {
    const tm = teamInfos[i];
    teamLookup.push( {value: tm[0], text: tm[1]} );
}
function getTeamFromId(id) {
    try {
        return teamLookup.filter(x => parseInt(x.value)==parseInt(id))[0].text;
    } catch (e) {}
    return '';
}
function getEditableClassAndType(colName) {
    switch (colName) {
        case 'id':
            return ['', ''];
            break;
        
        case 'Claimed':
            return ['claimedCol', 'select'];
            break;
        
        default:
            return ['textEditable', 'text'];
    }
}

function fetch_employee_data() {
    $.ajax({
        url:"referrals_table/fetch.php",
        method:"POST",
        data: {'q' : 'SELECT * FROM `all_referrals` WHERE 1 ORDER BY `all_referrals`.`id` DESC LIMIT 5'},
        dataType:"json",
        success: function(data) {
            let html_data = '';
            for (let i=0; i<data.length; i++) {
                const row = data[i];

                html_data += '<tr>'
                for (let j = 0; j < row.length; j++) {
                    const cell = row[j];
                    const col = tableCols[j];
                    const cls = getEditableClassAndType(col)[0];
                    const typ = getEditableClassAndType(col)[1];
                    
                    if (typ == 'select') {
                        html_data += '<td data-name="'+col+'" class="'+cls+'" data-type="'+typ+'" data-pk="'+row[1]+'">'+getTeamFromId(cell)+'</td>';
                    } else {
                        html_data += '<td data-name="'+col+'" class="'+cls+'" data-type="'+typ+'" data-pk="'+row[1]+'">'+cell+'</td>';
                    }
                }
                html_data += '</tr>';
            }
            $('#employee_data').append(html_data);
        }
    });
}
$('#employee_data').editable({ // textEditable class is now editable
    container: 'body',
    selector: 'td.textEditable',
    url: "referrals_table/update.php",
    title: 'Edit Cell',
    type: "GET",
    dataType: 'json'
});
$('#employee_data').editable({ // claimedCol class is now editable with select
    container: 'body',
    selector: 'td.claimedCol',
    url: "referrals_table/update.php",
    title: 'Edit Cell',
    type: "GET",
    dataType: 'json',
    source: teamLookup,
    validate: function(value) {
        if($.trim(value) == '') { return 'This field is required' }
    }
});

fetch_employee_data();

</script>
</div>

<?php makeHTMLbottom() ?>
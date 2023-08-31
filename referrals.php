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


    ///////////////////////////////////////////////////
    //                  Make Query                   //
    ///////////////////////////////////////////////////
    $operatorLookup = array(
        'eq' => ['="', '"'], // equals
        'ne' => ['!="', '"'], // not equals
        'sw' => ['like "', '%"'], // starts with
        'ct' => ['like "%', '%"'], // contains
        'nct' => ['not like "', '%"'], // doesn't contain
        'fw' => ['like "%', '"'], // finishes with
        'gt' => ['>', ''], // greater than
        'lt' => ['<', ''], // less than
        
        'null' => ['=""', 'IS NULL'], // is empty
        'nn' => ['!=""', 'IS NOT NULL'], // not empty
        'in' => 'matches one of the following (separated by cammas stored in value)',
        
        'bw' => ['BETWEEN ', ' AND '], // between value and value2
        'nbw' => ['NOT BETWEEN ', ' AND '], //NOT between value and value2
    );
    $MAIN_QUERY = 'SELECT * FROM `all_referrals` WHERE 1 ORDER BY `all_referrals`.`id` DESC LIMIT 10';

    if (isset($_GET['filters'])) {
        $filtersCount = intval($_GET['filters']);
        $MAIN_QUERY = '';
        for ($i=0; $i < $filtersCount; $i++) { 
            $MAIN_QUERY .= '(';
            $field = $_GET['field-'.$i]; 
            $op = $_GET['operator-'.$i]; 
            $value = $_GET['value-'.$i]; 
            $value2 = $_GET['value2-'.$i];

            if ($op == 'null' || $op == 'nn') // spacial case for empty or not empty
            {
                $MAIN_QUERY .= '(`'.$field.'` '.$operatorLookup[$op][0].' OR `'.$field.'` '.$operatorLookup[$op][1].')';
            }
            else if ($op == 'in') // spacial case for matches
            {
                $mats = explode(",", $value);
                $MAIN_QUERY .= '(';
                foreach ($mats as $j => $m) {
                    $MAIN_QUERY .= '`'.$field.'` '.$operatorLookup['eq'][0].$value.$operatorLookup['eq'][1].' AND ';
                }
                $MAIN_QUERY = substr($MAIN_QUERY, 0, -5);
                $MAIN_QUERY .= ')';
            }
            else if ($op == 'bw' || $op == 'nbw') // spacial case for between and not between
            {
                $MAIN_QUERY .= '`'.$field.'` '.$operatorLookup[$op][0].$value.$operatorLookup[$op][1].$value2;
            }
            else // otherwise, handle normally
            {
                $MAIN_QUERY .= '`'.$field.'` '.$operatorLookup[$op][0].$value.$operatorLookup[$op][1];
            }
            $MAIN_QUERY .= ') AND';
        }
        $MAIN_QUERY = substr($MAIN_QUERY, 0, -4);
        $MAIN_QUERY = 'SELECT * FROM `all_referrals` WHERE '.$MAIN_QUERY.' ORDER BY `all_referrals`.`id` DESC LIMIT 10';
    }
    echo('mainQ: '.$MAIN_QUERY);
?>
<link href="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
<script src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
<script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/bootstrap3-editable/js/bootstrap-editable.js"></script>
<script src="structured_filter/script.js"></script>
<link rel="stylesheet" href="structured_filter/style.css">
<link rel="stylesheet" type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.css">
<style>
#data_table {
    border-spacing: 0 0px;
}
#data_table td {
    text-wrap: nowrap;
}
#data_table tr:nth-child(even) {
    background-color: #fee4ff;
}
#data_table tr.header {
    position: sticky;
    top: 80px;
    box-shadow: 1px 2px 10px -7px rgba(0, 0, 0, 0.5);
}
.btn-primary {
    color: #fff;
    background-color: #ca43ff;
    border-color: transparent;
}
.btn-primary:hover {
    background-color: #b037df;
    border-color: transparent;
}
</style>
<div class="top">
    <i class="fa-solid fa-bars sidebar-toggle"></i>
    <h2>Referral Panel</h2>
    <img src="img/logo.png" alt="">
</div>
<div class="dash-content">
<div id="myFilter"></div>
<button onclick="refreshWithFilter()">GO</button>
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
function refreshWithFilter() {
    window.location.href = '?' + $("#myFilter").structFilter("valUrl");
}

function make_table(data) {
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
make_table(<?php echo(json_encode( readSQL($_SESSION['missionInfo']->mykey, $MAIN_QUERY) )); ?>);
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

$(document).ready(function() { // create filter box
    $("#myFilter").structFilter({
        submitButton: true,
        fields: [
            {id:"First Name", type:"text", label:"First Name"},
            {id:"id", type:"number", label:"id"},
            {id:"active", type:"boolean", label:"Is active"},
            {id:"age", type:"number", label:"Age"},
            {id:"bday", type:"date", label:"Birthday"},
            {id:"category", type:"list", label:"Category",
                list:[
                    {id:"1", label:"Family"},
                    {id:"2", label:"Friends"},
                    {id:"3", label:"Business"},
                    {id:"4", label:"Acquaintances"},
                    {id:"5", label:"Other"}
                ]
            }
        ]
    });
});

</script>
</div>

<?php makeHTMLbottom() ?>
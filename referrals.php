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

    // get table cols info
    $tableColInfo = readTableColumnInfo($_SESSION['missionInfo']->mykey, 'all_referrals');

    // get all referral types
    $referral_types = readSQL($_SESSION['missionInfo']->mykey, 'SELECT * FROM `referral_types` WHERE 1');


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
    $MAIN_QUERY = 'SELECT * FROM `all_referrals` WHERE 1 ORDER BY `all_referrals`.`id` DESC LIMIT 25';

    /*  // attempting to fix getting referrals on one specific day. Too complecated to deal with now though
    $colTypeLookup = array();
    for ($i=0; $i < count($tableColInfo); $i++) { 
        $colTypeLookup[ $tableColInfo[$i][0] ] = $tableColInfo[$i][1];
    }
    function giveQuotes($col, $val) {
        global $colTypeLookup;
        echo($colTypeLookup[$col]);
        if ($colTypeLookup[$col] == 'datetime' || $colTypeLookup[$col] == 'int') {
            return $val;
        } else {
            return '"'.$val.'"';
        }
    }
    */

    if (isset($_GET['val'])) {
        $MAIN_QUERY = '';
        if (isset($_GET['filters'])) {
            $filtersCount = intval($_GET['filters']);
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
                        $MAIN_QUERY .= '`'.$field.'` '.$operatorLookup['eq'][0].$m.$operatorLookup['eq'][1].' OR ';
                    }
                    $MAIN_QUERY = substr($MAIN_QUERY, 0, -4);
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
        } else {
            $MAIN_QUERY = '1';
        }
        if ($_GET['rowsLimit'] == 'ALL') {
            $limitStr = '';
        } else {
            $limitStr = ' LIMIT '.$_GET['rowsLimit'];
        }
        $MAIN_QUERY = 'SELECT * FROM `all_referrals` WHERE '.$MAIN_QUERY.' ORDER BY `all_referrals`.`'.$_GET['sortCol'].'` '.$_GET['sortDir'].$limitStr;
    }
    //echo('mainQ: '.$MAIN_QUERY);
?>
<link href="MYbootstrap.css" rel="stylesheet">
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
    margin-top: 150px;
    border-spacing: 0 0px;
}
#data_table td {
    text-wrap: nowrap;
}
#data_table tr:nth-child(even) {
    background-color: #feecff;
}
#data_table tr.header {
    z-index: 5;
    position: sticky;
    top: 233px;
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
#searchBarParent {
    position: fixed;
    left: var(--sidebarSize);
    width: calc(95% - var(--sidebarSize));
    transition: var(--tran-05);
    align-items: right;
    z-index: 5;
}
#searchBarParent div.otherBtns {
    width: 100%;
    align-items: end;
    display: flex;
    justify-content: flex-end;  
}
#searchBarParent div.otherBtns select {
    padding: 3px 7px;
}
#whiteBlanket {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 235px;
    background-color: white;
}
#manualAddBtn {
    position: fixed;
    right: 30px;
    bottom: 30px;
    padding: 17px;
    border-radius: 50%;
    font-size: 23px;
    width: 70px;
    height: 70px;
    box-shadow: 1px 2px 10px -3px rgba(0, 0, 0, 0.5);
}
#manualAddBtn * {
    transform: translateX(4px);
}
.delBtn {
    color: #ff000057;
    border: none;
    background-color: transparent;
    transition: 0.15s ease;
}
.delBtn:hover {
    color: #ff0000b0;
}
</style>
<div class="top">
    <i class="fa-solid fa-bars sidebar-toggle"></i>
    <h2>Referrals</h2>
    <img src="img/logo.png" alt="">
</div>
<div class="dash-content">
<div id="searchBarParent">
    <div id="myFilter"></div>
    <div class="otherBtns">
        Sort by:&nbsp;
        <select id="sortCol">
            <?php
            foreach ($tableColInfo as $i => $col) {
                if ($col[1] == 'int') {
                    $selected = '';
                    if($_GET['sortCol']==$col[0]) {$selected=' selected';}
                    echo('<option'.$selected.'>'.$col[0].'</option>');
                }
            }
            ?>
        </select>
        &nbsp;
        <select id="sortDir"> 
            <option value="DESC"<?php if($_GET['sortDir']=='DESC') {echo(' selected');} ?>>Descending</option>
            <option value="ASC"<?php if($_GET['sortDir']=='ASC') {echo(' selected');} ?>>Ascending</option>
        </select>
        &nbsp;&nbsp;&nbsp;
        Number of rows:&nbsp;
        <select id="rowsLimit" onchange="warnRequestingAllRows(this.value)"> 
            <option <?php if($_GET['rowsLimit']==25) {echo('selected');} ?>>25</option>
            <option <?php if($_GET['rowsLimit']==50) {echo('selected');} ?>>50</option>
            <option <?php if($_GET['rowsLimit']==100) {echo('selected');} ?>>100</option>
            <option <?php if($_GET['rowsLimit']==250) {echo('selected');} ?>>250</option>
            <option <?php if($_GET['rowsLimit']==500) {echo('selected');} ?>>500</option>
            <option <?php if($_GET['rowsLimit']=='ALL') {echo('selected');} ?>>ALL</option>
        </select>
        <button class="purpleBtn" style="padding: 5px 10px" onclick="refreshWithFilter()">GO</button>
    </div>
</div>
<div id="whiteBlanket"></div>
<table id="data_table" class="table table-bordered table-striped">
    <tr class="header">
        <td></td>
        <?php
            foreach ($tableCols as $key => $value) {
                echo('<td>'.$value.'</td>');
            }
        ?>
    </tr>
    <tbody id="employee_data"></tbody>
</table>
<button id="manualAddBtn" class="purpleBtn" onclick="addNewRow()"><i class="fa-solid fa-user-plus"></i></button>
<script>
function _(x) { return document.getElementById(x); }
HTMLCollection.prototype.forEach = function (x) { return Array.from(this).forEach(x); }
const filterBoxSizeChange = new ResizeObserver(entries => {
    _('data_table').style.marginTop = (entries[0].target.clientHeight + 10) + 'px';
    document.querySelector('#data_table tr.header').style.top = (entries[0].target.clientHeight + 93) + 'px';
    _('whiteBlanket').style.height = (entries[0].target.clientHeight + 93) + 'px';
});
filterBoxSizeChange.observe(_('searchBarParent'));
const tableCols = <?php echo(json_encode($tableCols)); ?>;
let teamInfos = <?php echo(json_encode($teamInfos)); ?>;
let TableInfo = <?php echo(json_encode($tableColInfo)); ?>;
TableInfo.map(col => {
    if (col[1].includes('text')) {
        col[1] = 'text';
    } else if (col[1].includes('date')) {
        col[1] = 'date';
    } else if (col[1].includes('int')) {
        col[1] = 'number';
    }
    return col;
});
let teamLookup = Array();
teamLookup.push( {value: 'Unclaimed', text: 'Unclaimed'} );
for (let i = 0; i < teamInfos.length; i++) {
    const tm = teamInfos[i];
    teamLookup.push( {value: tm[0], text: tm[1]} );
}
function getTeamFromId(id) {
    try {
        return teamLookup.filter(x => parseInt(x.value)==parseInt(id))[0].text;
    } catch (e) {}
    return id;
}
function getEditableClassAndType(colName) {
    switch (colName) {
        case 'Referral Type':
            return ['refTyp', 'select'];
            break;

        case 'id':
            return ['', ''];
            break;
        
        case 'Claimed':
            return ['claimedCol', 'select'];
            break;
        
        case 'Referral Sent':
            return ['SentStatus', 'select'];
            break;
        
        default:
            return ['textEditable', 'text'];
    }
}
function warnRequestingAllRows(v) {
    if (v.toLowerCase()=='all') {
        JSAlert.alert('Requesting all rows may crash your browser depending on how many rows result from your filter.<br>Just so you know.', '', JSAlert.Icons.Warning);
    }
}
function refreshWithFilter() {
    let q = '?' + $("#myFilter").structFilter("valUrl");
    q += '&val=' + encodeURIComponent(JSON.stringify($("#myFilter").structFilter("val")));
    q += '&sortCol=' + encodeURIComponent(_('sortCol').value);
    q += '&sortDir=' + encodeURIComponent(_('sortDir').value);
    q += '&rowsLimit=' + encodeURIComponent(_('rowsLimit').value);
    window.location.href = q;
}
function deleteRow(rowId, nam) {
    JSAlert.confirm('Are you absolutely sure you want to delete '+nam+'? This <strong>CANNOT be undone!</strong><br><br>If you simply want it to disappear from Referral Suite, set \'Referral Sent\' to "Not Interested"', '', JSAlert.Icons.Warning)
    .then(res => {
        if (res) {
            fetch('referrals_table/rm.php?pk='+rowId).then(res => {
                window.location.reload();
            });
        }
    });
}
function addNewRow() {
    fetch('referrals_table/new.php').then(res => {
        window.location.reload();
    });
}

function make_table(data) {
    let html_data = '';
    for (let i=0; i<data.length; i++) {
        const row = data[i];

        html_data += '<tr><td><button class="delBtn" onclick="deleteRow('+row[1]+', \''+row[7]+' '+row[8]+'\')"><i class="fa-solid fa-trash-can"></i></button></td>'
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
$('#employee_data').editable({ // refTyp class is now editable with select
    container: 'body',
    selector: 'td.refTyp',
    url: "referrals_table/update.php",
    title: 'Edit Cell',
    type: "GET",
    dataType: 'json',
    source: <?php echo(json_encode( $referral_types )); ?>.map(x =>{  return {value: x[1], text: x[1]}  }),
    validate: function(value) {
        if($.trim(value) == '') { return 'This field is required' }
    }
});
$('#employee_data').editable({ // SentStatus class is now editable with select
    container: 'body',
    selector: 'td.SentStatus',
    url: "referrals_table/update.php",
    title: 'Edit Cell',
    type: "GET",
    dataType: 'json',
    source: [
        {value: 'Not sent', text: 'Not sent'},
        {value: 'Sent', text: 'Sent'},
        {value: 'Not interested', text: 'Not interested'}
    ],
    validate: function(value) {
        if($.trim(value) == '') { return 'This field is required' }
    }
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
    let fields = Array();
    for (let i = 0; i < TableInfo.length; i++) {
        const col = TableInfo[i];
        if (col[0] == 'Referral Type') {
            const types = <?php echo(json_encode( $referral_types )); ?>.map(x => x[1]);
            let arr = Array();
            for (let j = 0; j < types.length; j++) {
                const typ = types[j];
                arr.push({
                    id : typ,
                    label : typ
                });
            }
            fields.push({
                id : col[0],
                type : 'list',
                label : col[0],
                list : arr
            });
        } else if (col[0] == 'Claimed') {
            fields.push({
                id : col[0],
                type : 'list',
                label : col[0],
                list : teamLookup.map(x => {
                    return {
                        id : x.value,
                        label : x.text
                    }
                })
            });
        } else {
            fields.push({
                id : col[0],
                type : col[1],
                label : col[0]
            });
        }
    }
    $("#myFilter").structFilter({
        fields: fields,
        buttonLabels: false
    });
    $("#myFilter").structFilter("val", <?php echo($_GET['val']); ?>);
});

</script>
</div>

<?php makeHTMLbottom() ?>
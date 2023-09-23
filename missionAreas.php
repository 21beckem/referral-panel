<?php
    session_start();
    if (!$_SESSION['missionSignedIn']) {
        header('location: login.php');
    }
    require_once('panel_maker.php');
    require_once('sql_tools.php');
    require_once('overall_vars.php');

    makeHTMLtop('Mission Areas');

    $missionAreas = readSQL($_SESSION['missionInfo']->mykey, 'SELECT * FROM `mission_areas` ORDER BY `mission_areas`.`name` ASC');

    $tableCols = readTableColumns($_SESSION['missionInfo']->mykey, 'mission_areas');
?>
<link href="MYbootstrap.css" rel="stylesheet">
<script src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
<script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/bootstrap3-editable/js/bootstrap-editable.js"></script>
<style>
#data_table {
    width: fit-content;
    margin-top: 5px;
    border-spacing: 0px 0px;
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
    top: 83px;
    box-shadow: 1px 2px 10px -7px rgba(0, 0, 0, 0.5);
}
.btn-primary {
    color: #fff;
    background-color: #ca43ff;
    border-color: transparent;
}
.btn-primary:hover, .btn-primary:focus {
    background-color: #b037df;
    border-color: transparent;
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
    <h2>Mission Areas</h2>
    <img src="img/logo.png" alt="">
</div>
<div class="dash-content">
<table id="data_table" class="table table-bordered table-striped">
    <tr class="header">
        <td></td>
        <td>Area Name</td>
        <td>Area Phone</td>
    </tr>
    <tbody id="employee_data"></tbody>
</table>
<button id="manualAddBtn" class="purpleBtn" onclick="addNewRow()">Add New Area</button>
<script>
function _(x) { return document.getElementById(x); }
HTMLCollection.prototype.forEach = function (x) { return Array.from(this).forEach(x); }
const tableCols = <?php echo(json_encode( $tableCols )); ?>;


function deleteRow(rowId, nam) {
    JSAlert.confirm('Are you sure you want to delete this? This cannot be undone!', '', JSAlert.Icons.Warning)
    .then(res => {
        if (res) {
            fetch('saving_functions/missionAreas_rm.php?pk='+rowId).then(res => {
                window.location.reload();
            });
        }
    });
}
function addNewRow() {
    fetch('saving_functions/missionAreas_new.php').then(res => {
        window.location.reload();
    });
}

function make_table(data) {
    let html_data = '';
    for (let i=0; i<data.length; i++) {
        const row = data[i];

        html_data += '<tr><td><button class="delBtn" onclick="deleteRow('+row[0]+')"><i class="fa-solid fa-trash-can"></i></button></td>';
        
        html_data += '<td data-name="'+tableCols[1]+'" class="textEditable" data-type="text" data-pk="'+row[0]+'">'+row[1]+'</td>';
        html_data += '<td data-name="'+tableCols[2]+'" class="textEditable" data-type="text" data-pk="'+row[0]+'">'+row[2]+'</td>';

        html_data += '</tr>';
    }
    $('#employee_data').append(html_data);
}
make_table(<?php echo(json_encode( $missionAreas )); ?>);
$('#employee_data').editable({ // textEditable class is now editable
    container: 'body',
    selector: 'td.textEditable',
    url: "saving_functions/missionAreas_update.php",
    title: 'Edit Cell',
    type: "GET",
    dataType: 'json'
});

</script>
</div>

<?php makeHTMLbottom() ?>
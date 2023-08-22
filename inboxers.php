<?php
    session_start();
    if (!$_SESSION['missionSignedIn']) {
        header('location: login.php');
    }
    require_once('panel_maker.php');
    require_once('sql_tools.php');
    require_once('overall_vars.php');
    makeHTMLtop('Inboxers');

    // get teams info
    $teamInfos = readSQL($_SESSION['missionInfo']->mykey, 'SELECT * FROM `teams` WHERE 1');
?>
<style>
#inboxersParentParent {
    margin-left: auto;
    margin-right: auto;
    position: relative;
    min-width: 600px;
    width: 100%;
    max-width: 1200px;
}
#inboxersParent {
    width: 100%;
    border-spacing: 0 10px;
}
#inboxersParent tr.editing input, #inboxersParent tr.editing select {
    background-color: #f9f9f9;
    cursor: auto;
    pointer-events: auto;
}
#inboxersParent tr.editing .delBtn {
    display: none;
}
#inboxersParent tr:not(.editing) .escBtn {
    display: none;
}
#inboxersParent tr.editing .editBtn {
    display: none;
}
#inboxersParent tr:not(.editing) .saveBtn {
    display: none;
}
#inboxersParent tr.disabled {
    cursor: default;
    pointer-events: none;
    opacity: 0.5;
}
#inboxersParent tr:not(:first-child) {
    box-shadow: 2px 5px 10px -7px rgba(0, 0, 0, 0.5);
}
#inboxersParent td:first-child {
    width: 50px;
}
#inboxersParent tr:first-child td {
    padding: 0px 10px;
}
#inboxersParent tr:not(:first-child) td {
    padding: 10px;
}
#addNewTeam {
    position: absolute;
    right: 10px;
    padding: 5px 10px;
}
#addNewTeam.disabled {
    cursor: default;
    pointer-events: none;
    opacity: 0.5;
}
.editBtn, .saveBtn, .delBtn, .escBtn {
    border: none;
    background-color: transparent;
    cursor: pointer;
}
input[type=text], select {
    pointer-events: none;
    background-color: transparent;
    border-radius: 3px;
    border: none;
    padding: 5px;
    width: 100%;
}
#inboxersParent tr:not(.editing) select {
  -webkit-appearance: none;
  -moz-appearance: none;
  text-indent: 1px;
  text-overflow: '';
}
</style>
<div class="top">
    <i class="fa-solid fa-bars sidebar-toggle"></i>
    <h2>Referral Panel</h2>
    <img src="img/logo.png" alt="">
</div>

<div class="dash-content">
        <div id="inboxersParentParent">
            <table id="inboxersParent">
                <tr>
                    <td>Area Name</td><td>Email</td><td>Color</td><td>Role</td><td></td>
                </tr>
                <tr style="background-color: cyan;">
                    <td><input type="text" value="Hägersten"></td>
                    <td><input type="text" value="1234567@missionary.org"></td>
                    <td><select><option>Red</option></select></td>
                    <td><select><option>Standard</option></select></td>
                    <td><i class="fa-solid fa-trash-can"></i></td>
                </tr>
                <tr style="background-color: red;">
                    <td><input type="text" value="Hägersten"></td>
                    <td><input type="text" value="1234567@missionary.org"></td>
                    <td><select><option>Red</option></select></td>
                    <td><select><option>Standard</option></select></td>
                    <td><i class="fa-solid fa-trash-can"></i></td>
                </tr>
            </table>
            <br>
            <button id="addNewTeam" class="purpleBtn" onclick="addNewTeam()">Add New Team</button>
            <br>
            <form id="hiddenForm" action="saving_functions/inboxers_save.php" method="POST">
                <input type="hidden" id="hiddenSavingEl" name="saveIt">
            </form>
        </div>
        <script>
function _(x) { return document.getElementById(x); }
HTMLCollection.prototype.forEach = function (x) { return Array.from(this).forEach(x); }
const InboxColors = <?php echo(json_encode($InboxColors)); ?>;
let teamInfos = <?php echo(json_encode($teamInfos)) ?>;
const roleOptions = ['Standard', 'Leader', 'Follow-up Saver'];

let inboxersParent = _('inboxersParent');
let hiddenForm = _('hiddenForm');
let hiddenSavingEl = _('hiddenSavingEl');

// make team color lookup
let teamColorLookup = {};
for (let i = 0; i < teamInfos.length; i++) {
    teamColorLookup[ teamInfos[i][1] ] = teamInfos[i][3];
}
function colorForTeam(team) {
    if (teamColorLookup.hasOwnProperty(team)) {
        return InboxColors[ teamColorLookup[team] ];
    } else { return ''; }
}

function makeInboxersList() {
    let toPaste = '<tr><td>Id</td><td>Area Name</td><td>Email</td><td>Color</td><td>Role</td><td></td></tr>';
    for (let i = 0; i < teamInfos.length; i++) {
        const tm = teamInfos[i];

        // make colors list
        let clrList = '';
        for (let i = 0; i < Object.keys(InboxColors).length; i++) {
            const clr = Object.keys(InboxColors)[i];
            clrList += '<option'+ ((tm[3] == clr) ? ' selected>':'>') +clr+'</option>';
        }
        // make role list
        let rolList = '';
        for (let i = 0; i < roleOptions.length; i++) {
            const rol = roleOptions[i];
            rolList += '<option'+ ((tm[4] == rol) ? ' selected>':'>') +rol+'</option>';
        }

        toPaste += `
            <tr style="background-color: `+InboxColors[tm[3]]+`;">
                <td>`+tm[0]+`</td>
                <td><input type="text" value="`+tm[1]+`"></td>
                <td><input type="text" value="`+tm[2]+`"></td>
                <td><select onchange="updateTeamColorBackground(this.parentElement.parentElement, this.value)">`+clrList+`</select></td>
                <td><select>`+rolList+`</select></td>
                <td>
                    <button class="editBtn" onclick="enableEdits(this.parentElement.parentElement)" title="Edit Team"><i class="fa-solid fa-pen-to-square"></i></button>
                    <button class="saveBtn" onclick="saveEdits(this.parentElement.parentElement,`+tm[0]+`)" title="Save Edits"><i class="fa-solid fa-floppy-disk"></i></button>
                </td>
                <td>
                    <button class="delBtn" onclick="deleteTeam('`+tm[1]+`', `+tm[0]+`)" title="Delete Team"><i class="fa-solid fa-trash-can"></i></button>
                    <button class="escBtn" onclick="discardChanges()" title="Undo Changes"><i class="fa-solid fa-rotate-left"></i></button>
                </td>
            </tr>`;
    }
    inboxersParent.innerHTML = toPaste;
}
function updateTeamColorBackground(tr, col) {
    tr.style.backgroundColor = InboxColors[col];
}
function enableEdits(tr) {
    document.querySelectorAll('#inboxersParent tr').forEach(x => {
        x.classList.remove('editing');
        if (x != tr) {
            x.classList.add('disabled');
        }
    });
    _('addNewTeam').classList.add('disabled');
    tr.classList.add('editing');
    console.log(tr);
}
function saveEdits(tr, tmId) {
    let saveVals = Array();
    tr.children.forEach(x=>{
        let input = x.querySelector('input, select');
        if (input != null) {
            saveVals.push( input.value );
        }
    });
    saveVals.unshift(tmId);
    hiddenSavingEl.value = JSON.stringify(saveVals);
    hiddenForm.submit();
}
function addNewTeam() {
    teamInfos.push( [0, '', '', Object.keys(InboxColors)[0], roleOptions[0]] );
    makeInboxersList();
    enableEdits( inboxersParent.querySelector('tr:last-child') );
}
function deleteTeam(nm, tmId) {
    if (confirm("Are you sure you want to delete "+nm+' from Referral Suite? This action cannot be undone!')) {
        hiddenSavingEl.value = tmId;
        hiddenForm.action = 'saving_functions/inboxers_delete.php';
        hiddenForm.submit();
    }
}
function discardChanges() {
    _('addNewTeam').classList.remove('disabled');
    makeInboxersList();
}
makeInboxersList();
    </script>
</div>

<?php makeHTMLbottom() ?>
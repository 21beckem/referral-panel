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
    cursor: auto;
    pointer-events: auto;
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
.editBtn, .saveBtn, .delBtn {
    border: none;
    background-color: transparent;
    cursor: pointer;
}
input[type=text], select {
    pointer-events: none;
    background-color: #f9f9f9;
    border: none;
    padding: 5px;
    width: 100%;
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
            <button id="addNewTeam" class="purpleBtn">Add New Team</button>
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

let inboxersParent = _('inboxersParent');
let hiddenForm = _('hiddenForm');

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
    let toPaste = '<tr><td>Area Name</td><td>Email</td><td>Color</td><td>Role</td><td></td></tr>';
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
        const roles = ['Standard', 'Leader', 'Follow-up Saver'];
        for (let i = 0; i < roles.length; i++) {
            const rol = roles[i];
            rolList += '<option'+ ((tm[4] == rol) ? ' selected>':'>') +rol+'</option>';
        }

        toPaste += `
            <tr style="background-color: `+colorForTeam(tm[1])+`;">
                <td><input type="text" value="`+tm[1]+`"></td>
                <td><input type="text" value="`+tm[2]+`"></td>
                <td><select onchange="updateTeamColorBackground(this.parentElement.parentElement, this.value)">`+clrList+`</select></td>
                <td><select>`+rolList+`</select></td>
                <td>
                    <button class="editBtn" onclick="enableEdits(this.parentElement.parentElement)"><i class="fa-solid fa-pen-to-square"></i></button>
                    <button class="saveBtn" onclick="saveEdits(`+i+`)"><i class="fa-solid fa-floppy-disk"></i></button>
                </td>
                <td><button class="delBtn"><i class="fa-solid fa-trash-can"></i></button></td>
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
    tr.classList.add('editing');
    console.log(tr);
}
function saveEdits(tr, tmId) {

}
makeInboxersList();
    </script>
</div>

<?php makeHTMLbottom() ?>
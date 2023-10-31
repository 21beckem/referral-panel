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
.sidenav {
    width: 170px;
    position: absolute;
    z-index: 1;
    left: 0px;
    overflow-x: hidden;
    padding: 8px 0;
}

.sidenav div {
    cursor: pointer;
    width: calc(100% - 10px);
    padding: 6px 8px;
    margin-bottom: 5px;
    text-decoration: none;
    font-size: 23px;
    display: block;
}
.sidenav div.active {
    width: 100%;
    border-radius: 0 10px 10px 0;
}
.sidenav button {
    border: none;
    padding: 6px 8px;
    margin-left: 0;
    border-top-left-radius: 0px;
    border-bottom-left-radius: 0px;
}

#teamInfoMainParent {
    margin-left: 180px;
    padding: 0px 10px;
    height: calc(100vh - 90px);
    overflow-y: scroll;
}
#topHalfPage {
    box-shadow: 1px 2px 12px -7px rgba(0, 0, 0, 0.5);
    display: flex;
    flex-direction: column;
    max-width: 550px;
    width: 70%;
    margin: 0 auto 0 auto;
}
#infoForm {
    width: 100%;
    padding: 15px;
}
#profilePic {
    position: relative;
    background-color: #f3f3f3;
    background-size: contain;
    margin: 20px auto 30px auto;
    border-radius: 50%;
    width: 80px;
    height: 80px;
}
#profilePic select {
    -moz-appearance: none;
    -webkit-appearance: none;
    position: absolute;
    width: 100%;
    height: 100%;
    background-color: transparent;
    border-radius: 50%;
    color: transparent;
    border: none;
    cursor: pointer;
}
#profilePic select:focus {
    outline: none;
}
#profilePic select option {
    color: black;
}
#profilePic:hover i {
    opacity: 0.4;
}
#profilePic i {
    pointer-events: none;
    text-align: center;
    color: white;
    width: 100%;
    height: 80px;
    font-size: 25px;
    padding: 37% 0px;
    position: absolute;
    top: 0;
    left: 0;
    border: none;
    background-color: black;
    opacity: 0;
    border-radius: 50%;
}
#infoForm .niceInput {
    width: 100%;
    padding: 3px;
    border-radius: 5px;
    border: 1px solid gray;
    margin-top: 3px;
    margin-bottom: 20px;
}
#statsBoxes {
    filter: opacity(0.2);
}
.box {
    margin-bottom: 20px !important;
}
#delBtn {
    float: right;
    margin: 10px;
    padding: 5px 20px;
    border-radius: 5px;
    cursor: pointer;
    color: #ff4c4c;
    border: solid 2px #ff4c4c;
    background-color: white;
    transition: all 0.5s ease
}
#delBtn:hover {
    color: white;
    border: solid 2px transparent;
    background-color: #ff4c4c;
}
</style>
<div class="top">
    <i class="fa-solid fa-bars sidebar-toggle"></i>
    <h2>Inboxers</h2>
    <img src="img/logo.png" alt="">
</div>

<div class="dash-content">
    <div id="teamBtns" class="sidenav">
        <?php
        foreach ($teamInfos as $i => $row) {
            $act = '';
            if ($row[0]==$_GET['id']) { $act = 'class="active"'; }
            echo('<div id="teamSelectBtn_'.$row[0].'" '.$act.' href="inboxers.php?id='.$row[0].'" onclick="location.href=this.getAttribute(\'href\')" style="background-color: '.$InboxColors[$row[3]].'">'.$row[1].'</div>');
        }
        ?>
        <button onclick="openThisTeam('new')" class="purpleBtn">Add Team</button>
    </div>

<div id="teamInfoMainParent" style="opacity:0">
    <div id="topHalfPage">
        <form id="infoForm" method="POST" action="saving_functions/inboxers_save.php">
            <div id="profilePic">
                <select onchange="updateProfileColor()" name="color" id="profilePicColor">
                    <?php
                    foreach ($InboxColors as $col => $hex) {
                        echo('<option>'.$col.'</option>');
                    }
                    ?>
                </select>
                <i class="fa-solid fa-pencil"></i>
            </div>

            <label for="id">Unique Id: </label>
            <input class="niceInput" type="text" name="id" id="uniqueIdIn" value="3" style="background-color: #e2e2e2; text-align: center; pointer-events: none;">
            <br><br>
            <label for="name">Name:</label><br>
            <input class="niceInput" type="text" name="name" id="nameIn">
            <br>
            <label for="email">Email:</label><br>
            <input class="niceInput" type="email" name="email" id="emailIn">
            <br>
            <input type="submit" class="purpleBtn" style="padding: 5px 15px; font-size: 17px" value="Save">
        </form>
        <form action="saving_functions/inboxers_delete.php" method="POST" onsubmit="return deleteThisTeam(event)" id="hiddenDeleteForm">
            <input type="hidden" name="id" id="deleteIdEl">
            <input type="submit" id="delBtn" value="Delete Team">
        </form>
    </div>

    <div id="statsBoxes" class="boxes" style="padding-top: 30px;">
        <div class="box box1">
            <span class="text">Currently Claimed</span>
            <span class="number">0</span>
        </div>
        <div class="box box2">
            <span class="text">Avg Contact Time</span>
            <span class="number">0 min</span>
        </div>
        <div class="box box1">
            <span class="text">Percent Sent</span>
            <span class="number">0%</span>
        </div>
        <div class="box box2">
            <span class="text">Total Ever Claimed</span>
            <span class="number">0</span>
        </div>
        <div class="box box1">
            <span class="text">Avg Send Time</span>
            <span class="number">0 days</span>
        </div>
        <div class="box box2">
            <span class="text">Percent Deceased</span>
            <span class="number">0%</span>
        </div>
    </div>
</div>
<script>
function _(x) { return document.getElementById(x); }
HTMLCollection.prototype.forEach = function (x) { return Array.from(this).forEach(x); }
let teamBtnsEl = _('teamBtns');
let teamInfoMainParent = _('teamInfoMainParent');
let profilePicEl = _('profilePic');
let profilePicColor = _('profilePicColor');
let uniqueIdIn = _('uniqueIdIn');
let nameIn = _('nameIn');
let emailIn = _('emailIn');
let roleIn = _('roleIn');

let streakNum = _('streakNum');
let inbucksNum = _('inbucksNum');

const TeamRoles = <?php echo(json_encode($TeamRoles)); ?>;
const InboxColors = <?php echo(json_encode($InboxColors)); ?>;
const teamInfos = <?php echo(json_encode($teamInfos)); ?>;
const teamBtnsHTML = teamBtnsEl.innerHTML;


function openThisTeam(tmId) {
    let thisTeam = teamInfos.filter(x => x[0]==parseInt(tmId))[0];
    if (tmId=='new') {
        thisTeam = ['auto-generated', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''];
    }
    teamBtnsEl.innerHTML = teamBtnsHTML;
    teamInfoMainParent.style.opacity = 1;
    
    uniqueIdIn.value = thisTeam[0];
    uniqueIdIn.style.width = ((uniqueIdIn.value.length * 8)+20) + 'px';
    profilePicColor.value = (thisTeam[3]=='') ? profilePicColor.options[0].value : thisTeam[3];
    updateProfileColor();
    nameIn.value = thisTeam[1];
    emailIn.value = thisTeam[2];

    _('deleteIdEl').value = thisTeam[0];
}

function updateProfileColor() {
    profilePicEl.style.backgroundImage = 'url("https://21beckem.github.io/referral-suite/img/fox_profile_pics/'+profilePicColor.value+'.svg")';
    try {
        _('teamSelectBtn_'+uniqueIdIn.value).style.backgroundColor = InboxColors[ profilePicColor.value ];
    } catch (e) {}
        
}

function deleteThisTeam(e) {
    e.preventDefault();
    let customAlert = new JSAlert("Are you sure you want to delete this team? All "+'num'+" referrals that this team has claimed will be lost!");
    customAlert.addButton("Yes").then(function() {
        _('hiddenDeleteForm').submit();
    });
    customAlert.addButton("No");
    customAlert.show();
    return false;
}

<?php
if (isset($_GET['id'])) {
    echo('openThisTeam('.$_GET['id'].');');
}
?>

</script>

<?php makeHTMLbottom() ?>
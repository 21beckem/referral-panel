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
    top: 0px;
    left: 0px;
    overflow-x: hidden;
    padding: 8px 0;
}

.sidenav div {
    cursor: pointer;
    width: 100%;
    padding: 6px 8px;
    margin-bottom: 5px;
    text-decoration: none;
    font-size: 23px;
    display: block;
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
}
#infoForm {
    width: 70%;
    padding: 15px;
}
#foxDataParent {
    position: relative;
    width: 30%;
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
#infoForm input[type=text] {
    width: 70%;
    padding: 3px;
    border-radius: 5px;
    border: 1px solid gray;
    margin-top: 3px;
    margin-bottom: 20px;
}
#streakNum {
    position: absolute;
    top: 10px;
    width: 100%;
    font-size: 50px;
    color: #f203ff;
    font-weight: bold;
    text-align: center;
}
#inbucksNum {
    width: 100%;
    font-size: 50px;
    color: #156f2b;
    font-weight: bold;
    text-align: center;
}
#inbucksNum::before {
    font-size: 20px;
    content: "$";
    color: #508d009c;
}
#inbucksNum::after {
    font-size: 20px;
    content: "$";
    color: transparent;
}
#streakImg {
    width: 100%;
    height: 70px;
    margin-top: 80px;
    background-repeat: no-repeat;
    background-position: center;
    transform: TranslateY(-40px);
    background-size: contain;
    background-image: url('https://ssmission.github.io/referral-suite/img/streak1.png')
}
#inbucksImg {
    width: 100%;
    height: 70px;
    margin-top: 30px;
    background-repeat: no-repeat;
    background-position: center;
    transform: TranslateY(-40px);
    background-size: contain;
    background-image: url('https://ssmission.github.io/referral-suite/img/inbucks1.png')
}
.box {
    margin-bottom: 20px !important;
}
</style>
<div class="top">
    <i class="fa-solid fa-bars sidebar-toggle"></i>
    <h2>Referral Panel</h2>
    <img src="img/logo.png" alt="">
</div>

<div class="dash-content">
    <div class="sidenav">
        <?php
        foreach ($teamInfos as $i => $row) {
            echo('<div onclick="" style="background-color: '.$InboxColors[$row[3]].'">'.$row[1].'</div>');
        }
        ?>
        <button class="purpleBtn">Add Team</button>
    </div>

<div id="teamInfoMainParent">
    <div id="topHalfPage">
        <form id="infoForm">
            <div id="profilePic">
                <select onchange="updateProfileColor()" name="profilePicColor" id="profilePicColor">
                    <?php
                    foreach ($InboxColors as $col => $hex) {
                        echo('<option>'.$col.'</option>');
                    }
                    ?>
                </select>
                <i class="fa-solid fa-pencil"></i>
            </div>

            <label for="uniqueId">Unique Id: </label>
            <input type="text" name="uniqueId" id="uniqueIdIn" disabled value="3" style="background-color: #e2e2e2; text-align: center">
            <br><br>
            <label for="name">Name:</label><br>
            <input type="text" name="name" id="nameIn">
            <br>
            <label for="email">Email:</label><br>
            <input type="text" name="email" id="emailIn">
            <br>
            <input type="submit" class="purpleBtn" style="padding: 5px 15px; font-size: 17px" value="Save">
        </form>
        <div id="foxDataParent">
            <div id="streakNum">43</div>
            <div id="streakImg"></div>

            <div id="inbucksNum">926</div>
            <div id="inbucksImg"></div>
            <center>
                <button class="purpleBtn" style="padding: 5px 15px; font-size: 17px; margin: auto">Clear Fox Data</button>
            </center>
        </div>
    </div>

    <div id="statsBoxes" class="boxes" style="padding-top: 50px;">
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
let teamInfoMainParent = _('teamInfoMainParent');
let profilePicEl = _('profilePic');
let profilePicColor = _('profilePicColor');
let uniqueIdIn = _('uniqueIdIn');
let nameIn = _('nameIn');
let emailIn = _('emailIn');

let streakNum = _('streakNum');
let inbucksNum = _('inbucksNum');

const InboxColors = <?php echo(json_encode($InboxColors)); ?>;
const teamInfos = <?php echo(json_encode($teamInfos)); ?>;

function updateProfileColor() {
    profilePicEl.style.backgroundImage = 'url("https://ssmission.github.io/referral-suite/img/fox_profile_pics/'+profilePicColor.value+'.svg")';
}

uniqueIdIn.style.width = ((uniqueIdIn.value.length * 8)+20) + 'px';
</script>

<?php makeHTMLbottom() ?>
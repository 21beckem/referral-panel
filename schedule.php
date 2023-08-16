<?php
    session_start();
    if (!$_SESSION['missionSignedIn']) {
        header('location: login.php');
    }
    require_once('panel_maker.php');
    require_once('sql_tools.php');
    makeHTMLtop('Schedule');

    // get schedule
    $rawSQLread = readSQL($_SESSION['missionInfo']->mykey, "SELECT * FROM `schedule` WHERE 1")[0][0];
    $schedArr = json_decode($rawSQLread);
    if ($schedArr == NULL) {
        $schedArr = json_decode('[["", "", "2002-10-22"], ["10:00", "11:00", ""]]');
    }
    //var_dump($schedArr);

    // get teams info
    $teamInfos = readSQL($_SESSION['missionInfo']->mykey, 'SELECT * FROM `teams` WHERE 1');
?>
<link rel="stylesheet" href="schedule.css">
<div class="top">
    <i class="fa-solid fa-bars sidebar-toggle"></i>
    <h2>Referral Panel</h2>
    <img src="img/logo.png" alt="">
</div>

<div class="dash-content">
    <table id="topBtns">
        <tr>
            <td><div>
                <label for="strtDateIn">Transfer Start Date</label> <input name="strtDateIn" id="strtDateIn" type="date"> <button class="purpleBtn">GO</button>
                <br><br>
                <label for="shftsInDay">Shifts In A Day</label> <input name="shftsInDay" id="shftsInDay" type="number"> <button class="purpleBtn">GO</button>
            </div></td>
            <td><div>
                <label>Copy First Week Onward</label> <button class="purpleBtn">GO</button>
            </div></td>
        </tr>
    </table>
    <div id="FullTableParent">
        <table id="timesCol">
            <tr></tr>
            <tr>
                <td><input type="time"></td><td><input type="time"></td>
            </tr>
            <tr>
                <td><input type="time"></td><td><input type="time"></td>
            </tr>
            <tr>
                <td><input type="time"></td><td><input type="time"></td>
            </tr>
            <tr>
                <td><input type="time"></td><td><input type="time"></td>
            </tr>
            <tr>
                <td><input type="time"></td><td><input type="time"></td>
            </tr>
            <tr>
                <td><input type="time"></td><td><input type="time"></td>
            </tr>
        </table>
        <div id="tbleWin">
            <table id="schTble">
                <tr>
                    <td><button onclick="this.nextElementSibling.classList.toggle('open')">v</button>Tuesday, Augest 15<clipbox><button>Copy Day</button><button>Paste Day</button></clipbox></td><td><button>v</button>Wednesday, Augest 16</td><td><button>v</button>Thursday, Augest 17</td><td><button>v</button>Tuesday, Augest 15</td><td><button>v</button>Wednesday, Augest 16</td><td><button>v</button>Thursday, Augest 17</td><td><button>v</button>Tuesday, Augest 15</td><td><button>v</button>Wednesday, Augest 16</td><td><button>v</button>Thursday, Augest 17</td><td><button>v</button>Tuesday, Augest 15</td><td><button>v</button>Wednesday, Augest 16</td><td><button>v</button>Thursday, Augest 17</td><td><button>v</button>Tuesday, Augest 15</td><td><button>v</button>Wednesday, Augest 16</td><td><button>v</button>Thursday, Augest 17</td><td><button>v</button>Tuesday, Augest 15</td><td><button>v</button>Wednesday, Augest 16</td><td><button>v</button>Thursday, Augest 17</td><td><button>v</button>Tuesday, Augest 15</td><td><button>v</button>Wednesday, Augest 16</td><td><button>v</button>Thursday, Augest 17</td><td><button>v</button>Tuesday, Augest 15</td><td><button>v</button>Wednesday, Augest 16</td><td><button>v</button>Thursday, Augest 17</td>
                </tr>
                <tr>
                    <td><select><option>Hägersten</option></select></td><td><select><option>SMOEs</option></select></td><td><select><option>Gävle</option></select></td><td><select><option>Hägersten</option></select></td><td><select><option>SMOEs</option></select></td><td><select><option>Gävle</option></select></td><td><select><option>Hägersten</option></select></td><td><select><option>SMOEs</option></select></td><td><select><option>Gävle</option></select></td><td><select><option>Hägersten</option></select></td><td><select><option>SMOEs</option></select></td><td><select><option>Gävle</option></select></td><td><select><option>Hägersten</option></select></td><td><select><option>SMOEs</option></select></td><td><select><option>Gävle</option></select></td><td><select><option>Hägersten</option></select></td><td><select><option>SMOEs</option></select></td><td><select><option>Gävle</option></select></td><td><select><option>Hägersten</option></select></td><td><select><option>SMOEs</option></select></td><td><select><option>Gävle</option></select></td><td><select><option>Hägersten</option></select></td><td><select><option>SMOEs</option></select></td><td><select><option>Gävle</option></select></td>
                </tr>
                <tr>
                    <td><select><option>Hägersten</option></select></td><td><select><option>SMOEs</option></select></td><td><select><option>Gävle</option></select></td><td><select><option>Hägersten</option></select></td><td><select><option>SMOEs</option></select></td><td><select><option>Gävle</option></select></td><td><select><option>Hägersten</option></select></td><td><select><option>SMOEs</option></select></td><td><select><option>Gävle</option></select></td><td><select><option>Hägersten</option></select></td><td><select><option>SMOEs</option></select></td><td><select><option>Gävle</option></select></td><td><select><option>Hägersten</option></select></td><td><select><option>SMOEs</option></select></td><td><select><option>Gävle</option></select></td><td><select><option>Hägersten</option></select></td><td><select><option>SMOEs</option></select></td><td><select><option>Gävle</option></select></td><td><select><option>Hägersten</option></select></td><td><select><option>SMOEs</option></select></td><td><select><option>Gävle</option></select></td><td><select><option>Hägersten</option></select></td><td><select><option>SMOEs</option></select></td><td><select><option>Gävle</option></select></td>
                </tr>
                <tr>
                    <td><select><option>Hägersten</option></select></td><td><select><option>SMOEs</option></select></td><td><select><option>Gävle</option></select></td><td><select><option>Hägersten</option></select></td><td><select><option>SMOEs</option></select></td><td><select><option>Gävle</option></select></td><td><select><option>Hägersten</option></select></td><td><select><option>SMOEs</option></select></td><td><select><option>Gävle</option></select></td><td><select><option>Hägersten</option></select></td><td><select><option>SMOEs</option></select></td><td><select><option>Gävle</option></select></td><td><select><option>Hägersten</option></select></td><td><select><option>SMOEs</option></select></td><td><select><option>Gävle</option></select></td><td><select><option>Hägersten</option></select></td><td><select><option>SMOEs</option></select></td><td><select><option>Gävle</option></select></td><td><select><option>Hägersten</option></select></td><td><select><option>SMOEs</option></select></td><td><select><option>Gävle</option></select></td><td><select><option>Hägersten</option></select></td><td><select><option>SMOEs</option></select></td><td><select><option>Gävle</option></select></td>
                </tr>
                <tr>
                    <td><select><option>Hägersten</option></select></td><td><select><option>SMOEs</option></select></td><td><select><option>Gävle</option></select></td><td><select><option>Hägersten</option></select></td><td><select><option>SMOEs</option></select></td><td><select><option>Gävle</option></select></td><td><select><option>Hägersten</option></select></td><td><select><option>SMOEs</option></select></td><td><select><option>Gävle</option></select></td><td><select><option>Hägersten</option></select></td><td><select><option>SMOEs</option></select></td><td><select><option>Gävle</option></select></td><td><select><option>Hägersten</option></select></td><td><select><option>SMOEs</option></select></td><td><select><option>Gävle</option></select></td><td><select><option>Hägersten</option></select></td><td><select><option>SMOEs</option></select></td><td><select><option>Gävle</option></select></td><td><select><option>Hägersten</option></select></td><td><select><option>SMOEs</option></select></td><td><select><option>Gävle</option></select></td><td><select><option>Hägersten</option></select></td><td><select><option>SMOEs</option></select></td><td><select><option>Gävle</option></select></td>
                </tr>
                <tr>
                    <td><select><option>Hägersten</option></select></td><td><select><option>SMOEs</option></select></td><td><select><option>Gävle</option></select></td><td><select><option>Hägersten</option></select></td><td><select><option>SMOEs</option></select></td><td><select><option>Gävle</option></select></td><td><select><option>Hägersten</option></select></td><td><select><option>SMOEs</option></select></td><td><select><option>Gävle</option></select></td><td><select><option>Hägersten</option></select></td><td><select><option>SMOEs</option></select></td><td><select><option>Gävle</option></select></td><td><select><option>Hägersten</option></select></td><td><select><option>SMOEs</option></select></td><td><select><option>Gävle</option></select></td><td><select><option>Hägersten</option></select></td><td><select><option>SMOEs</option></select></td><td><select><option>Gävle</option></select></td><td><select><option>Hägersten</option></select></td><td><select><option>SMOEs</option></select></td><td><select><option>Gävle</option></select></td><td><select><option>Hägersten</option></select></td><td><select><option>SMOEs</option></select></td><td><select><option>Gävle</option></select></td>
                </tr>
                <tr>
                    <td><select><option>Hägersten</option></select></td><td><select><option>SMOEs</option></select></td><td><select><option>Gävle</option></select></td><td><select><option>Hägersten</option></select></td><td><select><option>SMOEs</option></select></td><td><select><option>Gävle</option></select></td><td><select><option>Hägersten</option></select></td><td><select><option>SMOEs</option></select></td><td><select><option>Gävle</option></select></td><td><select><option>Hägersten</option></select></td><td><select><option>SMOEs</option></select></td><td><select><option>Gävle</option></select></td><td><select><option>Hägersten</option></select></td><td><select><option>SMOEs</option></select></td><td><select><option>Gävle</option></select></td><td><select><option>Hägersten</option></select></td><td><select><option>SMOEs</option></select></td><td><select><option>Gävle</option></select></td><td><select><option>Hägersten</option></select></td><td><select><option>SMOEs</option></select></td><td><select><option>Gävle</option></select></td><td><select><option>Hägersten</option></select></td><td><select><option>SMOEs</option></select></td><td><select><option>Gävle</option></select></td>
                </tr>
            </table>
        </div>
    </div>
    <button id="saveBtn" class="purpleBtn">Save to Referral Suite</button>
    <script>
function _(x) { return document.getElementById(x); }
let strtDateInEl = _('strtDateIn');
let shftsInDayEl = _('shftsInDay');
let timesColEl = _('timesCol');
let schTbleEl = _('schTble');
const InboxColors = {
    'teal' : '#00FFFF',
    'orange' : '#F6B26B',
    'lavender' : '#CAB7FC',
    'red' : '#E06666',
    'purple' : '#BF60FF',
    'green' : '#B5D7A8',
    'light-green' : '#C5FF8A',
    'pink' : '#D5A6BD',
    'yellow' : '#FFE599'
}

let schedArr = <?php echo(json_encode($schedArr)); ?>;
let teamInfos = <?php echo(json_encode($teamInfos)); ?>;

// make team color lookup
let teamColorLookup = {};
for (let i = 0; i < teamInfos.length; i++) {
    teamColorLookup[ teamInfos[i][1] ] = teamInfos[i][3];
}

function setAllValuesAndTables() {
    // set first date
    strtDateInEl.value = schedArr[0][2];
    
    // set shifts in day
    shftsInDayEl.value = schedArr.length - 1;

    // make times cols
    let timesColOutput = '<tr></tr>';
    for (let i = 1; i < schedArr.length; i++) {
        timesColOutput += '<tr><td><input type="time" value="' + schedArr[i][0] + '"></td><td><input type="time" value="' + schedArr[i][1] + '"></td></tr>'
    }
    timesColEl.innerHTML = timesColOutput;
    
    
    // make HTML table (first row)
    const monthNames = ["January","February","March","April","May","June","July","August","September","October","November","December"];
    const dayNames = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
    let mainTbOut = '<tr>';
    for (let i = 2; i < schedArr[0].length; i++) {
        const thisDate = new Date(schedArr[0][i]);
        const niceDate = dayNames[thisDate.getDay()] + '\n' + monthNames[thisDate.getMonth()] + ' ' + String(thisDate.getDate());
        mainTbOut += '<td><button onclick="this.nextElementSibling.classList.toggle(\'open\')">v</button>' + niceDate;
        mainTbOut += '<clipbox><button>Copy Day</button><button>Paste Day</button></clipbox></td>';
    }
    mainTbOut += '</tr>';


    // make HTML table (main table)
    for (let i = 1; i < schedArr.length; i++) {
        const row = schedArr[i];
        mainTbOut += '<tr>';
        for (let j = 2; j < row.length; j++) {
            const cell = row[j];
            // make dropdown list of all inboxers
            let inboxersOptions = '<option></option>';
            for (let k = 0; k < teamInfos.length; k++) {
                const team = teamInfos[k];
                inboxersOptions += '<option'+( (cell==team[1]) ? ' selected' : '' )+'>' + team[1] + '</option>';
            }

            mainTbOut += '<td><select onchange="dropdownOnChange(this)" style="background-color: '+colorForTeam(cell)+';">' + inboxersOptions + '</select></td>';
        }
        mainTbOut += '</tr>';
    }

    schTbleEl.innerHTML = mainTbOut;
}
function colorForTeam(team) {
    if (teamColorLookup.hasOwnProperty(team)) {
        return InboxColors[ teamColorLookup[team] ];
    } else {
        return '';
    }
}

function dropdownOnChange(el) {
    //alert(el.value);
    el.style.backgroundColor = colorForTeam(el.value);
}

setAllValuesAndTables();
    </script>
</div>

<!-- </div><div style="width: 10000px; height: 100px; background-color: black"> -->

<?php makeHTMLbottom() ?>
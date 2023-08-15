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
                    <td><button>v</button>Tuesday,<br>Augest 15</td><td><button>v</button>Wednesday,<br>Augest 16</td><td><button>v</button>Thursday,<br>Augest 17</td><td><button>v</button>Tuesday,<br>Augest 15</td><td><button>v</button>Wednesday,<br>Augest 16</td><td><button>v</button>Thursday,<br>Augest 17</td><td><button>v</button>Tuesday,<br>Augest 15</td><td><button>v</button>Wednesday,<br>Augest 16</td><td><button>v</button>Thursday,<br>Augest 17</td><td><button>v</button>Tuesday,<br>Augest 15</td><td><button>v</button>Wednesday,<br>Augest 16</td><td><button>v</button>Thursday,<br>Augest 17</td><td><button>v</button>Tuesday,<br>Augest 15</td><td><button>v</button>Wednesday,<br>Augest 16</td><td><button>v</button>Thursday,<br>Augest 17</td><td><button>v</button>Tuesday,<br>Augest 15</td><td><button>v</button>Wednesday,<br>Augest 16</td><td><button>v</button>Thursday,<br>Augest 17</td><td><button>v</button>Tuesday,<br>Augest 15</td><td><button>v</button>Wednesday,<br>Augest 16</td><td><button>v</button>Thursday,<br>Augest 17</td><td><button>v</button>Tuesday,<br>Augest 15</td><td><button>v</button>Wednesday,<br>Augest 16</td><td><button>v</button>Thursday,<br>Augest 17</td>
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

let schedArr = <?php echo(json_encode($schedArr)); ?>;
let teamInfos = <?php echo(json_encode($teamInfos)); ?>;

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


// make HTML table
for (let i = 0; i < schedArr[0].length-2; i++) {
    
}


    </script>
</div>

<!-- </div><div style="width: 10000px; height: 100px; background-color: black"> -->

<?php makeHTMLbottom() ?>
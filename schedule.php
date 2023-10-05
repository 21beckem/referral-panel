<?php
    session_start();
    if (!$_SESSION['missionSignedIn']) {
        header('location: login.php');
    }
    require_once('panel_maker.php');
    require_once('sql_tools.php');
    require_once('overall_vars.php');
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
    <h2>Schedule</h2>
    <img src="img/logo.png" alt="">
</div>

<div class="dash-content">
    <table id="topBtns">
        <tr>
            <td><div>
                <label for="strtDateIn">Set Transfer Start Date</label> <input name="strtDateIn" id="strtDateIn" type="date"> <button class="purpleBtn" onclick="setTransferStartDate()">GO</button>
                <br><br>
                <label for="shftsInDay">Set Shifts In A Day</label> <input name="shftsInDay" id="shftsInDay" type="number" min="0"> <button class="purpleBtn" onclick="setShiftsInDay()">GO</button>
            </div></td>
            <td><div>
                <label for="daysInTrans">Set Days this transfer</label> <input name="daysInTrans" id="daysInTrans" type="number" min="1"> <button class="purpleBtn" onclick="setDaysInTransfer()">GO</button>
                <br><br>
                <label>Copy First Week Onward</label> <button class="purpleBtn" onclick="cpyFrstWeekForwards()">GO</button>
            </div></td>
        </tr>
    </table>
    <div id="FullTableParent">
        <table id="timesCol"></table>
        <div id="tbleWin">
            <table id="schTble"></table>
        </div>
    </div>
    <form action="saving_functions/schedule_save.php" method="POST">
        <input type="hidden" id="hiddenSavingEl" name="saveIt">
        <input type="submit" id="saveBtn" class="purpleBtn" onclick="bigSaveBtn()" value="Save to Referral Suite">
    </form>
    <script>
function _(x) { return document.getElementById(x); }
HTMLCollection.prototype.forEach = function (x) { return Array.from(this).forEach(x); }
let strtDateInEl = _('strtDateIn');
let shftsInDayEl = _('shftsInDay');
let timesColEl = _('timesCol');
let schTbleEl = _('schTble');
let daysInTransEl = _('daysInTrans');
let hiddenSavingEl = _('hiddenSavingEl');
const InboxColors = <?php echo(json_encode($InboxColors)); ?>;
let currentCopiedDay = null;
let pstBtnsDisabled = ' disabled';

let schedArr = <?php echo(json_encode($schedArr)); ?>;
let teamInfos = <?php echo(json_encode($teamInfos)); ?>;
teamInfos.unshift(['-2', '~ Other ~', '', 'white', '', '', '0']);

// make team color lookup
let teamColorLookup = {};
for (let i = 0; i < teamInfos.length; i++) {
    teamColorLookup[ teamInfos[i][0] ] = teamInfos[i][3];
}

function setAllValuesAndTables() {
    // set first date
    strtDateInEl.value = schedArr[0][2];
    
    // set shifts in day
    shftsInDayEl.value = schedArr.length - 1;

    // set weeks in transfer
    daysInTransEl.value = (schedArr[0].length-2);

    // make times cols
    let timesColOutput = '<tr></tr>';
    for (let i = 1; i < schedArr.length; i++) {
        timesColOutput += '<tr><td><input type="time" value="' + schedArr[i][0] + '" onchange="saveSetTimeVal(this,'+i+',0)"></td><td><input type="time" value="' + schedArr[i][1] + '" onchange="saveSetTimeVal(this,'+i+',1)"></td></tr>'
    }
    timesColEl.innerHTML = timesColOutput;
    
    
    // make HTML table (first row)
    const monthNames = ["January","February","March","April","May","June","July","August","September","October","November","December"];
    const dayNames = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
    let mainTbOut = '<tr>';
    for (let i = 2; i < schedArr[0].length; i++) {
        const thisDate = new Date(schedArr[0][i]);
        const niceDate = dayNames[thisDate.getDay()] + '<br>' + monthNames[thisDate.getMonth()] + ' ' + String(thisDate.getDate());
        mainTbOut += '<td><button onclick="openCpyDropdown(this)">v</button>';
        mainTbOut += '<clipbox><button class="cpy" onclick="cpyBtn(this, '+i+')">Copy Day</button><button class="pst'+pstBtnsDisabled+'" onclick="pstBtn(this, '+i+')">Paste Day</button></clipbox>'+niceDate+'</td>';
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
                inboxersOptions += '<option value="'+team[0]+'"'+( (cell==team[0]) ? ' selected' : '' )+'>' + team[1] + '</option>';
            }

            mainTbOut += '<td><select onchange="dropdownOnChange(this, '+i+', '+j+')" style="background-color: '+colorForTeam(cell)+';">' + inboxersOptions + '</select></td>';
        }
        mainTbOut += '</tr>';
    }

    hiddenSavingEl.value = JSON.stringify(schedArr);
    schTbleEl.innerHTML = mainTbOut;
}
function colorForTeam(teamId) {
    if (teamColorLookup.hasOwnProperty(teamId)) {
        return InboxColors[ teamColorLookup[teamId] ];
    } else { return ''; }
}
function openCpyDropdown(el) {
    document.querySelectorAll('clipbox').forEach(x => {
        if (el.nextElementSibling != x) {
            x.classList.remove('open');
        }
    });
    el.nextElementSibling.classList.toggle('open');
}

function dropdownOnChange(el, row, col) {
    setDontRefresh(true);
    schedArr[row][col] = el.value;
    el.style.backgroundColor = colorForTeam(el.value);
    hiddenSavingEl.value = JSON.stringify(schedArr);
}

function cpyBtn(el, id) {
    el.parentElement.classList.remove('open');
    document.getElementsByClassName('pst').forEach(x => {
        x.classList.remove('disabled');
    });
    pstBtnsDisabled = '';
    currentCopiedDay = schedArr.map((row) => {
        return row.filter((x, i) => {
            return parseInt(id) == i;
        })[0];
    });
    console.log('copied day: ', currentCopiedDay);
}
function pstBtn(el, id) {
    setDontRefresh(true);
    el.parentElement.classList.remove('open');
    schedArr = schedArr.map((row, i) => {
        return row.map((x, j) => {
            //console.log(j, id, x);
            if (j == parseInt(id)) {
                //console.log('changing: ', x, currentCopiedDay[i]);
                return currentCopiedDay[i];
            }
            return x;
        });
    });
    console.table(schedArr);
    setTransferStartDate();
}
function setTransferStartDate() {
    setDontRefresh(true);
    let d = new Date(strtDateInEl.value);
    for (let i = 2; i < schedArr[0].length; i++) {
        let getYear = d.toLocaleString("default", { year: "numeric" });
        var getMonth = d.toLocaleString("default", { month: "2-digit" });
        var getDay = d.toLocaleString("default", { day: "2-digit" });
        schedArr[0][i] = getYear + "-" + getMonth + "-" + getDay;
        d.setDate(d.getDate()+1);
    }
    setAllValuesAndTables();
}
function saveSetTimeVal(el, row, col) {
    setDontRefresh(true);
    schedArr[row][col] = el.value;
    hiddenSavingEl.value = JSON.stringify(schedArr);
}
function setShiftsInDay() {
    setDontRefresh(true);
    let newLen = parseInt(shftsInDayEl.value) + 1;
    if (newLen > schedArr.length) { // need to add rows
        let blankRow = Array(schedArr[0].length);
        blankRow.fill('');
        let RsToAdd = (newLen - schedArr.length);
        //console.log(newLen, RsToAdd);
        for (let i = 0; i < RsToAdd; i++) {
            schedArr.push([...blankRow]);
        }
    }
    else if (newLen < schedArr.length) { // need to remove rows
        let elemsToDelete = schedArr.length - newLen;
        schedArr.splice(schedArr.length - elemsToDelete,
    elemsToDelete);
    }
    setAllValuesAndTables();
}
function setDaysInTransfer() {
    setDontRefresh(true);
    let colsDiff = daysInTransEl.value - (schedArr[0].length-2);
    console.log('colsDiff:', colsDiff);
    if (colsDiff > 0) { // need to add cols
        let blankAddingRow = Array(colsDiff);
        blankAddingRow.fill('');
        schedArr = schedArr.map((x,i) => {
            return x.concat([...blankAddingRow]);
        });
    }
    else if (colsDiff < 0) { // need to remove cols
        colsDiff = Math.abs(colsDiff);
        schedArr.map(x => {
            return x.splice(x.length - colsDiff,
            colsDiff);
        });
    }
    setTransferStartDate();
}
function cpyFrstWeekForwards() {
    if (schedArr[0].length <= 9) {
        console.log('not more than a week long');
        return;
    }
    setDontRefresh(true);
    for (let i = 1; i < schedArr.length; i++) {
        for (let j = 7; j < schedArr[i].length-2; j++) {
            let copyableDayI = j % 7;
            console.log(schedArr[i][copyableDayI+2]);
            schedArr[i][j+2] = schedArr[i][copyableDayI+2];
        }
    }
    setAllValuesAndTables();
}
function bigSaveBtn() {
    console.table(schedArr);
    setDontRefresh(false);
}

setAllValuesAndTables();
    </script>
</div>

<?php makeHTMLbottom() ?>
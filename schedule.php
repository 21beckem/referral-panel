<?php
    session_start();
    if (!$_SESSION['missionSignedIn']) {
        header('location: login.php');
    }
    require_once('panel_maker.php');
    makeHTMLtop('Schedule');
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
</div>

<!-- </div><div style="width: 10000px; height: 100px; background-color: black"> -->

<?php makeHTMLbottom() ?>
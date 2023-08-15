<?php
    session_start();
    if (!$_SESSION['missionSignedIn']) {
        header('location: login.php');
    }
    require_once('panel_maker.php');
    makeHTMLtop('Schedule');
?>
<style>
table, tr {
    width: 100%;
    height: 100%;
}
td {
    width: 50%;
    height: 100%;
}
td div {
    width: 60%;
    margin-left: 20%;
    text-align: right;
    height: 100%;
}
td div input {
    background-color: #ededed;
    border: none;
    padding: 5px;
    margin-left: 10px;
    width: 150px;
    text-align: center;
}
td div button {
    background: linear-gradient(140deg, rgba(232,133,208,1) -20%, rgb(196 167 217) 100%);
    background-color: #BBA7DA;
    border: none;
    cursor: pointer;
    padding: 3px;
    border-radius: 3px;
    margin-left: 10px;
    color: #fff;
    box-shadow: 1px 2px 10px -7px rgba(0, 0, 0, 0.5);
}
</style>
<div class="top">
    <i class="fa-solid fa-bars sidebar-toggle"></i>
    <h2>Referral Panel</h2>
    <img src="img/logo.png" alt="">
</div>

<div class="dash-content">
    <table>
        <tr>
            <td><div>
                <label for="strtDateIn">Transfer Start Date</label> <input name="strtDateIn" id="strtDateIn" type="date"> <button>GO</button>
                <br><br>
                <label for="shftsInDay">Shifts In A Day</label> <input name="shftsInDay" id="shftsInDay" type="number"> <button>GO</button>
            </div></td>
            <td><div>
                <label>Copy First Week Onward</label> <button>GO</button>
            </div></td>
        </tr>
    </table>
</div>

<?php makeHTMLbottom() ?>
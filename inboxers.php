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
.sidenav div:nth-child(even) {
    background: #eee;
}
.sidenav div:nth-child(odd) {
    background: #f2ddf0;
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
    background-image: url('img/logo.png');
    background-size: contain;
    margin: 20px auto 30px auto;
    border-radius: 50%;
    width: 80px;
    height: 80px;
}
#infoForm input {
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
</style>
<div class="top">
    <i class="fa-solid fa-bars sidebar-toggle"></i>
    <h2>Referral Panel</h2>
    <img src="img/logo.png" alt="">
</div>

<div class="dash-content">
    <div class="sidenav">
        <div>Hägersten</div>
        <div>Karlstad</div>
        <div>Jönköping</div>
        <div>Kristianstad</div>
        <button class="purpleBtn">Add Team</button>
    </div>

<div id="teamInfoMainParent">
    <div id="topHalfPage">
        <form id="infoForm">
            <div id="profilePic"></div>

            <label>Unique Id: 3</label><br><br>

            <label for="name">Name:</label><br>
            <input type="text" name="name">
            <br>
            <label for="email">Email:</label><br>
            <input type="text" name="email">
        </form>
        <div id="foxDataParent">
            <div id="streakNum">43</div>
            <img style="width: 100%; margin-top: 30px;" src="https://ssmission.github.io/referral-suite/img/streak1.png">
            <br><br>
            <div id="inbucksNum">43</div>
            <div id="inbucksImg"></div>
        </div>
    </div>
</div>

<?php makeHTMLbottom() ?>
<?php
    session_start();
    if (!$_SESSION['missionSignedIn']) {
        header('location: login.php');
    }
    require_once('panel_maker.php');
    makeHTMLtop();
?>

<div class="top">
    <i class="fa-solid fa-bars sidebar-toggle"></i>
    <h2>Referral Panel</h2>
    <img src="img/logo.png" alt="">
</div>

<div class="dash-content">
    <h3>Welcome, <?php echo($_SESSION['missionInfo']->name) ?></h3>
    <div class="overview">
        <div class="title">
            <i class="fa-solid fa-gauge-simple-high"></i>
            <span class="text">Dashboard</span>
        </div>

        <div class="boxes">
            <div class="box box1">
                <i class="fa-solid fa-plus"></i>
                <span class="text">Referrals Received Today</span>
                <span class="number">0</span>
            </div>
            <div class="box box2">
                <i class="fa-solid fa-clock"></i>
                <span class="text">Avg Claim Time</span>
                <span class="number">0 min</span>
            </div>
            <div class="box box3">
                <i class="fa-solid fa-paper-plane"></i>
                <span class="text">Percent Sent</span>
                <span class="number">0%</span>
            </div>
        </div>
    </div>

    <div class="activity">
        <div class="title">
            <i class="fa-solid fa-clock"></i>
            <span class="text">Recent Activity</span>
        </div>

        <div class="activity-data">
            <div class="data names">
                <span class="data-title">Name</span>
                <span class="data-list">Prem Shahi</span>
                <span class="data-list">Deepa Chand</span>
                <span class="data-list">Manisha Chand</span>
                <span class="data-list">Pratima Shahi</span>
                <span class="data-list">Man Shahi</span>
                <span class="data-list">Ganesh Chand</span>
                <span class="data-list">Bikash Chand</span>
            </div>
            <div class="data email">
                <span class="data-title">Email</span>
                <span class="data-list">premshahi@gmail.com</span>
                <span class="data-list">deepachand@gmail.com</span>
                <span class="data-list">prakashhai@gmail.com</span>
                <span class="data-list">manishachand@gmail.com</span>
                <span class="data-list">pratimashhai@gmail.com</span>
                <span class="data-list">manshahi@gmail.com</span>
                <span class="data-list">ganeshchand@gmail.com</span>
            </div>
            <div class="data joined">
                <span class="data-title">Joined</span>
                <span class="data-list">2022-02-12</span>
                <span class="data-list">2022-02-12</span>
                <span class="data-list">2022-02-13</span>
                <span class="data-list">2022-02-13</span>
                <span class="data-list">2022-02-14</span>
                <span class="data-list">2022-02-14</span>
                <span class="data-list">2022-02-15</span>
            </div>
            <div class="data type">
                <span class="data-title">Type</span>
                <span class="data-list">New</span>
                <span class="data-list">Member</span>
                <span class="data-list">Member</span>
                <span class="data-list">New</span>
                <span class="data-list">Member</span>
                <span class="data-list">New</span>
                <span class="data-list">Member</span>
            </div>
            <div class="data status">
                <span class="data-title">Status</span>
                <span class="data-list">Liked</span>
                <span class="data-list">Liked</span>
                <span class="data-list">Liked</span>
                <span class="data-list">Liked</span>
                <span class="data-list">Liked</span>
                <span class="data-list">Liked</span>
                <span class="data-list">Liked</span>
            </div>
        </div>
    </div>
</div>

<?php makeHTMLbottom() ?>
<?php
    session_start();
    if (!$_SESSION['missionSignedIn']) {
        header('location: login.php');
    }
    require_once('panel_maker.php');
    makeHTMLtop('Dashboard');
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
    <br><br>

    <div class="overview">
        <div class="title">
            <i class="fa-solid fa-graduation-cap"></i>
            <span class="text">Tutorials</span>
        </div>

        <center>
            <iframe width="424" height="238"
            src="https://www.youtube.com/embed/BDyCvzzOKhc"
            title="Kan Gud ge mig hjälp?" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            allowfullscreen
            style="border-radius: 10px;"></iframe>
        </center>
    </div>

</div>

<?php makeHTMLbottom() ?>
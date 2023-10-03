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

        <div class="boxes" style="justify-content:center">
            <div class="box" style="width:100%; background-color:#00000029; opacity:0.3; max-width:900px">
                <span class="text">Coming Soon</span>
                <span class="number">Quick Stats</span>
            </div>
        </div>
    </div>
    <br><br>

    <div class="overview">
        <div class="title">
            <i class="fa-solid fa-graduation-cap"></i>
            <span class="text">Tutorials</span>
        </div>
        <div class="boxes" style="justify-content:center">
            <div class="box" style="width:100%; background-color:#00000029; opacity:0.3; max-width:900px">
                <span class="text">Coming Soon</span>
                <span class="number">Tutorial Videos</span>
            </div>
        </div>

        
        <!-- <center>
            <iframe width="424" height="238"
            src="https://www.youtube.com/embed/BDyCvzzOKhc"
            title="Kan Gud ge mig hjälp?" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            allowfullscreen
            style="border-radius: 10px;"></iframe>
        </center> -->
    </div>

</div>

<?php makeHTMLbottom() ?>
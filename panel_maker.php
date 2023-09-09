<?php
$_SESSION['lastURL'] = $_SERVER['REQUEST_URI'];
function acivateThisTab($nm, $tab) {
    if (strpos(strtolower($nm), strtolower($tab)) !== false) {
        return 'active';
    } else {
        return '';
    }
}
function makeHTMLtop($name="") {
    $nameStr = "";
    if ($name != "" && $name != "Dashboard") {
        $nameStr = ' | '.$name;
    }
    $tabs = array('Dashboard', 'Referrals', 'Schedule', 'Inboxers', 'Templates', 'Integrate', 'Config');
    $activeTab = array();
    for ($i=0; $i < count($tabs); $i++) { 
        array_push($activeTab, acivateThisTab($name, $tabs[$i]));
    }

    $successToAlert = '';
    if (isset($_SESSION['sucess_status'])) {
        if ($_SESSION['sucess_status']) {
            $successToAlert = "let successToAlert = JSAlert.alert('Changes Saved', '', JSAlert.Icons.Success);  successToAlert.dismissIn(1500);";
        } else {
            $successToAlert = "JSAlert.alert('Oops! Something went wrong.<br>Please try again', '', JSAlert.Icons.Failed);";
        }
        unset($_SESSION['sucess_status']);
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="admin-template.css">
        <script src="https://kit.fontawesome.com/0bddc0a0f7.js" crossorigin="anonymous"></script>
        <script src="https://ssmission.github.io/referral-suite/jsalert.js"></script>
        <title>Referral Panel<?php echo($nameStr); ?></title> 
    </head>
    <body>
        <nav style="opacity:1">
            <script>
            window.onload = () => { <?php echo($successToAlert); ?> }
            </script>
            <div class="menu-items">
                <ul class="nav-links">
                    <li class="<?php echo(acivateThisTab($name, 'Dashboard')); ?>"><a href="index.php">
                        <i class="fa-solid fa-house"></i>
                        <span class="link-name">Dashboard</span>
                    </a></li>
                    <li class="<?php echo(acivateThisTab($name, 'Referrals')); ?>"><a href="referrals.php">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <span class="link-name">Referrals</span>
                    </a></li>
                    <li class="<?php echo(acivateThisTab($name, 'Schedule')); ?>"><a href="schedule.php">
                        <i class="fa-regular fa-calendar"></i>
                        <span class="link-name">Schedule</span>
                    </a></li>
                    <li class="<?php echo(acivateThisTab($name, 'Inboxers')); ?>"><a href="inboxers.php">
                        <i class="fa-solid fa-users"></i>
                        <span class="link-name">Inboxers</span>
                    </a></li>
                    <li class="<?php echo(acivateThisTab($name, 'Templates')); ?>"><a href="#">
                        <i class="fa-regular fa-paste"></i>
                        <span class="link-name">Templates</span>
                    </a></li>
                    <li class="<?php echo(acivateThisTab($name, 'Mission Areas')); ?>"><a href="#">
                        <i class="fa-solid fa-place-of-worship"></i>
                        <span class="link-name">Mission Areas</span>
                    </a></li>
                    <li class="<?php echo(acivateThisTab($name, 'Integrate')); ?>"><a href="integrate.php">
                        <i class="fa-solid fa-link"></i>
                        <span class="link-name">Integrate</span>
                    </a></li>
                    <li class="<?php echo(acivateThisTab($name, 'Settings')); ?>"><a href="#">
                        <i class="fa-solid fa-gears"></i>
                        <span class="link-name">Settings</span>
                    </a></li>
                </ul>
                
                <ul class="logout-mode">
                    <li><a href="logout.php">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span class="link-name">Logout</span>
                    </a></li>
                </ul>
            </div>
        </nav>
    
        <section class="dashboard">
    <?php
}
function makeHTMLbottom() {
    echo(<<<HERA
        </section>

        <script src="admin-template.js"></script>
    </body>
    </html>
    HERA);
}
?>
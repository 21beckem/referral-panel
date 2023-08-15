<?php
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
    echo(<<<HERA
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="admin-template.css">
        <script src="https://kit.fontawesome.com/0bddc0a0f7.js" crossorigin="anonymous"></script>
        <title>Referral Panel{$nameStr}</title> 
    </head>
    <body>
        <nav>
    
            <div class="menu-items">
                <ul class="nav-links">
                    <li class="{$activeTab[0]}"><a href="index.php">
                        <i class="fa-solid fa-house"></i>
                        <span class="link-name">Dashboard</span>
                    </a></li>
                    <li class="{$activeTab[1]}"><a href="#">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <span class="link-name">Referrals</span>
                    </a></li>
                    <li class="{$activeTab[2]}"><a href="schedule.php">
                        <i class="fa-regular fa-calendar"></i>
                        <span class="link-name">Schedule</span>
                    </a></li>
                    <li class="{$activeTab[3]}"><a href="#">
                        <i class="fa-solid fa-users"></i>
                        <span class="link-name">Inboxers</span>
                    </a></li>
                    <li class="{$activeTab[4]}"><a href="#">
                        <i class="fa-regular fa-paste"></i>
                        <span class="link-name">Templates</span>
                    </a></li>
                    <li class="{$activeTab[5]}"><a href="#">
                        <i class="fa-solid fa-link"></i>
                        <span class="link-name">Integrate</span>
                    </a></li>
                    <li class="{$activeTab[6]}"><a href="#">
                        <i class="fa-solid fa-gears"></i>
                        <span class="link-name">Config</span>
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
    HERA);
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
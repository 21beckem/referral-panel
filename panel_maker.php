<?php
function makeHTMLtop($name="") {
    if ($name != "") {
        $name = ' | '.$name;
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
        <title>Referral Panel{$name}</title> 
    </head>
    <body>
        <nav>
    
            <div class="menu-items">
                <ul class="nav-links">
                    <li class="active"><a href="index.php">
                        <i class="fa-solid fa-house"></i>
                        <span class="link-name">Dashboard</span>
                    </a></li>
                    <li><a href="#">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <span class="link-name">Referrals</span>
                    </a></li>
                    <li><a href="schedule.php">
                        <i class="fa-regular fa-calendar"></i>
                        <span class="link-name">Schedule</span>
                    </a></li>
                    <li><a href="#">
                        <i class="fa-solid fa-users"></i>
                        <span class="link-name">Inboxers</span>
                    </a></li>
                    <li><a href="#">
                        <i class="fa-regular fa-paste"></i>
                        <span class="link-name">Templates</span>
                    </a></li>
                    <li><a href="#">
                        <i class="fa-solid fa-link"></i>
                        <span class="link-name">Integrate</span>
                    </a></li>
                    <li><a href="#">
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
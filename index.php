<?php
    session_start();
    if (!$_SESSION['missionSignedIn']) {
        header('location: login.php');
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
    <title>Referral Panel</title> 
</head>
<body>
    <nav>

        <div class="menu-items">
            <ul class="nav-links">
                <li class="active"><a href="#">
                    <i class="fa-solid fa-house"></i>
                    <span class="link-name">Dashboard</span>
                </a></li>
                <li><a href="#">
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
        <div class="top">
            <i class="fa-solid fa-bars sidebar-toggle"></i>
            <img src="img/logo.png" alt="">
        </div>

        <div class="dash-content">
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
    </section>

    <script src="admin-template.js"></script>
</body>
</html>
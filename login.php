<?php
session_start();
if ($_SESSION['missionSignedIn']) {
    header('location: index.php');
}

// handle sign-in attempt
require_once('sql_tools.php');
$SignInError = '';
if ($_POST['email'] && $_POST['password']) {
    $readRes = readSQL('Referral_Suite_General', 'SELECT * FROM `mission_users` WHERE `email`="'.strtolower($_POST['email']).'"');
    if (count($readRes) == 0) {
        $SignInError = "Email not recognised";
    } else {
        if (!password_verify($_POST['password'], $readRes[0][2])) {
            $SignInError = "Password does not match email";
        } else {
            $_SESSION['missionSignedIn'] = true;
            $_SESSION['missionInfo'] = (object) [
                "name" => $readRes[0][1],
                "mykey" => $readRes[0][3]
            ];
            header('location: index.php');
            die();
        }
    }
}
if ($SignInError == '') {
    $errorShow = 'none';
} else {
    $errorShow = 'block';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Referral Panel | Sign In</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <style>
body {
    margin: 0;
    padding: 0;
    font-family: Roboto;
    background-repeat: no-repeat;
    background-size: cover;
    height: 100vh;
    overflow: hidden;
}
.center {
    position: absolute;
    padding: 25px;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 29vw;
    min-width: 300px;
    background-color: white;
    box-shadow: 2px 4px 14px -10px black;
    border-radius: 10px;
}
input[type="text"],
input[type="email"],
input[type="password"] {
    border: none;
    background-color: #f1f1f1;
    width: 100%;
    padding: 5px;
}
input[type="submit"] {
    font-size: 20px;
    margin: 20px;
    background: linear-gradient(140deg, rgba(232, 133, 208, 1) -20%, rgb(196 167 217) 100%);
    background-color: #BBA7DA;
    border: none;
    cursor: pointer;
    padding: 10px 30px;
    border-radius: 3px;
    color: #fff;
    box-shadow: 1px 2px 10px -7px rgba(0, 0, 0, 0.5);
}
    </style>
    <link rel="stylesheet" href="admin-template.css">
</head>
<body>
    <div class="container">
        <div class="center">
            <center><h1>Referral Panel</h1></center>
            <br>
            <form action="" method="POST">
                <p style="color: red; font-size: small; display: <?php echo($errorShow); ?>"><?php echo($SignInError); ?></p>
                <div class="txt_field">
                    <label>Email Address</label><br>
                    <input type="email" name="email" required>
                </div>
                <br>
                <div class="txt_field">
                    <label>Password</label><br>
                    <input type="password" name="password" required>
                </div>
                <br>
                <center><input name="submit" type="Submit" value="Login"></center>
                <div class="signup_link">
                    Not a Member? <a href="signup.html">Sign your mission up!</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
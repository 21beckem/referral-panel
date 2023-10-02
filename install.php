<?php
    session_start();
    if (!$_SESSION['missionSignedIn']) {
        header('location: login.php');
    }
    require_once('panel_maker.php');
    require_once('sql_tools.php');
    require_once('overall_vars.php');
    makeHTMLtop('Install');

    $referral_types = readSQL($_SESSION['missionInfo']->mykey, 'SELECT * FROM `referral_types` WHERE 1');
?>
<style>
.sidenav {
    width: 170px;
    position: absolute;
    z-index: 1;
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
    display: block;
    background-color: #f6f6f6;
}
.sidenav div.tabbed {
    margin-left: 15px;
    width: calc(100% - 15px);
    padding: 4px 8px 4px 20px;
    border-radius: 9px 22px;
}
.sidenav button {
    border: none;
    padding: 6px 8px;
    margin-left: 0;
    border-top-left-radius: 0px;
    border-bottom-left-radius: 0px;
}

#rightHalf {
    margin-top: 90px;
    margin-left: 0;
    padding: 0px 10px;
}
#rightHalf hr {
    width: 50%;
    margin-left: auto;
    margin-right: auto;
    margin-top: 30px;
    margin-bottom: 30px;
}
#rightHalf .card {
    width: 100%;
    max-width: 1000px;
    background-color: white;
    box-shadow: 1px 2px 8px -5px rgba(0, 0, 0, 0.5);
    padding: 20px;
    margin-left: auto;
    margin-right: auto;
    margin-top: 10px;
    margin-bottom: 10px;
}
#rightHalf .card p {
    color: #4d4d4d;
}
h4 {
    margin-bottom: 5px;
}
p {
    margin-bottom: -7px;
    padding-bottom: 0;
}
.pasteMe {
    padding: 10px;
    width: 100%;
    margin-top: 5px;
}
</style>
<div class="top">
    <i class="fa-solid fa-bars sidebar-toggle"></i>
    <h2>Integrate</h2>
    <img src="img/logo.png" alt="">
</div>

<div id="rightHalf">
    <div class="card">
        <h2>Install</h2>
        <br>
        <p>Welcome to the <strong>Install</strong> page!</p>
        <br>
        <p>On this page, you'll be given a all you need to install <strong>Referral Suite</strong> on missionary phones.</p>
        <br>
        <p>Because our phones are managed by MASS360, the installation process isn't as simple as just downloading an app. <strong>That being said</strong>, I've taken the time to make an installer that will walk every missionary through how to install <strong>Referral Suite</strong> on their own phones, so the process isn't hard.</p>
        <br>
        <p>Estimated installation time: <strong>5 minutes</strong></p>
    </div>
    <hr>

    <div class="card">
        <h3><i class="fa-solid fa-phone" style="color: #a533ff; font-size: 40px"></i> Normal Devices</h3>
        <br>
        <p>Just in case you want to install <strong>Referral Suite</strong> on a device that doesn't have MASS360</p>
        <br>
        <br>
        <p>This process is <strong>very simple</strong>. Simply open this link on the device and click <strong>Install</strong></p>
        <br>
        <input type="text" disabled value="https://ssmission.cloud/referral-suite-manager/install/installApp.html" class="pasteMe"><br>
    </div>
    <hr>
    <div class="card">
        <h3><i class="fa-solid fa-phone-slash" style="color: #a533ff; font-size: 40px"></i> Missionary Devices</h3>
        <br>
        <p>For <strong>Missionary Phones</strong>, follow instructions below</p>
        <br>
        <br>
        <p>This process is also <strong>quite simple</strong>.</p>
        <br>
        <p><strong>Send</strong> this link to everyone who wants to install the app. Have them <strong>download</strong> this file to their phone and <strong>open it with google chrome</strong>.</p>
        <br>
        <p>After that, it will tell you everything else you need to do.</p>
        <br>
        <input type="text" disabled value="https://drive.google.com/file/d/1RTS-hXQNBf7Nco59upvgBVYIkFYM8de-/view?usp=sharing" class="pasteMe"><br>
    </div>
    <div style="width: 5px; height: 150px;"></div>
</div>
<script>
function _(x) { return document.getElementById(x); }
HTMLCollection.prototype.forEach = function (x) { return Array.from(this).forEach(x); }

function addNewReferralType() {
    JSAlert.prompt('Make sure this is right. This will be tedious <br> for you to change later after referrals <br> start coming in using under this type', '', '', 'Add New Referral Type').then(res => {
        if (res == null) { return; }
        _('addNewTypeValue').value = res;
        _('addNewTypeForm').submit();
    });
}
function deleteThisReferralType(el) {
    JSAlert.confirm('Are you sure you want to delete this referral type? <br><br> Even if you\'re not using it anymore I\'d suggest not removing <br> it so you can still filter search for these referrals', '', JSAlert.Icons.Warning).then(res => {
        if (res) {
            el.nextElementSibling.value = '1';
            el.parentElement.submit()
        }
    });
}
function enableRefTypEditing(id) {
    document.querySelectorAll('.refTypCard.editing').forEach(el => {
        el.classList.remove('editing');
        let inp = el.querySelector('input[type=text]');
        inp.value = inp.getAttribute('data-original-val');
    });
    if (id != undefined) {
        _('refTypId_'+id).classList.add('editing');
    }
}

</script>

<?php makeHTMLbottom() ?>
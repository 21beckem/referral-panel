<?php
    session_start();
    if (!$_SESSION['missionSignedIn']) {
        header('location: login.php');
    }
    require_once('panel_maker.php');
    require_once('sql_tools.php');
    require_once('overall_vars.php');
    makeHTMLtop('Templates');
    
    $referral_types = readSQL($_SESSION['missionInfo']->mykey, 'SELECT * FROM `referral_types` WHERE 1');
    $tableCols = readTableColumns($_SESSION['missionInfo']->mykey, 'all_referrals');
?>
<style>
.dash-content {
    display: flex;
    justify-content: space-between;
}
.sidenav {
    top: 80px;
    position: sticky;
    width: 170px;
    z-index: 1;
    left: 0px;
    overflow-x: hidden;
    padding: 8px 0;
    margin-right: 2px;
    align-self: flex-start;
}
#contactType div {
    border-radius: 5px;
    padding: 10px;
    box-shadow: 1px 2px 12px -7px rgba(0, 0, 0, 0.5);
    cursor: pointer;
}
#contactType div:after {
    content: ' >';
    opacity: 0.5;
}

#mainParent {
    padding: 0px 10px;
    flex: 1;
    max-width: 500px;
}
.templateCard {
    box-shadow: 1px 2px 12px -7px rgba(0, 0, 0, 0.5);
    padding: 25px;
    margin-bottom: 25px;
}
.templateCard textarea {
    width: 100%;
    border-radius: 20px;
}
#tableColBtns {
    display: flex;
    justify-content: flex-start;
    flex-direction: column;
    align-items: flex-end;
}
#tableColBtns div {
    border-radius: 5px;
    padding: 3px;
    box-shadow: 1px 2px 12px -7px rgba(0, 0, 0, 0.5);
    cursor: pointer;
}
#tableColBtns div:before {
    content: '{';
    opacity: 0.5;
}
#tableColBtns div:after {
    content: '}';
    opacity: 0.5;
}
</style>
<div class="top">
    <i class="fa-solid fa-bars sidebar-toggle"></i>
    <h2>Templates</h2>
    <img src="img/logo.png" alt="">
</div>

<div class="dash-content">
    <div style="display: flex">
        <div class="sidenav" id="refTypes">
            <?php
            foreach ($referral_types as $i => $row) {
                echo('<div href="templates.php?typ='.$row[1].'" onclick="location.href=this.getAttribute(\'href\')" class="purpleBtn" style="margin: 5px 0px;">'.$row[1].'</div>');
            }
            ?>
        </div>
        <div class="sidenav" id="contactType">
            <div>SMS</div>
            <div>Email</div>
        </div>
    </div>

    <div id="mainParent" style="opacity:1">
        <div class="templateCard">
            <textarea style="width:100%" rows="7" disabled></textarea>
        </div>
        <div class="templateCard">
            <textarea style="width:100%" rows="7" disabled></textarea>
        </div>
        <div class="templateCard">
            <textarea style="width:100%" rows="7" disabled></textarea>
        </div>
        <div class="templateCard">
            <textarea style="width:100%" rows="7" disabled></textarea>
        </div>
        <div class="templateCard">
            <textarea style="width:100%" rows="7" disabled></textarea>
        </div>
    </div>
    <div class="sidenav" id="tableColBtns">
        <div>first name</div>
        <div>last name</div>
        <div>address</div>
        <div>street address</div>
        <div>city</div>
        <div>zip</div>
        <div>phone</div>
        <div>teaching area</div>
        <div>email</div>
        <div>ad name</div>
        <div>experience</div>
        <div>help request</div>
        <div>lang</div>
        <div>referral origin</div>

    </div>
<script>
function _(x) { return document.getElementById(x); }
HTMLCollection.prototype.forEach = function (x) { return Array.from(this).forEach(x); }

function openTab(refTyp) {

}

<?php
if (isset($_GET['id'])) {
    echo('openThisTeam('.$_GET['id'].');');
}
?>

</script>

<?php makeHTMLbottom() ?>
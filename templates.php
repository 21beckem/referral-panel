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
    
    if (isset($_GET['refTyp'])) {
        $templates = readSQL($_SESSION['missionInfo']->mykey, 'SELECT * FROM `templates` WHERE `Referral Type`="'.$_GET['refTyp'].'" AND `type`="'.$_GET['contactTyp'].'"');
    } else {
        $templates = [];
    }
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
    min-width: 170px;
    z-index: 1;
    left: 0px;
    overflow-x: hidden;
    padding: 8px 0;
    margin-right: 2px;
    align-self: flex-start;
}
#refTypes div.active {
    text-align: center;
    box-shadow: inset 1px 2px 8px 0px rgb(255 255 255);
}
#contactType div {
    border-radius: 5px;
    padding: 10px;
    box-shadow: 1px 2px 12px -7px rgba(0, 0, 0, 0.5);
    cursor: pointer;
}
#contactType div label {
    pointer-events: none;
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
.templateCard .textarea {
    border: 1px solid rgba(118, 118, 118, 0.3);
    background-color: rgba(239, 239, 239, 0.3);
    width: 100%;
    border-radius: 20px;
    padding: 10px;
}
#tableColBtns {
    display: flex;
    justify-content: flex-start;
    flex-direction: column;
    align-items: flex-end;
    padding-right: 10px;
    background-color: #efefef;
    border-radius: 5px;
}
.dataCard {
    border-radius: 5px;
    padding: 3px;
    margin-bottom: 3px;
    box-shadow: 1px 2px 12px -7px rgba(0, 0, 0, 0.5);
    cursor: pointer;
    background-color: white;
    width: fit-content;
}
.textarea .dataCard {
    display: inline;
    cursor: default;
    padding: 0px;
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
                if ($row[1]==$_GET['refTyp']) {
                    $activeState = ' active';
                } else {
                    $activeState = '';
                }
                echo('<div onclick="openRefType(\''.$row[1].'\')" class="purpleBtn'.$activeState.'" style="margin: 5px 0px;">'.$row[1].'</div>');
            }
            ?>
        </div>
        <div class="sidenav" id="contactType">
            <div onclick="this.querySelector('input').click()">
                <input onchange="updateContactTyp(this.value)" type="radio" id="SMS_radio" name="contactTyp" value="SMS" <?php if (!isset($_GET['contactTyp']) || $_GET['contactTyp']=='SMS') {echo('checked');} ?>>
                <label for="SMS">SMS</label>
            </div>
            <div onclick="this.querySelector('input').click()">
                <input onchange="updateContactTyp(this.value)" type="radio" id="MAIL_radio" name="contactTyp" value="Email" <?php if ($_GET['contactTyp']=='Email') {echo('checked');} ?>>
                <label for="Email">Email</label>
            </div>
        </div>
    </div>

    <div id="mainParent" style="opacity:<?php if (isset($_GET['refTyp'])) {echo('1');} else {echo('0');} ?>">
        <?php
            foreach ($templates as $i => $row) {
                echo('
                <div class="templateCard">
                    <textarea style="width:100%" rows="7" disabled>'.$row[3].'</textarea>
                </div>');
            }
        ?>
        <div class="templateCard">
            <div class="textarea" contenteditable="true">
                hi there you little <div contenteditable="false" class="dataCard">{street address}</div>
            </div>
        </div>
        <div class="templateCard">
            <div class="textarea" contenteditable="true">
                Wy<div contenteditable="false" class="dataCard">{phone}</div>asdfsadfsadfasdfsadfasfdsa
            </div>
        </div>
        <div class="templateCard">
            <div class="textarea" contenteditable="true">
                hi<div contenteditable="false" class="dataCard">{first name}</div>
            </div>
        </div>
    </div>
    <div class="sidenav" id="tableColBtns">
        <div class="dataCard" onclick="addDataCard(this.innerHTML)">{first name}</div>
        <div class="dataCard" onclick="addDataCard(this.innerHTML)">{last name}</div>
        <div class="dataCard" onclick="addDataCard(this.innerHTML)">{address}</div>
        <div class="dataCard" onclick="addDataCard(this.innerHTML)">{street address}</div>
        <div class="dataCard" onclick="addDataCard(this.innerHTML)">{city}</div>
        <div class="dataCard" onclick="addDataCard(this.innerHTML)">{zip}</div>
        <div class="dataCard" onclick="addDataCard(this.innerHTML)">{phone}</div>
        <div class="dataCard" onclick="addDataCard(this.innerHTML)">{teaching area}</div>
        <div class="dataCard" onclick="addDataCard(this.innerHTML)">{email}</div>
        <div class="dataCard" onclick="addDataCard(this.innerHTML)">{ad name}</div>
        <div class="dataCard" onclick="addDataCard(this.innerHTML)">{experience}</div>
        <div class="dataCard" onclick="addDataCard(this.innerHTML)">{help request}</div>
        <div class="dataCard" onclick="addDataCard(this.innerHTML)">{lang}</div>
        <div class="dataCard" onclick="addDataCard(this.innerHTML)">{referral origin}</div>
    </div>
<script>
function _(x) { return document.getElementById(x); }
HTMLCollection.prototype.forEach = function (x) { return Array.from(this).forEach(x); }

let currentInput = {
    selection : null,
    range : null
};
setInterval(() => {
    if (window.getSelection().anchorNode!=null && Boolean(window.getSelection().anchorNode.parentElement.closest('div.textarea'))) {
        currentInput = {
            selection : window.getSelection(),
            range : window.getSelection().getRangeAt(0)
        };
    }
}, 500);


function addDataCard(text) {
    let selection = currentInput.selection;
    let range = currentInput.range;
    range.deleteContents();
    let node = document.createElement('div');
    node.setAttribute('contenteditable', 'false');
    node.classList.add('dataCard');
    node.innerHTML = text;
    currentInput.range.insertNode(node);

    for(let position = 0; position != text.length; position++)
    {
        selection.modify("move", "right", "character");
    };
}

function openRefType(refTyp) {
    location.href = '?refTyp=' + refTyp + '&contactTyp=' + document.querySelector('input[name="contactTyp"]:checked').value;
}
function updateContactTyp(val) {
    let refTyp = document.querySelector('#refTypes div.active');
    if (refTyp!=null) {
        location.href = '?refTyp=' + refTyp.innerHTML + '&contactTyp=' + val;
    }
}

<?php
if (isset($_GET['id'])) {
    echo('openThisTeam('.$_GET['id'].');');
}
?>

</script>

<?php makeHTMLbottom() ?>
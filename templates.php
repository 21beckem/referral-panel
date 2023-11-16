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
    padding: 25px 25px 10px 25px;
    margin-bottom: 25px;
    position: relative;
}
.templateCard .textarea {
    border: 1px solid rgba(118, 118, 118, 0.3);
    background-color: rgba(239, 239, 239, 0.3);
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    min-height: 45px;
    border-radius: 5px;
}
.templateCard .textarea.SMS {
    box-shadow: 0 0 13px -8px #0085ff inset;
}
.templateCard .textarea.Email {
    box-shadow: 0 0 13px -9px red inset;
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
dataCard {
    border-radius: 5px;
    padding: 3px;
    margin-bottom: 3px;
    box-shadow: 1px 2px 12px -7px rgba(0, 0, 0, 0.5);
    cursor: pointer;
    background-color: white;
    width: fit-content;
}
.textarea dataCard {
    display: inline;
    cursor: default;
    padding: 0px;
    border: 1px solid #3200324a;
    background-color: white;
}
.templateCard .saveBtn {
    display: none;
    overflow: hidden;
    padding: 3px 20px;
}
.templateCard .delBtn {
    position: absolute;
    top: 5px;
    right: 8px;
    cursor: pointer;
    color: #ff000057;
    background-color: transparent;
    border: none;
    transition: color 0.15s ease;
}
.templateCard .delBtn:hover {
    color: #ff0000b0;
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
    </div>
    <div class="sidenav" id="tableColBtns">
        <h3 style="width: calc(100% - 10px); text-align: center; margin-bottom: 10px;">Data Cards</h3>
        <dataCard onclick="addDataCard(this.innerHTML)">{first name}</dataCard>
        <dataCard onclick="addDataCard(this.innerHTML)">{last name}</dataCard>
        <dataCard onclick="addDataCard(this.innerHTML)">{address}</dataCard>
        <dataCard onclick="addDataCard(this.innerHTML)">{street address}</dataCard>
        <dataCard onclick="addDataCard(this.innerHTML)">{city}</dataCard>
        <dataCard onclick="addDataCard(this.innerHTML)">{zip}</dataCard>
        <dataCard onclick="addDataCard(this.innerHTML)">{phone}</dataCard>
        <dataCard onclick="addDataCard(this.innerHTML)">{teaching area}</dataCard>
        <dataCard onclick="addDataCard(this.innerHTML)">{email}</dataCard>
        <dataCard onclick="addDataCard(this.innerHTML)">{ad name}</dataCard>
        <dataCard onclick="addDataCard(this.innerHTML)">{experience}</dataCard>
        <dataCard onclick="addDataCard(this.innerHTML)">{help request}</dataCard>
        <dataCard onclick="addDataCard(this.innerHTML)">{lang}</dataCard>
        <dataCard onclick="addDataCard(this.innerHTML)">{referral origin}</dataCard>
    </div>
<script>
document.execCommand('defaultParagraphSeparator', false, 'div');
function _(x) { return document.getElementById(x); }
HTMLCollection.prototype.forEach = function (x) { return Array.from(this).forEach(x); }

// make all the cards
const templates = <?php echo(json_encode($templates)); ?>;
let mainParent = _('mainParent');
templates.forEach((row, i) => {
    // convert curly-brackets to dataCards
    let newTmpMssg = row[3].replace(/{[^}]*}/gm, function (x) {
        return '<dataCard contenteditable="false">' + x + '</dataCard>';
    });
    //console.log(newTmpMssg);

    // convert rest to HTML
    //console.log(JSON.stringify(newTmpMssg));
    let manMadeHTML = newTmpMssg.split('\n').map(lin => {
        if (lin=='\r') {
            return '<div><br></div>';
        }
        return '<div>' + lin + '</div>';
    }).join('');
    //console.log(manMadeHTML);

    // paste
    mainParent.innerHTML += `
        <div class="templateCard">
            <form method="POST" action="saving_functions/template_save.php" onsubmit="return confirmDeleteTemplate(this)">
                <input type="hidden" name="setting" value="delete">
                <input type="hidden" name="id" value="`+row[0]+`">
                <button class="delBtn"><i class="fa-solid fa-trash-can"></i></button>
            </form>
            <form method="POST" action="saving_functions/template_save.php" onsubmit="onTextareaEdit(this.querySelector('.textarea'))">
                <div class="textarea <?php echo($_GET['contactTyp']); ?>" oninput="onTextareaEdit(this)" contenteditable="true">`+manMadeHTML+`</div>
                <input type="hidden" name="setting" value="update">
                <input type="hidden" name="id" value="`+row[0]+`">
                <input type="hidden" class="hiddenTxt" name="txt" value="">
                <input type="submit" class="purpleBtn saveBtn" value="Save">
            </form>
        </div>`;
});
mainParent.innerHTML += `
    <form method="POST" action="saving_functions/template_save.php">
        <input type="hidden" name="setting" value="new">
        <input type="hidden" name="refTyp" value="<?php echo($_GET['refTyp']); ?>">
        <input type="hidden" name="contactTyp" value="<?php echo($_GET['contactTyp']); ?>">
        <input type="submit" class="purpleBtn saveBtn" style="display:block" value="Add New Template">
    </form>`;
function onTextareaEdit(el) {
    if (!el.classList.contains('textarea')) { return; }
    let val = el.innerHTML;

    // fix html output
    if (val.includes('<div>')) {
        let pArr = val.replace("</div>", "").split("<div>");
        val = '<div>' + val.replace('<div>', '</div><div>');
    } else {
        val = '<div>' + val + '</div>';
    }
    val = val.replaceAll('<div></div>', '');

    // convert html to plain text
    let conv = val.replace(/<div>(.*?)\n*<\/div>/gmi, function(x, m) {
        if (m=='<br>') {
            return '\n';
        }
        m = m.replaceAll('&nbsp;', ' ');
        return m.replace(/<dataCard contenteditable="false">(.*?)\n*<\/dataCard>/gmi, function(x, m) { return m; }) + '\n';
    });
    conv = stripHTML( conv.replace(/(\r\n|\n|\r)\Z/gm,"") );

    // console.log(el.innerHTML);
    // console.log(val);
    console.log(JSON.stringify(conv));
    console.log('-------------------');
    el.parentElement.querySelector('.hiddenTxt').value = conv;
    el.parentElement.querySelector('.saveBtn').style.display = 'block';

    return false;
}
function stripHTML(str) {
    let doc = new DOMParser().parseFromString(str, 'text/html');
    return doc.body.textContent || "";
}

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
}, 250);


function addDataCard(text) {
    let selection = currentInput.selection;
    let range = currentInput.range;
    range.deleteContents();
    let node = document.createElement('dataCard');
    node.setAttribute('contenteditable', 'false');
    node.innerHTML = text;
    currentInput.range.insertNode(node);

    onTextareaEdit( currentInput.range.commonAncestorContainer.closest('.textarea') );
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
let currentDeletingForm = null;
function confirmDeleteTemplate(el) {
    JSAlert.confirm('Are you absolutely sure you want to delete this template? This CANNOT be undone.', '', JSAlert.Icons.Warning)
    .then(res => {
        if (res) {
            currentDeletingForm.submit();
        }
    });
    currentDeletingForm = el;
    return false;
}

</script>

<?php makeHTMLbottom() ?>
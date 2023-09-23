<?php
    session_start();
    if (!$_SESSION['missionSignedIn']) {
        header('location: login.php');
    }
    require_once('panel_maker.php');
    require_once('sql_tools.php');
    require_once('overall_vars.php');
    makeHTMLtop('Settings');
    
    $settings_rows = readSQL($_SESSION['missionInfo']->mykey, 'SELECT * FROM `settings` ORDER BY `settings`.`sort_order` ASC');
?>
<style>
.settingsSection .openBtn {
    background-color: #eee;
    color: #444;
    cursor: pointer;
    padding: 18px;
    width: 100%;
    border: none;
    text-align: left;
    outline: none;
    font-size: 15px;
    transition: 0.4s;
}
.settingsSection.active, .settingsSection .openBtn:hover {
    background-color: #ebdcf0;
}
.settingsSection .openBtn:after {
    content: '\002B';
    color: #777;
    font-weight: bold;
    float: right;
    margin-left: 5px;
}
.settingsSection.active .openBtn:after {
    content: "\2212";
}
.settingsSection .panel {
    padding: 0px;
    background-color: white;
    max-height: 0;
    overflow: hidden;
    transition: all 0.2s ease-out;
}
.settingsSection.active .panel {
    padding: 20px 10px;
}

.settingName {
    font-size: 20px;
    margin-right: 10px;
}
.settingSplit {
    width: 75%;
    margin: 15px auto 15px auto;
    border: 1px dotted #d2d2d2;
}
</style>
<div class="top">
    <i class="fa-solid fa-bars sidebar-toggle"></i>
    <h2>Settings</h2>
    <img src="img/logo.png" alt="">
</div>

<div class="dash-content">
    <div id="accordionParent">
        <div class="settingsSection">
            <button class="openBtn" onclick="clickOpenAccordion(this)">Section 1</button>
            <div class="panel">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            </div>
        </div>
        
        <div class="settingsSection">
            <button class="openBtn" onclick="clickOpenAccordion(this)">Section 2</button>
            <div class="panel">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            </div>
        </div>
        
        <div class="settingsSection">
            <button class="openBtn" onclick="clickOpenAccordion(this)">Section 3</button>
            <div class="panel">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            </div>
        </div>
    </div>

    <div id="mainParent" style="opacity:<?php if (isset($_GET['refTyp'])) {echo('1');} else {echo('0');} ?>">
    </div>
<script>
function _(x) { return document.getElementById(x); }
HTMLCollection.prototype.forEach = function (x) { return Array.from(this).forEach(x); }
const settings_rows = <?php echo(json_encode( $settings_rows )); ?>;

function makeAccordions(this_settings_rows) {
    let lastHeader = null;
    let accordions = this_settings_rows.map((row, i) => {
        let toReturn = '';
        
        // start new header section
        if (lastHeader != row[2]) {
            if (lastHeader != null) {
                toReturn += '</div></div>';
            }
            toReturn += `<div class="settingsSection">
                            <button class="openBtn" onclick="clickOpenAccordion(this)">` + row[2] + `</button>
                        <div class="panel">`;
            lastHeader = row[2];
        }

        // paste name
        toReturn += '<a class="settingName">' + row[5] +'</a>';

        // make value editor
        let typ = row[3];
        if (typ=='text' || typ=='number' || typ=='date') {
            toReturn += `<input type="`+typ+`" disabled value="`+row[6]+`">`;
        }
        
        // add break between
        if (this_settings_rows[i+1] && this_settings_rows[i+1][2]==row[2]) {
            toReturn += '<hr class="settingSplit">';
        }
        return toReturn;
    }).join('');
    if(accordions != '') {
        accordions += '</div></div>';
    }

    _('accordionParent').innerHTML = accordions;
}
makeAccordions( settings_rows );

function clickOpenAccordion(el) {
    // close all others
    document.querySelectorAll('.settingsSection .openBtn').forEach(thisEl => {
        if (thisEl != el) {
            openAccordion(thisEl, false);
        }
    });

    // open this
    openAccordion(el);
}
function openAccordion(el, forceState=null) {
    if (typeof(forceState) !== 'boolean') {
        el.parentElement.classList.toggle('active');
    } else {
        if (forceState) {
            el.parentElement.classList.add('active');
        } else {
            el.parentElement.classList.remove('active');
        }
    }
    let panel = el.nextElementSibling;
    if (el.parentElement.classList.contains('active')) {
        panel.style.maxHeight = (panel.scrollHeight+40) + 'px';
    } else {
        panel.style.maxHeight = '0';
    }
}

</script>

<?php makeHTMLbottom() ?>
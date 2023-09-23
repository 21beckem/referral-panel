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
<link href="MYbootstrap.css" rel="stylesheet">
<script src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
<script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/bootstrap3-editable/js/bootstrap-editable.js"></script>
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
.settingsSection .settingsPanel {
    padding: 0px;
    background-color: white;
    max-height: 0;
    overflow: hidden;
    transition: all 0.2s ease-out;
}
.settingsSection.active .settingsPanel {
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
.jsonTable {
    width: 100%;
}
.jsonTable .name {
    width: 50%;
    display: inline-block;
    text-align: right;
    padding-right: 10px;
}
.jsonTable .name input {
    font-weight: bold;
}
.jsonTable input {
    min-width: 200px;
    width: 40%;
    text-align: center;
}
.jsonTable .row {
    margin: 15px 0px 15px 0px;
}
div.input {
    display: inline-block;
    padding: 5px;
    border: 1px solid #d5bbde;
    cursor: pointer;
}
div.input:empty:before {
    color: #DD1144;
    font-style: italic;
    text-decoration: none;
    content: "Empty";
}
</style>
<div class="top">
    <i class="fa-solid fa-bars sidebar-toggle"></i>
    <h2>Settings</h2>
    <img src="img/logo.png" alt="">
</div>

<div class="dash-content">
    <div id="accordionParent">
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
                        <div class="settingsPanel">`;
            lastHeader = row[2];
        }

        // paste name
        toReturn += '<a class="settingName">' + row[5] +'</a>';

        // make value editor
        let typ = row[3];
        let val = row[6];
        if (typ=='text' || typ=='number' || typ=='date')
        {
            toReturn += `<div disabled value="`+val+`" data-name="`+row[5]+`" class="input textEditable" data-type="text" data-pk="`+row[0]+`">`+val+`</div>`;
        }
        else if (typ=='bool' || typ=='boolean')
        {
            toReturn += `<input type="`+typ+`" disabled value="`+Boolean(parseInt(val))+`">`;
        }
        else if (typ=='json')
        {
            toReturn += '<div class="jsonTable">';
            let json = JSON.parse(val);
            for (let key in json) {
                console.log(key);
                toReturn += '<div class="row">';
                toReturn += `<div class="name">
                    <input value="`+key+`" disabled></div>
                    <input type="`+typ+`" disabled value="`+json[key]+`">
                    <br>`;
                toReturn += '</div>';
            }
            toReturn += '</div>';
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

$('#accordionParent').editable({ // textEditable class is now editable
    container: 'body',
    selector: '.textEditable',
    url: "",
    title: 'Edit Setting',
    type: "GET",
    dataType: 'json'
});

</script>

<?php makeHTMLbottom() ?>
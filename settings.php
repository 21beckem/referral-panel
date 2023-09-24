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
#accordionParent {
    margin: 0 auto 0 auto;
    max-width: 800px;
    width: 100%;
}
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
.jsonTable .name .input {
    font-weight: bold;
}
.jsonTable .input {
    min-width: 200px;
    width: 40%;
    text-align: center;
}
.jsonTable .input:not(.textEditable) { 
    cursor: default;
    background-color: #f0f0f0;
    padding: 0px;
    margin: 5px;
}
.jsonTable .row {
    margin: 15px 0px 15px 0px;
    transform: translateY(-10px);
}
div.input {
    display: inline-block;
    padding: 5px;
    border: 1px solid #d5bbde;
    cursor: pointer;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
    background-color: white;
    transform: translateY(10px);
}
div.input:empty:before {
    color: #DD1144;
    font-style: italic;
    text-decoration: none;
    content: "Empty";
}
.delBtn {
    color: #ff000057;
    border: none;
    background-color: transparent;
    transition: 0.15s ease;
    margin-right: 10px;
    display: inline-block;
}
.delBtn:hover {
    color: #ff0000b0;
}
.newBtn {
    margin: 0 auto 0 auto;
    width: 100px;
    text-align: center;
    transform: translateY(-10px);
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
        toReturn += '<a class="settingName">' + (row[5]).toTitleCase() +'</a>';

        // make value editor
        let typ = row[3];
        let val = row[6];
        if (typ=='text' || typ=='number' || typ=='date')
        {
            toReturn += `<div disabled value="`+val+`" data-name="`+row[5]+`" class="input textEditable" data-type="text" data-pk="`+row[0]+`">`+val+`</div>`;
        }
        else if (typ=='bool' || typ=='boolean')
        {
            toReturn += `<div disabled value="`+val+`" data-name="`+row[5]+`" class="input boolEditable" data-type="select" data-pk="`+row[0]+`">`+String(Boolean(val)).toTitleCase()+`</div>`;
        }
        else if (typ=='json')
        {
            toReturn += '<a style="opacity:0.5">{</a>';
            toReturn += '<div class="jsonTable">';
            let json = JSON.parse(val);
            const modifiable = Boolean(parseInt(row[4]));
            for (let key in json) {
                console.log(key);
                toReturn += '<div class="row">';
                toReturn += `<div class="name">`;
                if (modifiable) {
                    toReturn += '<button class="delBtn"><i class="fa-solid fa-trash-can"></i></button>';
                }
                toReturn += `<div disabled value="`+key+`" data-name="`+JSON.stringify([row[5], key, 'key'])+`" class="input `+(modifiable ? 'textEditable' : '')+`" data-type="text" data-pk="`+row[0]+`">`+key+`</div></div>`;
                toReturn += `<div disabled value="`+json[key]+`" data-name="`+JSON.stringify([row[5], key, 'key'])+`" class="input textEditable" data-type="text" data-pk="`+row[0]+`">`+json[key]+`</div>`;
                toReturn += `<br>`;
                toReturn += '</div>';
            }
            if (modifiable) {
                toReturn += '<div class="newBtn purpleBtn">Add 1 More</div>';
            }
            toReturn += '</div>';
            toReturn += '<a style="opacity:0.5">}</a>';
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
$('#accordionParent').editable({ // SentStatus class is now editable with select
    container: 'body',
    selector: '.boolEditable',
    url: "",
    title: 'Edit Setting',
    type: "GET",
    dataType: 'json',
    source: [
        {value: 'true', text: 'True'},
        {value: 'true', text: 'False'}
    ],
    validate: function(value) {
        if($.trim(value) == '') { return 'This field is required' }
    }
});

</script>

<?php makeHTMLbottom() ?>
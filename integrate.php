<?php
    session_start();
    if (!$_SESSION['missionSignedIn']) {
        header('location: login.php');
    }
    require_once('panel_maker.php');
    require_once('sql_tools.php');
    require_once('overall_vars.php');
    makeHTMLtop('Integrate');
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
    margin-left: 180px;
    padding: 0px 10px;
    height: calc(100vh - 90px);
    overflow-y: scroll;
}
#rightHalf .card {
    width: 100%;
    background-color: white;
    box-shadow: 1px 2px 8px -5px rgba(0, 0, 0, 0.5);
    padding: 10px;
}
.refTypCard {
    padding: 5px;
    background-color: #f6f6f6;
    width: fit-content;
    margin: 5px;
}
.refTypCard * {
    margin: 0px 5px;
}
.refTypCard input {
    background-color: transparent;
    border: none;
    pointer-events: none;
    border-radius: 3px;
    padding: 2px;
}
.refTypCard.editing input {
    background-color: white;
    border: auto;
    pointer-events: auto;
}
.refTypCard i {
    cursor: pointer;
    width: 15px;
}
.refTypCard.editing .editBtn {
    display: none;
}
.refTypCard:not(.editing) .saveBtn {
    display: none;
}
.refTypCard.editing .deleBtn {
    display: none;
}
.refTypCard:not(.editing) .undoBtn {
    display: none;
}
</style>
<div class="top">
    <i class="fa-solid fa-bars sidebar-toggle"></i>
    <h2>Referral Panel</h2>
    <img src="img/logo.png" alt="">
</div>

<div class="dash-content">
    <div id="teamBtns" class="sidenav">
        <div href="#">1) Referral Types</div>
        <div href="#">2) Connect</div>
        <div href="#" class="tabbed">● Facebook</div>
        <div href="#" class="tabbed">● Webhooks</div>
        <button onclick="openThisTeam('new')" class="purpleBtn">Add Team</button>
    </div>

<div id="rightHalf">
    <div class="card">
        <h3>Referral Types</h3>
        <form action="" class="refTypCard" id="refTypId_1">
            <input type="hidden" name="id" value="1">
            <input type="text" name="value" value="MB Request" data-original-val="MB Request">
            <i class="editBtn fa-solid fa-pencil" onclick="enableRefTypEditing(1)"></i>
            <i class="saveBtn fa-solid fa-floppy-disk" onclick="this.parentElement.submit()"></i>
            <i class="undoBtn fa-solid fa-rotate-left" onclick="enableRefTypEditing()"></i>
            <i class="deleBtn fa-solid fa-trash-can" style="color: #cb0101;" onclick="this.nextElementSibling.value = '1'; this.parentElement.submit()"></i>
            <input type="hidden" name="delete" value="0">
        </form>
        <form action="" class="refTypCard" id="refTypId_2">
            <input type="hidden" name="id" value="2">
            <input type="text" name="value" value="Missionary Visit" data-original-val="Missionary Visit">
            <i class="editBtn fa-solid fa-pencil" onclick="enableRefTypEditing(2)"></i>
            <i class="saveBtn fa-solid fa-floppy-disk" onclick="this.parentElement.submit()"></i>
            <i class="undoBtn fa-solid fa-rotate-left" onclick="enableRefTypEditing()"></i>
            <i class="deleBtn fa-solid fa-trash-can" style="color: #cb0101;" onclick="this.nextElementSibling.value = '1'; this.parentElement.submit()"></i>
            <input type="hidden" name="delete" value="0">
        </form>
    </div>
</div>
<script>
function _(x) { return document.getElementById(x); }
HTMLCollection.prototype.forEach = function (x) { return Array.from(this).forEach(x); }

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
<?php
    session_start();
    if (!$_SESSION['missionSignedIn']) {
        header('location: login.php');
    }
    require_once('panel_maker.php');
    require_once('sql_tools.php');
    require_once('overall_vars.php');
    makeHTMLtop('Integrate');

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
#webhookKeys {
    margin-left: auto;
    margin-right: auto;
    border-spacing: 0;
    box-shadow: 1px 2px 8px -5px rgba(0, 0, 0, 0.5);
}
#webhookKeys td {
    padding: 5px;
}
#webhookKeys tr:first-child {
    background-color: #fcdcff;
    font-size: 20px;
}
</style>
<div class="top">
    <i class="fa-solid fa-bars sidebar-toggle"></i>
    <h2>Referral Panel</h2>
    <img src="img/logo.png" alt="">
</div>

<div id="rightHalf">
    <div class="card">
        <h2>Connect</h2>
        <br>
        <p>Welcome to the <strong>Integrate</strong> page!</p>
        <br>
        <p>First things first, you need to add a <strong>Referral Type</strong>. Integration isn't possible until you have at least one Referral Type</p>
        <br>
        <p>This is where you'll connect your ads, forms, etc. to Referral Panel so that you can use Referral Suite to manage all your referrals. The steps below are generalized for everyone. <strong>You can't simply copy and paste everything without reading the instructions.</strong> But as long as you read all the instructions you'll have no problem at all!</p>
    </div>
    <hr>
    <div class="card">
        <h2>Referral Types</h2>
        <?php
        foreach ($referral_types as $i => $row) {
            echo(<<<HERRA
            <form action="saving_functions/referral_types_save.php" method="POST" class="refTypCard" id="refTypId_{$row[0]}">
                <input type="hidden" name="id" value="{$row[0]}">
                <input type="text" name="value" value="{$row[1]}" data-original-val="{$row[1]}">
                <i class="editBtn fa-solid fa-pencil" onclick="enableRefTypEditing({$row[0]})"></i>
                <i class="saveBtn fa-solid fa-floppy-disk" onclick="this.parentElement.submit()"></i>
                <i class="undoBtn fa-solid fa-rotate-left" onclick="enableRefTypEditing()"></i>
                <i class="deleBtn fa-solid fa-trash-can" style="color: #cb0101;" onclick="deleteThisReferralType(this)"></i>
                <input type="hidden" name="delete" value="0">
            </form>
            HERRA);
        }
        ?>
        <button class="purpleBtn" style="padding:6px 8px; margin-top: 10px;" onclick="addNewReferralType()">Add New Referral Type</button>
        <form action="saving_functions/referral_types_save.php" method="POST" id="addNewTypeForm">
            <input type="hidden" name="id" value="new">
            <input type="hidden" name="value" value="" id="addNewTypeValue">
            <input type="hidden" name="delete" value="0">
        </form>
    </div>
    <?php if (count($referral_types) != 0) { ?>
    <hr>

    <div class="card">
        <h3><i class="fa-brands fa-facebook" style="color: #3396ff; font-size: 40px"></i> Facebook</h3>
        <br>
        <p>Connect Referral Panel <strong>directly</strong> to Facebook Ads Manager</p>
        <br>
        <center><h2 style="color: #c6c6c6;">Coming Soon</h2></center>
        <br>
        <p>This feature is still in progress. I'll hopefully have it avalible soon!! But until then, use Webhooks</p>
    </div>
    <hr>
    <div class="card">
        <h3><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-webhook" width="40" height="40" viewBox="0 0 24 24" stroke-width="2" stroke="#fc8c03" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path stroke="none" d="M0 0h24v24H0z" fill="none"/> <path d="M4.876 13.61a4 4 0 1 0 6.124 3.39h6" /> <path d="M15.066 20.502a4 4 0 1 0 1.934 -7.502c-.706 0 -1.424 .179 -2 .5l-3 -5.5" /> <path d="M16 8a4 4 0 1 0 -8 0c0 1.506 .77 2.818 2 3.5l-3 5.5" /> </svg> Webhooks</h3>
        <br>
        <p>Connect Referral Panel to <strong>any</strong> platform using Webhooks</p>
        <br>
        <p>For this tutorial's sake, I'll assume you're using Zapier to push referrals to Referral Panel. However, any system that can submit a POST request to a specific URL is capable of being used here.</p>
        <br>
        <h4>Step 1: Event / Method</h4>
        <p>Select POST</p>
        <br>
        <br>
        <h4>Step 2: URL / Action</h4>
        <p>Use this Url:</p>
        <input type="text" disabled value="https://www.referralpanel.com/API/new_referral.php CHANGE THIS URL LATER!!" class="pasteMe"><br>
        <br>
        <br>
        <h4>Step 3: Data -> manditory data</h4>
        <p>This step is the easiest to mess up. Pay attention!</p>
        <br>
        <p>Under Data click add (+). Then on the left paste:</p>
        <input type="text" disabled value="mykey" class="pasteMe"><br>
        <p>And on the right paste:</p>
        <input type="text" disabled value="<?php echo($_SESSION['missionInfo']->mykey); ?>" class="pasteMe"><br>
        <p style="font-size: 13px">That is your security key. Don't share it with anyone.</p>
        <br>
        <br>
        <p>Click add (+) again and on the left paste:</p>
        <input type="text" disabled value="date" class="pasteMe"><br>
        <p>And on the right paste:</p>
        <input type="text" disabled value="{{zap_meta_human_now}}" class="pasteMe"><br>
        <p style="font-size: 13px">Replace this with the current timestamp if not using Zapier</p>
        <br>
        <br>
        <p>Click add (+) again and on the left paste:</p>
        <input type="text" disabled value="type" class="pasteMe"><br>
        <p>And on the right paste one of your Referral Types. For example:</p>
        <input type="text" disabled value="<?php echo($referral_types[0][1]); ?>" class="pasteMe"><br>
        <p style="font-size: 13px">Must be spelled EXACTLY as you spelled it at the top of this page. (Best to just copy and paste)</p>
        <br>
        <br>
        <h4>Step 4: Referral Data</h4>
        <p>Nearly Done! Just fill in all the person's info!</p>
        <br>
        <br>
        <p>For this step, you're going to be adding all of the referrals' specific data. You may add as few or as many of these as you'd like. But keep in mind that at least 1 contact method must be provided.</p>
        <br>
        <p>Now you may add as many more rows of data as you'd like. The value in the left coloumn <strong>MUST</strong> match exactly one of the following keys:</p>
        <br>
        <table id="webhookKeys">
            <tr>
                <td><center>Key</center></td><td><center>Description</center></td>
            </tr>
            <tr>
                <td><input type="text" disabled value="fname" class="pasteMe"></td><td>First Name</td>
            </tr>
            <tr>
                <td><input type="text" disabled value="lname" class="pasteMe"></td><td>Last Name</td>
            </tr>
            <tr>
                <td><input type="text" disabled value="phone" class="pasteMe"></td><td>Phone Number</td>
            </tr>
            <tr>
                <td><input type="text" disabled value="email" class="pasteMe"></td><td>Email Address</td>
            </tr>
            <tr>
                <td><input type="text" disabled value="street" class="pasteMe"></td><td>Street Address</td>
            </tr>
            <tr>
                <td><input type="text" disabled value="city" class="pasteMe"></td><td>City</td>
            </tr>
            <tr>
                <td><input type="text" disabled value="zip" class="pasteMe"></td><td>Zip/Postal Code</td>
            </tr>
            <tr>
                <td><input type="text" disabled value="lang" class="pasteMe"></td><td>Preferred Language</td>
            </tr>
            <tr>
                <td><input type="text" disabled value="platform" class="pasteMe"></td><td>Platform The Referral Came From (fb, ig, web)</td>
            </tr>
            <tr>
                <td><input type="text" disabled value="ad_name" class="pasteMe"></td><td>Ad Name</td>
            </tr>
            <tr>
                <td><input type="text" disabled value="ad_id" class="pasteMe"></td><td>Id Of Your Ad<p style="font-size: 13px">Usefull for your own reference only</p></td>
            </tr>
            <tr>
                <td><input type="text" disabled value="form_id" class="pasteMe"></td><td>Id Of Your Form<p style="font-size: 13px">Usefull for your own reference only</p></td>
            </tr>
            <tr>
                <td><input type="text" disabled value="helpRequest" class="pasteMe"></td><td>Discription Of What They Want Help With<p style="font-size: 13px">Usefull for Family History referrals</p></td>
            </tr>
            <tr>
                <td><input type="text" disabled value="knowledgeLevel" class="pasteMe"></td><td>Discription Of How Much Previous Knowledge They Have<p style="font-size: 13px">Usefull for Family History referrals</p></td>
            </tr>
        </table>
        <br>
        <br>
        <br>
        <h4>Step 5: Celebrate!!</h4>
        <p>You've earned it!</p>
        <br>
        <p>If you're using Zapier you can test the action and as long as there are no errors, you should be good to go! (This will create a new row appear on the <a href="referrals.php">Referrals Tab</a>)</p>
    </div>
    <div style="width: 5px; height: 150px;"></div>
    <?php } ?>
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
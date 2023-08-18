<?php
    session_start();
    if (!$_SESSION['missionSignedIn']) {
        header('location: login.php');
    }
    require_once('panel_maker.php');
    require_once('sql_tools.php');
    makeHTMLtop('Inboxers');

    // get teams info
    $teamInfos = readSQL($_SESSION['missionInfo']->mykey, 'SELECT * FROM `teams` WHERE 1');
?>
<style>
#inboxersParent {
    width: 100%;
    border-spacing: 0 10px;
}
#inboxersParent tr:not(:first-child) {
    box-shadow: 2px 5px 10px -7px rgba(0, 0, 0, 0.5);
}
#inboxersParent tr:first-child td {
    padding: 0px 10px;
}
#inboxersParent tr:not(:first-child) td {
    padding: 10px;
}
#addNewTeam {
    position: absolute;
    right: 25px;
    padding: 5px 10px;
}
input[type=text], select {
    background-color: #f9f9f9;
    border: none;
    padding: 5px;
    width: 100%;
}
</style>
<div class="top">
    <i class="fa-solid fa-bars sidebar-toggle"></i>
    <h2>Referral Panel</h2>
    <img src="img/logo.png" alt="">
</div>

<div class="dash-content">
    <table id="inboxersParent">
        <tr>
            <td>Area Name</td><td>Email</td><td>Color</td><td>Role</td><td></td>
        </tr>
        <tr style="background-color: cyan;">
            <td><input type="text" value="Hägersten"></td>
            <td><input type="text" value="1234567@missionary.org"></td>
            <td><select><option>Red</option></select></td>
            <td><select><option>Standard</option></select></td>
            <td><i class="fa-solid fa-trash-can"></i></td>
        </tr>
        <tr style="background-color: red;">
            <td><input type="text" value="Hägersten"></td>
            <td><input type="text" value="1234567@missionary.org"></td>
            <td><select><option>Red</option></select></td>
            <td><select><option>Standard</option></select></td>
            <td><i class="fa-solid fa-trash-can"></i></td>
        </tr>
    </table>
    <button id="addNewTeam" class="purpleBtn">Add New Team</button>
    <form action="saving_functions/schedule_save.php" method="POST">
        <input type="hidden" id="hiddenSavingEl" name="saveIt">
        <input type="submit" id="saveBtn" class="purpleBtn" onclick="bigSaveBtn()" value="Save to Referral Suite">
    </form>
    <script>
let teamInfos = <?php echo(json_encode($teamInfos)) ?>;

    </script>
</div>

<?php makeHTMLbottom() ?>
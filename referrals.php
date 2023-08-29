<?php
    session_start();
    if (!$_SESSION['missionSignedIn']) {
        header('location: login.php');
    }
    require_once('panel_maker.php');
    require_once('sql_tools.php');
    require_once('overall_vars.php');

    makeHTMLtop('Referrals');

    // get teams info
    $teamInfos = readSQL($_SESSION['missionInfo']->mykey, 'SELECT * FROM `teams` WHERE 1');

    // get table cols
    $tableCols = readTableColumns($_SESSION['missionInfo']->mykey, 'all_referrals');

    // get referrals list
    $referralList = readSQL($_SESSION['missionInfo']->mykey, 'SELECT * FROM `all_referrals` LIMIT 5');
?>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
<script src="http://code.jquery.com/jquery-2.0.3.min.js"></script> 
<script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/bootstrap3-editable/js/bootstrap-editable.js"></script>
<style>
table {
    width: 100%;
    border-spacing: 0 0px;
}
table td {
    padding: 0px 10px;
}
table tr:nth-child(even) {
    background-color: #fee4ff;
}
</style>
<div class="top">
    <i class="fa-solid fa-bars sidebar-toggle"></i>
    <h2>Referral Panel</h2>
    <img src="img/logo.png" alt="">
</div>
<div class="dash-content">
<table id="data_table" class="table table-bordered table-striped">
    <tr>
        <?php
            foreach ($tableCols as $key => $value) {
                echo('<td>'.$value.'</td>');
            }
        ?>
    </tr>
    <tbody id="employee_data">
    </tbody>
<?php
/*for ($i=0; $i < count($referralList); $i++) { 
    $ref = $referralList[$i];
    echo('<tr id="tableRowId_'.$ref[1].'">');
    for ($j=0; $j < count($ref); $j++) { 
        $refVal = $ref[$j];
        echo('<td>'.$refVal.'</td>');
    }
    echo('</tr>');
}*/
?>
</table>
</div>
<script>
    
function fetch_employee_data()
 {
  $.ajax({
   url:"referrals_table/fetch.php",
   method:"POST",
   dataType:"json",
   success:function(data)
   {
    for(var count=0; count<data.length; count++)
    {
     var html_data = '<tr>';
     html_data += '<td data-name="name" class="name" data-type="text" data-pk="'+data[count][1]+'">'+data[count][0]+'</td>';
     html_data += '<td>'+data[count][1]+'</td>';
     html_data += '<td data-name="gender" class="gender" data-type="select" data-pk="'+data[count][1]+'">'+data[count][2]+'</td>';
     html_data += '<td data-name="designation" class="designation" data-type="text" data-pk="'+data[count][1]+'">'+data[count][3]+'</td>';
     html_data += '<td data-name="age" class="age" data-type="text" data-pk="'+data[count][1]+'">'+data[count][4]+'</td>';
     html_data += '</tr>';
     $('#employee_data').append(html_data);
    }
   }
  })
 }
 $('#employee_data').editable({
  container: 'body',
  selector: 'td.name',
  url: "update.php",
  title: 'Gender',
  type: "POST",
  dataType: 'json',
  source: [{value: "Male", text: "Male"}, {value: "Female", text: "Female"}],
  validate: function(value){
   if($.trim(value) == '')
   {
    return 'This field is required';
   }
  }
 });

 fetch_employee_data();

</script>
</div>

<?php makeHTMLbottom() ?>
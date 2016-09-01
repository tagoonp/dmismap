<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
include "../configuration/connect.class.php";
$db = new database();
$db->connect();

$sessionName = $db->getSessionname();

$stage = 0;
if(isset($_POST['alertStage'])){
  $stage = $_POST['alertStage'];
}

$strSQL = sprintf("SELECT * FROM dsw1_user WHERE username = '%s'", mysql_real_escape_string($_SESSION[$sessionName.'sessUsername']));
$resultCheck = $db->select($strSQL,false,true);

// $strSQL = sprintf("SELECT * FROM dsw1_alert WHERE 1 ORDER BY alt_id DESC LIMIT 0, 200");
$strSQL = sprintf("SELECT * FROM dsw1_alert WHERE 1  AND id_evt = '".$resultCheck[0]['user_eventgroup_id']."' LIMIT 0, 200");

if($stage==1){
  $strSQL = sprintf("SELECT * FROM dsw1_alert WHERE alt_stage = '1' AND id_evt = '".$resultCheck[0]['user_eventgroup_id']."' LIMIT 0, 100");
}else if($stage==2){
  $strSQL = sprintf("SELECT * FROM dsw1_alert WHERE alt_stage = '2' AND id_evt = '".$resultCheck[0]['user_eventgroup_id']."' LIMIT 0, 100");
}else if($stage==3){
  $strSQL = sprintf("SELECT * FROM dsw1_alert WHERE alt_stage = '3' AND id_evt = '".$resultCheck[0]['user_eventgroup_id']."' LIMIT 0, 100");
}else if($stage==4){
  $strSQL = sprintf("SELECT * FROM dsw1_alert WHERE alt_stage = '4' AND id_evt = '".$resultCheck[0]['user_eventgroup_id']."' LIMIT 0, 100");
}

$result = $db->select($strSQL,false,true);

?>
<table class="table table-hover"  style="font-weight: 300; margin-bottom: 0px;">
<tbody>


<?php

if($result){
  foreach ($result as $value) {
    ?>
    <tr>
      <td class="col-sm-1" style="border:none;   font-weight: 300; padding-left: 10px;">
        <?php
        switch ($value['alt_stage']) {
          case '1':
            ?> <img src="../images/marker/redpin2.png" alt="" /> <?php
            break;
          case '2':
            ?> <img src="../images/marker/ylpin2.png" alt="" /> <?php
            break;
          case '3':
            ?> <img src="../images/marker/grpin2.png" alt="" /> <?php
            break;
          case '4':
              ?> <img src="../images/marker/blpin.png" alt="" /> <?php
            break;
          default:
            print "N/A";
            break;
        }
        ?>
      </td>
      <td class="col-sm-2" style="border:none;   font-weight: 300;">
        <?php print $value['alt_date_ent']." ".$value['alt_time_ent']; ?>
      </td>
      <td class="col-sm-2" style="border:none;   font-weight: 300;">
        <a href="javascript: showEvent2('<?php print $value['alt_id']; ?>')"><?php print $value['alt_phone']; ?></a>
      </td>
      <td class="col-sm-2" style="border:none;   font-weight: 300;">
        <?php print $value['alt_name']; ?>
      </td>
      <td style="border:none;   font-weight: 300;">
        <?php print $value['alt_other_msg']; ?>
      </td>
      <td class="col-sm-2" style="border:none;   font-weight: 300;">
        <?php print $value['alt_level']; ?>
      </td>
      <td class="col-sm-1" style="border:none;   font-weight: 300;">
        <?php print $value['alt_chanal']; ?>
      </td>
    </tr>
    <?php
  }
}else{
  ?>
  <tr>
    <td colspan="7">
      ไม่พบข้อมูล
    </td>
  </tr>
  <?php
}
?>
</tbody>
</table>

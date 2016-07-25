<?php
date_default_timezone_set("Asia/Bangkok");
include "../configuration/connect.class.php";
$db = new database();
$db->connect();

$markerID = $_POST['placeID'];

$strSQL = "SELECT *
          FROM dsw1_alert
          WHERE alt_id = '".$markerID."'";
$resultQuery = $db->select($strSQL,false,true);

// print $strSQL;
if($resultQuery){
  ?>
  <table class="table table-condensed" style="padding: 0px; margin: 0px;">
    <thead style="background: #f3f3f3;">
      <th>
        ชื่อผู้ประสาน
      </th>
      <th>
        วันที่-เวลา
      </th>
      <th>
        สถานะ
      </th>
    </thead>
    <tbody>
      <?php
      foreach ($resultQuery as $value) {
        ?>
        <tr>
          <td>
            <?php if($value['alt_username']!=''){ print $value['alt_username']; }else{ print "รับแจ้งทาง Application"; } ?>
          </td>
          <td>
            <?php print $value['alt_date_ent']." ".$value['alt_time_ent']; ?>
          </td>
          <td>
            <img src="../images/marker/redpin2.png" alt="" />
          </td>
        </tr>
        <?php
      }


  $strSQL = "SELECT *
            FROM dsw1_transection
            WHERE tr_alt_id = '".$markerID."'
            ORDER BY tr_id";
  $resultQuery2 = $db->select($strSQL,false,true);

  if($resultQuery2){
    foreach ($resultQuery2 as $value2) {
      ?>
      <tr>
        <td>
          <?php if($value2['tr_assignto']!=''){ print $value2['tr_assignto']; }else{ print "N/A"; } ?>
        </td>
        <td>
          <?php print $value2['tr_date']." ".$value2['tr_time']; ?>
        </td>
        <td>
          <?php
          switch($value2['tr_tostage']){
            case 1: ?> <img src="../images/marker/redpin2.png" alt="" /> <?php ; break;
            case 2: ?> <img src="../images/marker/ylpin2.png" alt="" /> <?php ; break;
            case 3: ?> <img src="../images/marker/grpin2.png" alt="" /> <?php ; break;
          }
          ?>

        </td>
      </tr>
      <?php
    }
  }

  ?>
</tbody>
</table>
<?php
}else{
  ?>
  <table class="table table-condensed" style="padding: 0px; margin: 0px;">
    <thead style="background: #f3f3f3;">
      <th>
        ชื่อผู้ประสาน
      </th>
      <th>
        วันที่-เวลา
      </th>
      <th>
        สถานะ
      </th>
    </thead>
    <tbody>
      <tr>
        <td colspan="3">
          ไม่พบข้อมูล
        </td>
      </tr>
    </tbody>
  </table>
  <?php
}

$db->disconnect();

?>

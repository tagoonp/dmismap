<?php
date_default_timezone_set("Asia/Bangkok");
include "../configuration/connect.class.php";
$db = new database();
$db->connect();

$stagement = $_POST['stage'];

$strSQL = "SELECT *
          FROM dsw1_alert
          WHERE alt_stage = '".$stagement."'";
$resultQuery = $db->select($strSQL,false,true);

if($resultQuery){
  ?>
  <table class="table table-condensed">
    <thead style="background: #f3f3f3;">
      <tr style="background: #4D6F71; color: #fff;">
        <td>
          วัน-เวลาแจ้ง
        </td>
        <td class="text-left">
          หมายเลขโทรศัพท์
        </td>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($resultQuery as $value) {
        ?>
        <tr>
          <td>
            <?php print $value['alt_date_ent']." ".$value['alt_time_ent']; ?>
          </td>
          <td>
            <a href="javascript: showEvent2('<?php print $value['alt_id'];?>','<?php print $value['alt_lat'];?>','<?php print $value['alt_lng'];?>')"><?php print $value['alt_phone']; ?></a>
          </td>
        </tr>
        <?php
      }
  ?>
  </tbody>
  </table>
<?php
}else{
  ?>
  <table class="table table-condensed">
    <thead>
      <tr style="background: #4D6F71; color: #fff;">
        <td>
          วัน-เวลาแจ้ง
        </td>
        <td class="text-left">
          หมายเลขโทรศัพท์
        </td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td colspan="2">
          ไม่พบข้อมูล
        </td>
      </tr>
    </tbody>
  </table>
  <?php
}

// print $strSQL;
$db->disconnect();

?>

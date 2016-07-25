<?php
date_default_timezone_set("Asia/Bangkok");
include "../configuration/connect.class.php";
$db = new database();
$db->connect();
$sessionName = $db->getSessionname();

$strSQL = "SELECT * FROM dsw1_alert WHERE 1 LIMIT 0,30";
$result = $db->select($strSQL,false,true);

if($result){
  ?>
  <table class="table table-bordered" style="border: none; border-weight: 0px;">
    <thead style="border: none; border-weight: 0px;">
        <tr style="border: none; border-weight: 0px;">
          <th style="border: none; border-weight: 0px;">#</th>
          <th style="background: #8EBEEF; color: #fff; ">วัน-เวลาที่แจ้ง</th>
          <th style="background: #8EBEEF; color: #fff; ">ชื่อผู้แจ้ง</th>
          <th style="background: #8EBEEF; color: #fff; ">หมายเลขโทรศัพท์</th>
          <th style="background: #8EBEEF; color: #fff; ">สถานะปัจจุบัน</th>
          <th style="background: #8EBEEF; color: #fff; ">ระดับความต้องการ</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $c = 1;
        foreach ($result as $value) {
          ?>
          <tr>
            <td>
              <?php print $c; ?>
            </td>
            <td>
              <?php print printDate($value['alt_date_ent'])." ".$value['alt_time_ent']; ?>
            </td>
            <td>
              <?php print $value['alt_name']; ?>
            </td>
            <td>
              <?php print $value['alt_phone']; ?>
            </td>
            <td>
              <?php
              switch($value['alt_stage']){
                case 1: print '<font color="#FF3333">แจ้งการร้องขอ</font>'; break;
                case 2: print '<font color="#FE9600">กำลังดำเนินการ</font>'; break;
                case 3: print '<font color="#3BD900">ช่วยเหลือแล้ว</font>'; break;
                default: print '<font color="#448AD2">ช่วยเหลือแล้ว > 4 ชม.</font>';
              }
              ?>
            </td>
            <td>
              <?php
              switch($value['alt_level']){
                case 'common': print '<span style="color: #377AAD;">ทั่วไป</span>'; break;
                case 'urgen': print '<span style="color: #FD3116;">ด่วน</span>'; break;
                case 'severe': print '<span style="color: red;">เร่งด่วน</span>'; break;
                default: print '<span style="color: #377AAD;">ทั่วไป</span>';
              }
              ?>
            </td>
          </tr>
          <?php
          $c++;
        }
        ?>
      </tbody>
  </table>
  <?php
}

?>
<?php
function printDate($dateValue){
  $month=array("ไม่ระบุ","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
  $arr = explode('-', $dateValue);
  $newDate = $arr[2]." ".$month[intval($arr[1])]." ".($arr[0] + 543);
  print $newDate;
}
?>

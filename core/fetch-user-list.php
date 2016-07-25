<?php
date_default_timezone_set("Asia/Bangkok");
include "../configuration/connect.class.php";
$db = new database();
$db->connect();
$sessionName = $db->getSessionname();

$strSQL = "SELECT * FROM dsw1_user a inner join dsw1_userinformation b on a.username = b.username inner join dsw1_institute c on a.institute_id = c.inst_id  WHERE 1 LIMIT 0,30";
$result = $db->select($strSQL,false,true);

if($result){
  ?>
  <table class="table table-bordered" style="border: none; border-weight: 0px;">
    <thead style="border: none; border-weight: 0px;">
      <tr style="border: none; border-weight: 0px;">
        <th style="background: #8EBEEF; color: #fff; ">#</th>
        <th style="background: #8EBEEF; color: #fff; ">ชื่อ-นามสกุล</th>
        <th style="background: #8EBEEF; color: #fff; ">หมายเลขโทรศัพท์</th>
        <th style="background: #8EBEEF; color: #fff; ">ศูนย์ประสานงาน</th>
        <th style="background: #8EBEEF; color: #fff; ">สถานะปัจจุบัน</th>
        <th style="background: #8EBEEF; color: #fff; "></th>
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
              <?php print $value['usr_fname']." ".$value['usr_lname']; ?>
            </td>
            <td>
              <?php print $value['usr_phone']; ?>
            </td>
            <td>
              <?php print $value['inst_name']; ?>
            </td>
            <td>
              <?php
              switch($value['active_status']){
                case 'Yes': print '<span class="label label-primary">Enabled</span>'; break;
                default: print '<span class="label label-danger">Disable</span>';
              }
              ?>
            </td>
            <td class="text-center">
              <button type="button" name="button" class="btn btn-info" style="padding-left: 10px; padding-right: 2px;"><i class="fa fa-search"></i></button>
              <button type="button" name="button" class="btn btn-info" style="padding-left: 10px; padding-right: 2px;"><i class="fa fa-wrench"></i></button>
              <button type="button" name="button" class="btn btn-danger" style="padding-left: 10px; padding-right: 2px;"><i class="fa fa-trash"></i></button>
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

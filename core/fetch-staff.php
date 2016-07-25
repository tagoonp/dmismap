<?php
date_default_timezone_set("Asia/Bangkok");
include "../configuration/connect.class.php";
$db = new database();
$db->connect();

$strSQL = "SELECT *
          FROM dsw1_user a INNER JOIN dsw1_userinformation b
          ON a.username = b.username
          INNER JOIN dsw1_usertype c
          ON a.usertype_id = c.usertype_id
          WHERE a.active_status = 'Yes' and a.institute_id = '".$_POST['instituteID']."' and a.usertype_id != '1'";
$resultQuery = $db->select($strSQL,false,true);

if($resultQuery){
  ?>
  <table class="table table-condensed" style="padding: 0px; margin: 0px;">
    <thead style="background: #f3f3f3;">
      <th>
        ชื่อผู้ประสาน
      </th>
      <th>
        ตำแหน่ง
      </th>
      <th>
        หมายเลขโทรศัพท์
      </th>
      <th>
        &nbsp;
      </th>
    </thead>
    <tbody>
      <?php
      foreach ($resultQuery as $value) {
        ?>
        <tr>
          <td>
            <?php print $value['usr_fname']." ".$value['usr_lname']; ?>
          </td>
          <td>
            <?php print $value['usertype_desc']; ?>
          </td>
          <td>
            <?php print $value['usr_phone']; ?>
          </td>
          <td>
            <div class="text-right">
              <button type="button" name="button" class="btn btn-primary" style="font-size: 0.7em; " onclick="assignCoordination('<?php print $value['username'];?>')"><i class="fa fa-plus"></i> มอบหมาย</button>
            </div>

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
  <table class="table table-condensed" style="padding: 0px; margin: 0px;">
    <thead style="background: #f3f3f3;">
      <th>
        ชื่อผู้ประสาน
      </th>
      <th>
        ตำแหน่ง
      </th>
      <th>
        หมายเลขโทรศัพท์
      </th>
      <th>
        &nbsp;
      </th>
    </thead>
    <tbody>
      <tr>
        <td colspan="4">
          ไม่พบข้อมูล
        </td>
      </tr>
    </tbody>
  </table>
  <?php
}

$db->disconnect();

?>

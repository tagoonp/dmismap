<?php
date_default_timezone_set("Asia/Bangkok");
require ("../configuration/connect.class.php");
$db = new database();
$db->connect();

$strSQL = "SELECT * FROM dsw1_alert WHERE alt_id = '".$_GET['placeID']."'";
$result = $db->select($strSQL,false,true);

if(!$result){

}


?>
<script type="text/javascript">
  $(function(){
    $('.btnClostInfoWndow').click(function(){
      alert('a');
      for (var i = 0; i < infowindow.length; i++) {
        infowindow[i].close();
      }
    });
  });
</script>
<div id="iw-container" style="font-family: 'Kanit', sans-serif; width: 350px; height: 300px;">
  <div class="iw-title" style="font-family: 'Kanit', sans-serif;">
    <table width="100%">
      <tr>
        <td>
          รายการที่ : <?php print $result[0]['alt_id']; ?>
        </td>
        <td style="width: 50px; font-size: 0.8em; padding-right: 10px;" class="text-right">
          <div class="btnClostInfoWndow"><i class="fa fa-close"></i></div>
        </td>
      </tr>
    </table>
  </div>
    <div class="iw-content">
      <div class="iw-subTitle">รายละเอียด</div>
      <img src="../images/vistalegre.jpg" alt="Porcelain Factory of Vista Alegre" height="115" width="83">
      <p>
        ผู้แจ้ง : <?php print $result[0]['alt_name']; ?><br>
        หมายเลขโทรศัพท์ : <?php print $result[0]['alt_phone']; ?>
      </p>
      <div class="iw-subTitle">ความต้องการ</div>
      <p>
        ความต้องการหลัก: <br>
        ข้อความ/อื่นๆ : <br>
      </p>
    </div>
  <div class="iw-bottom-gradient"></div>
</div>

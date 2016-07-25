<?php
session_start();


date_default_timezone_set("Asia/Bangkok");
include "../configuration/connect.class.php";
$db = new database();
$db->connect();
$sessionName = $db->getSessionname();

if(!isset($_SESSION[$sessionName.'sessID'])){
  print "Session time out";
  exit();
}

if($_SESSION[$sessionName.'sessID'] != session_id()){
  print "Session time out";
  exit();
}

$strSQL = sprintf("INSERT INTO dsw1_alert (alt_date_ent, alt_time_ent, alt_phone, alt_name, alt_stage, alt_level, alt_food, alt_drug, alt_other_msg, alt_lat, alt_lng, alt_chanal, alt_username) VALUES
          ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')",
          mysql_real_escape_string(date('Y-m-d')),
          mysql_real_escape_string(date('H:i:s')),
          mysql_real_escape_string($_POST['phone']),
          mysql_real_escape_string($_POST['fname']),
          mysql_real_escape_string('1'),
          mysql_real_escape_string('urgen'),
          mysql_real_escape_string($_POST['food_status']),
          mysql_real_escape_string($_POST['drug_status']),
          mysql_real_escape_string($_POST['other']),
          mysql_real_escape_string($_POST['lat']),
          mysql_real_escape_string($_POST['lng']),
          mysql_real_escape_string($_SESSION[$sessionName.'sessUsername']),
          mysql_real_escape_string('Phone to CC')
        );
$resultInsert = $db->insert($strSQL,false,true);
if($resultInsert){
  print "Y";
}else{
  print "ไม่สามารถบันทึกรายการได้";
  // print $strSQL;
}


$db->disconnect();

?>

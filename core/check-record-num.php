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

$strSQL = sprintf("SELECT count(*) numrows FROM dsw1_alert WHERE alt_stage = '1'");
$result = $db->select($strSQL,false,true);

if($result){
  print $result[0]['numrows'];
}else{
  print 0;
}

$db->disconnect();

?>

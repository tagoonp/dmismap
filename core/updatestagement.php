<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
include "../configuration/connect.class.php";
$db = new database();
$db->connect();
$sessionName = $db->getSessionname();

$markerID = $_POST['alt_id'];
$staffID = $_POST['staff'];
$toStage = $_POST['toStage'];

$strSQL = "SELECT *
          FROM dsw1_alert
          WHERE alt_id = '".$markerID."'";
$resultQuery = $db->select($strSQL,false,true);

if(!$resultQuery){
  print "N";
}else{
  $strSQL = "UPDATE dsw1_alert SET alt_stage = '".$toStage."' WHERE alt_id = '".$markerID."'";
  $resultUpdate = $db->update($strSQL);

  if($resultUpdate){
    $strSQL = "INSERT INTO dsw1_transection VALUE ('', '".date('Y-m-d')."', '".date('H:i:s')."', '".$staffID."','".$_SESSION[$sessionName.'sessUsername']."', '".$toStage."','".$markerID."')";
    $resultInsert = $db->insert($strSQL,false,true);
  }

  print "Y";
}

$db->disconnect();

?>

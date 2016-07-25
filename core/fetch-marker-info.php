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

$strTemp = $strSQL;
$return = '';

if($resultQuery){
  for($i=0;$i<count($resultQuery);$i++){
    $return[$i]['alt_id'] = $resultQuery[$i]['alt_id'];
    $return[$i]['alt_date_ent'] = $resultQuery[$i]['alt_date_ent'];
    $return[$i]['alt_time_ent'] = $resultQuery[$i]['alt_time_ent'];
    $return[$i]['alt_phone'] = $resultQuery[$i]['alt_phone'];
    $return[$i]['alt_name'] = $resultQuery[$i]['alt_name'];
    $return[$i]['alt_stage'] = $resultQuery[$i]['alt_stage'];
    $return[$i]['alt_level'] = $resultQuery[$i]['alt_level'];
    $return[$i]['alt_food'] = $resultQuery[$i]['alt_food'];
    $return[$i]['alt_drug'] = $resultQuery[$i]['alt_drug'];
    $return[$i]['alt_other'] = $resultQuery[$i]['alt_other'];
    $return[$i]['alt_other_msg'] = $resultQuery[$i]['alt_other_msg'];
    $return[$i]['alt_place'] = $resultQuery[$i]['alt_place'];
    $return[$i]['alt_lat'] = $resultQuery[$i]['alt_lat'];
    $return[$i]['alt_lng'] = $resultQuery[$i]['alt_lng'];
    $return[$i]['alt_image'] = $resultQuery[$i]['alt_image'];
    $return[$i]['alt_chanal'] = $resultQuery[$i]['alt_chanal'];
  }
}

echo json_encode($return);
// echo json_encode($strTemp);
$db->disconnect();

?>

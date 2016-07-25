<?php
date_default_timezone_set("Asia/Bangkok");
include "../configuration/connect.class.php";
$db = new database();
$db->connect();

$markerData = $_POST['markerData'];

if(sizeof($markerData)==1){
  if($markerData[0]==0){
    $strSQL = "SELECT *
              FROM dsw1_alert
              WHERE 1 ORDER BY alt_date_ent";
  }else{
    $condition = implode(',', $markerData);
    $strSQL = "SELECT *
              FROM dsw1_alert
              WHERE alt_stage in ('".$condition."') ORDER BY alt_date_ent";
  }
}else{
  $condition = implode("','", $markerData);
  $strSQL = "SELECT *
            FROM dsw1_alert
            WHERE alt_stage in ('".$condition."') ORDER BY alt_date_ent";
}

$strTemp = $strSQL;
$resultQuery = $db->select($strSQL,false,true);

$return = '';
for($i=0;$i<count($resultQuery);$i++){
  $curr = date('Y-m-d H:i:s');
  $date1 = new DateTime($curr); //Current date

  if($resultQuery[$i]['alt_stage']==3){
    $strSQL = "SELECT * FROM dsw1_transection WHERE tr_alt_id = '".$resultQuery[$i]['alt_id']."' ORDER BY tr_id DESC LIMIT 0,1";
    $resultCheckStage = $db->select($strSQL,false,true);
    if($resultCheckStage){
      $date2 = new DateTime($resultCheckStage[0]['tr_date']." ".$resultCheckStage[0]['tr_time']); //Date-time of data
      $diff = $date2->diff($date1); // Get DateInterval Object
      $hr = intVal($diff->format('%h'));

      if($hr > 4){
        $strSQL = "UPDATE dsw1_alert
                  SET alt_stage = '4'
                  WHERE alt_id = '".$resultQuery[$i]['alt_id']."'";
        $resultUPDATE = $db->update($strSQL);

        $return[$i]['alt_id'] = $resultQuery[$i]['alt_id'];
        $return[$i]['alt_date_ent'] = $resultQuery[$i]['alt_date_ent'];
        $return[$i]['alt_time_ent'] = $resultQuery[$i]['alt_time_ent'];
        $return[$i]['alt_stage'] = 4;
        $return[$i]['alt_level'] = $resultQuery[$i]['alt_level'];
        $return[$i]['alt_food'] = $resultQuery[$i]['alt_food'];
        $return[$i]['alt_drug'] = $resultQuery[$i]['alt_drug'];
        $return[$i]['alt_other'] = $resultQuery[$i]['alt_other'];
        $return[$i]['alt_other_msg'] = $resultQuery[$i]['alt_other_msg'];
        $return[$i]['alt_place'] = $resultQuery[$i]['alt_place'];
        $return[$i]['alt_lat'] = $resultQuery[$i]['alt_lat'];
        $return[$i]['alt_lng'] = $resultQuery[$i]['alt_lng'];
        $return[$i]['alt_phone'] = $resultQuery[$i]['alt_phone'];
        $return[$i]['alt_chanal'] = $resultQuery[$i]['alt_chanal'];

      }else{
        $return[$i]['alt_id'] = $resultQuery[$i]['alt_id'];
        $return[$i]['alt_date_ent'] = $resultQuery[$i]['alt_date_ent'];
        $return[$i]['alt_time_ent'] = $resultQuery[$i]['alt_time_ent'];
        $return[$i]['alt_stage'] = $resultQuery[$i]['alt_stage'];
        $return[$i]['alt_level'] = $resultQuery[$i]['alt_level'];
        $return[$i]['alt_food'] = $resultQuery[$i]['alt_food'];
        $return[$i]['alt_drug'] = $resultQuery[$i]['alt_drug'];
        $return[$i]['alt_other'] = $resultQuery[$i]['alt_other'];
        $return[$i]['alt_other_msg'] = $resultQuery[$i]['alt_other_msg'];
        $return[$i]['alt_place'] = $resultQuery[$i]['alt_place'];
        $return[$i]['alt_lat'] = $resultQuery[$i]['alt_lat'];
        $return[$i]['alt_lng'] = $resultQuery[$i]['alt_lng'];
        $return[$i]['alt_phone'] = $resultQuery[$i]['alt_phone'];
        $return[$i]['alt_chanal'] = $resultQuery[$i]['alt_chanal'];
      }
    }else{
      $return[$i]['alt_id'] = $resultQuery[$i]['alt_id'];
      $return[$i]['alt_date_ent'] = $resultQuery[$i]['alt_date_ent'];
      $return[$i]['alt_time_ent'] = $resultQuery[$i]['alt_time_ent'];
      $return[$i]['alt_stage'] = $resultQuery[$i]['alt_stage'];
      $return[$i]['alt_level'] = $resultQuery[$i]['alt_level'];
      $return[$i]['alt_food'] = $resultQuery[$i]['alt_food'];
      $return[$i]['alt_drug'] = $resultQuery[$i]['alt_drug'];
      $return[$i]['alt_other'] = $resultQuery[$i]['alt_other'];
      $return[$i]['alt_other_msg'] = $resultQuery[$i]['alt_other_msg'];
      $return[$i]['alt_place'] = $resultQuery[$i]['alt_place'];
      $return[$i]['alt_lat'] = $resultQuery[$i]['alt_lat'];
      $return[$i]['alt_lng'] = $resultQuery[$i]['alt_lng'];
      $return[$i]['alt_phone'] = $resultQuery[$i]['alt_phone'];
      $return[$i]['alt_chanal'] = $resultQuery[$i]['alt_chanal'];
    }
  }else{
    $return[$i]['alt_id'] = $resultQuery[$i]['alt_id'];
    $return[$i]['alt_date_ent'] = $resultQuery[$i]['alt_date_ent'];
    $return[$i]['alt_time_ent'] = $resultQuery[$i]['alt_time_ent'];
    $return[$i]['alt_stage'] = $resultQuery[$i]['alt_stage'];
    $return[$i]['alt_level'] = $resultQuery[$i]['alt_level'];
    $return[$i]['alt_food'] = $resultQuery[$i]['alt_food'];
    $return[$i]['alt_drug'] = $resultQuery[$i]['alt_drug'];
    $return[$i]['alt_other'] = $resultQuery[$i]['alt_other'];
    $return[$i]['alt_other_msg'] = $resultQuery[$i]['alt_other_msg'];
    $return[$i]['alt_place'] = $resultQuery[$i]['alt_place'];
    $return[$i]['alt_lat'] = $resultQuery[$i]['alt_lat'];
    $return[$i]['alt_lng'] = $resultQuery[$i]['alt_lng'];
    $return[$i]['alt_phone'] = $resultQuery[$i]['alt_phone'];
    $return[$i]['alt_chanal'] = $resultQuery[$i]['alt_chanal'];
  }


  //
  // if(($resultQuery[$i]['alt_stage']==3) && ($hr > 4)){
  //
  //
  //
  // }else{
  //
  // }
}


echo json_encode($return);
// echo json_encode($strTemp);
$db->disconnect();

?>
